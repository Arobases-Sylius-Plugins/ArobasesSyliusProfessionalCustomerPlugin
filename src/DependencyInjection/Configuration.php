<?php

declare(strict_types=1);

namespace Arobases\SyliusProfessionalCustomerPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('arobases_sylius_professional_customer_plugin');
        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
