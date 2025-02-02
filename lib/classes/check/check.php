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
 * Base class for checks
 *
 * @package    core
 * @category   check
 * @copyright  2020 Brendan Heywood <brendan@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core\check;

use coding_exception;

/**
 * Base class for checks
 *
 * @copyright  2020 Brendan Heywood <brendan@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class check {

    /**
     * @var string $component - The component / plugin this task belongs to.
     *
     * This can be autopopulated by the check manager.
     * Otherwise, it is dynamically determined by get_component().
     */
    protected $component = '';

    /**
     * Get the frankenstyle component name
     *
     * @return string
     */
    public function get_component(): string {
        // Return component if has been set by the manager.
        if (!empty($this->component)) {
            return $this->component;
        }

        // Else work it out based on the classname.
        // Because the first part of the classname is always the component.
        $parts = explode("\\", get_called_class());

        if (empty($parts)) {
            throw new coding_exception("Unable to determine component for check");
        }

        return $parts[0];
    }

    /**
     * Get the frankenstyle component name
     *
     * @param string $component name
     */
    public function set_component(string $component) {
        $this->component = $component;
    }

    /**
     * Get the check's id
     *
     * This defaults to the base name of the class which is ok in the most
     * cases but if you have a check which can have multiple instances then
     * you should override this to be unique.
     *
     * @return string must be unique within a component
     */
    public function get_id(): string {
        $class = get_class($this);
        $id = explode("\\", $class);
        return end($id);
    }

    /**
     * Get the check reference
     *
     * @return string must be globally unique
     */
    public function get_ref(): string {
        $ref = $this->get_component();
        if (!empty($ref)) {
            $ref .= '_';
        }
        $ref .= $this->get_id();
        return $ref;
    }

    /**
     * Get the short check name
     *
     * @return string
     */
    public function get_name(): string {
        $id = $this->get_id();
        return get_string("check{$id}", $this->get_component());
    }

    /**
     * A link to a place to action this
     *
     * @return \action_link|null
     */
    public function get_action_link(): ?\action_link {
        return null;
    }

    /**
     * Return the result
     *
     * @return result object
     */
    abstract public function get_result(): result;

}

