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

namespace core;

use core_plugin_manager;
use testable_core_plugin_manager;
use testable_plugininfo_base;

/**
 * Unit tests for plugin manager class.
 *
 * @package   core
 * @category  test
 * @copyright 2013 Petr Skoda {@link http://skodak.org}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers \core_plugin_manager
 */
final class plugin_manager_test extends \advanced_testcase {
    public static function setUpBeforeClass(): void {
        global $CFG;
        require_once($CFG->dirroot . '/lib/tests/fixtures/testable_plugin_manager.php');
        require_once($CFG->dirroot . '/lib/tests/fixtures/testable_plugininfo_base.php');
        parent::setUpBeforeClass();
    }

    public function tearDown(): void {
        // The caches of the testable singleton must be reset explicitly. It is
        // safer to kill the whole testable singleton at the end of every test.
        testable_core_plugin_manager::reset_caches();
        parent::tearDown();
    }

    public function test_instance(): void {
        $pluginman1 = core_plugin_manager::instance();
        $this->assertInstanceOf('core_plugin_manager', $pluginman1);
        $pluginman2 = core_plugin_manager::instance();
        $this->assertSame($pluginman1, $pluginman2);
        $pluginman3 = testable_core_plugin_manager::instance();
        $this->assertInstanceOf('core_plugin_manager', $pluginman3);
        $this->assertInstanceOf('testable_core_plugin_manager', $pluginman3);
        $pluginman4 = testable_core_plugin_manager::instance();
        $this->assertSame($pluginman3, $pluginman4);
        $this->assertNotSame($pluginman1, $pluginman3);
    }

    public function test_reset_caches(): void {
        // Make sure there are no warnings or errors.
        core_plugin_manager::reset_caches();
        testable_core_plugin_manager::reset_caches();
    }

    /**
     * Make sure that the tearDown() really kills the singleton after this test.
     */
    public function test_teardown_works_precheck(): void {
        $pluginman = testable_core_plugin_manager::instance();
        $pluginfo = testable_plugininfo_base::fake_plugin_instance(
            'fake',
            '/dev/null',
            'one',
            '/dev/null/fake',
            'testable_plugininfo_base',
            $pluginman
        );
        $pluginman->inject_testable_plugininfo('fake', 'one', $pluginfo);

        $this->assertInstanceOf('\core\plugininfo\base', $pluginman->get_plugin_info('fake_one'));
        $this->assertNull($pluginman->get_plugin_info('fake_two'));
    }

    public function test_teardown_works_postcheck(): void {
        $pluginman = testable_core_plugin_manager::instance();
        $this->assertNull($pluginman->get_plugin_info('fake_one'));
        $this->assertNull($pluginman->get_plugin_info('fake_two'));
    }

    public function test_get_plugin_types(): void {
        // Make sure there are no warnings or errors.
        $types = core_plugin_manager::instance()->get_plugin_types();
        $this->assertIsArray($types);
        foreach ($types as $type => $fulldir) {
            $this->assertFileExists($fulldir);
        }
    }

    public function test_get_installed_plugins(): void {
        $types = core_plugin_manager::instance()->get_plugin_types();
        foreach ($types as $type => $fulldir) {
            $installed = core_plugin_manager::instance()->get_installed_plugins($type);
            foreach ($installed as $plugin => $version) {
                $this->assertMatchesRegularExpression('/^[a-z]+[a-z0-9_]*$/', $plugin);
                $this->assertTrue(
                    is_numeric($version),
                    'All plugins should have a version, plugin ' . $type . '_' . $plugin . ' does not have version info.'
                );
            }
        }
    }

    public function test_get_enabled_plugins(): void {
        $types = core_plugin_manager::instance()->get_plugin_types();
        foreach ($types as $type => $fulldir) {
            $enabled = core_plugin_manager::instance()->get_enabled_plugins($type);
            if (is_array($enabled)) {
                foreach ($enabled as $key => $val) {
                    $this->assertMatchesRegularExpression('/^[a-z]+[a-z0-9_]*$/', $key);
                    $this->assertSame($key, $val);
                }
            } else {
                $this->assertNull($enabled);
            }
        }
    }

