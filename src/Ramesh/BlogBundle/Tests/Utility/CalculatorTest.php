<?php 

namespace Ramesh\BlogBundle\Tests\Utility;

use Ramesh\BlogBundle\Utility\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $calc = new Calculator();
        $result = $calc->add(30, 12);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(42, $result);
        $this->assertGreaterThan(40, $result);
    }
}
