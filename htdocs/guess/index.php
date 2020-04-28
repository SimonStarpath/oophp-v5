<?php
/**
 * Guess my number, using POST
 */

require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";

if (!isset($_SESSION["game"])) {
    $game = new Guess();

    $game -> random();
    $_SESSION["game"] = $game;
    $_SESSION["res"] = null;
}

$game = $_SESSION["game"];
?>

<!--pre>
<?=var_dump($_SESSION)?>
</pre -->


<?php
//Render the page
require __DIR__ . "/view/guess_my_number_post.php"
?>


<!-- pre>
<?=var_dump($_SESSION)?>
</pre -->
