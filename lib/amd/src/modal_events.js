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
 * Contain the events a modal can fire.
 *
 * @module     core/modal_events
 * @class      modal_events
 * @copyright  2016 Ryan Wyllie <ryan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
export default {
    // Default events.
    shown: 'modal:shown',
    hidden: 'modal:hidden',
    destroyed: 'modal:destroyed',
    bodyRendered: 'modal:bodyRendered',
    outsideClick: 'modal:outsideClick',
    // ModalSaveCancel events.
    save: 'modal-save-cancel:save',
    'delete': 'modal-delete-cancel:delete', // Delete is a reserved word.
    cancel: 'modal-save-cancel:cancel',
};
