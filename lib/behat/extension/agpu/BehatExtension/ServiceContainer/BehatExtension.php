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

namespace agpu\BehatExtension\ServiceContainer;

use Behat\Behat\Definition\ServiceContainer\DefinitionExtension;
use Behat\Behat\EventDispatcher\ServiceContainer\EventDispatcherExtension;
use Behat\Behat\Gherkin\ServiceContainer\GherkinExtension;
use Behat\Behat\Tester\ServiceContainer\TesterExtension;
use Behat\Testwork\Cli\ServiceContainer\CliExtension;
use Behat\Testwork\Output\ServiceContainer\OutputExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Behat\Testwork\ServiceContainer\ServiceProcessor;
use Behat\Testwork\Suite\ServiceContainer\SuiteExtension;
use agpu\BehatExtension\Driver\WebDriverFactory;
use agpu\BehatExtension\Output\Formatter\agpuProgressFormatterFactory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

// phpcs:disable agpu.NamingConventions.ValidFunctionName.LowercaseMethod

/**
 * Behat extension for agpu
 *
 * Provides multiple features directory loading (Gherkin\Loader\agpuFeaturesSuiteLoader
 *
 * @package core
 * @copyright 2016 Rajesh Taneja <rajesh@agpu.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class BehatExtension implements ExtensionInterface {
    /** @var string Extension configuration ID */
    const agpu_ID = 'agpu';

    /** @var ServiceProcessor */
    private $processor;

    /**
     * Initializes compiler pass.
     *
     * @param null|ServiceProcessor $processor
     */
    public function __construct(?ServiceProcessor $processor = null) {
        $this->processor = $processor ? : new ServiceProcessor();
    }

    /**
     * Loads agpu specific configuration.
     *
     * @param ContainerBuilder $container ContainerBuilder instance
     * @param array            $config    Extension configuration hash (from behat.yml)
     */
    public function load(ContainerBuilder $container, array $config) {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/services'));
        $loader->load('core.xml');

        // Getting the extension parameters.
        $container->setParameter('behat.agpu.parameters', $config);

        // Load agpu progress formatter.
        $agpuprogressformatter = new agpuProgressFormatterFactory();
        $agpuprogressformatter->buildFormatter($container);

        // Load custom step tester event dispatcher.
        $this->loadEventDispatchingStepTester($container);

        // Load chained step tester.
        $this->loadChainedStepTester($container);

        // Load step count formatter.
        $this->loadagpuListFormatter($container);

        // Load step count formatter.
        $this->loadagpuStepcountFormatter($container);

        // Load screenshot formatter.
        $this->loadagpuScreenshotFormatter($container);

        // Load namespace alias.
        $this->alias_old_namespaces();
    }

    /**
     * Loads agpu List formatter.
     *
     * @param ContainerBuilder $container
     */
    protected function loadagpuListFormatter(ContainerBuilder $container) {
        $definition = new Definition('agpu\BehatExtension\Output\Formatter\agpuListFormatter', [
            'agpu_list',
            'List all scenarios. Use with --dry-run',
            ['stepcount' => false],
            $this->createOutputPrinterDefinition()
        ]);
        $definition->addTag(OutputExtension::FORMATTER_TAG, ['priority' => 101]);
        $container->setDefinition(OutputExtension::FORMATTER_TAG . '.agpu_list', $definition);
    }

    /**
     * Loads agpu Step count formatter.
     *
     * @param ContainerBuilder $container
     */
    protected function loadagpuStepcountFormatter(ContainerBuilder $container) {
        $definition = new Definition('agpu\BehatExtension\Output\Formatter\agpuStepcountFormatter', [
            'agpu_stepcount',
            'Count steps in feature files. Use with --dry-run',
            ['stepcount' => false],
            $this->createOutputPrinterDefinition()
        ]);
        $definition->addTag(OutputExtension::FORMATTER_TAG, ['priority' => 101]);
        $container->setDefinition(OutputExtension::FORMATTER_TAG . '.agpu_stepcount', $definition);
    }

    /**
     * Loads agpu screenshot formatter.
     *
     * @param ContainerBuilder $container
     */
    protected function loadagpuScreenshotFormatter(ContainerBuilder $container) {
        $definition = new Definition('agpu\BehatExtension\Output\Formatter\agpuScreenshotFormatter', [
            'agpu_screenshot',
            // phpcs:ignore Generic.Files.LineLength.TooLong
            'Take screenshot of all steps. Use --format-settings \'{"formats": "html,image"}\' to get specific o/p type',
            ['formats' => 'html,image'],
            $this->createOutputPrinterDefinition()
        ]);
        $definition->addTag(OutputExtension::FORMATTER_TAG, ['priority' => 102]);
        $container->setDefinition(OutputExtension::FORMATTER_TAG . '.agpu_screenshot', $definition);
    }

    /**
     * Creates output printer definition.
     *
     * @return Definition
     */
    protected function createOutputPrinterDefinition() {
        return new Definition('Behat\Testwork\Output\Printer\StreamOutputPrinter', [
            new Definition('Behat\Behat\Output\Printer\ConsoleOutputFactory'),
        ]);
    }

    /**
     * Loads definition printers.
     *
     * @param ContainerBuilder $container
     */
    private function loadDefinitionPrinters(ContainerBuilder $container) {
        $definition = new Definition('agpu\BehatExtension\Definition\Printer\ConsoleDefinitionInformationPrinter', [
            new Reference(CliExtension::OUTPUT_ID),
            new Reference(DefinitionExtension::PATTERN_TRANSFORMER_ID),
            new Reference(DefinitionExtension::DEFINITION_TRANSLATOR_ID),
            new Reference(GherkinExtension::KEYWORDS_ID)
        ]);
        $container->removeDefinition('definition.information_printer');
        $container->setDefinition('definition.information_printer', $definition);
    }

    /**
     * Loads definition controller.
     *
     * @param ContainerBuilder $container
     */
    private function loadController(ContainerBuilder $container) {
        $definition = new Definition('agpu\BehatExtension\Definition\Cli\AvailableDefinitionsController', [
            new Reference(SuiteExtension::REGISTRY_ID),
            new Reference(DefinitionExtension::WRITER_ID),
            new Reference('definition.list_printer'),
            new Reference('definition.information_printer')
        ]);
        $container->removeDefinition(CliExtension::CONTROLLER_TAG . '.available_definitions');
        $container->setDefinition(CliExtension::CONTROLLER_TAG . '.available_definitions', $definition);
    }

    /**
     * Loads chained step tester.
     *
     * @param ContainerBuilder $container
     */
    protected function loadChainedStepTester(ContainerBuilder $container) {
        // Chained steps.
        $definition = new Definition('agpu\BehatExtension\EventDispatcher\Tester\ChainedStepTester', [
            new Reference(TesterExtension::STEP_TESTER_ID),
        ]);
        $definition->addTag(TesterExtension::STEP_TESTER_WRAPPER_TAG, ['priority' => 100]);
        $container->setDefinition(TesterExtension::STEP_TESTER_WRAPPER_TAG . '.substep', $definition);
    }

    /**
     * Loads event-dispatching step tester.
     *
     * @param ContainerBuilder $container
     */
    protected function loadEventDispatchingStepTester(ContainerBuilder $container) {
        $definition = new Definition('agpu\BehatExtension\EventDispatcher\Tester\agpuEventDispatchingStepTester', [
            new Reference(TesterExtension::STEP_TESTER_ID),
            new Reference(EventDispatcherExtension::DISPATCHER_ID)
        ]);
        $definition->addTag(TesterExtension::STEP_TESTER_WRAPPER_TAG, ['priority' => -9999]);
        $container->setDefinition(TesterExtension::STEP_TESTER_WRAPPER_TAG . '.event_dispatching', $definition);
    }

    /**
     * Setups configuration for current extension.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder) {
        // phpcs:disable PEAR.WhiteSpace.ObjectOperatorIndent.Incorrect
        $builder->children()
            ->arrayNode('capabilities')
                ->useAttributeAsKey('key')
                ->prototype('variable')->end()
                ->end()
            ->arrayNode('steps_definitions')
                ->useAttributeAsKey('key')
                ->prototype('variable')->end()
                ->end()
            ->scalarNode('agpudirroot')
                ->defaultNull()
                ->end()
            ->end()
        ->end();
        // phpcs:enable PEAR.WhiteSpace.ObjectOperatorIndent.Incorrect
    }

    /**
     * Returns the extension config key.
     *
     * @return string
     */
    public function getConfigKey() {
        return self::agpu_ID;
    }

    /**
     * Initializes other extensions.
     *
     * This method is called immediately after all extensions are activated but
     * before any extension `configure()` method is called. This allows extensions
     * to hook into the configuration of other extensions providing such an
     * extension point.
     *
     * @param ExtensionManager $extensionmanager
     */
    public function initialize(ExtensionManager $extensionmanager) {
        if (null !== $minkextension = $extensionmanager->getExtension('mink')) {
            $minkextension->registerDriverFactory(new WebDriverFactory());
        }
    }

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container) {
        // Load controller for definition printing.
        $this->loadDefinitionPrinters($container);
        $this->loadController($container);
    }

    /**
     * Alias old namespace of given. when and then for BC.
     */
    private function alias_old_namespaces() {
        class_alias('agpu\\BehatExtension\\Context\\Step\\Given', 'Behat\\Behat\\Context\\Step\\Given', true);
        class_alias('agpu\\BehatExtension\\Context\\Step\\When', 'Behat\\Behat\\Context\\Step\\When', true);
        class_alias('agpu\\BehatExtension\\Context\\Step\\Then', 'Behat\\Behat\\Context\\Step\\Then', true);
    }
}
