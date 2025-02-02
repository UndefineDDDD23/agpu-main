<?php
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

declare(strict_types=1);

namespace core_reportbuilder\event;

use coding_exception;
use core\event\base;
use core_reportbuilder\local\models\audience;
use agpu_url;

/**
 * Report builder custom report audience deleted event class.
 *
 * @package     core_reportbuilder
 * @copyright   2021 David Matamoros <davidmc@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int    reportid:      The id of the report
 * }
 */
class audience_deleted extends base {

    /**
     * Initialise the event data.
     */
    protected function init() {
        $this->data['objecttable'] = audience::TABLE;
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Creates an instance from a report audience object
     *
     * @param audience $audience
     * @return self
     */
    public static function create_from_object(audience $audience): self {
        $eventparams = [
            'context'  => $audience->get_report()->get_context(),
            'objectid' => $audience->get('id'),
            'other' => [
                'reportid' => $audience->get('reportid'),
            ]
        ];
        $event = self::create($eventparams);
        $event->add_record_snapshot($event->objecttable, $audience->to_record());
        return $event;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('audiencedeletedevent', 'core_reportbuilder');
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        $reportid = $this->other['reportid'];
        return "The user with id '$this->userid' deleted the audience with id '$this->objectid' in the custom report" .
            " with id '$reportid'.";
    }

    /**
     * Custom validations.
     *
     * @throws coding_exception
     */
    protected function validate_data(): void {
        parent::validate_data();
        if (!isset($this->objectid)) {
            throw new coding_exception('The \'objectid\' must be set.');
        }
        if (!isset($this->other['reportid'])) {
            throw new coding_exception('The \'reportid\' must be set in other.');
        }
    }

    /**
     * Returns relevant URL.
     *
     * @return agpu_url
     */
    public function get_url(): agpu_url {
        return new agpu_url('/reportbuilder/edit.php', ['id' => $this->other['reportid']], 'audience');
    }
}
