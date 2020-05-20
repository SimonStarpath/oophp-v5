
<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="contentId" value="<?= esc($content->id) ?>"/>

    <p>
        <label>Title:<br>
        <input style="width:50%;" type="text" name="contentTitle" value="<?= esc($content->title) ?>"/>
        </label>
    </p>

    <p>
        <label>Path:<br>
        <input style="width:50%;" type="text" name="contentPath" value="<?= esc($content->path) ?>"/>
    </p>

    <p>
        <label>Slug:<br>
        <input style="width:50%;" type="text" name="contentSlug" value="<?= esc($content->slug) ?>"/>
    </p>

    <p>
        <label>Text:<br>
        <textarea style="width:100%;" name="contentData"><?= esc($content->data) ?></textarea>
     </p>

     <p>
         <label>Type:<br>
         <input style="width:50%;" type="text" name="contentType" value="<?= esc($content->type) ?>"/>
     </p>

     <p>
         <label>Filter:<br>
         <input style="width:50%;" type="text" name="contentFilter" value="<?= esc($content->filter) ?>"/>
     </p>

     <p>
         <label>Publish:<br>
         <input style="width:50%;" type="datetime" name="contentPublish" value="<?= esc($content->published) ?>"/>
     </p>

    <p>
        <button type="submit" name="doSave" formaction="update"><i class="fas fa-save" aria-hidden="true"></i> Save</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
        <button type="submit" name="doDelete" formaction="delete"><i class="fas fa-trash" aria-hidden="true"></i> Delete</button>
    </p>
    </fieldset>
</form>
