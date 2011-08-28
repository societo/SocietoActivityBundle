<?php

/**
 * SocietoActivityBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is licensed under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\ActivityBundle\PageGadget;

use Societo\PageBundle\PageGadget\AbstractPageGadget;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

/**
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
class ActivityList extends AbstractPageGadget
{
    protected $caption = 'Activity Stream';
    protected $description = 'Show a block of specified member\'s activity stream';

    public function execute($gadget, $parentAttributes, $parameters)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->get('doctrine.orm.entity_manager');

        $maxResults = $gadget->getParameter('max_results', 20);

        $member = $parentAttributes->get('member', $user->getMember());

        $filtering = $gadget->getParameter('filtering', array());

        switch ($gadget->getParameter('type', 'all')) {
            case 'following':
                $method = 'getByMemberWithFollowingQuery';
                break;
            case 'member':
                $method = 'getByMemberQuery';
                break;
            default:
                $method = 'getAllMemberQuery';
        }
        $builder = $em->getRepository('SocietoActivityBundle:Activity')->$method($member->getId(), $filtering);
        $adapter = new DoctrineORMAdapter($builder->getQuery());
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta
            ->setMaxPerPage($maxResults)
            ->setCurrentPage($this->get('request')->query->get('page', 1))
        ;

        return $this->render('SocietoActivityBundle:PageGadget:activity_list.html.twig', array(
            'gadget'  => $gadget,
            'list'  => $pagerfanta->getCurrentPageResults(),
            'route_to_more_page' => $gadget->getParameter('route_to_more_page'),
            'has_pager' => $gadget->getParameter('has_pager'),
            'attributes' => $parentAttributes,
            'pagerfanta' => $pagerfanta,
        ));
    }

    public function getOptions()
    {
        $options =  array(
            'type' => array(
                'type'    => 'choice',
                'options' => array(
                    'choices' => array(
                        'all'       => 'Activity of all members in this site',
                        'following' => 'Activity of following members',
                        'member'    => 'Activity of the specified member',
                    ),
                ),
            ),

            'max_results' => array(
                'type' => 'text',
                'options' => array(
                    'required' => false,
                ),
            ),

            'route_to_more_page' => array(
                'type' => 'text',
                'options' => array(
                    'required' => false,
                ),
            ),

            'has_pager' => array(
                'type' => 'choice',
                'options' => array(
                    'choices' => array(
                        0 => 'No',
                        1 => 'Yes',
                    ),
                ),
            ),
        );

        $options['filtering'] = array(
            'type' => 'choice',
            'options' => array(
                'choices' => $this->get('societo.activity.builder')->getTypes(),
                'multiple' => true,
                'required' => false,
            ),
        );

        return $options;
    }
}
