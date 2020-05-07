<?php

namespace Ssg\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Ssg\Dice\Dice", $dice);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectWithArguments()
    {
        $dice = new Dice(10);
        $this->assertInstanceOf("\Ssg\Dice\Dice", $dice);
    }


    /**
     * Roll the dice and verify that the value is within limits
     */
    public function testRoll()
    {
        $dice = new Dice(10);

        $firstroll = $dice -> roll();
        $this->assertTrue($firstroll >= 1 && $firstroll <= 10);

        $secondroll = $dice -> roll();
        $this->assertTrue($secondroll >= 1 && $secondroll <= 10);
    }


    /**
     * Get the last roll of the dice and verify that the value
     * is the same as from the roll operation
     */
    public function testGetLastRoll()
    {
        $dice = new Dice(10);

        $firstroll = $dice -> roll();
        $this->assertTrue($firstroll == $dice -> getLastRoll());

        $secondroll = $dice -> roll();
        $this->assertTrue($secondroll == $dice -> getLastRoll());
    }


    /**
     * Sum up the rolls of the dice and verify that the value
     * is the same as from the sum-operation
     */
    public function testSum()
    {
        $dice = new Dice(10);

        $firstroll = $dice -> roll();
        $secondroll = $dice -> roll();
        $thirdroll = $dice -> roll();
        $sum = $firstroll + $secondroll + $thirdroll;
        $res = $dice -> sum();
        $this->assertSame($sum, $res);
    }


    /**
     * Take an average of the rolls of the dice and verify that the value
     * is the same as from the avg-operation
     */
    public function testAvg()
    {
        $dice = new Dice(10);

        $firstroll = $dice -> roll();
        $secondroll = $dice -> roll();
        $thirdroll = $dice -> roll();
        $sum = round(($firstroll + $secondroll + $thirdroll) / 3, 2);
        $res = $dice -> avg();
        $this->assertSame($sum, $res);
    }
}
