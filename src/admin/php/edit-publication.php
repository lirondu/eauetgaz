<?php
$pubId = (isset($_GET['id'])) ? $_GET['id'] : 0;

if ($pubId != 0) {
	$currPub = GetSinglePublication($pubId);
}

$allPubs = GetAllPublications();
?>


<div id="editor-container" class="small-editor-container">
    <form action="javascript:void(0);" class="publication-editor" custom-new="false">
        <div class="form-fields">
            <ul>
                <li class="clear" style="margin-bottom:15px;">
                    <label for="edit_page_select">Editing Page:</label>
                    <select name="pub_id" id="edit_pub_select">
                        <option value="">Choose publication...</option>
						<?
						foreach ($allPubs as $akey => $aval) {
							?>
							<option value="<? echo $aval['id']; ?>" 
									<? echo ($pubId == $aval['id']) ? 'selected="selected"' : ''; ?>>
										<? echo $aval['title']; ?>
							</option>
							<?
						}
						?>
                    </select>
                </li>

				<?
				if ($pubId != 0 && $currPub != NULL) {
					?>
					<li>
						<label for="pub_title">Title</label>
						<input name="pub_title" id="pub_title" type="text" value="<? echo $currPub['title']; ?>" />
					</li>
					<?
				}
				?>

			</ul>
		</div>

		<?
		if ($pubId != 0 && $currPub != NULL) {
			?>
			<label for="pub_content" style="margin-bottom: 3px; display: block;">Content:</label>
			<textarea rows="1" cols="1" id="ckeditor_small" name="pub_content">
				<? echo $currPub['content']; ?>
			</textarea>

			<!--<input type="hidden" name="edit_pub_id" value="<? echo $currPub['id']; ?>" />-->
			<input type="submit" value="Submit" class="submit ui_btn" id="edit_publication_submit" />
			<?
		}
		?>
	</form>
</div>

<script type = "text/javascript" src = "js/cmsPublications.js"></script>