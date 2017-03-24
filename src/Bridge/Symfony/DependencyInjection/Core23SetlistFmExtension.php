<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class Core23SetlistFmExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $this->configureApi($container, $config);
        $this->configureHttpClient($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function configureApi(ContainerBuilder $container, array $config)
    {
        $container->setParameter('core23.setlistfm.api.endpoint', $config['api']['endpoint']);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function configureHttpClient(ContainerBuilder $container, array $config)
    {
        $container->setAlias('core23.setlistfm.http.client', $config['http']['client']);
        $container->setAlias('core23.setlistfm.http.message_factory', $config['http']['message_factory']);
    }
}
