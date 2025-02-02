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
 * This module adds ajax search functions to the template library page.
 *
 * @module     tool_templatelibrary/search
 * @copyright  2015 Damyon Wiese <damyon@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery', 'core/ajax', 'core/log', 'core/notification', 'core/templates', 'core/config'],
       function($, ajax, log, notification, templates, config) {

    /**
     * The ajax call has returned with a new list of templates.
     *
     * @method reloadListTemplate
     * @param {String[]} templateList List of template ids.
     */
    var reloadListTemplate = function(templateList) {
        templates.render('tool_templatelibrary/search_results', {templates: templateList})
            .done(function(result, js) {
                templates.replaceNode($('[data-region="searchresults"]'), result, js);
            }).fail(notification.exception);
    };

    /**
     * Get the current values for the form inputs and refresh the list of matching templates.
     *
     * @method refreshSearch
     * @param {String} themename The naeme of the theme.
     */
    var refreshSearch = function(themename) {
        var componentStr = $('[data-field="component"]').val();
        var searchStr = $('[data-region="list-templates"] [data-region="input"]').val();

        if (searchStr !== '') {
            $('[data-region="list-templates"] [data-action="clearsearch"]').removeClass('d-none');
        } else {
            $('[data-region="list-templates"] [data-action="clearsearch"]').addClass('d-none');
        }

        // Trigger the search.
        ajax.call([
            {methodname: 'tool_templatelibrary_list_templates',
              args: {component: componentStr, search: searchStr, themename: themename},
              done: reloadListTemplate,
              fail: notification.exception}
        ], true, false);
    };

    var throttle = null;

    /**
     * Call the specified function after a delay. If this function is called again before the function is executed,
     * the function will only be executed once.
     *
     * @method queueRefresh
     * @param {function} callback
     * @param {Number} delay The time in milliseconds to delay.
     */
    var queueRefresh = function(callback, delay) {
        if (throttle !== null) {
            window.clearTimeout(throttle);
        }

        throttle = window.setTimeout(function() {
            callback();
            throttle = null;
        }, delay);
    };

    var changeHandler = function() {
        queueRefresh(refreshSearch.bind(this, config.theme), 400);
    };
    // Add change handlers to refresh the list.
    $('[data-region="list-templates"]').on('change', '[data-field="component"]', changeHandler);
    $('[data-region="list-templates"]').on('input', '[data-region="input"]', changeHandler);
    $('[data-action="clearsearch"]').on('click', function() {
        $('[data-region="input"]').val('');
        refreshSearch(config.theme);
        $(this).addClass('d-none');
    });

    refreshSearch(config.theme);
    return {};
});