    public function test_get_present_plugins(): void {
        $types = core_plugin_manager::instance()->get_plugin_types();
        foreach ($types as $type => $fulldir) {
            $present = core_plugin_manager::instance()->get_present_plugins($type);
            if (is_array($present)) {
                foreach ($present as $plugin => $version) {
                    $this->assertMatchesRegularExpression(
                        '/^[a-z]+[a-z0-9_]*$/',
                        $plugin,
                        'All plugins are supposed to have version.php file.'
                    );
                    $this->assertIsObject($version);
                    $this->assertTrue(
                        is_numeric($version->version),
                        'All plugins should have a version, plugin ' . $type . '_' . $plugin . ' does not have version info.'
                    );
                }
            } else {
                // No plugins of this type exist.
                $this->assertNull($present);
            }
        }
    }

    public function test_get_plugins(): void {
        $plugininfos1 = core_plugin_manager::instance()->get_plugins();
        foreach ($plugininfos1 as $type => $infos) {
            foreach ($infos as $name => $info) {
                $this->assertInstanceOf('\core\plugininfo\base', $info);
            }
        }

        // The testable variant of the manager holds its own tree of the
        // plugininfo objects.
        $plugininfos2 = testable_core_plugin_manager::instance()->get_plugins();
        $this->assertNotSame($plugininfos1['mod']['forum'], $plugininfos2['mod']['forum']);

        // Singletons of each manager class share the same tree.
        $plugininfos3 = core_plugin_manager::instance()->get_plugins();
        $this->assertSame($plugininfos1['mod']['forum'], $plugininfos3['mod']['forum']);
        $plugininfos4 = testable_core_plugin_manager::instance()->get_plugins();
        $this->assertSame($plugininfos2['mod']['forum'], $plugininfos4['mod']['forum']);
    }

    public function test_plugininfo_back_reference_to_the_plugin_manager(): void {
        $plugman1 = core_plugin_manager::instance();
        $plugman2 = testable_core_plugin_manager::instance();

        foreach ($plugman1->get_plugins() as $type => $infos) {
            foreach ($infos as $info) {
                $this->assertSame($info->pluginman, $plugman1);
            }
        }

        foreach ($plugman2->get_plugins() as $type => $infos) {
            foreach ($infos as $info) {
                $this->assertSame($info->pluginman, $plugman2);
            }
        }
    }

    public function test_get_plugins_of_type(): void {
        $plugininfos = core_plugin_manager::instance()->get_plugins();
        foreach ($plugininfos as $type => $infos) {
            $this->assertSame($infos, core_plugin_manager::instance()->get_plugins_of_type($type));
        }
    }

    public function test_get_subplugins_of_plugin(): void {
        global $CFG;

        // Any standard plugin with subplugins is suitable.
        $this->assertFileExists("$CFG->dirroot/lib/editor/tiny", 'TinyMCE is not present.');

        $subplugins = core_plugin_manager::instance()->get_subplugins_of_plugin('editor_tiny');
        foreach ($subplugins as $component => $info) {
            $this->assertInstanceOf('\core\plugininfo\base', $info);
        }
    }

    public function test_get_subplugins(): void {
        // Tested already indirectly from test_get_subplugins_of_plugin().
        $subplugins = core_plugin_manager::instance()->get_subplugins();
        $this->assertIsArray($subplugins);
    }

    public function test_get_parent_of_subplugin(): void {
        global $CFG;

        // Any standard plugin with subplugins is suitable.
        $this->assertFileExists("$CFG->dirroot/lib/editor/tiny", 'TinyMCE is not present.');

        $parent = core_plugin_manager::instance()->get_parent_of_subplugin('tiny');
        $this->assertSame('editor_tiny', $parent);
    }

    public function test_plugin_name(): void {
        global $CFG;

        // Any standard plugin is suitable.
        $this->assertFileExists("$CFG->dirroot/lib/editor/tiny", 'TinyMCE is not present.');

        $name = core_plugin_manager::instance()->plugin_name('editor_tiny');
        $this->assertSame(get_string('pluginname', 'editor_tiny'), $name);
    }

    public function test_plugintype_name(): void {
        $name = core_plugin_manager::instance()->plugintype_name('editor');
        $this->assertSame(get_string('type_editor', 'core_plugin'), $name);
    }

