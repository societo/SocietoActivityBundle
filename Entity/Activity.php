<?php

/**
 * SocietoActivityBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is licensed under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\ActivityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Societo\BaseBundle\Entity\BaseEntity;

/**
 * @ORM\Entity(repositoryClass="Societo\ActivityBundle\Repository\ActivityRepository")
 * @ORM\Table(name="activity")
 */
class Activity extends BaseEntity
{
    /**
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @ORM\ManyToOne(targetEntity="Societo\BaseBundle\Entity\Member")
     * @ORM\JoinColumn(name="actor_id", referencedColumnName="id")
     */
    protected $actor;

    /**
     * @ORM\Column(name="verb", type="text")
     */
    protected $verb;

    /**
     * @ORM\Column(name="type", type="text")
     */
    protected $type;

    /**
     * @ORM\Column(name="object", type="array")
     */
    protected $object;

    /**
     * @ORM\Column(name="target", type="array")
     */
    protected $target;

    /**
     * @ORM\Column(name="generator", type="text")
     */
    protected $generator;

    //  TODO: icon

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setActor($actor)
    {
        $this->actor = $actor;
    }

    public function setVerb($verb)
    {
        $this->verb = $verb;
    }

    public function getVerb()
    {
        return $this->verb;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setGenerator($generator)
    {
        $this->generator = $generator;
    }

    public function getGenerator()
    {
        return $this->generator;
    }

    public function getActor()
    {
        return $this->actor;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function setObject($object)
    {
        $this->object = $object;
    }

    public function getObject()
    {
        return $this->object;
    }
}
