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

namespace core_question\local\bank;

/**
 * Tracks all the contexts related to the one we are currently editing questions and provides helper methods to check permissions.
 *
 * @package   core_question
 * @copyright 2007 Jamie Pratt me@jamiep.org
 * @author    2021 Safat Shahin <safatshahin@catalyst-au.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class question_edit_contexts {

    /**
     * @var \string[][] array of the capabilities.
     */
    public static $caps = [
            'editq' => [
                    'agpu/question:add',
                    'agpu/question:editmine',
                    'agpu/question:editall',
                    'agpu/question:viewmine',
                    'agpu/question:viewall',
                    'agpu/question:usemine',
                    'agpu/question:useall',
                    'agpu/question:movemine',
                    'agpu/question:moveall'],
            'questions' => [
                    'agpu/question:add',
                    'agpu/question:editmine',
                    'agpu/question:editall',
                    'agpu/question:viewmine',
                    'agpu/question:viewall',
                    'agpu/question:movemine',
                    'agpu/question:moveall'],
            'categories' => [
                    'agpu/question:managecategory'],
            'import' => [
                    'agpu/question:add'],
            'export' => [
                    'agpu/question:viewall',
                    'agpu/question:viewmine']];

    /**
     * @var array of contexts.
     */
    protected $allcontexts;

    /**
     * Constructor
     * @param \context $thiscontext the current context.
     */
    public function __construct(\context $thiscontext) {
        $this->allcontexts = array_values($thiscontext->get_parent_contexts(true));
    }

    /**
     * Get all the contexts.
     *
     * @return \context[] all parent contexts
     */
    public function all() {
        return $this->allcontexts;
    }

    /**
     * Get the lowest context.
     *
     * @return \context lowest context which must be either the module or course context
     */
    public function lowest() {
        return $this->allcontexts[0];
    }

    /**
     * Get the contexts having cap.
     *
     * @param string $cap capability
     * @return \context[] parent contexts having capability, zero based index
     */
    public function having_cap($cap) {
        $contextswithcap = [];
        foreach ($this->allcontexts as $context) {
            if (has_capability($cap, $context)) {
                $contextswithcap[] = $context;
            }
        }
        return $contextswithcap;
    }

    /**
     * Get the contexts having at least one cap.
     *
     * @param array $caps capabilities
     * @return \context[] parent contexts having at least one of $caps, zero based index
     */
    public function having_one_cap($caps) {
        $contextswithacap = [];
        foreach ($this->allcontexts as $context) {
            foreach ($caps as $cap) {
                if (has_capability($cap, $context)) {
                    $contextswithacap[] = $context;
                    break; // Done with caps loop.
                }
            }
        }
        return $contextswithacap;
    }

    /**
     * Context having at least one cap.
     *
     * @param string $tabname edit tab name
     * @return \context[] parent contexts having at least one of $caps, zero based index
     */
    public function having_one_edit_tab_cap($tabname) {
        return $this->having_one_cap(self::$caps[$tabname]);
    }

    /**
     * Contexts for adding question and also using it.
     *
     * @return \context[] those contexts where a user can add a question and then use it.
     */
    public function having_add_and_use() {
        $contextswithcap = [];
        foreach ($this->allcontexts as $context) {
            if (!has_capability('agpu/question:add', $context)) {
                continue;
            }
            if (!has_any_capability(['agpu/question:useall', 'agpu/question:usemine'], $context)) {
                continue;
            }
            $contextswithcap[] = $context;
        }
        return $contextswithcap;
    }

    /**
     * Has at least one parent context got the cap $cap?
     *
     * @param string $cap capability
     * @return boolean
     */
    public function have_cap($cap) {
        return (count($this->having_cap($cap)));
    }

    /**
     * Has at least one parent context got one of the caps $caps?
     *
     * @param array $caps capability
     * @return boolean
     */
    public function have_one_cap($caps) {
        foreach ($caps as $cap) {
            if ($this->have_cap($cap)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Has at least one parent context got one of the caps for actions on $tabname
     *
     * @param string $tabname edit tab name
     * @return boolean
     */
    public function have_one_edit_tab_cap($tabname) {
        return $this->have_one_cap(self::$caps[$tabname]);
    }

    /**
     * Throw error if at least one parent context hasn't got the cap $cap
     *
     * @param string $cap capability
     */
    public function require_cap($cap) {
        if (!$this->have_cap($cap)) {
            throw new \agpu_exception('nopermissions', '', '', $cap);
        }
    }

    /**
     * Throw error if at least one parent context hasn't got one of the caps $caps
     *
     * @param array $caps capabilities
     */
    public function require_one_cap($caps) {
        if (!$this->have_one_cap($caps)) {
            $capsstring = join(', ', $caps);
            throw new \agpu_exception('nopermissions', '', '', $capsstring);
        }
    }

    /**
     * Throw error if at least one parent context hasn't got one of the caps $caps
     *
     * @param string $tabname edit tab name
     */
    public function require_one_edit_tab_cap($tabname) {
        if (!$this->have_one_edit_tab_cap($tabname)) {
            throw new \agpu_exception('nopermissions', '', '', 'access question edit tab '.$tabname);
        }
    }
}
