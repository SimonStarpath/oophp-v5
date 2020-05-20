<?php

namespace Ssg\MyTextFilter;

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
class MyTextFilterController implements AppInjectableInterface
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
        $title = "Text Format | oophp";

        $page = $this->app->page;

        //$page->add("movie1/header");

        $page->add("textfilter/index", [
            "res" => "",
        ]);

        //$page->add("movie1/footer");

        return $page->render([
            "title" => $title,
        ]);
    }


    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/bbcode
     *
     * @return object
     */
    public function bbcodeAction() : object
    {
        $title = "BBCode Text Format | oophp";

        $page = $this->app->page;
        //$page->add("movie1/header");
        $tfc = new MyTextFilter();

        $text = file_get_contents(__DIR__ . "/text/bbcode.txt");
        $html = $tfc->nl2br($tfc->bbcode2html($text));

        $page->add("textfilter/bbcode", [
            "text" => $text,
            "html" => $html,
        ]);

        //$page->add("movie1/footer");

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/clickable
     *
     * @return object
     */
    public function clickableAction() : object
    {
        $title = "Clickable Text Format | oophp";

        $page = $this->app->page;
        //$page->add("movie1/header");
        $tfc = new MyTextFilter();

        $text = file_get_contents(__DIR__ . "/text/clickable.txt");
        $html = $tfc->nl2br($tfc->makeClickable($text));

        $page->add("textfilter/clickable", [
            "text" => $text,
            "html" => $html,
        ]);

        //$page->add("movie1/footer");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/markdown
     *
     * @return object
     */
    public function markdownAction() : object
    {
        $title = "Markdown Text Format | oophp";

        $page = $this->app->page;
        //$page->add("movie1/header");
        $tfc = new MyTextFilter();

        $text = file_get_contents(__DIR__ . "/text/sample.md");
        $html = $tfc->markdown($text);


        $page->add("textfilter/markdown", [
            "text" => $text,
            "html" => $html,
        ]);

        //$page->add("movie1/footer");

        return $page->render([
            "title" => $title,
        ]);
    }
}
