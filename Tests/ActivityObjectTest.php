<?php

/**
 * This file is applied CC0 <http://creativecommons.org/publicdomain/zero/1.0/>
 */

namespace Societo\ActivityBundle\Test;

use Societo\ActivityBundle\ActivityObject;

class ActivityObjectTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyToArray()
    {
        $object = new ActivityObject();
        $this->assertEquals(0, count($object->toArray()));
    }

    public function testToArray()
    {
        $object = new ActivityObject('text');
        $this->assertEquals(1, count($object->toArray()));
    }
}
