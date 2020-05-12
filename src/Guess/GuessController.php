<?php

namespace Ssg\Guess;

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
class GuessController implements AppInjectableInterface
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
     * @return string
     */
    public function initAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        $game = new Guess();

        $game -> random();
        $session->set("game", $game);
        $session->set("tries", $game ->tries());
        $session->set("res", null);
        // $_SESSION["game"] = $game;
        // $_SESSION["tries"] = $game ->tries();
        // $_SESSION["res"] = null;

        return $response->redirect("guess1/play");
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
        //$game = $_SESSION["game"];
        $page = $this->app->page;
        $request = $this->app->request;
        $session = $this->app->session;

        //$guess = $_POST["guess"] ?? null;
        // $tries = $_SESSION["tries"] ?? null;
        // $res = $_SESSION["res"] ?? null;
        // $number = $_SESSION["number"] ?? null;
        // $op = $_SESSION["op"] ?? null;

        $guess = $request->getPost("guess");
        $tries = $session->get("tries");
        $res = $session->get("res");
        $number = $session->get("number");
        $oper = $session->get("op");

        // $_SESSION["guess"] = null;
        // $_SESSION["res"] = null;
        // $_SESSION["op"] = null;

        $session->set("guess", null);
        $session->set("res", null);
        $session->set("op", null);

        $data = [
            //$game => $_SESSION["game"],
            //$res => $_SESSION["res"],
            "tries" => $tries,
            "number" => $number,
            "res" => $res,
            "guess" => $guess,
            "op" => $oper
        ];

        $page->add("guess1/play", $data);
        //$this->app->page->add("guess1/debug");

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
        $request = $this->app->request;
        $response = $this->app->response;
        $session = $this->app->session;

        // $game = $_SESSION["game"];
        // $guess = $_POST["guess"] ?? null;
        //
        // $_SESSION["number"] = $_SESSION["game"] -> number();
        // $_SESSION["guess"] = $guess;

        $game = $session->get("game");
        $guess = $request->getPost("guess");

        $session->set("number", $game->number());
        $session->set("guess", $guess);

        try {
            //$_SESSION["res"] = $_SESSION["game"] -> makeGuess($guess);
            $session->set("res", $game->makeGuess($guess));
        } catch (Ssg\Guess\GuessException $ge) {
            //$_SESSION["res"] = $ge -> errorMessage();
            $session->set("res", $ge -> errorMessage());
        }

        // $_SESSION["tries"] = $_SESSION["game"] -> tries();
        // $_SESSION["op"] = "Guess";

        $session->set("tries", $game->tries());
        $session->set("op", "Guess");

        return $response->redirect("guess1/play");
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function cheatActionPost() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        // $game = $_SESSION["game"];
        // $_SESSION["number"] = $_SESSION["game"] -> number();
        // $_SESSION["op"] = "Cheat";

        $game = $session->get("game");
        $session->set("number", $game->number());
        $session->set("op", "Cheat");

        return $response->redirect("guess1/play");
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function restartActionPost() : object
    {
        $session = $this->app->session;

        $session->set("op", "Restart");

        return $this->app->response->redirect("guess1/init");
    }
}
