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
 * AbstractGenerator
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
abstract class AbstractGenerator
{
    abstract public function getAvailableType();

    abstract public function getGeneratorName();

    public function registerActivity($em, $actor, $verb, $object, $target, $content, $type)
    {
        $activity = new \Societo\ActivityBundle\Entity\Activity();

        $activity->setContent($content);
        $activity->setActor($actor);
        $activity->setGenerator($this->getGeneratorName());
        $activity->setVerb($verb);

        $activity->setObject($object->toArray());
        $activity->setTarget($target->toArray());
        $activity->setType($type);

        $em->persist($activity);
        $em->flush();
    }
}