    public function test_plugintype_name_plural(): void {
        $name = core_plugin_manager::instance()->plugintype_name_plural('editor');
        $this->assertSame(get_string('type_editor_plural', 'core_plugin'), $name);
    }

    public function test_get_plugin_info(): void {
        global $CFG;

        // Any standard plugin is suitable.
        $this->assertFileExists("$CFG->dirroot/lib/editor/tiny", 'TinyMCE is not present.');

        $info = core_plugin_manager::instance()->get_plugin_info('editor_tiny');
        $this->assertInstanceOf('\core\plugininfo\editor', $info);
    }

    public function test_can_uninstall_plugin(): void {
        global $CFG;

        // Any standard plugin that is required by some other standard plugin is ok.
        $this->assertFileExists("$CFG->dirroot/report/competency", 'competency report is not present');
        $this->assertFileExists("$CFG->dirroot/$CFG->admin/tool/lp", 'tool lp is not present');

        $this->assertFalse(core_plugin_manager::instance()->can_uninstall_plugin('tool_lp'));
        $this->assertTrue(core_plugin_manager::instance()->can_uninstall_plugin('report_competency'));
    }

    public function test_plugin_states(): void {
        global $CFG;
        $this->resetAfterTest();

        // Any standard plugin that is ok.
        $this->assertFileExists("$CFG->dirroot/mod/assign", 'assign module is not present');
        $this->assertFileExists("$CFG->dirroot/mod/forum", 'forum module is not present');
        $this->assertFileExists("$CFG->dirroot/$CFG->admin/tool/phpunit", 'phpunit tool is not present');
        $this->assertFileDoesNotExist("$CFG->dirroot/mod/xxxxxxx");
        $this->assertFileDoesNotExist("$CFG->dirroot/enrol/autorize");

        // Ready for upgrade.
        $assignversion = get_config('mod_assign', 'version');
        set_config('version', $assignversion - 1, 'mod_assign');
        // Downgrade problem.
        $forumversion = get_config('mod_forum', 'version');
        set_config('version', $forumversion + 1, 'mod_forum');
        // Not installed yet.
        unset_config('version', 'tool_phpunit');
        // Missing already installed.
        set_config('version', 2013091300, 'mod_xxxxxxx');
        // Deleted present.
        set_config('version', 2013091300, 'enrol_authorize');

        core_plugin_manager::reset_caches();

        $plugininfos = core_plugin_manager::instance()->get_plugins();
        foreach ($plugininfos as $type => $infos) {
            /** @var \core\plugininfo\base $info */
            foreach ($infos as $info) {
                if ($info->component === 'mod_assign') {
                    $this->assertSame(
                        core_plugin_manager::PLUGIN_STATUS_UPGRADE,
                        $info->get_status(),
                        'Invalid ' . $info->component . ' state'
                    );
                } else if ($info->component === 'mod_forum') {
                    $this->assertSame(
                        core_plugin_manager::PLUGIN_STATUS_DOWNGRADE,
                        $info->get_status(),
                        'Invalid ' . $info->component . ' state'
                    );
                } else if ($info->component === 'tool_phpunit') {
                    $this->assertSame(
                        core_plugin_manager::PLUGIN_STATUS_NEW,
                        $info->get_status(),
                        'Invalid ' . $info->component . ' state'
                    );
                } else if ($info->component === 'mod_xxxxxxx') {
                    $this->assertSame(
                        core_plugin_manager::PLUGIN_STATUS_MISSING,
                        $info->get_status(),
                        'Invalid ' . $info->component . ' state'
                    );
                } else if ($info->component === 'enrol_authorize') {
                    $this->assertSame(
                        core_plugin_manager::PLUGIN_STATUS_DELETE,
                        $info->get_status(),
                        'Invalid ' . $info->component . ' state'
                    );
                } else {
                    $this->assertSame(
                        core_plugin_manager::PLUGIN_STATUS_UPTODATE,
                        $info->get_status(),
                        'Invalid ' . $info->component . ' state'
                    );
                }
            }
        }
    }

