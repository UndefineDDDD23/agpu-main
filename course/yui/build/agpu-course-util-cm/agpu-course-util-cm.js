YUI.add('agpu-course-util-cm', function (Y, NAME) {

/**
 * A collection of utility classes for use with course modules.
 *
 * @module agpu-course-util
 * @submodule agpu-course-util-cm
 */

Y.namespace('agpu.core_course.util.cm');

/**
 * A collection of utility classes for use with course modules.
 *
 * @class agpu.core_course.util.cm
 * @static
 */
Y.agpu.core_course.util.cm = {
    CONSTANTS: {
        MODULEIDPREFIX: 'module-'
    },
    SELECTORS: {
        COURSEMODULE: '.activity',
        INSTANCENAME: '.instancename'
    },

    /**
     * Retrieve the course module item from one of it's child Nodes.
     *
     * @method getCourseModuleNodeFromComponent
     * @param coursemodulecomponent {Node} The component Node.
     * @return {Node|null} The Course Module Node.
     */
    getCourseModuleFromComponent: function(coursemodulecomponent) {
        return Y.one(coursemodulecomponent).ancestor(this.SELECTORS.COURSEMODULE, true);
    },

    /**
     * Determines the section ID for the provided section.
     *
     * @method getId
     * @param coursemodule {Node} The course module to find an ID for.
     * @return {Number|false} The ID of the course module in question or false if no ID was found.
     */
    getId: function(coursemodule) {
        // We perform a simple substitution operation to get the ID.
        var id = coursemodule.get('id').replace(
                this.CONSTANTS.MODULEIDPREFIX, '');

        // Attempt to validate the ID.
        id = parseInt(id, 10);
        if (typeof id === 'number' && isFinite(id)) {
            return id;
        }
        return false;
    },

    /**
     * Determines the section ID for the provided section.
     *
     * @method getName
     * @param coursemodule {Node} The course module to find an ID for.
     * @return {Number|false} The ID of the course module in question or false if no ID was found.
     */
    getName: function(coursemodule) {
        var instance = coursemodule.one(this.SELECTORS.INSTANCENAME);
        if (instance) {
            return instance.get('firstChild').get('data');
        }
        return null;
    }
};


}, '@VERSION@', {"requires": ["node", "agpu-course-util-base"]});
