<?php

namespace Ssg\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandHistogramTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dicehand = new DiceHandHistogram();
        $this->assertInstanceOf("\Ssg\Dice\DiceHand", $dicehand);
        $res = $dicehand -> roll();
        $exp = 5;
        $this->assertSame($exp, count($res));
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Use arguments.
     */
    public function testCreateObjectWithArguments()
    {
        $exp = 3;
        $dicehand = new DiceHandHistogram($exp);
        $this->assertInstanceOf("\Ssg\Dice\DiceHand", $dicehand);
        $res = $dicehand -> roll();
        $this->assertSame($exp, count($res));
    }


    /**
     * Roll the dicehand and verify that the values are within limits
     */
    public function testRoll()
    {
        $exp = 10;
        $dicehand = new DiceHandHistogram($exp);
        $res = $dicehand -> roll();
        $this->assertSame($exp, count($res));
        foreach ($res as $r) {
            $this->assertTrue($r >= 1 && $r <= 6);
        }
    }


    /**
     * Get values of the roll of the dices and verify that the value
     * is the same as from the roll operation
     */
    public function testValues()
    {
        $dicehand = new DiceHandHistogram(8);
        $exp = $dicehand -> roll();
        $res = $dicehand -> values();
        $this -> assertEquals($exp, $res);
    }


    /**
     * Sum up the roll of the dicehand and verify that the value
     * is the same as from the sum-operation
     */
    public function testSum()
    {
        $dicehand = new DiceHandHistogram(8);
        $exp = array_sum($dicehand -> roll());
        $res = $dicehand -> sum();
        $this->assertSame($exp, $res);
    }


    /**
     * Take an average of the roll of the dicehand and verify that the value
     * is the same as from the avg-operation
     */
    public function testAvg()
    {
        $dices = 8;
        $dicehand = new DiceHandHistogram($dices);
        $roll = $dicehand -> roll();
        $exp = round(array_sum($roll) / $dices, 2);
        $res = $dicehand -> average();
        $this->assertSame($exp, $res);
    }


    /**
     * Get the max value of the histogram
     */
    public function testgetHistogramMax()
    {
        $dices = 8;
        $dicehand = new DiceHandHistogram($dices);
        $res = $dicehand -> getHistogramMax();
        $exp = 6;
        $this->assertSame($exp, $res);
    }
}
