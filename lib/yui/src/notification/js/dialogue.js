/**
 * The generic dialogue class for use in agpu.
 *
 * @module agpu-core-notification
 * @submodule agpu-core-notification-dialogue
 */

var DIALOGUE_NAME = 'agpu dialogue',
    DIALOGUE,
    DIALOGUE_FULLSCREEN_CLASS = DIALOGUE_PREFIX + '-fullscreen',
    DIALOGUE_HIDDEN_CLASS = DIALOGUE_PREFIX + '-hidden',
    DIALOGUE_SELECTOR = ' [role=dialog]',
    MENUBAR_SELECTOR = '[role=menubar]',
    DOT = '.',
    HAS_ZINDEX = 'agpu-has-zindex',
    CAN_RECEIVE_FOCUS_SELECTOR = 'input:not([type="hidden"]):not([disabled]):not([tabindex^="-"]),' +
        'a[href]:not([disabled]):not([tabindex^="-"]),' +
        'button:not([disabled]):not([tabindex^="-"]),' +
        'textarea:not([disabled]):not([tabindex^="-"]),' +
        'select:not([disabled]):not([tabindex^="-"]),' +
        '[tabindex]:not([disabled]):not([tabindex^="-"])',
    FORM_SELECTOR = 'form';

/**
 * A re-usable dialogue box with agpu classes applied.
 *
 * @param {Object} c Object literal specifying the dialogue configuration properties.
 * @constructor
 * @class M.core.dialogue
 * @extends Panel
 */
