<?php

/**
 * SocietoActivityBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under licensed the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\ActivityBundle;

use \Doctrine\ORM\Events;

class RegisterActivityEventSubscriber implements \Doctrine\Common\EventSubscriber
{
    private $builder;

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    private function generateActivity($entity, $em, $type)
    {
        foreach ($this->builder->getGenerators() as $generator) {
            if ($generator instanceof \Societo\ActivityBundle\ActivityGenerator\DoctrineEntityGenerator) {
                if ($generator->execute($entity, $em, $type)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function postPersist($e)
    {
        return $this->generateActivity($e->getEntity(), $e->getEntityManager(), 'persist');
    }

    public function postUpdate($e)
    {
        return $this->generateActivity($e->getEntity(), $e->getEntityManager(), 'update');
    }

    public function getSubscribedEvents()
    {
        return array(Events::postPersist, Events::postUpdate);
    }
}
