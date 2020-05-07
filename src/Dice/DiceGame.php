<?php
namespace Ssg\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class DiceGame
{
    const INVALID_DICE_VALUE = 1;
    const LOWEST_VALUE_FOR_WIN = 100;

    private $players = [];
    private $dicehand;
    private $nbrOfDices;
    private $currentPlayerIndex;
    private $currentSum;
    private $currentPlayerRollsNbr;


    public function __construct(int $nbrofplayers = 2, bool $withComputer = true, int $nbrOfDices = 6)
    {
        $count = $nbrofplayers;

        if ($withComputer) {
            $count--;
        }

        for ($i = 0; $i < $count; $i++) {
            $idpart = $i + 1;
            array_push($this -> players, new Player("Player " . $idpart));
        }

        if ($withComputer) {
            array_push($this -> players, new ComputerPlayer("Computer"));
        }

        $this -> dicehand = new DiceHand($nbrOfDices);
        $this -> currentPlayerIndex = 0;
        $this -> currentSum = 0;
        $this -> nbrOfDices = $nbrOfDices;
        $this -> currentPlayerRollsNbr = 0;
    }

    public function rollDiceHand()
    {
        $roll = [];

        $roll = $this -> dicehand -> roll();

        if ($this -> isValidRoll()) {
            $this -> currentSum += $this -> dicehand -> sum();
        } else {
            $this -> currentSum = 0;
        }

        $this -> currentPlayerRollsNbr++;
        return $roll;
    }


    public function isValidRoll()
    {
        return !in_array(self::INVALID_DICE_VALUE, $this -> dicehand -> values());
    }


    public function getCurrentPlayer()
    {
        return $this -> players[$this -> currentPlayerIndex] -> getId();
    }


    public function getCurrentSum()
    {
        return $this -> currentSum;
    }

    public function getPlayersPoints()
    {
        $playersList = [];

        foreach ($this -> players as $player) {
            array_push($playersList, [$player -> getId(), $player -> getPoints()]);
        }

        return $playersList;
    }


    public function nextPlayer()
    {
        $this -> players[$this -> currentPlayerIndex] -> addPoints($this -> currentSum);
        $this -> currentSum = 0;
        $this -> currentPlayerIndex++;

        if ($this -> currentPlayerIndex >= count($this -> players)) {
            $this -> currentPlayerIndex = 0;
        }

        $this -> currentPlayerRollsNbr = 0;
    }


    public function forceNextInTurn()
    {
        if ($this -> currentPlayerRollsNbr == 0) {
            return false;
        }

        if (!($this -> isValidRoll())) {
            return true;
        }

        $playMore =
        $this -> players[$this -> currentPlayerIndex] -> keepPlaying(
            $this -> currentSum,
            self::LOWEST_VALUE_FOR_WIN,
            $this -> nbrOfDices
        );

        if ($playMore !== null) {
            return !$playMore;
        }

        return null;
    }


    public function whoWins()
    {
        for ($i = 0; $i < count($this -> players); $i++) {
            if ($this -> players[$i] -> getPoints() >= self::LOWEST_VALUE_FOR_WIN) {
                return $this -> players[$i] -> getId();
            }
        }

        return null;
    }
}