    public function test_plugin_available_updates(): void {
        $pluginman = testable_core_plugin_manager::instance();

        $foobar = testable_plugininfo_base::fake_plugin_instance(
            'foo',
            '/dev/null',
            'bar',
            '/dev/null/fake',
            'testable_plugininfo_base',
            $pluginman
        );
        $foobar->versiondb = 2015092900;
        $foobar->versiondisk = 2015092900;
        $pluginman->inject_testable_plugininfo('foo', 'bar', $foobar);

        $washere = false;
        foreach ($pluginman->get_plugins() as $type => $infos) {
            foreach ($infos as $name => $plugin) {
                $updates = $plugin->available_updates();
                if ($plugin->component != 'foo_bar') {
                    $this->assertNull($updates);
                } else {
                    $this->assertTrue(is_array($updates));
                    $this->assertEquals(3, count($updates));
                    foreach ($updates as $update) {
                        $washere = true;
                        $this->assertInstanceOf('\core\update\info', $update);
                        $this->assertEquals($update->component, $plugin->component);
                        $this->assertTrue($update->version > $plugin->versiondb);
                    }
                }
            }
        }
        $this->assertTrue($washere);
    }

    public function test_some_plugins_updatable_none(): void {
        $pluginman = testable_core_plugin_manager::instance();
        $this->assertFalse($pluginman->some_plugins_updatable());
    }

    public function test_some_plugins_updatable_some(): void {
        $pluginman = testable_core_plugin_manager::instance();

        $foobar = testable_plugininfo_base::fake_plugin_instance(
            'foo',
            '/dev/null',
            'bar',
            '/dev/null/fake',
            'testable_plugininfo_base',
            $pluginman
        );
        $foobar->versiondb = 2015092900;
        $foobar->versiondisk = 2015092900;
        $pluginman->inject_testable_plugininfo('foo', 'bar', $foobar);

        $this->assertTrue($pluginman->some_plugins_updatable());
    }

    public function test_available_updates(): void {
        $pluginman = testable_core_plugin_manager::instance();

        $foobar = testable_plugininfo_base::fake_plugin_instance(
            'foo',
            '/dev/null',
            'bar',
            '/dev/null/fake',
            'testable_plugininfo_base',
            $pluginman
        );
        $foobar->versiondb = 2015092900;
        $foobar->versiondisk = 2015092900;
        $pluginman->inject_testable_plugininfo('foo', 'bar', $foobar);

        $updates = $pluginman->available_updates();

        $this->assertTrue(is_array($updates));
        $this->assertEquals(1, count($updates));
        $update = $updates['foo_bar'];
        $this->assertInstanceOf('\core\update\remote_info', $update);
        $this->assertEquals('foo_bar', $update->component);
        $this->assertEquals(2015100400, $update->version->version);
    }

    public function test_get_remote_plugin_info(): void {
        $pluginman = testable_core_plugin_manager::instance();

        $this->assertFalse($pluginman->get_remote_plugin_info('not_exists', ANY_VERSION, false));

        $info = $pluginman->get_remote_plugin_info('foo_bar', 2015093000, true);
        $this->assertEquals(2015093000, $info->version->version);

        $info = $pluginman->get_remote_plugin_info('foo_bar', 2015093000, false);
        $this->assertEquals(2015100400, $info->version->version);
    }

    /**
     * The combination of ANY_VERSION + $exactmatch is illegal.
     */
    public function test_get_remote_plugin_info_exception(): void {
        $pluginman = testable_core_plugin_manager::instance();
        $this->expectException(\agpu_exception::class);
        $pluginman->get_remote_plugin_info('any_thing', ANY_VERSION, true);
    }

    public function test_is_remote_plugin_available(): void {
        $pluginman = testable_core_plugin_manager::instance();

        $this->assertFalse($pluginman->is_remote_plugin_available('not_exists', ANY_VERSION, false));
        $this->assertTrue($pluginman->is_remote_plugin_available('foo_bar', 2013131313, false));
        $this->assertFalse($pluginman->is_remote_plugin_available('foo_bar', 2013131313, true));
    }

