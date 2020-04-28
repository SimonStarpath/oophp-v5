<?php

require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";
require __DIR__ . "/functions.php";

/**
 * A processing page that does a redirect.
 */
$_SESSION["guess"] = $_POST["guess"] ?? null;
$_SESSION["doInit"] = $_POST["doInit"] ?? null;
$_SESSION["doGuess"] = $_POST["doGuess"] ?? null;
$_SESSION["doCheat"] = $_POST["doCheat"] ?? null;
$_SESSION["doDestroy"] = $_POST["doDestroy"] ?? null;

//var_dump($_SESSION);

$game = $_SESSION["game"];
//Init and play the game
if ($_SESSION["doInit"] || $game === null) {
    if ($game === null) {
        $game = new Guess();
        $game -> random();
        $_SESSION["game"] = $game;
    } else {
        $game -> random();
    }
    $_SESSION["res"] = null;
} elseif ($_SESSION["doGuess"]) {
    try {
        $_SESSION["res"] = $game -> makeGuess($_POST["guess"]);
    } catch (GuessException $ge) {
        $_SESSION["res"] = $ge -> errorMessage();
    }
} elseif ($_SESSION["doDestroy"]) {
    destroySession();
}

//var_dump($_SESSION);
header("Location: index.php");
exit;
