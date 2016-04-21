<?
$metaInfo = GetMetaData();
?>
<p class="cms-note ui-state-highlight ui-corner-all">
	<span class="highlight">Note:</span> 'Description' and 'Keywords' are used by search engines for indexing.
</p>

<div id="editor-container">
	<form action="javascript:void(0);" class="meta-editor">
		<div class="form-fields">
			<ul>
                <li class="clear" style="margin-left:0;">
					<label for="meta_title" style="vertical-align:top">Title:</label>
                    <input type="text" name="meta_title" id="meta_title" value="<?php echo $metaInfo['title']; ?>" />
				</li>
				<li class="clear" style="margin-left:0;">
					<label for="meta_description" style="vertical-align:top">Description:</label>
					<textarea name="meta_description" id="meta_description"><?php echo $metaInfo['description']; ?></textarea>
				</li>
                <li class="clear" style="margin-left:0;">
					<label for="meta_keywords" style="vertical-align:top">Keywords:</label>
					<textarea name="meta_keywords" id="meta_keywords"><?php echo $metaInfo['keywords']; ?></textarea>
				</li>
				<li class="clear" style="margin-left:0;">
					<input type="submit" value="Submit" class="submit ui_btn" id="meta-info-submit" style="float: left;" />
				</li>
			</ul>
		</div>
	</form>
</div>

<script type = "text/javascript" src = "js/cmsMetaData.js"></script>