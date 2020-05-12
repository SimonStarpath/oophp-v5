<?php

namespace Ssg\Dice;

use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test the controller like it would be used from the router,
 * simulating the actual router paths and calling it directly.
 */
class DiceControllerTest extends TestCase
{
    private $controller;
    private $app;

    /**
     * Setup the controller, before each testcase, just like the router
     * would set it up.
     */
    protected function setUp(): void
    {
        global $di;

        // Init service container $di to contain $app as a service
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $app = $di;
        $this->app = $app;
        $di->set("app", $app);

        // Create and initiate the controller
        $this->controller = new DiceController();
        $this->controller->setApp($app);
        //$this->controller->initialize();
    }



    /**
     * Call the controller index action.
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertIsString($res);
        $this->assertContains("Index of the game", $res);
    }


    /**
     * Call the controller debug action.
     */
    public function testDebugAction()
    {
        $res = $this->controller->debugAction();
        $this->assertIsString($res);
        $this->assertContains("Debug my game", $res);
    }



    /**
     * Call the controller init action.
     */
    public function testInitAction()
    {
        $res = $this->controller->initAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }



    /**
     * Call the controller init action.
     */
    public function testSetupActionGet()
    {
        $this->app->session->set("nbrofplayers", 3);
        $this->app->session->set("nbrofdices", 4);
        $res = $this->controller->setupActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);
        $res2 = $this->app->session->get("game");
        $this->assertNotNull($res2);
    }



    /**
     * Call the controller play action GET.
     */
    public function testPlayActionGet()
    {
        $res = $this->controller->playActionGet();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    /**
     * Call the controller play action POST.
     */
    public function testPlayActionPost()
    {
        $this->app->session->set("game", new DiceGame());
        $res = $this->controller->playActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
        $res2 = $this->app->session->get("histogram");
        $this->assertNotNull($res2);
    }


    /**
     * Call the controller next action POST.
     */
    public function testNextActionPost()
    {
        $game = new DiceGame();
        $player1 = $game->getCurrentPlayer();
        $this->app->session->set("game", $game);
        $res = $this->controller->nextActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
        $player2 = $this->app->session->get("player");
        $this->assertNotSame($player1, $player2);
    }


    /**
     * Call the controller next action POST.
     */
    public function testSetupActionPost()
    {
        $game = new DiceGame();
        $this->app->session->set("game", $game);
        $this->app->request->setPost("players", 4);
        $this->app->request->setPost("dices", 10);
        $res = $this->controller->setupActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
        $res = $this->app->session->get("nbrofplayers");
        $this->assertSame(4, $res);
        $res = $this->app->session->get("nbrofdices");
        $this->assertSame(10, $res);
    }
}
