<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

if (!$resultset) {
    return;
}
?>

<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Actions</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td>
            <a href="<?="update?contentId=" . $row->id ?>"><i class="fas fa-edit" aria-hidden="true"></i></a>
            <?php if ($row->deleted !== null && strlen($row->deleted) > 0) { ?>
                <a href="<?= "undelete?contentId=" . $row->id ?>"><i class="fas fa-trash-restore" aria-hidden="true"></i></a>
            <?php } else { ?>
                <a href="<?= "delete?contentId=" . $row->id ?>"><i class="fas fa-trash"></i></a>
            <?php } ?>
        </td>
    </tr>
<?php endforeach; ?>
</table>
