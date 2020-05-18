<?php

namespace Anax\View;

/**
 * Template file to render a READ-view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>


<table>
    <tr>
        <td>Titel</td>
        <td><?= $movie->title ?></td>
    </tr>
    <tr>
        <td>År</td>
        <td><?= $movie->year ?></td>
    </tr>
    <tr>
        <td>Bild</td>
        <td><?= $movie->image ?></td>
    </tr>
</table>

<a href="<?= url("movie1/edit?movieId=" . $movie->id) ?>">Ändra</a>
<a href="<?= url("movie1"); ?>">Visa alla filmer</a>
