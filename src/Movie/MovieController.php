<?php

namespace Ssg\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MovieController implements AppInjectableInterface
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
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $session = $this->app->session;
        $movieWrapper = $session->get("movieWrapper");

        if ($movieWrapper === null) {
            $movieWrapper = new MovieWrapper();
            $movieWrapper = $session->set("movieWrapper", $movieWrapper);
        }

        $res = $movieWrapper->getAll($db);

        $title = "Movie database | oophp";

        $page->add("movie1/header");

        $page->add("movie1/index", [
            "resultset" => $res,
        ]);

        $page->add("movie1/footer");

        return $page->render([
            "title" => $title,
        ]);
    }


    /**
     * This is the index method action, it handles:
     * POST METHOD mountpoint/index
     *
     * @return object
     */
    public function indexActionPost() : object
    {
        return $this->app->response->redirect("movie1/index");
    }


    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint/search-title
     *
     * @return object
     */
    public function searchTitleActionGet() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $session = $this->app->session;
        $movieWrapper = $session->get("movieWrapper");
        $res = $movieWrapper->searchTitle($db, getGet("searchTitle"));

        $title = "Search Movie database | oophp";

        $page->add("movie1/header");

        $page->add("movie1/search-title", [
            "resultset" => $res,
            "searchTitle" => getGet("searchTitle"),
        ]);

        if (getGet("searchTitle") != null && ($res == null || count($res) == 0)) {
            $page->add("movie1/no-match");
        }

        $page->add("movie1/index", [
            "resultset" => $res,
        ]);

        $page->add("movie1/footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint/search-year
     *
     * @return object
     */
    public function searchYearActionGet() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $session = $this->app->session;
        $movieWrapper = $session->get("movieWrapper");
        $res = $movieWrapper->searchYear($db, getGet("year1"), getGet("year2"));

        $title = "Search Movie database | oophp";

        $page->add("movie1/header");

        $page->add("movie1/search-year", [
            "resultset" => $res,
            "year1" => getGet("year1"),
            "year2" => getGet("year2"),
        ]);

        if ((getGet("year1") != null || getGet("year2") != null) &&
        ($res == null || count($res) == 0)) {
            $page->add("movie1/no-match");
        }

        $page->add("movie1/index", [
            "resultset" => $res,
        ]);

        $page->add("movie1/footer");

        return $page->render([
            "title" => $title,
        ]);
    }


    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint/edit
     *
     * @return object
     */
    public function editActionGet() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $session = $this->app->session;
        $movieWrapper = $session->get("movieWrapper");
        $res = $movieWrapper->read($db, getGet("movieId"));

        $title = "Edit Movie | oophp";

        $page->add("movie1/header");

        $page->add("movie1/edit", [
            "movie" => $res,
        ]);

        $page->add("movie1/footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * POST METHOD mountpoint/edit
     *
     * @return object
     */
    public function editActionPost() : object
    {
        $db = $this->app->db;
        $response = $this->app->response;
        $session = $this->app->session;
        $movieWrapper = $session->get("movieWrapper");

        $movieId = getPost("movieId");
        $movieTitle = getPost("movieTitle");
        $movieYear = getPost("movieYear");
        $movieImage = getPost("movieImage");

        $movieWrapper->update($db, $movieId, $movieTitle, $movieYear, $movieImage);

        return $response->redirect("movie1/view?movieId=$movieId");
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint/delete
     *
     * @return object
     */
    public function deleteActionGet() : object
    {
        $db = $this->app->db;
        $response = $this->app->response;
        $session = $this->app->session;
        $movieWrapper = $session->get("movieWrapper");
        $movieWrapper->delete($db, getGet("movieId"));

        return $response->redirect("movie1/index");
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint/create
     *
     * @return object
     */
    public function createActionGet() : object
    {
        $page = $this->app->page;
        $title = "Create Movie | oophp";

        $page->add("movie1/header");

        $page->add("movie1/create");

        $page->add("movie1/footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * POST METHOD mountpoint/create
     *
     * @return object
     */
    public function createActionPost() : object
    {
        $db = $this->app->db;
        $response = $this->app->response;
        $session = $this->app->session;
        $movieWrapper = $session->get("movieWrapper");

        $movieTitle = getPost("movieTitle");
        $movieYear = getPost("movieYear");
        $movieImage = getPost("movieImage");

        $movieWrapper->create($db, $movieTitle, $movieYear, $movieImage);

        return $response->redirect("movie1/index");
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint/view
     *
     * @return object
     */
    public function viewActionGet() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $session = $this->app->session;
        $movieWrapper = $session->get("movieWrapper");
        $res = $movieWrapper->read($db, getGet("movieId"));

        $title = "View Movie | oophp";

        $page->add("movie1/header");

        $page->add("movie1/show", [
            "movie" => $res,
        ]);

        $page->add("movie1/footer");

        return $page->render([
            "title" => $title,
        ]);
    }
}
