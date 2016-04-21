
<div id="editor-container" class="small-editor-container">
	<form action="javascript:void(0);" class="publication-editor" custom-new="true">
		<div class="form-fields">
			<ul>
				<li>
					<label for="pub_title">Title</label>
					<input name="pub_title" id="pub_title" type="text" />
				</li>
			</ul>
		</div>
        
        <label for="pub_content" style="margin-bottom: 3px; display: block;">Content:</label>
		<textarea rows="1" cols="1" id="ckeditor_small" name="pub_content"></textarea>
        
		<input type="submit" value="Create" class="submit ui_btn" id="new_publication_submit" />
	</form>
</div>

<script type="text/javascript" src="js/cmsPublications.js"></script>