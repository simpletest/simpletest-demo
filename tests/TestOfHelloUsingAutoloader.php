<?php
namespace App\Tests;

// Composer autoload (loads App\ and App\Tests namespaces)
require_once __DIR__ . '/../vendor/autoload.php';

// Include SimpleTest autorun directly from the installed package (composer does not
// automatically include SimpleTest's autorun file).
require_once __DIR__ . '/../vendor/simpletest/simpletest/src/autorun.php';

use App\Hello;

class TestOfHelloUsingAutoloader extends \UnitTestCase
{
    public function testWorld()
    {
        $this->assertEqual(Hello::world(), 'Hello, world!');
    }
}
