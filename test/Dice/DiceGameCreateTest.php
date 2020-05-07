<?php

namespace Ssg\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceGame.
 */
class DiceGameCreateTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $players = 2;
        $dices = 6;
        $dicegame = new DiceGame();
        $this->assertInstanceOf("\Ssg\Dice\DiceGame", $dicegame);
        $res = $dicegame -> getPlayersPoints();
        $this -> assertSame($players, count($res));
        $this -> assertSame($dices, count($dicegame -> rollDiceHand()));

        $found = false;
        foreach ($res as $p) {
            if (strcmp($p[0], "Computer") == 0) {
                $found = true;
                break;
            }
        }
        $this -> assertTrue($found);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Use arguments.
     */
    public function testCreateObjectWithArguments()
    {
        $players = 5;
        $dices = 4;
        $withComputer = false;
        $dicegame = new DiceGame($players, $withComputer, $dices);
        $this->assertInstanceOf("\Ssg\Dice\DiceGame", $dicegame);
        $res = $dicegame -> getPlayersPoints();
        $this -> assertSame($players, count($res));
        $this -> assertSame($dices, count($dicegame -> rollDiceHand()));

        $found = false;
        foreach ($res as $p) {
            if (strcmp($p[0], "Computer") == 0) {
                $found = true;
                break;
            }
        }
        $this -> assertFalse($found);
    }
}
