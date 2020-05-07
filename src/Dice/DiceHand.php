<?php
namespace Ssg\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class DiceHand
{
    private $dices = [];
    private $roll = [];


    public function __construct(int $count = 5)
    {
        for ($i = 0; $i < $count; $i++) {
            array_push($this -> dices, new Dice());
        }
    }

    public function roll()
    {
        $nbrOfDices = count($this -> dices);
        $this -> roll = [];
        for ($i = 0; $i < $nbrOfDices; $i++) {
            array_push($this -> roll, $this -> dices[$i] -> roll());
        }
        return $this -> roll;
    }

    public function values()
    {
        return $this -> roll;
    }

    public function sum()
    {
        return array_sum($this -> roll);
    }

    public function average()
    {
        return round(array_sum($this -> roll) / count($this -> roll), 2);
    }
}
