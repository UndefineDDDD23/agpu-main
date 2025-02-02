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
 * Block generator base class.
 *
 * @package    core
 * @category   test
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * Block generator base class.
 *
 * Extend in blocks/xxxx/tests/generator/lib.php as class block_xxxx_generator.
 *
 * @package    core
 * @category   test
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class testing_block_generator extends component_generator_base {
    /** @var int number of created instances */
    protected $instancecount = 0;

    /**
     * To be called from data reset code only,
     * do not use in tests.
     * @return void
     */
    public function reset() {
        $this->instancecount = 0;
    }

    /**
     * Returns block name
     * @return string name of block that this class describes
     * @throws coding_exception if class invalid
     */
    public function get_blockname() {
        $matches = null;
        if (!preg_match('/^block_([a-z0-9_]+)_generator$/', get_class($this), $matches)) {
            throw new coding_exception('Invalid block generator class name: '.get_class($this));
        }

        if (empty($matches[1])) {
            throw new coding_exception('Invalid block generator class name: '.get_class($this));
        }
        return $matches[1];
    }

    /**
     * Fill in record defaults.
     *
     * @param stdClass $record
     * @return stdClass
     */
    protected function prepare_record(stdClass $record) {
        $record->blockname = $this->get_blockname();
        if (!isset($record->parentcontextid)) {
            $record->parentcontextid = context_system::instance()->id;
        }
        if (!isset($record->showinsubcontexts)) {
            $record->showinsubcontexts = 0;
        }
        if (!isset($record->pagetypepattern)) {
            $record->pagetypepattern = '*';
        }
        if (!isset($record->subpagepattern)) {
            $record->subpagepattern = null;
        }
        if (!isset($record->defaultregion)) {
            $record->defaultregion = 'side-pre';
        }
        if (!isset($record->defaultweight)) {
            $record->defaultweight = 5;
        }
        if (!isset($record->configdata)) {
            $record->configdata = null;
        }
        return $record;
    }

    /**
     * Create a test block instance.
     *
     * The $record passed in becomes the basis for the new row added to the
     * block_instances table. You only need to supply the values of interest.
     * Any missing values have sensible defaults filled in.
     *
     * The $options array provides additional data, not directly related to what
     * will be inserted in the block_instance table, which may affect the block
     * that is created. The meanings of any data passed here depends on the particular
     * type of block being created.
     *
     * @param array|stdClass $record forms the basis for the entry to be inserted in the block_instances table.
     * @param array $options further, block-specific options to control how the block is created.
     * @return stdClass the block_instance record that has just been created.
     */
    public function create_instance($record = null, $options = array()) {
        global $DB, $PAGE;

        $this->instancecount++;

        // Creating a block is a back end operation, which should not cause any output to happen.
        // This will allow us to check that the theme was not initialised while creating the block instance.
        $outputstartedbefore = $PAGE->get_where_theme_was_initialised();

        $record = (object)(array)$record;
        $this->preprocess_record($record, $options);
        $record = $this->prepare_record($record);

        if (empty($record->timecreated)) {
            $record->timecreated = time();
        }
        if (empty($record->timemodified)) {
            $record->timemodified = time();
        }

        $id = $DB->insert_record('block_instances', $record);
        context_block::instance($id);

        $instance = $DB->get_record('block_instances', array('id' => $id), '*', MUST_EXIST);

        // If the theme was initialised while creating the block instance, something somewhere called an output
        // function. Rather than leaving this as a hard-to-debug situation, let's make it fail with a clear error.
        $outputstartedafter = $PAGE->get_where_theme_was_initialised();

        if ($outputstartedbefore === null && $outputstartedafter !== null) {
            throw new coding_exception('Creating a block_' . $this->get_blockname() . ' initialised the theme and output!',
                'This should not happen. Creating a block should be a pure back-end operation. Unnecessarily initialising ' .
                'the output mechanism at the wrong time can cause subtle bugs and is a significant performance hit. There is ' .
                'likely a call to an output function that caused it:' . PHP_EOL . PHP_EOL .
                format_backtrace($outputstartedafter, true));
        }

        return $instance;
    }

    /**
     * Can be overridden to do block-specific processing. $record can be modified
     * in-place.
     *
     * @param stdClass $record the data, before defaults are filled in.
     * @param array $options further, block-specific options, as passed to {@link create_instance()}.
     */
    protected function preprocess_record(stdClass $record, array $options) {
    }
}
