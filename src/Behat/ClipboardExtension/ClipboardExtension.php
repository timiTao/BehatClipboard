<?php
/**
 * User: Tomasz Kunicki
 * Date: 13.11.2014
 */
namespace Behat\ClipboardExtension;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ClipboardExtension
 *
 * @package Behat\ClipboardExtension\Clipboard
 */
class ClipboardExtension implements ExtensionInterface
{

    /**
     * Main service name
     */
    const SERVICE_NAME = 'clipboard';

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        // TODO: Implement process() method.
    }

    /**
     * Returns the extension config key.
     *
     * @return string
     */
    public function getConfigKey()
    {
        return 'clipboard';
    }

    /**
     * Initializes other extensions.
     *
     * This method is called immediately after all extensions are activated but
     * before any extension `configure()` method is called. This allows extensions
     * to hook into the configuration of other extensions providing such an
     * extension point.
     *
     * @param ExtensionManager $extensionManager
     */
    public function initialize(ExtensionManager $extensionManager)
    {
        /**
         * Nope
         */
    }

    /**
     * Setups configuration for the extension.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('prefix')->defaultValue('clipboard')->info(
                'All values that match PREFIX.** will be try to transform from clipboard value. Default: clipboard'
            )->end()
            ->scalarNode('pattern')->defaultValue('/^%s\.([a-zA-Z0-9_\.]+)/')->info(
                'All values that match PATTERN will be try to transform from clipboard value. Default: /^%s\.([a-zA-Z0-9_\.]+)/ where %s will be prefix'
            )->end()
            ->scalarNode('throw_errors_on_not_found')->defaultTrue()->info(
                'When value is not found, on TRUE, will throw exception. Default: false'
            )->end();
    }

    /**
     * Loads extension services into temporary container.
     *
     * @param ContainerBuilder $container
     * @param array $config
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $this->loadClipboard($container);
        $this->loadContextInitializer($container);
        $this->loadContextReader($container);

        $container->setParameter('clipboard.parameters', $config);
    }

    /**
     * Initialize main clipboard
     *
     * @param ContainerBuilder $container
     */
    private function loadClipboard(ContainerBuilder $container)
    {
        $container->setDefinition(
            ClipboardExtension::SERVICE_NAME,
            new Definition(
                'Behat\ClipboardExtension\Clipboard\ClipboardContainer', array(
                    '%clipboard.parameters%'
                )
            )
        );
    }

    /**
     * Init initializer for behat context
     *
     * @param ContainerBuilder $container
     */
    private function loadContextInitializer(ContainerBuilder $container)
    {
        $definition = new Definition(
            'Behat\ClipboardExtension\Context\Initializer\ClipboardInitializer', array(
                new Reference(ClipboardExtension::SERVICE_NAME)
            )
        );
        $definition->addTag(ContextExtension::INITIALIZER_TAG, array('priority' => 0));
        $container->setDefinition('clipboard.context_initializer', $definition);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function loadContextReader(ContainerBuilder $container)
    {
        $definition = new Definition('Behat\ClipboardExtension\Context\Reader\Transform\ClipboardTransform', array(
                new Reference(ClipboardExtension::SERVICE_NAME)
            ));
        $container->setDefinition('clipboard.context_transform', $definition);

        $definition = new Definition(
            'Behat\ClipboardExtension\Context\Reader\ClipboardEventReader', array(
                new Reference('clipboard.context_transform'),
                '%clipboard.parameters%'
            )
        );
        $definition->addTag(ContextExtension::READER_TAG, array('priority' => 0));
        $container->setDefinition('clipboard.context_reader', $definition);
    }
}