<?php

namespace Anax\View;

/**
 * Template file to render a INDEX-view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$action_root = substr($_SERVER["PHP_SELF"], 0, strpos($_SERVER["PHP_SELF"], "index"));

?>

<h1>Showing off Markdown</h1>

<h2>Markdown source in sample.md</h2>
<pre><?= $text ?></pre>

<h2>Text formatted as HTML source</h2>
<pre><?= htmlentities($html) ?></pre>

<h2>Text displayed as HTML</h2>
<?= $html ?>
