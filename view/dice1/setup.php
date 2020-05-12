<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<p>Play a game of dice (1), first to 100 wins!</p>


<form method="post" action="setup">
    <fieldset>
        <legend>Game setup</legend>

        <table>
            <tr>
                <td style="padding-right:10px"><label for="players">Number players</label></td>
                <td><input type="number" name="players" id="players" value="2" min="2" max="10"></td>
            </tr>
            <tr>
                <td><label for="dices">Number dices</label></td>
                <td><input type="number" name="dices" id="dices" value="3" min="1" max="10"></td>
            </tr>
        </table>

        <input style="float:right" type="submit" name="doSetup" value="Start game">
    </fieldset>
</form>