    public function test_resolve_requirements(): void {
        $pluginman = testable_core_plugin_manager::instance();

        // Prepare a fake pluginfo instance.
        $pluginfo = testable_plugininfo_base::fake_plugin_instance(
            'fake',
            '/dev/null',
            'one',
            '/dev/null/fake',
            'testable_plugininfo_base',
            $pluginman
        );
        $pluginfo->versiondisk = 2015060600;

        // Test no $plugin->requires is specified in version.php.
        $pluginfo->versionrequires = null;
        $this->assertTrue($pluginfo->is_core_dependency_satisfied(2015100100));
        $reqs = $pluginman->resolve_requirements($pluginfo, 2015100100, 29);
        $this->assertEquals(2015100100, $reqs['core']->hasver);
        $this->assertEquals(ANY_VERSION, $reqs['core']->reqver);
        $this->assertEquals($pluginman::REQUIREMENT_STATUS_OK, $reqs['core']->status);

        // Test plugin requires higher core version.
        $pluginfo->versionrequires = 2015110900;
        $this->assertFalse($pluginfo->is_core_dependency_satisfied(2015100100));
        $reqs = $pluginman->resolve_requirements($pluginfo, 2015100100, 29);
        $this->assertEquals(2015100100, $reqs['core']->hasver);
        $this->assertEquals(2015110900, $reqs['core']->reqver);
        $this->assertEquals($pluginman::REQUIREMENT_STATUS_OUTDATED, $reqs['core']->status);

        // Test plugin requires current core version.
        $pluginfo->versionrequires = 2015110900;
        $this->assertTrue($pluginfo->is_core_dependency_satisfied(2015110900));
        $reqs = $pluginman->resolve_requirements($pluginfo, 2015110900, 30);
        $this->assertEquals(2015110900, $reqs['core']->hasver);
        $this->assertEquals(2015110900, $reqs['core']->reqver);
        $this->assertEquals($pluginman::REQUIREMENT_STATUS_OK, $reqs['core']->status);

        // Test plugin requires lower core version.
        $pluginfo->versionrequires = 2014122400;
        $this->assertTrue($pluginfo->is_core_dependency_satisfied(2015100100));
        $reqs = $pluginman->resolve_requirements($pluginfo, 2015100100, 29);
        $this->assertEquals(2015100100, $reqs['core']->hasver);
        $this->assertEquals(2014122400, $reqs['core']->reqver);
        $this->assertEquals($pluginman::REQUIREMENT_STATUS_OK, $reqs['core']->status);

        // Test plugin dependencies and their availability.
        // See {@link \core\update\testable_api} class.

        $pluginfo->dependencies = ['foo_bar' => ANY_VERSION, 'not_exists' => ANY_VERSION];
        $reqs = $pluginman->resolve_requirements($pluginfo, 2015110900, 30);
        $this->assertNull($reqs['foo_bar']->hasver);
        $this->assertEquals(ANY_VERSION, $reqs['foo_bar']->reqver);
        $this->assertEquals($pluginman::REQUIREMENT_STATUS_MISSING, $reqs['foo_bar']->status);
        $this->assertEquals($pluginman::REQUIREMENT_AVAILABLE, $reqs['foo_bar']->availability);
        $this->assertEquals($pluginman::REQUIREMENT_UNAVAILABLE, $reqs['not_exists']->availability);

        $pluginfo->dependencies = ['foo_bar' => 2013122400];
        $reqs = $pluginman->resolve_requirements($pluginfo, 2015110900, 30);
        $this->assertEquals($pluginman::REQUIREMENT_AVAILABLE, $reqs['foo_bar']->availability);

        $pluginfo->dependencies = ['foo_bar' => 2015093000];
        $reqs = $pluginman->resolve_requirements($pluginfo, 2015110900, 30);
        $this->assertEquals($pluginman::REQUIREMENT_AVAILABLE, $reqs['foo_bar']->availability);

        $pluginfo->dependencies = ['foo_bar' => 2015100500];
        $reqs = $pluginman->resolve_requirements($pluginfo, 2015110900, 30);
        $this->assertEquals($pluginman::REQUIREMENT_AVAILABLE, $reqs['foo_bar']->availability);

        $pluginfo->dependencies = ['foo_bar' => 2025010100];
        $reqs = $pluginman->resolve_requirements($pluginfo, 2015110900, 30);
        $this->assertEquals($pluginman::REQUIREMENT_UNAVAILABLE, $reqs['foo_bar']->availability);

        // Plugin missing from disk - no version.php available.
        $pluginfo = testable_plugininfo_base::fake_plugin_instance(
            'fake',
            '/dev/null',
            'missing',
            '/dev/null/fake',
            'testable_plugininfo_base',
            $pluginman
        );
        $pluginfo->versiondisk = null;
        $this->assertEmpty($pluginman->resolve_requirements($pluginfo, 2015110900, 30));

        // Test plugin fails for incompatible version.
        $pluginfo = testable_plugininfo_base::fake_plugin_instance(
            'fake',
            '/dev/null',
            'two',
            '/dev/null/fake',
            'testable_plugininfo_base',
            $pluginman
        );
        $pluginfo->versiondisk = 2015060600;
        $pluginfo->pluginincompatible = 30;
        $reqs = $pluginman->resolve_requirements($pluginfo, 2015110900, 30);
        $this->assertEquals($pluginman::REQUIREMENT_STATUS_NEWER, $reqs['core']->status);

        // Test no failure for no incompatible version.
        $pluginfo->pluginincompatible = 30;
        $reqs = $pluginman->resolve_requirements($pluginfo, 2015110900, 29);
        $this->assertEquals($pluginman::REQUIREMENT_STATUS_OK, $reqs['core']->status);
    }

