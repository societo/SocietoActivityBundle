<?php

/**
 * SocietoActivityBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is licensed under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\ActivityBundle\ActivityGenerator;

/**
 * DoctrineEntityGenerator
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
abstract class DoctrineEntityGenerator extends AbstractGenerator
{
    private $entityName;

    public function __construct($entityName)
    {
        $this->entityName = $entityName;
    }

    public function execute($entity, $em, $type)
    {
        if (get_class($entity) !== $this->entityName) {
            return null;
        }

        $method = 'get'.ucfirst($type).'Activity';
        $this->$method($entity, $em);
    }

    public function getGeneratorName()
    {
        return $this->entityName;
    }

    abstract protected function getPersistActivity($entity, $em);

    abstract protected function getUpdateActivity($entity, $em);
}
