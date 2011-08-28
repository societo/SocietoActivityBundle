<?php

/**
 * SocietoActivityBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is licensed under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\ActivityBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class GeneratorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('societo.activity.builder')) {
            return;
        }

        $definition = $container->getDefinition('societo.activity.builder');

        $calls = $definition->getMethodCalls();
        $definition->setMethodCalls(array());
        foreach ($container->findTaggedServiceIds('societo.activity.generator') as $id => $attributes) {
            $definition->addMethodCall('addGenerator', array(new Reference($id)));
        }
        $definition->setMethodCalls(array_merge($definition->getMethodCalls(), $calls));
    }
}
