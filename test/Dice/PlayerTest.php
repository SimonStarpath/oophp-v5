<?php

namespace Ssg\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class PlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObject()
    {
        $name = "Harry Potter";
        $player = new Player($name);

        $this->assertInstanceOf("\Ssg\Dice\Player", $player);
    }


    /**
     * Get the id of the player and verify it's the same as
     * the id sent at object creation.
     */
    public function testGetId()
    {
        $name = "Harry Potter";
        $player = new Player($name);
        $res = $player -> getId();
        $this->assertSame($name, $res);
    }


    /**
     * Add some points to the player and verify that it's updated
     */
    public function testAddPointsOnce()
    {
        $name = "Harry Potter";
        $player = new Player($name);
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
        $name = "Harry Potter";
        $player = new Player($name);
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
        $name = "Harry Potter";
        $player = new Player($name);
        $res = $player -> getId();
        $this->assertSame($name, $res);
    }


    /**
     * Get the points of the player and verify that it's zero
     * after the object creation.
     */
    public function testGetPointsWhenAddedOnce()
    {
        $name = "Harry Potter";
        $player = new Player($name);
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
        $name = "Harry Potter";
        $player = new Player($name);
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
     * Checks if the player want to keep playing
     */
    public function testKeepPlaying()
    {
        $name = "Harry Potter";
        $player = new Player($name);
        $this->assertNull($player -> keepPlaying(10, 10, 10));
    }
}
