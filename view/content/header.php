<?php

namespace Anax\View;

$loginout = "Logga in";
if (getSession("login") !== null) {
    $loginout = "Logga ut";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title . $titleExtended ?></title>
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" data-auto-replace-svg="nest"></script>
</head>
<body>

<navbar class="navbar">
    <a href="<?= url("content"); ?>">Visa allt</a> |
    <a href="<?= url("content/admin"); ?>">Admin</a> |
    <a href="<?= url("content/create"); ?>">Lägg till nytt</a> |
    <a href="<?= url("content/pages/all"); ?>">Visa pages</a> |
    <a href="<?= url("content/blog/all"); ?>">Visa blog</a> |
    <a href="<?= url("content/login"); ?>"><?= $loginout ?></a> |
</navbar>

<?php if ($flashmessage !== null) : ?>
    <div style="margin-top:0.2em; padding: 0.3em; border: 4px solid #4682b4; background-color: #f0f8ff; color: #154360;">
        <p><?= $flashmessage ?> </p>
    </div>
<?php endif; ?>

<main>
