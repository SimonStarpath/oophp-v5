<?php

namespace Ssg\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    //private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    //
    //     // Use $this->app to access the framework services.
    // }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "Index of the game."; //__METHOD__ . ", \$db is {$this->db}";
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Debug my game."; //__METHOD__ . ", \$db is {$this->db}";
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function initAction() : object
    {
        $page = $this->app->page;

        $title = "Init the game";

        $page->add("dice1/setup", []);

        return $page->render([
            "title" => $title,
        ]);
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function setupActionGet() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;

        $game = new DiceGame($session->get("nbrofplayers"), true, $session->get("nbrofdices"));

        $session->set("game", $game);
        $session->set("sum", $game -> getCurrentSum());
        $session->set("player", $game -> getCurrentPlayer());
        $session->set("totals", $game -> getPlayersPoints());
        $session->set("histogram", $game -> getHistogram());

        return $response->redirect("dice1/play");
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionGet() : object
    {
        $title = "Play the game";

        $page = $this->app->page;
        $session = $this->app->session;

        $res = $session->get("res");
        $sum = $session->get("sum");
        $player = $session->get("player");
        $totals = $session->get("totals");
        $next = $session->get("next");
        $winner = $session->get("winner");
        $histogram = $session->get("histogram");

        $session->set("res", null);
        $session->set("sum", null);
        $session->set("player", null);
        $session->set("next", null);
        $session->set("winner", null);
        $session->set("totals", null);

        $data = [
            "res" => $res,
            "sum" => $sum,
            "player" => $player,
            "totals" => $totals,
            "next" => $next,
            "winner" => $winner,
            "histogram" => $histogram,
        ];

        if ($winner !== null) {
            $page->add("dice1/winner", $data);
        } else {
            $page->add("dice1/play", $data);
        }

        //$page->add("dice/debug");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionPost() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;
        $game = $session->get("game");

        $session->set("res", implode(", ", $game->rollDiceHand()));
        $session->set("sum", $game->getCurrentSum());
        $session->set("player", $game->getCurrentPlayer());
        $session->set("totals", $game->getPlayersPoints());
        $session->set("next", $game->forceNextInTurn());
        $session->set("winner", $game->whoWins());
        $session->set("histogram", $game->getHistogram());

        return $response->redirect("dice1/play");
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function nextActionPost() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        $session->set("res", null);
        $session->set("sum", null);

        $game = $session->get("game");
        $game->nextPlayer();

        $session->set("player", $game -> getCurrentPlayer());
        $session->set("totals", $game -> getPlayersPoints());
        $session->set("next", $game -> forceNextInTurn());
        $session->set("winner", $game -> whoWins());

        return $response->redirect("dice1/play");
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function setupActionPost() : object
    {
        $session = $this->app->session;
        $request = $this->app->request;
        $response = $this->app->response;

        $session->set("nbrofplayers", $request->getPost("players", 2));
        $session->set("nbrofdices", $request->getPost("dices", 3));

        return $response->redirect("dice1/setup");
    }
}
