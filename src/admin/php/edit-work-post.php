<?php
$id = (isset($_GET['id'])) ? $_GET['id'] : 0;

if ($id != 0) {
    $currPage = GetSinglePost('work_posts', $id);

    $galleryExistTitle      = $currPage['gallery_title_en'];
    $galleryExistContent    = $currPage['gallery_content'];
    $galleryExistPicsPerRow = $currPage['gallery_img_per_row'];
}

$all_posts_arr = GetAllWorkPostsOrderd();
?>


<div id="editor-container" class="small-editor-container">
    <form action="javascript:void(0);" class="post-editor">
        <div class="form-fields">
            <ul>
                <li class="clear" style="margin-bottom:15px;">
                    <label for="edit_post_select">Editing Page:</label>
                    <select name="post_id" id="edit_post_select">
                        <option value="">Choose post to edit...</option>
                        <?
                        foreach ($all_posts_arr as $akey => $aval) {
                            if ($id == $aval['id']) {
                                ?>
                                <option value="<? echo $aval['id']; ?>" selected="selected">
                                    <? echo $aval['title_en']; ?>
                                </option>
                                <?
                            } else {
                                ?>
                                <option value="<? echo $aval['id']; ?>">
                                    <? echo $aval['title_en']; ?>
                                </option>
                                <?
                            }
                        }
                        ?>
                    </select>
                </li>

                <?
                if ($id != 0) {
                    ?>
                    <li>
                        <label for="post-title-en">English Title</label>
                        <input type="checkbox" style="visibility: hidden;" />
                        <input name="post-title-en" id="post-title-en" type="text" value="<? echo $currPage['title_en']; ?>" />
                    </li>
                    <li>
                        <label for="post-location">Location</label>
                        <input type="checkbox" style="visibility: hidden;" />
                        <input name="post-location" id="post-location" type="text" value="<? echo $currPage['location']; ?>" />
                    </li>
                    <li>
                        <label for="post-city">City</label>
                        <input type="checkbox" style="visibility: hidden;" />
                        <input name="post-city" id="post-city" type="text" value="<? echo $currPage['city']; ?>" />
                    </li>
                    <li>
                        <label for="post-country">Country</label>
                        <input type="checkbox" style="visibility: hidden;" />
                        <input name="post-country" id="post-country" type="text" value="<? echo $currPage['country']; ?>" />
                    </li>
                    <li>
                        <label for="post-year">Year</label>
                        <input type="checkbox" style="visibility: hidden;" />
                        <input name="post-year" id="post-year" type="text" minlength="4" maxlength="4" size="4" value="<? echo $currPage['year']; ?>" />
                    </li>
                    <?
                    if (($currPage['show_on_home'] == '0')) {
                        ?>
                        <li>
                            <label for="show-on-home">Show on Home Page</label>
                            <input id="show-on-home" name="show-on-home" type="checkbox" />
                        </li>
                        <li id="post-thumb-li" style="visibility: hidden;">
                            <label for="post-thumb">Main Post Picture</label>
                            <input type="checkbox" style="visibility: hidden;" />
                            <input name="post-thumb" id="post-thumb" type="text" readonly="readonly" onfocus="javascript: this.blur();" />
                            <input id="post-thumb-browse" class="ui_btn" type="button" value="..." />
                        </li>
                        <?
                    } else {
                        ?>
                        <li>
                            <label for="show-on-home">Show on Home Page</label>
                            <input id="show-on-home" name="show-on-home" type="checkbox" checked="checked" />
                        </li>
                        <li id="post-thumb-li">
                            <label for="post-thumb">Main Post Picture</label>
                            <input type="checkbox" style="visibility: hidden;" />
                            <input name="post-thumb" id="post-thumb" type="text" readonly="readonly" onfocus="javascript: this.blur();" value="<? echo $currPage['thumbnail']; ?>" />
                            <input id="post-thumb-browse" class="ui_btn" type="button" value="..." />
                        </li>
                        <?
                    }
                }
                ?>
            </ul>
        </div>
        <?
        if ($id != 0) {
            ?>
            <label for="post-content-en" style="margin-bottom: 3px; display: block;">English content:</label>
            <textarea rows="1" cols="1" id="ckeditor_small" name="post-content-en">
                <? echo $currPage['content_en']; ?>
            </textarea>
            <?
            if ($currPage['gallery_content'] == '0') {
                ?>
                <div class="gallery-add-remove">
                    <label>Add gallery</label>
                    <span id="add-gallery" custom-added="false" class="ui-icon ui-icon-plus ui-corner-all"></span>
                </div>
				
				<div id="gallery-editor" style="display:none"></div>
                <?
            } else {
                ?>
                <div class="gallery-add-remove">
                    <label>Remove gallery</label>
                    <span id="add-gallery" custom-added="true" class="ui-icon ui-icon-minus ui-corner-all"></span>
                </div>
                
                <div id="gallery-editor">
                    <? include 'gallery.php'; ?>
                </div>
                <? }
            ?>

            <input type="submit" value="Submit" class="submit ui_btn" id="edit-post-submit" />
            <?
        }
        ?>
    </form>
</div>


<div id="file_manager_dialog">
    <div id="file_manager_cont"></div>
</div>

<? include './php/thumbMakerMsg.php'; ?>

<link rel="stylesheet" type="text/css" href="./css/thumb-maker.css">
<script src="./js/cmsThumbMaker.js"></script>
<script type="text/javascript" src="js/cmsWorkPosts.js"></script>