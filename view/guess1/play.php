<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$action_root = substr($_SERVER["PHP_SELF"], 0, strpos($_SERVER["PHP_SELF"], "/play"));
?>
<h1>Guess a number (1)</h1>
<p>Guess a number between 1 and 100, you have <?= $tries ?> tries left!</p>

<!-- action="<?= url("guess/play") ?>" -->

<form method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="tries" value="<?= $tries ?>">
    <?php if ($tries > 0 && strcmp("CORRECT", $res) != 0) { ?>
        <input type="submit" name="doGuess" value="Make a guess" formaction="<?= $_SERVER["PHP_SELF"]; ?>">
    <?php } else { ?>
        <input type="submit" name="doGuess" value="Make a guess" disabled>
    <?php }?>
    <input type="submit" name="doInit" value="Start from beginning" formaction=<?= url("guess1/restart") ?>>
    <input type="submit" name="doCheat" value="Cheat" formaction=<?= url("guess1/cheat") ?>>
    <!-- input type="submit" name="doDestroy" value="Destroy session" -->
</form>

<?php if ($res != null) : ?>
    <p> Your guess <?= $guess ?> is <b><?= $res ?></b></p>
<?php endif; ?>

<?php if (strcmp($op, "Cheat") == 0) : ?>
    <p> CHEAT: Current number is <?= $number ?>.</p>
<?php endif;
