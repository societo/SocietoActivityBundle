<?php

/**
 * SocietoActivityBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is licensed under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\ActivityBundle\Twig\Extension;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ActivityExtension extends \Twig_Extension
{
    private $builder;

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    public function getName()
    {
        return 'societo_activity';
    }

    public function getFunctions()
    {
        return array(
            'activity_generate' => new \Twig_Function_Method($this, 'generateActivity'),
        );
    }

    public function generateActivity($activity)
    {
        return $this->builder->build($activity->getActor(), $activity->getVerb(), $activity->getObject(), $activity->getTarget());
    }
}
