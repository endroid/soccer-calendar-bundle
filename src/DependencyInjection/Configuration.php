<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerCalendarBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /** @psalm-suppress PossiblyUndefinedMethod */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        /** @psalm-suppress TooManyArguments */
        $treeBuilder = new TreeBuilder('endroid_soccer_calendar');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            /** @psalm-suppress UndefinedMethod */
            $rootNode = $treeBuilder->root('endroid_soccer_calendar');
        }

        $rootNode
            ->children()
                ->arrayNode('competition_names')
                    ->prototype('scalar')
        ;

        return $treeBuilder;
    }
}
