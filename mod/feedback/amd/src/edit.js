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
 * Edit items in feedback module
 *
 * @module     mod_feedback/edit
 * @copyright  2016 Marina Glancy
 */
define(['jquery', 'core/ajax', 'core/str', 'core/notification'],
function($, ajax, str, notification) {
    var manager = {
        deleteItem: function(e) {
            e.preventDefault();
            var targetUrl = $(e.currentTarget).attr('href');

            str.get_strings([
                {
                    key:        'confirmation',
                    component:  'admin'
                },
                {
                    key:        'confirmdeleteitem',
                    component:  'mod_feedback'
                },
                {
                    key:        'yes',
                    component:  'agpu'
                },
                {
                    key:        'no',
                    component:  'agpu'
                }
            ])
            .then(function(s) {
                notification.confirm(s[0], s[1], s[2], s[3], function() {
                    window.location = targetUrl;
                });

                return;
            })
            .catch();
        },

        setup: function() {
            $('body').delegate('[data-action="delete"]', 'click', manager.deleteItem);
        }
    };

    return {
        setup: manager.setup
    };
});
