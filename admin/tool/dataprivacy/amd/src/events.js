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
 * Contain the events the data privacy tool can fire.
 *
 * @module     tool_dataprivacy/events
 * @copyright  2018 Jun Pataleta
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
export default {
    approve: 'tool_dataprivacy-data_request:approve',
    bulkApprove: 'tool_dataprivacy-data_request:bulk_approve',
    deny: 'tool_dataprivacy-data_request:deny',
    bulkDeny: 'tool_dataprivacy-data_request:bulk_deny',
    complete: 'tool_dataprivacy-data_request:complete',
    approveSelectCourses: 'tool_dataprivacy-data_request:approve-selected-courses'
};