    public function test_missing_dependencies(): void {
        $pluginman = testable_core_plugin_manager::instance();

        $one = testable_plugininfo_base::fake_plugin_instance(
            'fake',
            '/dev/null',
            'one',
            '/dev/null/fake',
            'testable_plugininfo_base',
            $pluginman
        );
        $one->versiondisk = 2015070800;

        $two = testable_plugininfo_base::fake_plugin_instance(
            'fake',
            '/dev/null',
            'two',
            '/dev/null/fake',
            'testable_plugininfo_base',
            $pluginman
        );
        $two->versiondisk = 2015070900;

        $pluginman->inject_testable_plugininfo('fake', 'one', $one);
        $pluginman->inject_testable_plugininfo('fake', 'two', $two);

        $this->assertEmpty($pluginman->missing_dependencies());

        $one->dependencies = ['foo_bar' => ANY_VERSION];
        $misdeps = $pluginman->missing_dependencies();
        $this->assertInstanceOf('\core\update\remote_info', $misdeps['foo_bar']);
        $this->assertEquals(2015100400, $misdeps['foo_bar']->version->version);

        $two->dependencies = ['foo_bar' => 2015100500];
        $misdeps = $pluginman->missing_dependencies();
        $this->assertInstanceOf('\core\update\remote_info', $misdeps['foo_bar']);
        $this->assertEquals(2015100500, $misdeps['foo_bar']->version->version);
    }

    /**
     * Tests for check_explicitly_supported function to ensure that versions are correctly reported.
     *
     * @dataProvider check_explicitly_supported_provider
     * @param array|null $supported Supported versions to inject
     * @param string|int|null $incompatible Incompatible version to inject.
     * @param int $version Version to test
     * @param int $expected
     * @return void
     */
    public function test_explicitly_supported($supported, $incompatible, $version, $expected): void {
        $pluginman = testable_core_plugin_manager::instance();

        // Prepare a fake pluginfo instance.
        $plugininfo = new testable_plugininfo_base();
        $plugininfo->type = 'fake';
        $plugininfo->typerootdir = '/dev/null';
        $plugininfo->name = 'example';
        $plugininfo->rootdir = '/dev/null/fake';
        $plugininfo->pluginman = $pluginman;
        $plugininfo->versiondisk = 2015060600;
        $plugininfo->supported = $supported;
        $plugininfo->incompatible = $incompatible;

        $pluginman->add_fake_plugin_info($plugininfo);

        $plugininfo->load_disk_version();

        $this->assertEquals($expected, $pluginman->check_explicitly_supported($plugininfo, $version));
    }

