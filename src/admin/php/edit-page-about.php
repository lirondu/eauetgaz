<?php
$pageId		 = 3;
$currPage	 = GetSinglePage($pageId);
?>


<div id="editor-container">
    <form action="javascript:void(0);" class="page-editor">
        <div class="form-fields">
            <ul>
				<li>
					<label for="title-en">Title</label>
					<input type="checkbox" style="visibility: hidden;" />
					<input type="text" disabled="disabled" value="<? echo $currPage['title_en']; ?>" />
				</li>
            </ul>


			<label for="content-en" style="margin-bottom: 3px; display: block;">English content:</label>
			<textarea rows="1" cols="1" id="ckeditor-en" name="content-en">
				<? echo $currPage['content_en']; ?>
			</textarea>

			<input type="hidden" name="edit-page-id" value="<? echo $currPage['id']; ?>" />
			<input type="submit" value="Submit" class="submit ui_btn" id="edit-about-page-submit" />

		</div>
    </form>
</div>

<script type="text/javascript" src="js/cmsSitePages.js"></script>