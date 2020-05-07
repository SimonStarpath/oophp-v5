<?php
namespace Ssg\Dice;

/**
 * A class that deict a dice with a given number of sides
 */
class Dice
{
    private $rolls;
    private $sides;


    public function __construct(int $sideCount = 6)
    {
        $this -> rolls = [];
        $this -> sides = $sideCount;
    }

    public function roll()
    {
        $roll = rand(1, $this -> sides);
        array_push($this -> rolls, $roll);
        return $roll;
    }

    public function getLastRoll()
    {
        $roll = end($this -> rolls);
        reset($this -> rolls);
        return $roll;
    }

    public function sum()
    {
        return array_sum($this -> rolls);
    }

    public function avg()
    {
        return round(array_sum($this -> rolls) / count($this -> rolls), 2);
    }
}