    /**
     * Data provider for check_explicitly_supported with a range of correctly defined version support values.
     *
     * @return array
     */
    public static function check_explicitly_supported_provider(): array {
        return [
            'Range, branch in support, lowest' => [
                'supported' => [29, 31],
                'incompatible' => null,
                'version' => 29,
                'expected' => core_plugin_manager::VERSION_SUPPORTED,
            ],
            'Range, branch in support, mid' => [
                'supported' => [29, 31],
                'incompatible' => null,
                'version' => 30,
                'expected' => core_plugin_manager::VERSION_SUPPORTED,
            ],
            'Range, branch in support, highest' => [
                'supported' => [29, 31],
                'incompatible' => null,
                'version' => 31,
                'expected' => core_plugin_manager::VERSION_SUPPORTED,
            ],

            'Range, branch not in support, high' => [
                'supported' => [29, 31],
                'incompatible' => null,
                'version' => 32,
                'expected' => core_plugin_manager::VERSION_NOT_SUPPORTED,
            ],
            'Range, branch not in support, low' => [
                'supported' => [29, 31],
                'incompatible' => null,
                'version' => 28,
                'expected' => core_plugin_manager::VERSION_NOT_SUPPORTED,
            ],
            'Range, incompatible, high.' => [
                'supported' => [29, 31],
                'incompatible' => 32,
                'version' => 33,
                'expected' => core_plugin_manager::VERSION_NOT_SUPPORTED,
            ],
            'Range, incompatible, low.' => [
                'supported' => [29, 31],
                'incompatible' => 32,
                'version' => 31,
                'expected' => core_plugin_manager::VERSION_SUPPORTED,
            ],
            'Range, incompatible, equal.' => [
                'supported' => [29, 31],
                'incompatible' => 32,
                'version' => 32,
                'expected' => core_plugin_manager::VERSION_NOT_SUPPORTED,
            ],
            'No supports' => [
                'supported' => null,
                'incompatible' => null,
                'version' => 32,
                'expected' => core_plugin_manager::VERSION_NO_SUPPORTS,
            ],
            'No supports, but incompatible, older' => [
                'supported' => null,
                'incompatible' => 30,
                'version' => 32,
                'expected' => core_plugin_manager::VERSION_NOT_SUPPORTED,
            ],
            'No supports, but incompatible, equal' => [
                'supported' => null,
                'incompatible' => 32,
                'version' => 32,
                'expected' => core_plugin_manager::VERSION_NOT_SUPPORTED,
            ],
            'No supports, but incompatible, newer' => [
                'supported' => null,
                'incompatible' => 34,
                'version' => 32,
                'expected' => core_plugin_manager::VERSION_NO_SUPPORTS,
            ],
        ];
    }

    /**
     * @dataProvider is_deleted_standard_plugin_provider
     */
    public function test_is_deleted_standard_plugin(
        mixed $type,
        mixed $name,
        bool $expected,
    ): void {
        $this->assertEquals(
            $expected,
            \core_plugin_manager::is_deleted_standard_plugin($type, $name),
        );
    }

    public static function is_deleted_standard_plugin_provider(): array {
        return [
            // Valid deleted plugin.
            ['h5plib', 'v124', true],
            // Valid type, but not a valid plugin.
            ['h5plib', 'v99', false],
            // Invalid type.
            ['marmelade', 'paddington', false],
        ];
    }

    public function test_get_deleted_plugins(): void {
        $plugins = core_plugin_manager::get_deleted_plugins();
        $this->assertIsArray($plugins);

        // Pick a couple we know should be there.
        $this->assertContains('h5plib_v124', $plugins);
        $this->assertNotContains('h5plib_v99', $plugins);

        $this->assertContains('editor_tinymce', $plugins);
        $this->assertNotContains('editor_tiny', $plugins);
    }

    public function test_standard_plugins_list_no_type(): void {
        $plugins = core_plugin_manager::standard_plugins_list('typo');
        $this->assertFalse($plugins);
    }

    /**
     * @dataProvider standard_plugins_list_provider
     */
    public function test_standard_plugins_list(
        string $type,
        array $expectedplugins,
    ): void {
        $plugins = core_plugin_manager::standard_plugins_list($type);
        $this->assertIsArray($plugins);
        foreach ($expectedplugins as $expected) {
            $this->assertContains($expected, $plugins);
        }
    }

    public static function standard_plugins_list_provider(): array {
        return [
            [
                'mod',
                ['forum', 'assign', 'book', 'choice'],
            ],
            [
                'block',
                ['starredcourses', 'badges'],
            ],
            [
                'tiny',
                ['autosave', 'h5p'],
            ],
        ];
    }

    public function test_get_standard_plugins(): void {
        $plugins = core_plugin_manager::get_standard_plugins();
        $this->assertIsArray($plugins);

        $this->assertContains('mod_forum', $plugins);
        $this->assertContains('block_badges', $plugins);
        $this->assertNotContains('marmelade_paddington', $plugins);
    }
}
