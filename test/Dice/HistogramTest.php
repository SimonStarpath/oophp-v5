<?php

namespace Ssg\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class HistogramTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObject()
    {
        $histogram = new Histogram();
        $this->assertInstanceOf("\Ssg\Dice\HIstogram", $histogram);
    }


    /**
     * Inject test
     */
    public function testInjectData()
    {
        $histogram = new Histogram();
        $dicehand = new DiceHandHistogram(10);
        $exp = $dicehand -> roll();
        $histogram->injectData($dicehand);
        $res = $histogram -> getSerie();
        $this->assertSame($exp, $res);
    }


    /**
     * Get as text
     */
    public function testGetAsText()
    {
        $histogram = new Histogram();
        $dicehand = new DiceHandHistogram(10);
        $dicehand -> roll();
        $histogram->injectData($dicehand);
        $res = $histogram -> getAsText();
        $this->assertSame(6, count($res));
    }
}
