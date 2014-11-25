<?php
/**
 * User: Tomasz Kunicki
 * Date: 13.11.2014
 */
namespace Behat\ClipboardExtension;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

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
     * extension point
     *
     * @param ExtensionManager $extensionManager
     */
    public function initialize(ExtensionManager $extensionManager)
    {
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
            ->arrayNode('defaults')
                ->prototype('scalar')
            ->end();
    }

    /**
     * Loads extension services into temporary container.
     *
     * @param ContainerBuilder $container
     * @param array $config
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/Config'));
        $loader->load('services.yml');

        $container->setParameter('clipboard.parameters', $config);
        $container->setParameter('clipboard.parameters.defaults', $config['defaults']);
    }
}
