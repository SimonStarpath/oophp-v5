<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));


/**
 * Init the game and redirect to play the game
 */
$app->router->get("guess/init", function () use ($app) {
    $game = new Ssg\Guess\Guess();

    $game -> random();
    $_SESSION["game"] = $game;
    $_SESSION["tries"] = $game ->tries();
    $_SESSION["res"] = null;

    $app->response->redirect("guess/play");
});


/**
 * Play the game - show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";
    $game = $_SESSION["game"];
    $guess = $_POST["guess"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $number = $_SESSION["number"] ?? null;
    $op = $_SESSION["op"] ?? null;

    $_SESSION["guess"] = null;
    $_SESSION["res"] = null;
    $_SESSION["op"] = null;

    $data = [
        //$game => $_SESSION["game"],
        //$res => $_SESSION["res"],
        "tries" => $tries,
        "number" => $number,
        "res" => $res,
        "guess" => $guess,
        "op" => $op
    ];

    $app->page->add("guess/play", $data);
    //$app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Play the game - make a guess
 */
$app->router->post("guess/play", function () use ($app) {
    $title = "Play the game";
    $game = $_SESSION["game"];
    $guess = $_POST["guess"] ?? null;
    // $doInit = $_POST["doInit"] ?? null;
    // $doGuess = $_POST["doGuess"] ?? null;
    // $doCheat = $_POST["doCheat"] ?? null;

    $_SESSION["number"] = $_SESSION["game"] -> number();
    $_SESSION["guess"] = $guess;

    try {
        $_SESSION["res"] = $_SESSION["game"] -> makeGuess($guess);
    } catch (Ssg\Guess\GuessException $ge) {
        $_SESSION["res"] = $ge -> errorMessage();
    }

    $_SESSION["tries"] = $_SESSION["game"] -> tries();
    $_SESSION["op"] = "Guess";

    $app->response->redirect("guess/play");
});

/**
 * Cheat the game
 */
$app->router->post("guess/play/cheat", function () use ($app) {
    $title = "Cheat the game";
    $game = $_SESSION["game"];
    $_SESSION["number"] = $_SESSION["game"] -> number();
    $_SESSION["op"] = "Cheat";

    $app->response->redirect("guess/play");
});

/**
 * Restart the game
 */
$app->router->post("guess/play/restart", function () use ($app) {
    $title = "Restart the game";
    $_SESSION["op"] = "Restart";

    $app->response->redirect("guess/init");
});
