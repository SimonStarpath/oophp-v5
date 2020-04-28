<?php
class GuessException extends Exception
{
    public function errorMessage()
    {
        $errorMsg = 'Invalid guess : ' . $this->getMessage() .
        ', the guess must be a number in range [1, 100].';
        return $errorMsg;
    }
}
