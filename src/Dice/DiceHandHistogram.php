<?php

namespace Ssg\Dice;

/**
 * A dice which has the ability to present data to be used for creating
 * a histogram.
 */
class DiceHandHistogram extends DiceHand implements HistogramInterface
{
    use HistogramInterfaceTrait;


    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax()
    {
        return 6;
    }



    /**
     * Roll the dice, remember its value in the serie and return
     * its value.
     *
     * @return int the value of the rolled dice.
     */
    public function roll()
    {
        $this->serie = array_merge($this->serie, parent::roll());
        return $this->values();
    }
}
