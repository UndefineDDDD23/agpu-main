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

namespace core_message;

use core_cache\data_source_interface;
use core_cache\definition;

/**
 * Cache data source for the time of the last message in a conversation.
 *
 * @package    core_message
 * @category   cache
 * @copyright  2016 Ryan Wyllie <ryan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class time_last_message_between_users implements data_source_interface {

    /** @var time_last_message_between_users the singleton instance of this class. */
    protected static $instance = null;

    /**
     * Returns an instance of the data source class that the cache can use for loading data using the other methods
     * specified by the data_source_interface interface.
     *
     * @param definition $definition
     * @return object
     */
    public static function get_instance_for_cache(definition $definition) {
        if (is_null(self::$instance)) {
            self::$instance = new time_last_message_between_users();
        }
        return self::$instance;
    }

    /**
     * Loads the data for the key provided ready formatted for caching.
     *
     * @param string|int $key The key to load.
     * @return mixed What ever data should be returned, or false if it can't be loaded.
     */
    public function load_for_cache($key) {
        $message = api::get_most_recent_conversation_message($key);

        if ($message) {
            return $message->timecreated;
        } else {
            return null;
        }
    }

    /**
     * Loads several keys for the cache.
     *
     * @param array $keys An array of keys each of which will be string|int.
     * @return array An array of matching data items.
     */
    public function load_many_for_cache(array $keys) {
        $results = [];

        foreach ($keys as $key) {
            $results[] = $this->load_for_cache($key);
        }

        return $results;
    }
}
