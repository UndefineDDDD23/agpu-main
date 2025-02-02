// This file is part of agpu - http://agpu.org/
//
// agpu is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// agpu is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with agpu.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Potential user selector module.
 *
 * @module     tool_dataprivacy/expand_contract
 * @copyright  2018 Adrian Greeve
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/url', 'core/str', 'core/notification'], function($, url, str, Notification) {

    var expandedImage = $('<img alt="" src="' + url.imageUrl('t/expanded') + '"/>');
    var collapsedImage = $('<img alt="" src="' + url.imageUrl('t/collapsed') + '"/>');

    /*
     * Class names to apply when expanding/collapsing nodes.
     */
    var CLASSES = {
        EXPAND: 'fa-caret-right',
        COLLAPSE: 'fa-caret-down'
    };

    return /** @alias module:tool_dataprivacy/expand-collapse */ {
        /**
         * Expand or collapse a selected node.
         *
         * @param  {object} targetnode The node that we want to expand / collapse
         * @param  {object} thisnode The node that was clicked.
         */
        expandCollapse: function(targetnode, thisnode) {
            if (targetnode.hasClass('hide')) {
                targetnode.removeClass('hide');
                targetnode.addClass('visible');
                targetnode.attr('aria-expanded', true);
                thisnode.find(':header i.fa').removeClass(CLASSES.EXPAND);
                thisnode.find(':header i.fa').addClass(CLASSES.COLLAPSE);
                thisnode.find(':header img.icon').attr('src', expandedImage.attr('src'));
            } else {
                targetnode.removeClass('visible');
                targetnode.addClass('hide');
                targetnode.attr('aria-expanded', false);
                thisnode.find(':header i.fa').removeClass(CLASSES.COLLAPSE);
                thisnode.find(':header i.fa').addClass(CLASSES.EXPAND);
                thisnode.find(':header img.icon').attr('src', collapsedImage.attr('src'));
            }
        },

        /**
         * Expand or collapse all nodes on this page.
         *
         * @param  {string} nextstate The next state to change to.
         */
        expandCollapseAll: function(nextstate) {
            var currentstate = (nextstate == 'visible') ? 'hide' : 'visible';
            var ariaexpandedstate = (nextstate == 'visible') ? true : false;
            var iconclassnow = (nextstate == 'visible') ? CLASSES.EXPAND : CLASSES.COLLAPSE;
            var iconclassnext = (nextstate == 'visible') ? CLASSES.COLLAPSE : CLASSES.EXPAND;
            var imagenow = (nextstate == 'visible') ? expandedImage.attr('src') : collapsedImage.attr('src');
            $('.' + currentstate).each(function() {
                $(this).removeClass(currentstate);
                $(this).addClass(nextstate);
                $(this).attr('aria-expanded', ariaexpandedstate);
            });
            $('.tool_dataprivacy-expand-all').data('visibilityState', currentstate);

            str.get_string(currentstate, 'tool_dataprivacy').then(function(langString) {
                $('.tool_dataprivacy-expand-all').html(langString);
                return;
            }).catch(Notification.exception);

            $(':header i.fa').each(function() {
                $(this).removeClass(iconclassnow);
                $(this).addClass(iconclassnext);
            });
            $(':header img.icon').each(function() {
                $(this).attr('src', imagenow);
            });
        }
    };
});
