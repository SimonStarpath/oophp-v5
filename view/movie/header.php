<?php

namespace Anax\View;

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title . $titleExtended ?></title>
</head>
<body>

<navbar class="navbar">
    <a href="<?= url("movie"); ?>">Visa alla filmer</a> |
    <a href="<?= url("movie/create"); ?>">Lägg till ny film</a> |
    <a href="<?= url("movie/search-title"); ?>">Sök efter titel</a> |
    <a href="<?= url("movie/search-year"); ?>">Sök efter år</a> |
</navbar>

<h1>My Movie Database</h1>

<main>
