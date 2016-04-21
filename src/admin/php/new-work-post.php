
<div id="editor-container" class="small-editor-container">
    <form action="javascript:void(0);" class="post-editor">
        <div class="form-fields">
            <ul>
                <li>
                    <label for="post-title-en">English Title</label>
                    <input type="checkbox" style="visibility: hidden;" />
                    <input name="post-title-en" id="post-title-en" type="text" />
                </li>
                <li>
                    <label for="post-location">Location</label>
                    <input type="checkbox" style="visibility: hidden;" />
                    <input name="post-location" id="post-location" type="text" />
                </li>
                <li>
                    <label for="post-city">City</label>
                    <input type="checkbox" style="visibility: hidden;" />
                    <input name="post-city" id="post-city" type="text" />
                </li>
                <li>
                    <label for="post-country">Country</label>
                    <input type="checkbox" style="visibility: hidden;" />
                    <input name="post-country" id="post-country" type="text" />
                </li>
                <li>
                    <label for="post-year">Year</label>
                    <input type="checkbox" style="visibility: hidden;" />
                    <input name="post-year" id="post-year" type="text" minlength="4" maxlength="4" size="4" />
                </li>
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
            </ul>
        </div>

        <label for="post-content-en" style="margin-bottom: 3px; display: block;">English content:</label>
        <textarea rows="1" cols="1" id="ckeditor_small" name="post-content-en"></textarea>

        <div class="gallery-add-remove">
            <label>Add gallery</label>
            <span id="add-gallery" custom-added="false" class="ui-icon ui-icon-plus ui-corner-all"></span>
        </div>
        <div id="gallery-editor" style="display:none"></div>

        <input type="submit" value="Create" class="submit ui_btn" id="new-post-submit" />
    </form>
</div>


<div id="file_manager_dialog">
    <div id="file_manager_cont"></div>
</div>

<? include './php/thumbMakerMsg.php'; ?>

<link rel="stylesheet" type="text/css" href="./css/thumb-maker.css">
<script src="./js/cmsThumbMaker.js"></script>
<script type="text/javascript" src="js/cmsWorkPosts.js"></script>