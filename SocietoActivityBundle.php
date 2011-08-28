<?php

/**
 * SocietoActivityBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is licensed under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\ActivityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Societo\ActivityBundle\DependencyInjection\Compiler\GeneratorPass;

/**
 * SocietoActivityBundle
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
class SocietoActivityBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new GeneratorPass());
    }
}
