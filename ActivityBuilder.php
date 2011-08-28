<?php

/**
 * SocietoActivityBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is licensed under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

namespace Societo\ActivityBundle;

/**
 * ActivityBuilder
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
class ActivityBuilder
{
    const DEFAULT_VERB = 'post';

    private $template;

    private static $conjugated = array();

    private $types = array();

    private $generators = array();

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function addGenerator($generator)
    {
        $this->generators[] = $generator;
        $this->types += $generator->getAvailableType();
    }

    public function getGenerators()
    {
        return $this->generators;
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function build($actor, $verb = self::DEFAULT_VERB, $object = '', $target = '', $preposition = 'to')
    {
        $parts = array(
            '{actor}'       => (string)$actor,
            '{verb}'        => $this->conjugate($verb),
            '{object}'      => '',
            '{preposition}' => '',
            '{target}'      => '',
        );

        if ($object) {
            $parts['{object}'] = $object['text'];
        }

        if ($target) {
            $parts['{preposition}'] = $preposition;
            $parts['{target}'] = $target['text'];
        }

        // TODO: replace to use twig
        return trim(preg_replace('/ +/', ' ', strtr($this->template, $parts)));
    }

    private function conjugate($string)
    {
        if (isset(self::$conjugated[$string])) {
            return self::$conjugated[$string];
        }

        $irregular = include __DIR__.'/Resources/irregularConjugateList.php';

        $parts = explode('-', $string);
        $verb = $parts[0];

        if (isset($irregular[$verb])) {
            $pastVerb = $irregular[$verb];
        } else {
            // from http://cpansearch.perl.org/src/RWG/Lingua-EN-Conjugate-0.311/lib/Lingua/EN/Conjugate.pm
            $pastVerb = $verb.'ed';
            $pastVerb = preg_replace('/([bcdfghjklmnpqrstvwxyz])eed$/', '$1ed', $pastVerb);
            $pastVerb = preg_replace('/([bcdfghjklmnpqrstvwxyz])yed$/', '$1ied', $pastVerb);
            $pastVerb = preg_replace('/eed$/', 'ed', $pastVerb);
        }

        $parts[0] = $pastVerb;

        $result = implode('-', $parts);
        self::$conjugated[$string] = $result;

        return $result;
    }
}
