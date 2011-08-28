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
 * ActivityObject
 *
 * @author Kousuke Ebihara <ebihara@php.net>
 */
class ActivityObject
{
    private $text = null;

    public function __construct($text = null)
    {
        $this->text = $text;
    }

    public function toArray()
    {
        $result = array();

        if ($this->text) {
            $result['text'] = $this->text;
        }

        return $result;
    }
}
