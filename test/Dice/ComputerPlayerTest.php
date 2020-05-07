<?php

namespace Ssg\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class ComputerPlayer.
 */
class ComputerPlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObject()
    {
        $name = "Computer Harry Potter";
        $player = new ComputerPlayer($name);

        $this->assertInstanceOf("\Ssg\Dice\ComputerPlayer", $player);
    }


    /**
     * Get the id of the player and verify it's the same as
     * the id sent at object creation.
     */
    public function testGetId()
    {
        $name = "Computer Harry Potter";
        $player = new ComputerPlayer($name);
        $res = $player -> getId();
        $this->assertSame($name, $res);
    }


    /**
     * Add some points to the player and verify that it's updated
     */
    public function testAddPointsOnce()
    {
        $name = "Computer Harry Potter";
        $player = new ComputerPlayer($name);
        $player -> addPoints(25);
        $res = $player -> getPoints();
        $this->assertSame(25, $res);
    }

    /**
     * Add some points to the player several times
     * and verify that it's updated
     */
    public function testAddPointsTwice()
    {
        $name = "Computer Harry Potter";
        $player = new ComputerPlayer($name);
        $player -> addPoints(11);
        $res = $player -> getPoints();
        $this->assertSame(11, $res);

        $player -> addPoints(21);
        $res = $player -> getPoints();
        $this->assertSame(11 + 21, $res);
    }


    /**
     * Get the points of the player and verify that it's zero
     * after the object creation.
     */
    public function testGetPointsWhenZero()
    {
        $name = "Computer Harry Potter";
        $player = new ComputerPlayer($name);
        $res = $player -> getId();
        $this->assertSame($name, $res);
    }


    /**
     * Get the points of the player and verify that it's zero
     * after the object creation.
     */
    public function testGetPointsWhenAddedOnce()
    {
        $name = "Computer Harry Potter";
        $player = new ComputerPlayer($name);
        $player -> addPoints(12);
        $res = $player -> getPoints();
        $this->assertSame(12, $res);
    }


    /**
     * Get the points of the player and verify that it's updated
     * after one addition.
     */
    public function testGetPointsWhenAddedMultiple()
    {
        $name = "Computer Harry Potter";
        $player = new ComputerPlayer($name);
        $player -> addPoints(12);
        $res = $player -> getPoints();
        $this->assertSame(12, $res);

        $player -> addPoints(5);
        $res = $player -> getPoints();
        $this->assertSame(12 + 5, $res);

        $player -> addPoints(23);
        $res = $player -> getPoints();
        $this->assertSame(12 + 5 + 23, $res);
    }


    /**
     * Checks if the player wants to keep playing when the
     * points already surpass the limit necessary for win
     */
    public function testKeepPlayingSurpassLimit()
    {
        $name = "Computer Harry Potter";
        $player = new ComputerPlayer($name);
        $player -> addPoints(90);
        $this->assertFalse($player -> keepPlaying(14, 100, 5));
    }


    /**
     * Checks if the player wants to keep playing when the
     * points accumulated are more than half of dices' value combined
     */
    public function testKeepPlayingMoreThanHalfOnDices()
    {
        $name = "Computer Harry Potter";
        $player = new ComputerPlayer($name);
        $player -> addPoints(20);
        $this->assertFalse($player -> keepPlaying(19, 100, 6));
    }


    /**
     * Checks if the player wants to keep playing when the
     * points accumulated are less than half of dices' value combined
     */
    public function testKeepPlayingLessThanHalfOnDices()
    {
        $name = "Computer Harry Potter";
        $player = new ComputerPlayer($name);
        $player -> addPoints(20);
        $this->assertTrue($player -> keepPlaying(17, 100, 6));
    }
}
