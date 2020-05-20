<?php

namespace Ssg\Content;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;
use Ssg\MyTextFilter\MyTextFilter;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ContentController implements AppInjectableInterface
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
     * GET METHOD content
     * GET METHOD content/
     * GET METHOD content/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $contentWrapper = new ContentWrapper();

        $res = $contentWrapper->getAll($db);

        $title = "Show all content | oophp";

        $page->add("content/header", [
            "flashmessage" => getSession("flashmessage"),
        ]);
        setSession("flashmessage", null);

        $page->add("content/show-all", [
            "resultset" => $res,
        ]);

        $page->add("content/footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD content/admin
     *
     * @return object
     */
    public function adminAction() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $contentWrapper = new ContentWrapper();

        if (getSession("login") == null) {
            return $this->app->response->redirect("content/login");
        }

        $res = $contentWrapper->getAll($db);

        $title = "Admin | oophp";

        $page->add("content/header", [
            "flashmessage" => getSession("flashmessage"),
        ]);
        setSession("flashmessage", null);

        $page->add("content/admin", [
            "resultset" => $res,
        ]);

        $page->add("content/footer");

        return $page->render([
            "title" => $title,
        ]);
    }


    /**
     * This is the index method action, it handles:
     * GET METHOD content/create
     *
     * @return object
     */
    public function createActionGet() : object
    {
        $page = $this->app->page;

        if (getSession("login") == null) {
            return $this->app->response->redirect("content/login");
        }

        $title = "Create | oophp";

        $page->add("content/header", [
            "flashmessage" => getSession("flashmessage"),
        ]);
        setSession("flashmessage", null);
        $page->add("content/create");
        $page->add("content/footer");

        return $page->render([
            "title" => $title,
        ]);
    }


    /**
     * This is the index method action, it handles:
     * POST METHOD content/create
     *
     * @return object
     */
    public function createActionPost() : object
    {
        $db = $this->app->db;
        $contentWrapper = new ContentWrapper();

        if (hasKeyPost("doCreate")) {
            $id = $contentWrapper->create($db, getPost("contentTitle"));
            setSession("flashmessage", "Ny databaspost med id " . $id . " har lagts till i databasen!");
            return $this->app->response->redirect("content/update?contentId=" . $id);
        }

        return $this->app->response->redirect("content");
    }


    /**
     * This is the index method action, it handles:
     * GET METHOD content/update
     *
     * @return object
     */
    public function updateActionGet() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $contentWrapper = new ContentWrapper();

        if (getSession("login") == null) {
            return $this->app->response->redirect("content/login");
        }

        $title = "Update | oophp";

        $contentId = getPost("contentId") ?: getGet("contentId");

        $page->add("content/header", [
            "flashmessage" => getSession("flashmessage"),
        ]);
        setSession("flashmessage", null);

        $page->add("content/edit", [
            "id" => $contentId,
            "content" => $contentWrapper->read($db, $contentId),
        ]);

        $page->add("content/footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * POST METHOD content/update
     *
     * @return object
     */
    public function updateActionPost() : object
    {
        $db = $this->app->db;
        $contentWrapper = new ContentWrapper();

        $params = getPost([
            "contentTitle",
            "contentPath",
            "contentSlug",
            "contentData",
            "contentType",
            "contentFilter",
            "contentPublish",
            "contentId"
        ]);

        if (!$params["contentSlug"]) {
            $params["contentSlug"] = slugify($params["contentTitle"]);
        }

        $slug = $params["contentSlug"];
        $i = 1;
        $temp = $contentWrapper->findSlug($db, $slug);
        while ($temp !== null && $temp->id != $params["contentId"]) {
            $slug = $params["contentSlug"] . "-" . $i;
            $i++;
            $temp = $contentWrapper->findSlug($db, $slug);
        }
        $params["contentSlug"] = $slug;

        if (!$params["contentPath"]) {
            $params["contentPath"] = null;
        }
        $contentWrapper->update($db, array_values($params));
        setSession("flashmessage", "Databaspost med id " . $params["contentId"] . " har uppdaterats!");

        return $this->app->response->redirect("content");
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD content/delete
     *
     * @return object
     */
    public function deleteActionGet() : object
    {
        $db = $this->app->db;
        $contentWrapper = new ContentWrapper();

        $contentId = getPost("contentId") ?: getGet("contentId");

        $contentWrapper->delete($db, $contentId);
        setSession("flashmessage", "Databaspost med id " . $contentId . " har raderats!");

        return $this->app->response->redirect("content");
    }



    /**
     * This is the index method action, it handles:
     * POST METHOD content/delete
     *
     * @return object
     */
    public function deleteActionPost() : object
    {
        $id = getPost("contentId");
        return $this->app->response->redirect("content/delete?contentId=" . $id);
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD content/delete
     *
     * @return object
     */
    public function undeleteActionGet() : object
    {
        $db = $this->app->db;
        $contentWrapper = new ContentWrapper();

        $contentId = getPost("contentId") ?: getGet("contentId");

        $contentWrapper->undelete($db, $contentId);
        setSession("flashmessage", "Databaspost med id " . $contentId . " har återställts!");

        return $this->app->response->redirect("content");
    }



    /**
     * This is the index method action, it handles:
     * POST METHOD content/undelete
     *
     * @return object
     */
    public function undeleteActionPost() : object
    {
        $id = getPost("contentId");
        return $this->app->response->redirect("content/undelete?contentId=" . $id);
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD content/blog
     *
     * @return object
     */
    public function blogActionGet($slug) : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $contentWrapper = new ContentWrapper();

        $page->add("content/header", [
            "flashmessage" => getSession("flashmessage"),
        ]);
        setSession("flashmessage", null);
        if (strcmp("all", $slug) == 0) {
            $title = "Blog | oophp";
            $res = $contentWrapper->getAllBlog($db);
            $page->add("content/blog", [
                "resultset" => $res,
            ]);
        } else {
            $title = "Blog | oophp";
            $res = $contentWrapper->getBlogBySlug($db, $slug);
            if (!$res) {
                $title = "404 | oophp";
                $page->add("content/404");
            } else {
                $page->add("content/blogpost", [
                    "content" => $res,
                    "filter" => new MyTextFilter(),
                ]);
            }
        }

        $page->add("content/footer");
        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * GET METHOD content/blog
     *
     * @return object
     */
    public function pagesActionGet($slug) : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $contentWrapper = new ContentWrapper();

        $page->add("content/header", [
            "flashmessage" => getSession("flashmessage"),
        ]);
        setSession("flashmessage", null);
        if (strcmp("all", $slug) == 0) {
            $title = "Blog | oophp";
            $res = $contentWrapper->getAllPages($db);
            $page->add("content/pages", [
                "resultset" => $res,
            ]);
        } else {
            $title = "Blog | oophp";
            $res = $contentWrapper->getPageBySlug($db, $slug);
            if (!$res) {
                $title = "404 | oophp";
                $page->add("content/404");
            } else {
                $page->add("content/page", [
                    "content" => $res,
                    "filter" => new MyTextFilter(),
                ]);
            }
        }

        $page->add("content/footer");
        return $page->render([
            "title" => $title,
        ]);
    }


    /**
     * This is the index method action, it handles:
     * GET METHOD content/login
     *
     * @return object
     */
    public function loginActionGet() : object
    {
        $page = $this->app->page;
        $login = getSession("login");

        $page->add("content/header", [
            "flashmessage" => getSession("flashmessage"),
        ]);
        if (!$login) {
            $title = "Login | oophp";
            $page->add("content/login");
        } else {
            $title = "Logout | oophp";
            $page->add("content/logout", [
                "login" => $login,
            ]);
        }

        $page->add("content/footer");
        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * POST METHOD content/create
     *
     * @return object
     */
    public function loginActionPost() : object
    {
        $db = $this->app->db;
        $loginWrapper = new LoginWrapper();
        $userId = getPost("user");
        $pass = getPost("password");


        if (hasKeyPost("doLogin")) {
            if ($pass !== null) {
                $userEntry = $loginWrapper->findUser($db, $userId);
                if ($userEntry !== null) {
                    if (strcmp($userEntry->pass, $pass) == 0) {
                        setSession("flashmessage", "Användare " . $userId . " är nu inloggad.");
                        setSession("login", $userId);
                    } else {
                        setSession("flashmessage", "Inloggningen misslyckades, felaktigt lösenord.");
                    }
                } else {
                    setSession("flashmessage", "Inloggningen misslyckades, okänd användare.");
                }
            } else {
                setSession("flashmessage", "Inloggningen misslyckades, lösenord saknas!");
            }
        } else {
            setSession("login", null);
            setSession("flashmessage", "Du är nu utloggad från databasen!");
        }

        return $this->app->response->redirect("content/login");
    }
}
