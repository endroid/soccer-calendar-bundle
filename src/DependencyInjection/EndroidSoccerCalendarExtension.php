<?php

declare(strict_types=1);

namespace Endroid\SoccerCalendarBundle\DependencyInjection;

use Endroid\SoccerCalendarBundle\Controller\TeamListController;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class EndroidSoccerCalendarExtension extends Extension
{
    /** @param array<mixed> $configs */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $teamLoaderControllerDefinition = $container->getDefinition(TeamListController::class);
        $teamLoaderControllerDefinition->setArgument(0, $config['competition_names']);
    }
}
