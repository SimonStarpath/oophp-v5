<?php

namespace Anax\View;

/**
 * Template file to render a INDEX-view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

if (!$resultset) {
    return;
}

$action_root = substr($_SERVER["PHP_SELF"], 0, strpos($_SERVER["PHP_SELF"], "index"));

?>

<script src="https://use.fontawesome.com/0aee473986.js"></script>
<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
        <th>Operation</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><img class="thumb" src="<?= $action_root . $row->image ?>"></td>
        <td><a href="<?= $action_root . "/movie1/view?movieId=" . $row->id ?>"><?= $row->title ?></a></td>
        <td><?= $row->year ?></td>
        <td>
            <a href="<?= $action_root . "/movie1/edit?movieId=" . $row->id ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            <a href="<?= $action_root . "/movie1/delete?movieId=" . $row->id ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
