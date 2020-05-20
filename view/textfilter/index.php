<?php

namespace Anax\View;

/**
 * Template file to render a INDEX-view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$action_root = substr($_SERVER["PHP_SELF"], 0, strpos($_SERVER["PHP_SELF"], "index"));

?>
<h1> Välj nedan textformatteringsgfilter för att se hur det kan se ut </h1>
<ul>
    <li><a href="textfilter/bbcode">BBCODE + NL2BR</a></li>
    <li><a href="textfilter/clickable">CLICKABLE</a></li>
    <li><a href="textfilter/markdown">MARKDOWN</a></li>
</ul>
