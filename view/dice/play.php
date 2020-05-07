<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<p>Play a game of dice, first to 100 wins!</p>
<div style="min-height:11em;">
<?php if ($totals !== null) : ?>
    <table>
        <tr>
            <th>Player ID</th>
            <th>Points</th>
        </tr>
    <?php foreach ($totals as $total) { ?>
        <tr>
            <td><?= $total[0] ?></td>
            <td><?= $total[1] ?></td>
        </tr>
    <?php }; ?>
    </table>
<?php endif; ?>


<!-- action="<?= url("dice/play") ?>" -->

<?php if ($player != null) : ?>
    <p> The player is: <b><?= $player ?></b></p>
<?php endif; ?>

<?php if ($res != null) : ?>
    <p> The dices say: <b><?= $res ?></b></p>
<?php endif; ?>

<?php if ($res != null && $sum == 0) : ?>
    <p> Current player lost all points accumulated during this turn!</p>
<?php endif; ?>

<?php if ($sum != null) : ?>
    <p> The accumulated points during this turn: <b><?= $sum ?></b></p>
<?php endif; ?>
</div>

<form method="post">
    <?php if (($next != true) && ($res == null || $sum != 0)) { ?>
        <input type="submit" name="doRoll" value="Roll" formaction="<?= $_SERVER["PHP_SELF"]; ?>">
    <?php } else { ?>
        <!--input type="submit" name="doRoll" value="Roll" formaction="<?= $_SERVER["PHP_SELF"]; ?>" disabled -->
    <?php }?>
    <?php if ($next === null || $next == true) { ?>
        <input type="submit" name="doNextPlayer" value="Next Player" formaction="<?= $_SERVER["PHP_SELF"]; ?>/next">
    <?php } ?>
</form>
