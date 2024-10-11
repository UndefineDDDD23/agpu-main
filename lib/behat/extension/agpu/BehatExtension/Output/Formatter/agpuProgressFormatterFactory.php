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

namespace agpu\BehatExtension\Output\Formatter;

use Behat\Testwork\Exception\ServiceContainer\ExceptionExtension;
use Behat\Testwork\Output\ServiceContainer\Formatter\FormatterFactory;
use Behat\Testwork\Output\ServiceContainer\OutputExtension;
use Behat\Testwork\ServiceContainer\ServiceProcessor;
use Behat\Testwork\Translator\ServiceContainer\TranslatorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

// phpcs:disable agpu.NamingConventions.ValidFunctionName.LowercaseMethod

/**
 * agpu behat context class resolver.
 *
 * @package    core
 * @copyright  2016 Rajesh Taneja <rajesh@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class agpuProgressFormatterFactory implements FormatterFactory {
    /** @var ServiceProcessor */
    private $processor;

    /** @var string agpu progress ID */
    const ROOT_LISTENER_ID_agpu = 'output.node.listener.agpuprogress';

    /** @var string agpu printer ID */
    const RESULT_TO_STRING_CONVERTER_ID_agpu = 'output.node.printer.result_to_string';

    /** @var string Available extension points */
    const ROOT_LISTENER_WRAPPER_TAG_agpu = 'output.node.listener.agpuprogress.wrapper';

    /**
     * Initializes extension.
     *
     * @param null|ServiceProcessor $processor
     */
    public function __construct(?ServiceProcessor $processor = null) {
        $this->processor = $processor ? : new ServiceProcessor();
    }

    /**
     * Builds formatter configuration.
     *
     * @param ContainerBuilder $container
     */
    public function buildFormatter(ContainerBuilder $container) {
        $this->loadRootNodeListener($container);
        $this->loadCorePrinters($container);
        $this->loadPrinterHelpers($container);
        $this->loadFormatter($container);
    }

    /**
     * Processes formatter configuration.
     *
     * @param ContainerBuilder $container
     */
    public function processFormatter(ContainerBuilder $container) {
        $this->processListenerWrappers($container);
    }

    /**
     * Loads progress formatter node event listener.
     *
     * @param ContainerBuilder $container
     */
    protected function loadRootNodeListener(ContainerBuilder $container) {
        $definition = new Definition('Behat\Behat\Output\Node\EventListener\AST\StepListener', [
            new Reference('output.node.printer.agpuprogress.step')
        ]);
        $container->setDefinition(self::ROOT_LISTENER_ID_agpu, $definition);
    }

    /**
     * Loads formatter itself.
     *
     * @param ContainerBuilder $container
     */
    protected function loadFormatter(ContainerBuilder $container) {

        $definition = new Definition('Behat\Behat\Output\Statistics\TotalStatistics');
        $container->setDefinition('output.agpuprogress.statistics', $definition);

        $agpuconfig = $container->getParameter('behat.agpu.parameters');

        $definition = new Definition(
            'agpu\BehatExtension\Output\Printer\agpuProgressPrinter',
            [$agpuconfig['agpudirroot']]
        );
        $container->setDefinition('agpu.output.node.printer.agpuprogress.printer', $definition);

        $definition = new Definition('Behat\Testwork\Output\NodeEventListeningFormatter', [
            'agpu_progress',
            'Prints information about then run followed by one character per step.',
            [
                'timer' => true
            ],
            $this->createOutputPrinterDefinition(),
            new Definition('Behat\Testwork\Output\Node\EventListener\ChainEventListener', [
                [
                    new Reference(self::ROOT_LISTENER_ID_agpu),
                    new Definition('Behat\Behat\Output\Node\EventListener\Statistics\StatisticsListener', [
                        new Reference('output.agpuprogress.statistics'),
                        new Reference('output.node.printer.agpuprogress.statistics')
                    ]),
                    new Definition('Behat\Behat\Output\Node\EventListener\Statistics\ScenarioStatsListener', [
                        new Reference('output.agpuprogress.statistics')
                    ]),
                    new Definition('Behat\Behat\Output\Node\EventListener\Statistics\StepStatsListener', [
                        new Reference('output.agpuprogress.statistics'),
                        new Reference(ExceptionExtension::PRESENTER_ID)
                    ]),
                    new Definition('Behat\Behat\Output\Node\EventListener\Statistics\HookStatsListener', [
                        new Reference('output.agpuprogress.statistics'),
                        new Reference(ExceptionExtension::PRESENTER_ID)
                    ]),
                    new Definition('Behat\Behat\Output\Node\EventListener\AST\SuiteListener', [
                        new Reference('agpu.output.node.printer.agpuprogress.printer')
                    ])
                ]
            ])
        ]);
        $definition->addTag(OutputExtension::FORMATTER_TAG, ['priority' => 1]);
        $container->setDefinition(OutputExtension::FORMATTER_TAG . '.agpuprogress', $definition);
    }

    /**
     * Loads printer helpers.
     *
     * @param ContainerBuilder $container
     */
    protected function loadPrinterHelpers(ContainerBuilder $container) {
        $definition = new Definition('Behat\Behat\Output\Node\Printer\Helper\ResultToStringConverter');
        $container->setDefinition(self::RESULT_TO_STRING_CONVERTER_ID_agpu, $definition);
    }

    /**
     * Loads feature, scenario and step printers.
     *
     * @param ContainerBuilder $container
     */
    protected function loadCorePrinters(ContainerBuilder $container) {
        $definition = new Definition('Behat\Behat\Output\Node\Printer\CounterPrinter', [
            new Reference(self::RESULT_TO_STRING_CONVERTER_ID_agpu),
            new Reference(TranslatorExtension::TRANSLATOR_ID),
        ]);
        $container->setDefinition('output.node.agpu.printer.counter', $definition);

        $definition = new Definition('Behat\Behat\Output\Node\Printer\ListPrinter', [
            new Reference(self::RESULT_TO_STRING_CONVERTER_ID_agpu),
            new Reference(ExceptionExtension::PRESENTER_ID),
            new Reference(TranslatorExtension::TRANSLATOR_ID),
            '%paths.base%'
        ]);
        $container->setDefinition('output.node.agpu.printer.list', $definition);

        $definition = new Definition('Behat\Behat\Output\Node\Printer\Progress\ProgressStepPrinter', [
            new Reference(self::RESULT_TO_STRING_CONVERTER_ID_agpu)
        ]);
        $container->setDefinition('output.node.printer.agpuprogress.step', $definition);

        $definition = new Definition('Behat\Behat\Output\Node\Printer\Progress\ProgressStatisticsPrinter', [
            new Reference('output.node.agpu.printer.counter'),
            new Reference('output.node.agpu.printer.list')
        ]);
        $container->setDefinition('output.node.printer.agpuprogress.statistics', $definition);
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
     * Processes all registered pretty formatter node listener wrappers.
     *
     * @param ContainerBuilder $container
     */
    protected function processListenerWrappers(ContainerBuilder $container) {
        $this->processor->processWrapperServices(
            $container,
            self::ROOT_LISTENER_ID_agpu,
            self::ROOT_LISTENER_WRAPPER_TAG_agpu
        );
    }
}
