<?php
namespace Ssg\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class ComputerPlayer extends Player
{
    public function __construct(String $id)
    {
        parent::__construct($id);
    }


    public function keepPlaying(int $points, int $limit, int $nbrOfDices, int $leadingScore = 0)
    {
        $temp = $this -> points + $points;
        // Win, no more playing
        if ($temp >= $limit) {
            return false;
        }

        // If leader is close to winning (missing only 15% of the total points),
        // take a chance
        if ($temp < $leadingScore && $leadingScore >= $limit * 0.15) {
            return true;
        }

        // If leader is close to winning (missing half possible total dice points),
        // take a chance
        if ($temp < $leadingScore && $leadingScore >= ($nbrOfDices * 6/2)) {
            return true;
        }

        // Half possible dice points is upper limit for the turn
        if ($points > ($nbrOfDices * 6/2)) {
            return false;
        }

        /* Take a chance
        if (rand(0, 1) > 0.5) {
            return false;
        }*/

        return true;
    }
}
