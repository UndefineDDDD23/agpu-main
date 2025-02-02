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
 * Data generators for acceptance testing.
 *
 * @package   core
 * @category  test
 * @copyright 2012 David Monllaó
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// NOTE: no agpu_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../behat/behat_base.php');

use Behat\Gherkin\Node\TableNode as TableNode;
use Behat\Behat\Tester\Exception\PendingException as PendingException;

/**
 * Class to set up quickly a Given environment.
 *
 * The entry point is the Behat steps:
 *     the following "entity types" exist:
 *       | test | data |
 *
 * Entity type will either look like "users" or "activities" for core entities, or
 * "mod_forum > subscription" or "core_message > message" for entities belonging
 * to components.
 *
 * Generally, you only need to specify properties relevant to your test,
 * and everything else gets set to sensible defaults.
 *
 * The actual generation of entities is done by {@link behat_generator_base}.
 * There is one subclass for each component, e.g. {@link behat_core_generator}
 * or {@link behat_mod_quiz_generator}. To see the types of entity
 * that can be created for each component, look at the arrays returned
 * by the get_creatable_entities() method in each class.
 *
 * @package   core
 * @category  test
 * @copyright 2012 David Monllaó
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_data_generators extends behat_base {

    /**
     * Convert legacy entity names to the new component-specific form.
     *
     * In the past, there was no support for plugins, and everything that
     * could be created was handled by the core generator. Now, we can
     * support plugins, and so some thing should probably be moved.
     *
     * For example, in the future we should probably add
     * 'message contacts' => 'core_message > contact'] to
     * this array, and move generation of message contact
     * from core to core_message.
     *
     * @var array old entity type => new entity type.
     */
    protected $movedentitytypes = [
    ];

    /**
     * Creates the specified elements.
     *
     * See the class comment for an overview.
     *
     * @Given /^the following "(?P<element_string>(?:[^"]|\\")*)" exist:$/
     *
     * @param string    $entitytype The name of the type entity to add
     * @param TableNode $data
     */
    #[\core\attribute\example('And the following "activities" exist:
        | activity | name              | intro           | course   | idnumber | section | visible |
        | assign   | Activity sample 1 | Test assignment | C1       | sample1  | 1       | 1       |
        | assign   | Activity sample 2 | Test assignment | C1       | sample2  | 1       | 0       |')]
    public function the_following_entities_exist($entitytype, TableNode $data) {
        if (isset($this->movedentitytypes[$entitytype])) {
            $entitytype = $this->movedentitytypes[$entitytype];
        }
        list($component, $entity) = $this->parse_entity_type($entitytype);
        $this->get_instance_for_component($component)->generate_items($entity, $data);
    }

    /**
     * Create multiple entities of one entity type.
     *
     * @Given :count :entitytype exist with the following data:
     *
     * @param   string $entitytype The name of the type entity to add
     * @param   int $count
     * @param   TableNode $data
     */
    #[\core\attribute\example('And "5" "course enrolments" exist with the following data:
        | user   | student[count] |
        | course | C1             |
        | role   | student        |')]
    public function the_following_repeated_entities_exist(string $entitytype, int $count, TableNode $data): void {
        $rows = $data->getRowsHash();

        $tabledata = [array_keys($rows)];
        for ($current = 1; $current < $count + 1; $current++) {
            $rowdata = [];
            foreach ($rows as $fieldname => $fieldtemplate) {
                $rowdata[$fieldname] = str_replace('[count]', $current, $fieldtemplate);
            }
            $tabledata[] = $rowdata;
        }

        if (isset($this->movedentitytypes[$entitytype])) {
            $entitytype = $this->movedentitytypes[$entitytype];
        }
        list($component, $entity) = $this->parse_entity_type($entitytype);
        $this->get_instance_for_component($component)->generate_items($entity, new TableNode($tabledata), false);
    }

    /**
     * Creates the specified (singular) element.
     *
     * See the class comment for an overview.
     *
     * @Given the following :entitytype exists:
     *
     * @param string    $entitytype The name of the type entity to add
     * @param TableNode $data
     */
    #[\core\attribute\example('And the following "course" exists:
        | fullname         | Course test |
        | shortname        | C1          |
        | category         | 0           |
        | numsections      | 3           |
        | initsections     | 1           |')]
    public function the_following_entity_exists($entitytype, TableNode $data) {
        if (isset($this->movedentitytypes[$entitytype])) {
            $entitytype = $this->movedentitytypes[$entitytype];
        }
        list($component, $entity) = $this->parse_entity_type($entitytype);
        $this->get_instance_for_component($component)->generate_items($entity, $data, true);
    }

    /**
     * Parse a full entity type like 'users' or 'mod_forum > subscription'.
     *
     * E.g. parsing 'course' gives ['core', 'course'] and
     * parsing 'core_message > message' gives ['core_message', 'message'].
     *
     * @param string $entitytype the entity type
     * @return string[] with two elements, component and entity type.
     */
    protected function parse_entity_type(string $entitytype): array {
        $dividercount = substr_count($entitytype, ' > ');
        if ($dividercount === 0) {
            return ['core', $entitytype];
        } else if ($dividercount === 1) {
            list($component, $type) = explode(' > ', $entitytype);
            if ($component === 'core') {
                throw new coding_exception('Do not specify the component "core > ..." for entity types.');
            }
            return [$component, $type];
        } else {
            throw new coding_exception('The entity type must be in the form ' .
                    '"{entity-type}" for core entities, or "{component} > {entity-type}" ' .
                    'for entities belonging to other components. ' .
                    'For example "users" or "mod_forum > subscriptions".');
        }
    }

    /**
     * Get an instance of the appropriate subclass of this class for a given component.
     *
     * @param string $component The name of the component to generate entities for.
     * @return behat_generator_base the subclass of this class for the requested component.
     */
    protected function get_instance_for_component(string $component): behat_generator_base {
        global $CFG;

        // Ensure the generator class is loaded.
        require_once($CFG->libdir . '/behat/classes/behat_generator_base.php');
        if ($component === 'core') {
            $lib = $CFG->libdir . '/behat/classes/behat_core_generator.php';
        } else {
            $dir = core_component::get_component_directory($component);
            $lib = $dir . '/tests/generator/behat_' . $component . '_generator.php';
            if (!$dir || !is_readable($lib)) {
                throw new coding_exception("Component {$component} does not support " .
                        "behat generators yet. Missing {$lib}.");
            }
        }
        require_once($lib);

        // Create an instance.
        $componentclass = "behat_{$component}_generator";
        if (!class_exists($componentclass)) {
            throw new PendingException($component .
                    ' does not yet support the Behat data generator mechanism. Class ' .
                    $componentclass . ' not found in file ' . $lib . '.');
        }
        $instance = new $componentclass($component);
        return $instance;
    }

    /**
     * Get all entities that can be created in all components using the_following_entities_exist()
     *
     * @return array
     * @throws coding_exception
     */
    public function get_all_entities(): array {
        global $CFG;
        // Ensure the generator class is loaded.
        require_once($CFG->libdir . '/behat/classes/behat_generator_base.php');
        $componenttypes = core_component::get_component_list();
        $coregenerator = $this->get_instance_for_component('core');
        $pluginswithentities = ['core' => array_keys($coregenerator->get_available_generators())];
        foreach ($componenttypes as $components) {
            foreach ($components as $component => $componentdir) {
                try {
                    $plugingenerator = $this->get_instance_for_component($component);
                    $entities = array_keys($plugingenerator->get_available_generators());
                    if (!empty($entities)) {
                        $pluginswithentities[$component] = $entities;
                    }
                } catch (Exception $e) {
                    // The component has no generator, skip it.
                    continue;
                }
            }
        }
        return $pluginswithentities;
    }

    /**
     * Get the required fields for a specific creatable entity.
     *
     * @param string $entitytype
     * @return mixed
     * @throws coding_exception
     */
    public function get_entity(string $entitytype): array {
        [$component, $entity] = $this->parse_entity_type($entitytype);
        $generator = $this->get_instance_for_component($component);
        $entities = $generator->get_available_generators();
        if (!array_key_exists($entity, $entities)) {
            throw new coding_exception('No generator for ' . $entity . ' in component ' . $component);
        }
        return $entities[$entity];
    }
}
