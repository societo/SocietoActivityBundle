<?php

/**
 * SocietoActivityBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is licensed under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\ActivityBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ActivityRepository extends EntityRepository
{
    public function getByMemberQuery($memberId, $types = array())
    {
        $builder = $this->_em->createQueryBuilder();
        $builder->add('select', 'a')
            ->add('from', 'Societo\ActivityBundle\Entity\Activity a')
            ->add('where', 'a.actor = :id')
            ->add('orderBy', 'a.createdAt DESC')
            ->setParameter('id', $memberId)
        ;

        if ($types) {
            $ex = $this->_em->getExpressionBuilder();
            $builder->andWhere($ex->in('a.type', $types));
        }

        return $builder;
    }

    public function getByMemberWithFollowingQuery($memberId, $types = array())
    {
        $builder = $this->_em->createQueryBuilder();
        $builder->add('select', 'a')
            ->add('from', 'Societo\ActivityBundle\Entity\Activity a')
            ->add('where', 'a.actor IN (SELECT d.id FROM Societo\RelationshipBundle\Entity\Follower f LEFT JOIN f.destination d WHERE f.origin = :id OR f.destination = :id)')
            ->add('orderBy', 'a.createdAt DESC')
            ->setParameter('id', $memberId)
        ;

        if ($types) {
            $ex = $this->_em->getExpressionBuilder();
            $builder->andWhere($ex->in('a.type', $types));
        }

        return $builder;
    }

    public function getAllMemberQuery($memberId = null, $types = array())
    {
        $builder = $this->_em->createQueryBuilder();
        $builder->add('select', 'a')
            ->add('from', 'Societo\ActivityBundle\Entity\Activity a')
            ->add('orderBy', 'a.createdAt DESC')
        ;

        if ($types) {
            $ex = $this->_em->getExpressionBuilder();
            $builder->andWhere($ex->in('a.type', $types));
        }

        return $builder;
    }
}
