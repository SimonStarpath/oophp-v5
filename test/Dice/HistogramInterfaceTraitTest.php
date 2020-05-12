<?php

namespace Ssg\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class HistogramInterfaceTraitTest extends TestCase
{
    /**
     * Get the histogram serie
     */
    public function testGetHistogramSerie()
    {
        $exp = 10;
        $dicehand = new DiceHandHistogram($exp);
        $res = $dicehand -> roll();
        $this->assertSame($exp, count($res));
        foreach ($res as $r) {
            $this->assertTrue($r >= 1 && $r <= 6);
        }

        $res2 = $dicehand -> getHistogramSerie();
        $this->assertSame($res, $res2);
    }


    /**
     * Get the max value of the histogram
     */
    public function testgetHistogramMin()
    {
        $dices = 8;
        $dicehand = new DiceHandHistogram($dices);
        $res = $dicehand -> getHistogramMin();
        $exp = 1;
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
