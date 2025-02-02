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

/**
 * Lock configuration class, used to get an instance of the currently configured lock factory.
 *
 * @package    core
 * @category   lock
 * @copyright  Damyon Wiese 2013
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\lock;

defined('agpu_INTERNAL') || die();

/**
 * Lock configuration class, used to get an instance of the currently configured lock factory.
 *
 * @package   core
 * @category  lock
 * @copyright Damyon Wiese 2013
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class lock_config {

    /**
     * Get the currently configured locking subclass.
     *
     * @return string class name
     * @throws \coding_exception
     */
    public static function get_lock_factory_class(): string {

        global $CFG, $DB;

        if (during_initial_install()) {
            $lockfactoryclass = '\core\lock\installation_lock_factory';
        } else if (isset($CFG->lock_factory) && $CFG->lock_factory != 'auto') {
            if (!class_exists($CFG->lock_factory)) {
                // In this case I guess it is not safe to continue. Different cluster nodes could end up using different locking
                // types because of an installation error.
                throw new \coding_exception('Lock factory set in $CFG does not exist: ' . $CFG->lock_factory);
            }
            $lockfactoryclass = $CFG->lock_factory;
        } else {
            $dbtype = clean_param($DB->get_dbfamily(), PARAM_ALPHA);

            // DB Specific lock factory is preferred - should support auto-release.
            $lockfactoryclass = "\\core\\lock\\{$dbtype}_lock_factory";
            if (!class_exists($lockfactoryclass)) {
                $lockfactoryclass = '\core\lock\file_lock_factory';
            }

            // Test if the auto chosen lock factory is available.
            $lockfactory = new $lockfactoryclass('test');
            if (!$lockfactory->is_available()) {
                // Final fallback - DB row locking.
                $lockfactoryclass = '\core\lock\db_record_lock_factory';
            }
        }

        return $lockfactoryclass;
    }

    /**
     * Get an instance of the currently configured locking subclass.
     *
     * @param string $type - Unique namespace for the locks generated by this factory. e.g. core_cron
     * @return \core\lock\lock_factory
     * @throws \coding_exception
     */
    public static function get_lock_factory(string $type): \core\lock\lock_factory {
        global $CFG;

        $lockfactoryclass = self::get_lock_factory_class();
        $lockfactory = new $lockfactoryclass($type);
        if (!$lockfactory->is_available()) {
            throw new \coding_exception("Lock factory class $lockfactoryclass is not available.");
        }

        // If tracking performance, insert a timing wrapper to keep track of lock delays.
        if (MDL_PERF || (!empty($CFG->perfdebug) && $CFG->perfdebug > 7)) {
            $wrapper = new timing_wrapper_lock_factory($type, $lockfactory);
            $lockfactory = $wrapper;
        }

        return $lockfactory;
    }

}
