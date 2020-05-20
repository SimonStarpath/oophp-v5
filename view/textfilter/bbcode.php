<?php

namespace Anax\View;

/**
 * Template file to render a INDEX-view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$action_root = substr($_SERVER["PHP_SELF"], 0, strpos($_SERVER["PHP_SELF"], "index"));

?>

<h1>Showing off BBCode</h1>

<h2>Source in bbcode.txt</h2>
<pre><?= wordwrap(htmlentities($text)) ?></pre>

<h2>Filter BBCode and Nl2br applied, source</h2>
<pre><?= wordwrap(htmlentities($html)) ?></pre>

<h2>Filter BBCode applied, HTML (including nl2br())</h2>
<?= $html ?>
