<h1>GUESS MY NUMBER (using POST)</h1>
<!-- pre>
<?=var_dump($_SESSION["game"])?>
$game = $_SESSION["game"];
<?=var_dump($game -> number())?>
</pre -->

<p>Guess a number between 1 and 100, you have <?= $game -> tries(); ?> left!</p>

<form method="post" action="post-process.php">
    <input type="text" name="guess">
    <input type="hidden" name="number" value="<?= $game -> number(); ?>">
    <input type="hidden" name="tries" value="<?= $game -> tries(); ?>">
    <?php if ($game -> tries() > 0 && strcmp("CORRECT", $_SESSION["res"]) != 0) { ?>
        <input type="submit" name="doGuess" value="Make a guess">
    <?php } else { ?>
        <input type="submit" name="doGuess" value="Make a guess" disabled>
    <?php }?>
    <input type="submit" name="doInit" value="Start from beginning">
    <input type="submit" name="doCheat" value="Cheat">
    <!-- input type="submit" name="doDestroy" value="Destroy session" -->
</form>

<?php if (isset($_SESSION["doGuess"]) && $_SESSION["doGuess"]) : ?>
    <p> Your guess <?= $_SESSION["guess"] ?> is <b><?= $_SESSION["res"] ?></b></p>
<?php endif; ?>

<?php if (isset($_SESSION["doCheat"]) && $_SESSION["doCheat"]) : ?>
    <p> CHEAT: Current number is <?= $game -> number(); ?>.</p>
<?php endif;
