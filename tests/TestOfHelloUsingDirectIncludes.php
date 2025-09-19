<?php
namespace App\Tests;

// We still require SimpleTest autorun but rely on Composer to load App\Hello
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/simpletest/simpletest/src/autorun.php';

use App\Hello;

class TestOfHelloUsingDirectIncludes extends \UnitTestCase
{
    public function testWorld()
    {
        $this->assertEqual(Hello::world(), 'Hello, world!');
    }
}
