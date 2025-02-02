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
 * This file contains the interface required to implmeent a content writer.
 *
 * @package core_privacy
 * @copyright 2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_privacy\local\request;

defined('agpu_INTERNAL') || die();

/**
 * The writer factory class used to fetch and work with the content_writer.
 *
 * @copyright 2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class writer {
    /**
     * @var writer The singleton instance of this writer.
     */
    protected static $instance = null;

    /**
     * @var content_writer The current content_writer instance.
     */
    protected $realwriter = null;

    /**
     * Constructor for the content writer.
     *
     * Protected to prevent direct instantiation.
     */
    protected function __construct() {
    }

    /**
     * Singleton to return or create and return a copy of a content_writer.
     *
     * @return  content_writer
     */
    protected function get_writer_instance(): content_writer {
        if (null === $this->realwriter) {
            if (PHPUNIT_TEST) {
                $this->realwriter = new \core_privacy\tests\request\content_writer(static::instance());
            } else {
                $this->realwriter = new agpu_content_writer(static::instance());
            }
        }

        return $this->realwriter;
    }

    /**
     * Create a real content_writer for use by PHPUnit tests,
     * where a mock writer will not suffice.
     *
     * @return  content_writer
     */
    public static function setup_real_writer_instance() {
        if (!PHPUNIT_TEST) {
            throw new \coding_exception('setup_real_writer_instance() is only for use with PHPUnit tests.');
        }

        $instance = static::instance();

        if (null === $instance->realwriter) {
            $instance->realwriter = new agpu_content_writer(static::instance());
        }
    }

    /**
     * Return an instance of
     */
    final protected static function instance() {
        if (null === self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Reset the writer and content_writer.
     */
    final public static function reset() {
        static::$instance = null;
    }

    /**
     * Provide an instance of the writer with the specified context applied.
     *
     * @param   \context        $context    The context to apply
     * @return  content_writer              The content_writer
     */
    public static function with_context(\context $context): content_writer {
        return static::instance()
            ->get_writer_instance()
            ->set_context($context);
    }

    /**
     * Export the specified user preference.
     *
     * @param   string          $component  The name of the component.
     * @param   string          $key        The name of th key to be exported.
     * @param   string          $value      The value of the preference
     * @param   string          $description    A description of the value
     * @return  content_writer
     */
    public static function export_user_preference(
        string $component,
        string $key,
        string $value,
        string $description
    ): content_writer {
        return static::with_context(\context_system::instance())
            ->export_user_preference($component, $key, $value, $description);
    }
}