DIALOGUE = function(config) {
    // The code below is a hack to add the custom content node to the DOM, on the fly, per-instantiation and to assign the value
    // of 'srcNode' to this newly created node. Normally (see docs: https://yuilibrary.com/yui/docs/widget/widget-extend.html),
    // this node would be pre-existing in the DOM, and an id string would simply be passed in as a property of the config object
    // during widget instantiation, however, because we're creating it on the fly (and 'config.srcNode' isn't set yet), care must
    // be taken to add it to the DOM and to properly set the value of 'config.srcNode' before calling the parent constructor.
    // Note: additional classes can be added to this content node by setting the 'additionalBaseClass' config property (a string).
    var id = 'agpu-dialogue-' + Y.stamp(this) + '-wrap'; // Can't use this.get('id') as it's not set at this stage.
    config.notificationBase =
        Y.Node.create('<div class="' + CSS_CLASSES.BASE + '">')
            .append(Y.Node.create(
                '<div id="' + id + '" role="dialog" ' +
                'aria-labelledby="' + id + '-header-text" class="' + CSS_CLASSES.WRAP + '"  aria-live="polite"></div>'
            )
            .append(Y.Node.create('<div class="' + CSS_CLASSES.HEADER + ' yui3-widget-hd"></div>'))
            .append(Y.Node.create('<div class="' + CSS_CLASSES.BODY + ' yui3-widget-bd"></div>'))
            .append(Y.Node.create('<div class="' + CSS_CLASSES.FOOTER + ' yui3-widget-ft"></div>')));
    config.attachmentPoint = config.attachmentPoint || document.body;
    Y.one(config.attachmentPoint).append(config.notificationBase);
    config.srcNode = '#' + id;
    delete config.buttons; // Don't let anyone pass in buttons as we want to control these during init. addButton can be used later.
    DIALOGUE.superclass.constructor.apply(this, [config]);
};
Y.extend(DIALOGUE, Y.Panel, {
    // Window resize event listener.
    _resizeevent: null,
    // Orientation change event listener.
    _orientationevent: null,
    _calculatedzindex: false,
    // Current maskNode id
    _currentMaskNodeId: null,
    /**
     * The original position of the dialogue before it was reposition to
     * avoid browser jumping.
     *
     * @property _originalPosition
     * @protected
     * @type Array
     */
    _originalPosition: null,

    /**
     * The list of elements that have been aria hidden when displaying
     * this dialogue.
     *
     * @property _hiddenSiblings
     * @protected
     * @type Array
     */
    _hiddenSiblings: null,

    /**
     * Hide the modal only if it doesn't contain a form.
     *
     * @method hideIfNotForm
     */
    hideIfNotForm: function() {
        var bb = this.get('boundingBox'),
            formElement = bb.one(FORM_SELECTOR);

        if (formElement === null) {
            this.hide();
        }
    },

    /**
     * Initialise the dialogue.
     *
     * @method initializer
     */
    initializer: function() {
        var bb;

        if (this.get('closeButton') !== false) {
            var title = this.get('closeButtonTitle');
            // The buttons constructor does not allow custom attributes.
            this.get('buttons').header[0].setAttribute('title', title);
            this.get('buttons').header[0].setAttribute('aria-label', title);
        }

        this.setStdModContent(Y.WidgetStdMod.HEADER,
            '<h5 id="' + this.get('id') + '-wrap-header-text">' + this.get('headerContent') + '</h5>',
            Y.WidgetStdMod.REPLACE);

        // Initialise the element cache.
        this._hiddenSiblings = [];

        if (this.get('render')) {
            this.render();
        }
        this.after('visibleChange', this.visibilityChanged, this);
        if (this.get('center')) {
            this.centerDialogue();
        }

        if (this.get('modal')) {
            // If we're a modal then make sure our container is ARIA
            // hidden by default. ARIA visibility is managed for modal dialogues.
            this.get(BASE).set('aria-hidden', 'true');
            this.plug(Y.M.core.LockScroll);
        }

        // Remove the `focusoutside` listener.
        // It conflicts with the ARIA focuslock manager which supports both YUI and non-YUI dialogues.
        this.set('focusOn', Y.Array(this.get('focusOn')).filter(function(node) {
            return node.eventName !== 'focusoutside';
        }));

        Y.one('document').on('orientationchange', function() {
            // This will detect a change in orientation and re-trigger centering.
            this.centerDialogOnVisible();
        }, this);

        Y.one('window').on('resize', function() {
            // Detect window resize (most browsers).
            this.centerDialogOnVisible();
        }, this);
        // Observe dialog on size change.
        this.centerDialogOnDialogSizeChange(this);

        // Workaround upstream YUI bug http://yuilibrary.com/projects/yui3/ticket/2532507
        // and allow setting of z-index in theme.
        bb = this.get('boundingBox');
        bb.addClass(HAS_ZINDEX);

        // Add any additional classes that were specified.
        Y.Array.each(this.get('extraClasses'), bb.addClass, bb);

        if (this.get('visible')) {
            this.applyZIndex();
            this.applyAndTrapFocus();
            // Only do accessibility hiding for modals because the ARIA spec
            // says that all ARIA dialogues should be modal.
            if (this.get('modal')) {
                // Make this dialogue visible to screen readers.
                this.setAccessibilityVisible();
            }
        }
        // Recalculate the zIndex every time the modal is altered.
        this.on('maskShow', this.applyZIndex);

        this.on('maskShow', function() {
            // When the mask shows, position the boundingBox at the top-left of the window such that when it is
            // focused, the position does not change.
            var w = Y.one(Y.config.win),
                bb = this.get('boundingBox');

            if (!this.get('center')) {
                this._originalPosition = bb.getXY();
            }

            // Check if maskNode already init click event.
            var maskNode = this.get('maskNode');
            if (this._currentMaskNodeId !== maskNode.get('_yuid')) {
                this._currentMaskNodeId = maskNode.get('_yuid');
                maskNode.on('click', this.hideIfNotForm, this);
            }

            if (bb.getStyle('position') !== 'fixed') {
                // If the boundingBox has been positioned in a fixed manner, then it will not position correctly to scrollTop.
                bb.setStyles({
                    top: w.get('scrollTop'),
                    left: w.get('scrollLeft')
                });
            }
        }, this);

        // Add any additional classes to the content node if required.
        var nBase = this.get('notificationBase');
        var additionalClasses = this.get('additionalBaseClass');
        if (additionalClasses !== '') {
            nBase.addClass(additionalClasses);
        }

        // Remove the dialogue from the DOM when it is destroyed.
        this.after('destroyedChange', function() {
            this.get(BASE).remove(true);
        }, this);
    },

    /**
     * Either set the zindex to the supplied value, or set it to one more than the highest existing
     * dialog in the page.
     *
     * @method applyZIndex
     */
    applyZIndex: function() {
        var highestzindex = 1040,
            zindexvalue = 1,
            bb = this.get('boundingBox'),
            ol = this.get('maskNode'),
            zindex = this.get('zIndex');
        if (zindex !== 0 && !this._calculatedzindex) {
            // The zindex was specified so we should use that.
            bb.setStyle('zIndex', zindex);
        } else {
            // Determine the correct zindex by looking at all existing dialogs and menubars in the page.
            Y.all(DIALOGUE_SELECTOR + ', ' + MENUBAR_SELECTOR + ', ' + DOT + HAS_ZINDEX).each(function(node) {
                var zindex = this.findZIndex(node);
                if (zindex > highestzindex) {
                    highestzindex = zindex;
                }
            }, this);
            // Only set the zindex if we found a wrapper.
            zindexvalue = (highestzindex + 1).toString();
            bb.setStyle('zIndex', zindexvalue);
            this.set('zIndex', zindexvalue);
            if (this.get('modal')) {
                ol.setStyle('zIndex', zindexvalue);

                // In IE8, the z-indexes do not take effect properly unless you toggle
                // the lightbox from 'fixed' to 'static' and back. This code does so
                // using the minimum setTimeouts that still actually work.
                if (Y.UA.ie && Y.UA.compareVersions(Y.UA.ie, 9) < 0) {
                    setTimeout(function() {
                        ol.setStyle('position', 'static');
                        setTimeout(function() {
                            ol.setStyle('position', 'fixed');
                        }, 0);
                    }, 0);
                }
            }
            this._calculatedzindex = true;
        }
    },

    /**
     * Finds the zIndex of the given node or its parent.
     *
     * @method findZIndex
     * @param {Node} node The Node to apply the zIndex to.
     * @return {Number} Either the zIndex, or 0 if one was not found.
     */
    findZIndex: function(node) {
        // In most cases the zindex is set on the parent of the dialog.
        var zindex = node.getStyle('zIndex') || node.ancestor().getStyle('zIndex');
        if (zindex) {
            return parseInt(zindex, 10);
        }
        return 0;
    },

    /**
     * Event listener for the visibility changed event.
     *
     * @method visibilityChanged
     * @param {EventFacade} e
     */
    visibilityChanged: function(e) {
        var titlebar, bb;
        if (e.attrName === 'visible') {
            this.get('maskNode').addClass(CSS_CLASSES.LIGHTBOX);
            // Going from visible to hidden.
            if (e.prevVal && !e.newVal) {
                bb = this.get('boundingBox');
                if (this._resizeevent) {
                    this._resizeevent.detach();
                    this._resizeevent = null;
                }
                if (this._orientationevent) {
                    this._orientationevent.detach();
                    this._orientationevent = null;
                }
                require(['core/local/aria/focuslock'], function(FocusLockManager) {
                    // Untrap focus when the dialogue is hidden.
                    FocusLockManager.untrapFocus();
                });

                if (this.get('modal')) {
                    // Hide this dialogue from screen readers.
                    this.setAccessibilityHidden();
                }
            }
            // Going from hidden to visible.
            if (!e.prevVal && e.newVal) {
                // This needs to be done each time the dialog is shown as new dialogs may have been opened.
                this.applyZIndex();
                // This needs to be done each time the dialog is shown as the window may have been resized.
                this.makeResponsive();
                if (!this.shouldResizeFullscreen()) {
                    if (this.get('draggable')) {
                        titlebar = '#' + this.get('id') + ' .' + CSS_CLASSES.HEADER;
                        this.plug(Y.Plugin.Drag, {handles: [titlebar]});
                        Y.one(titlebar).setStyle('cursor', 'move');
                    }
                }

                // Only do accessibility hiding for modals because the ARIA spec
                // says that all ARIA dialogues should be modal.
                if (this.get('modal')) {
                    // Make this dialogue visible to screen readers.
                    this.setAccessibilityVisible();
                }
            }
            if (this.get('center') && !e.prevVal && e.newVal) {
                this.centerDialogue();
            }
        }
    },
    /**
     * If the responsive attribute is set on the dialog, and the window size is
     * smaller than the responsive width - make the dialog fullscreen.
     *
     * @method makeResponsive
     */
    makeResponsive: function() {
        var bb = this.get('boundingBox');

        if (this.shouldResizeFullscreen()) {
            // Make this dialogue fullscreen on a small screen.
            // Disable the page scrollbars.

            // Size and position the fullscreen dialog.

            bb.addClass(DIALOGUE_FULLSCREEN_CLASS);
            bb.setStyles({'left': null,
                          'top': null,
                          'width': null,
                          'height': null,
                          'right': null,
                          'bottom': null});
        } else {
            if (this.get('responsive')) {
                // We must reset any of the fullscreen changes.
                bb.removeClass(DIALOGUE_FULLSCREEN_CLASS)
                    .setStyles({'width': this.get('width'),
                                'height': this.get('height')});
            }
        }

        // Update Lock scroll if the plugin is present.
        if (this.lockScroll) {
            this.lockScroll.updateScrollLock(this.shouldResizeFullscreen());
        }
    },
    /**
     * Center the dialog on the screen.
     *
     * @method centerDialogue
     */
    centerDialogue: function() {
        var bb = this.get('boundingBox'),
            hidden = bb.hasClass(DIALOGUE_HIDDEN_CLASS),
            x,
            y;

        // Don't adjust the position if we are in full screen mode.
        if (this.shouldResizeFullscreen()) {
            return;
        }
        if (hidden) {
            bb.setStyle('top', '-1000px').removeClass(DIALOGUE_HIDDEN_CLASS);
        }
        x = Math.max(Math.round((bb.get('winWidth') - bb.get('offsetWidth')) / 2), 15);
        y = Math.max(Math.round((bb.get('winHeight') - bb.get('offsetHeight')) / 2), 15) + Y.one(window).get('scrollTop');
        bb.setStyles({'left': x, 'top': y});

        if (hidden) {
            bb.addClass(DIALOGUE_HIDDEN_CLASS);
        }
        this.makeResponsive();
    },

    /**
     * Automatic re-center dialog when dialog size is changed.
     *
     * @method centerDialogOnDialogSizeChange
     * @param {M.core.dialogue} dialog object to apply centering.
     */
    centerDialogOnDialogSizeChange: function(dialog) {
        // ResizeObserver doesn't get recognized in JSHint.
        // So we need to suppress the false warning.
        var observer = new ResizeObserver(function() { // jshint ignore:line
            dialog.centerDialogOnVisible();
        });
        var bb = dialog.get('boundingBox');
        observer.observe(bb._node, {attributes: true, attributeFilter: ['class']});
    },

    /**
     * Centering dialog when dialog is visible.
     *
     * @method centerDialogOnVisible
     */
    centerDialogOnVisible: function() {
        if (!this.get('visible')) {
            return; // Only centre visible dialogue.
        }

        if (this.name !== DIALOGUE_NAME) {
            return; // Only centre agpu dialogues.
        }

        if (this.shouldResizeFullscreen()) {
            this.makeResponsive();
        }
        this.centerDialogue();
    },

    /**
     * Return whether this dialogue should be fullscreen or not.
     *
     * Responsive attribute must be true and we should not be in an iframe and the screen width should
     * be less than the responsive width.
     *
     * @method shouldResizeFullscreen
     * @return {Boolean}
     */
    shouldResizeFullscreen: function() {
        return (window === window.parent) && this.get('responsive') &&
               Math.floor(Y.one(document.body).get('winWidth')) < this.get('responsiveWidth');
    },

    _focus: function() {
        this.focus();
    },

    show: function() {
        var result = DIALOGUE.superclass.show.call(this);
        if (!this.get('center') && this._originalPosition) {
            // Restore the dialogue position to it's location before it was moved at show time.
            this.get('boundingBox').setXY(this._originalPosition);
        }
        this.applyAndTrapFocus();
        return result;
    },

    hide: function(e) {
        if (e) {
            // If the event was closed by an escape key event, then we need to check that this
            // dialogue is currently focused to prevent closing all dialogues in the stack.
            if (e.type === 'key' && e.keyCode === 27 && !this.get('focused')) {
                return;
            }
        }

        // Unlock scroll if the plugin is present.
        if (this.lockScroll) {
            this.lockScroll.disableScrollLock();
        }

        return DIALOGUE.superclass.hide.call(this, arguments);
    },
    /**
     * Setup key delegation to keep tabbing within the open dialogue.
     *
     * @method keyDelegation
     */
    keyDelegation: function() {
        Y.log('The keyDelegation function has been deprecated in favour of the AMD core/local/aria/focuslock module');
        var bb = this.get('boundingBox');
        bb.delegate('key', function(e) {
            var target = e.target;
            var direction = 'forward';
            if (e.shiftKey) {
                direction = 'backward';
            }
            if (this.trapFocus(target, direction)) {
                e.preventDefault();
            }
        }, 'down:9', CAN_RECEIVE_FOCUS_SELECTOR, this);
    },

    /**
     * Trap the tab focus within the open modal.
     *
     * @method trapFocus
     * @param {string} target the element target
     * @param {string} direction tab key for forward and tab+shift for backward
     * @return {Boolean} The result of the focus action.
     */
    trapFocus: function(target, direction) {
        var bb = this.get('boundingBox'),
            firstitem = bb.one(CAN_RECEIVE_FOCUS_SELECTOR),
            lastitem = bb.all(CAN_RECEIVE_FOCUS_SELECTOR).pop();

        if (target === lastitem && direction === 'forward') { // Tab key.
            return firstitem.focus();
        } else if (target === firstitem && direction === 'backward') {  // Tab+shift key.
            return lastitem.focus();
        }
    },

    /**
     * Sets the appropriate aria attributes on this dialogue and the other
     * elements in the DOM to ensure that screen readers are able to navigate
     * the dialogue popup correctly.
     *
     * @method setAccessibilityVisible
     */
    setAccessibilityVisible: function() {
        // Get the element that contains this dialogue because we need it
        // to filter out from the document.body child elements.
        var container = this.get(BASE);

        // We need to get a list containing each sibling element and the shallowest
        // non-ancestral nodes in the DOM. We can shortcut this a little by leveraging
        // the fact that this dialogue is always appended to the document body therefore
        // it's siblings are the shallowest non-ancestral nodes. If that changes then
        // this code should also be updated.
        Y.one(document.body).get('children').each(function(node) {
            // Skip the element that contains us.
            if (node !== container) {
                var hidden = node.get('aria-hidden');
                // If they are already hidden we can ignore them.
                if (hidden !== 'true') {
                    // Save their current state.
                    node.setData('previous-aria-hidden', hidden);
                    this._hiddenSiblings.push(node);

                    // Hide this node from screen readers.
                    node.set('aria-hidden', 'true');
                }
            }
        }, this);

        // Make us visible to screen readers.
        container.set('aria-hidden', 'false');
    },

    /**
     * Restores the aria visibility on the DOM elements changed when displaying
     * the dialogue popup and makes the dialogue aria hidden to allow screen
     * readers to navigate the main page correctly when the dialogue is closed.
     *
     * @method setAccessibilityHidden
     */
    setAccessibilityHidden: function() {
        var container = this.get(BASE);
        container.set('aria-hidden', 'true');

        // Restore the sibling nodes back to their original values.
        Y.Array.each(this._hiddenSiblings, function(node) {
            var previousValue = node.getData('previous-aria-hidden');
            // If the element didn't previously have an aria-hidden attribute
            // then we can just remove the one we set.
            if (previousValue === null) {
                node.removeAttribute('aria-hidden');
            } else {
                // Otherwise set it back to the old value (which will be false).
                node.set('aria-hidden', previousValue);
            }
        });

        // Clear the cache. No longer need to store these.
        this._hiddenSiblings = [];
    },

    /**
     * Focuses on the node specified by focusOnShowSelector, or the first focusable node if nothing is specified.
     * It also traps the focus to the current bounding box.
     *
     * @method applyAndTrapFocus
     */
    applyAndTrapFocus: function() {
        var content = this.bodyNode;
        var focusSelector = this.get('focusOnShowSelector');
        var focusNode = null;

        // Try and find a node to focus on using the focusOnShowSelector attribute.
        if (focusSelector !== null) {
            focusNode = this.get('boundingBox').one(focusSelector);
        }
        if (!focusNode) {
            // Fall back to the first focusable element in the body of the dialogue if no focus node was found yet.
            if (content && content !== '') {
                focusNode = content.one(CAN_RECEIVE_FOCUS_SELECTOR);
            }
        }
        require(['core/local/aria/focuslock'], function(FocusLockManager) {
            // Trap focus to the current bounding box.
            FocusLockManager.trapFocus(this.get('boundingBox').getDOMNode());
            if (focusNode) {
                focusNode.focus();
            }
        }.bind(this));
    },
}, {
    NAME: DIALOGUE_NAME,
    CSS_PREFIX: DIALOGUE_PREFIX,
    ATTRS: {
        /**
         * Any additional classes to add to the base Node.
         *
         * @attribute additionalBaseClass
         * @type String
         * @default ''
         */
        additionalBaseClass: {
            value: ''
        },

        /**
         * The Notification base Node.
         *
         * @attribute notificationBase
         * @type Node
         */
        notificationBase: {

        },

        /**
         * Whether to display the dialogue modally and with a
         * lightbox style.
         *
         * @attribute lightbox
         * @type Boolean
         * @default true
         * @deprecated Since agpu 2.7. Please use modal instead.
         */
        lightbox: {
            lazyAdd: false,
            setter: function(value) {
                Y.log("The lightbox attribute of M.core.dialogue has been deprecated since agpu 2.7, " +
                      "please use the modal attribute instead",
                    'warn', 'agpu-core-notification-dialogue');
                this.set('modal', value);
            }
        },

        /**
         * Whether to display a close button on the dialogue.
         *
         * Note, we do not recommend hiding the close button as this has
         * potential accessibility concerns.
         *
         * @attribute closeButton
         * @type Boolean
         * @default true
         */
        closeButton: {
            validator: Y.Lang.isBoolean,
            value: true
        },

        /**
         * The title for the close button if one is to be shown.
         *
         * @attribute closeButtonTitle
         * @type String
         * @default 'Close'
         */
        closeButtonTitle: {
            validator: Y.Lang.isString,
            value: M.util.get_string('closebuttontitle', 'agpu')
        },

        /**
         * Whether to display the dialogue centrally on the screen.
         *
         * @attribute center
         * @type Boolean
         * @default true
         */
        center: {
            validator: Y.Lang.isBoolean,
            value: true
        },

        /**
         * Whether to make the dialogue movable around the page.
         *
         * @attribute draggable
         * @type Boolean
         * @default false
         */
        draggable: {
            validator: Y.Lang.isBoolean,
            value: false
        },

        /**
         * Used to generate a unique id for the dialogue.
         *
         * @attribute COUNT
         * @type String
         * @default null
         * @writeonce
         */
        COUNT: {
            writeOnce: true,
            valueFn: function() {
                return Y.stamp(this);
            }
        },

        /**
         * Used to disable the fullscreen resizing behaviour if required.
         *
         * @attribute responsive
         * @type Boolean
         * @default true
         */
        responsive: {
            validator: Y.Lang.isBoolean,
            value: true
        },

        /**
         * The width that this dialogue should be resized to fullscreen.
         *
         * @attribute responsiveWidth
         * @type Number
         * @default 768
         */
        responsiveWidth: {
            value: 768
        },

        /**
         * Selector to a node that should recieve focus when this dialogue is shown.
         *
         * The default behaviour is to focus on the header.
         *
         * @attribute focusOnShowSelector
         * @default null
         * @type String
         */
        focusOnShowSelector: {
            value: null
        }
    }
});

