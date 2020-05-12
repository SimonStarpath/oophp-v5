<?php
namespace Ssg\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class Player
{
    protected $points;
    protected $id;


    public function __construct(String $id)
    {
        $this -> points = 0;
        $this -> id = $id;
    }


    public function getId()
    {
        return $this -> id;
    }

    public function getPoints()
    {
        return $this -> points;
    }

    public function addPoints(int $points)
    {
        $this -> points += $points;
    }

    public function keepPlaying(int $points, int $limit, int $nbrOfDices, int $leadingScore = 0)
    {
        $points = $points;
        $limit = $limit;
        $nbrOfDices = $nbrOfDices;
        $leadingScore = $leadingScore;
        return null;
    }
}
