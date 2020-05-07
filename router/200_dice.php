<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));


/**
 * Init the game and redirect to play the game
 */
$app->router->get("dice/init", function () use ($app) {
    $title = "Init the game";

    $app->page->add("dice/setup", []);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Init the game and redirect to play the game
 */
$app->router->get("dice/setup", function () use ($app) {
    $game = new Ssg\Dice\DiceGame($_SESSION["nbrofplayers"], true, $_SESSION["nbrofdices"]);

    $_SESSION["game"] = $game;
    $_SESSION["sum"] = $_SESSION["game"] -> getCurrentSum();
    $_SESSION["player"] = $_SESSION["game"] -> getCurrentPlayer();
    $_SESSION["totals"] = $_SESSION["game"] -> getPlayersPoints();

    $app->response->redirect("dice/play");
});


/**
 * Play the game - show game status
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Play the game";
    $game = $_SESSION["game"];
    $res = $_SESSION["res"] ?? null;
    $sum = $_SESSION["sum"] ?? null;
    $player = $_SESSION["player"] ?? null;
    $totals = $_SESSION["totals"] ?? null;
    $next = $_SESSION["next"] ?? null;
    $winner = $_SESSION["winner"] ?? null;

    $_SESSION["res"] = null;
    $_SESSION["sum"] = null;
    $_SESSION["player"] = null;
    $_SESSION["next"] = null;
    $_SESSION["winner"] = null;
    $_SESSION["totals"] = null;

    $data = [
        "res" => $res,
        "sum" => $sum,
        "player" => $player,
        "totals" => $totals,
        "next" => $next,
        "winner" => $winner,
    ];

    if ($winner !== null) {
        $app->page->add("dice/winner", $data);
    } else {
        $app->page->add("dice/play", $data);
    }

    //$app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Play the game - make a guess
 */
$app->router->post("dice/play", function () use ($app) {
    $title = "Play the game";
    $game = $_SESSION["game"];

    $_SESSION["res"] = implode(", ", $_SESSION["game"] -> rollDiceHand());

    $_SESSION["sum"] = $_SESSION["game"] -> getCurrentSum();

    $_SESSION["player"] = $_SESSION["game"] -> getCurrentPlayer();

    $_SESSION["totals"] = $_SESSION["game"] -> getPlayersPoints();

    $_SESSION["next"] = $_SESSION["game"] -> forceNextInTurn();

    $_SESSION["winner"] = $_SESSION["game"] -> whoWins();

    $app->response->redirect("dice/play");
});

/**
 * Next player
 */
$app->router->post("dice/play/next", function () use ($app) {
    $title = "Next Player";

    $_SESSION["res"] = null;

    $_SESSION["sum"] = null;

    $_SESSION["game"] -> nextPlayer();

    $_SESSION["player"] = $_SESSION["game"] -> getCurrentPlayer();

    $_SESSION["totals"] = $_SESSION["game"] -> getPlayersPoints();

    $_SESSION["next"] = $_SESSION["game"] -> forceNextInTurn();

    $_SESSION["winner"] = $_SESSION["game"] -> whoWins();

    $app->response->redirect("dice/play");
});

/**
 * Restart the game
 */
$app->router->post("dice/setup", function () use ($app) {
    $title = "Restart the game";
    $_SESSION["nbrofplayers"] = $_POST["players"] ?? 2;
    $_SESSION["nbrofdices"] = $_POST["dices"] ?? 3;

    $app->response->redirect("dice/setup");
});
