/**
 * Provides the agpu Calendar class.
 *
 * @module agpu-form-dateselector
 */

/**
 * A class to overwrite the YUI3 Calendar in order to change the strings..
 *
 * @class M.form_agpucalendar
 * @constructor
 * @extends Calendar
 */
agpuCALENDAR = function() {
    agpuCALENDAR.superclass.constructor.apply(this, arguments);
};

Y.extend(agpuCALENDAR, Y.Calendar, {
        initializer: function(cfg) {
            this.set("strings.very_short_weekdays", cfg.WEEKDAYS_MEDIUM);
            this.set("strings.first_weekday", cfg.firstdayofweek);
        }
    }, {
        NAME: 'Calendar',
        ATTRS: {}
    }
);

M.form_agpucalendar = M.form_agpucalendar || {};
M.form_agpucalendar.initializer = function(params) {
    return new agpuCALENDAR(params);
};
