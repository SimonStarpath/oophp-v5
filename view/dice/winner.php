<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>

<p>Play a game of dice, first to 100 wins!</p>

<!-- action="<?= url("dice/play") ?>" -->

<?php if ($winner != null) : ?>
    <p> The winner is: <b><?= $winner ?></b></p>
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

<a href="init">Starta ett nytt spel!</a>