Y.Base.modifyAttrs(DIALOGUE, {
    /**
     * String with units, or number, representing the width of the Widget.
     * If a number is provided, the default unit, defined by the Widgets
     * DEF_UNIT, property is used.
     *
     * If a value of 'auto' is used, then an empty String is instead
     * returned.
     *
     * @attribute width
     * @default '400px'
     * @type {String|Number}
     */
    width: {
        value: '400px',
        setter: function(value) {
            if (value === 'auto') {
                return '';
            }
            return value;
        }
    },

    /**
     * Boolean indicating whether or not the Widget is visible.
     *
     * We override this from the default Widget attribute value.
     *
     * @attribute visible
     * @default false
     * @type Boolean
     */
    visible: {
        value: false
    },

    /**
     * A convenience Attribute, which can be used as a shortcut for the
     * `align` Attribute.
     *
     * Note: We override this in agpu such that it sets a value for the
     * `center` attribute if set. The `centered` will always return false.
     *
     * @attribute centered
     * @type Boolean|Node
     * @default false
     */
    centered: {
        setter: function(value) {
            if (value) {
                this.set('center', true);
            }
            return false;
        }
    },

    /**
     * Boolean determining whether to render the widget during initialisation.
     *
     * We override this to change the default from false to true for the dialogue.
     * We then proceed to early render the dialogue during our initialisation rather than waiting
     * for YUI to render it after that.
     *
     * @attribute render
     * @type Boolean
     * @default true
     */
    render: {
        value: true,
        writeOnce: true
    },

    /**
     * Any additional classes to add to the boundingBox.
     *
     * @attribute extraClasses
     * @type Array
     * @default []
     */
    extraClasses: {
        value: []
    },

    /**
     * Identifier for the widget.
     *
     * @attribute id
     * @type String
     * @default a product of guid().
     * @writeOnce
     */
    id: {
        writeOnce: true,
        valueFn: function() {
            var id = 'agpu-dialogue-' + Y.stamp(this);
            return id;
        }
    },

    /**
     * Collection containing the widget's buttons.
     *
     * @attribute buttons
     * @type Object
     * @default {}
     */
    buttons: {
        getter: Y.WidgetButtons.prototype._getButtons,
        setter: Y.WidgetButtons.prototype._setButtons,
        valueFn: function() {
            if (this.get('closeButton') === false) {
                return null;
            } else {
                return [
                    {
                        section: Y.WidgetStdMod.HEADER,
                        classNames: 'closebutton',
                        action: function() {
                            this.hide();
                        }
                    }
                ];
            }
        }
    }
});

Y.Base.mix(DIALOGUE, [Y.M.core.WidgetFocusAfterHide]);

M.core.dialogue = DIALOGUE;
