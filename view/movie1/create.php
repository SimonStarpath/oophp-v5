<?php

namespace Anax\View;

/**
 * Template file to render a CREATE-view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<form method="post">
    <fieldset>
    <legend>Create</legend>

    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" placeholder="Movie title"/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" placeholder="2020"/>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doCreate" value="Create">
    </p>
    </fieldset>
</form>
