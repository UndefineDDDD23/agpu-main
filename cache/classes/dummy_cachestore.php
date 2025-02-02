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

namespace core_cache;

/**
 * The cache dummy store.
 *
 * @copyright  2012 Sam Hemelryk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package core_cache
 */
class dummy_cachestore extends store {
    /**
     * The name of this store.
     * @var string
     */
    protected $name;

    /**
     * Gets set to true if this store is going to store data.
     * This happens when the definition doesn't require static acceleration as the loader will not be storing information and
     * something has to.
     * @var bool
     */
    protected $persist = false;

    /**
     * The stored data array
     * @var array
     */
    protected $store = [];

    /**
     * Cache definition
     * @var definition
     */
    protected $definition;

    /**
     * Constructs a dummy store instance.
     * @param string $name
     * @param array $configuration
     */
    public function __construct($name = 'Dummy store', array $configuration = []) {
        $this->name = $name;
    }

    /**
     * Returns true if this store plugin is usable.
     * @return bool
     */
    public static function are_requirements_met() {
        return true;
    }

    /**
     * Returns true if the user can add an instance.
     * @return bool
     */
    public static function can_add_instance() {
        return false;
    }

    /**
     * Returns the supported features.
     * @param array $configuration
     * @return int
     */
    public static function get_supported_features(array $configuration = []) {
        return store::SUPPORTS_NATIVE_TTL;
    }

    /**
     * Returns the supported mode.
     * @param array $configuration
     * @return int
     */
    public static function get_supported_modes(array $configuration = []) {
        return store::MODE_APPLICATION + store::MODE_REQUEST + store::MODE_SESSION;
    }

    /**
     * Initialises the store instance for a definition.
     * @param definition $definition
     */
    public function initialise(definition $definition) {
        // If the definition isn't using static acceleration then we need to be store data here.
        // The reasoning behind this is that:
        // - If the definition is using static acceleration then the cache loader is going to
        // store things in its static array.
        // - If the definition is not using static acceleration then the cache loader won't try to store anything
        // and we will need to store it here in order to make sure it is accessible.
        if ($definition->get_mode() !== store::MODE_APPLICATION) {
            // Neither the request cache nor the session cache provide static acceleration.
            $this->persist = true;
        } else {
            $this->persist = !$definition->use_static_acceleration();
        }

        $this->definition = $definition;
    }

    /**
     * Returns true if this has been initialised.
     * @return bool
     */
    public function is_initialised() {
        return (!empty($this->definition));
    }

    /**
     * Returns true the given mode is supported.
     * @param int $mode
     * @return bool
     */
    public static function is_supported_mode($mode) {
        return true;
    }

    /**
     * Returns the data for the given key
     * @param string $key
     * @return string|false
     */
    public function get($key) {
        if ($this->persist && array_key_exists($key, $this->store)) {
            return $this->store[$key];
        }
        return false;
    }

    /**
     * Gets' the values for many keys
     * @param array $keys
     * @return bool
     */
    public function get_many($keys) {
        $return = [];
        foreach ($keys as $key) {
            if ($this->persist && array_key_exists($key, $this->store)) {
                $return[$key] = $this->store[$key];
            } else {
                $return[$key] = false;
            }
        }
        return $return;
    }

    /**
     * Sets an item in the cache
     * @param string $key
     * @param mixed $data
     * @return bool
     */
    public function set($key, $data) {
        if ($this->persist) {
            $this->store[$key] = $data;
        }
        return true;
    }

    /**
     * Sets many items in the cache
     * @param array $keyvaluearray
     * @return int
     */
    public function set_many(array $keyvaluearray) {
        if ($this->persist) {
            foreach ($keyvaluearray as $pair) {
                $this->store[$pair['key']] = $pair['value'];
            }
        }
        return count($keyvaluearray);
    }

    /**
     * Deletes an item from the cache
     * @param string $key
     * @return bool
     */
    public function delete($key) {
        unset($this->store[$key]);
        return true;
    }
    /**
     * Deletes many items from the cache
     * @param array $keys
     * @return bool
     */
    public function delete_many(array $keys) {
        if ($this->persist) {
            foreach ($keys as $key) {
                unset($this->store[$key]);
            }
        }
        return count($keys);
    }

    /**
     * Deletes all of the items from the cache.
     * @return bool
     */
    public function purge() {
        $this->store = [];
        return true;
    }

    /**
     * Performs any necessary clean up when the store instance is being deleted.
     *
     * @deprecated since 3.2
     * @see dummy_cachestore::instance_deleted()
     */
    public function cleanup() {
        debugging(
            'dummy_cachestore::cleanup() is deprecated. Please use dummy_cachestore::instance_deleted() instead.',
            DEBUG_DEVELOPER
        );
        $this->instance_deleted();
    }

    /**
     * Performs any necessary operation when the store instance is being deleted.
     *
     * This method may be called before the store has been initialised.
     *
     * @since agpu 3.2
     */
    public function instance_deleted() {
        $this->purge();
    }

    /**
     * Generates an instance of the cache store that can be used for testing.
     *
     * @param definition $definition
     * @return self
     */
    public static function initialise_test_instance(definition $definition) {
        $cache = new dummy_cachestore('Dummy store test');
        if ($cache->is_ready()) {
            $cache->initialise($definition);
        }
        return $cache;
    }

    /**
     * Generates the appropriate configuration required for unit testing.
     *
     * @return array Array of unit test configuration data to be used by initialise().
     */
    public static function unit_test_configuration() {
        return [];
    }

    /**
     * Returns the name of this instance.
     * @return string
     */
    public function my_name() {
        return $this->name;
    }
}

// Alias this class to the old name.
// This file will be autoloaded by the legacyclasses autoload system.
// In future all uses of this class will be corrected and the legacy references will be removed.
class_alias(dummy_cachestore::class, \cachestore_dummy::class);
