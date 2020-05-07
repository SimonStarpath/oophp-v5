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


    public function keepPlaying(int $points, int $limit, int $nbrOfDices)
    {
        // Win, no more playing
        if (($this -> points + $points) >= $limit) {
            return false;
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
