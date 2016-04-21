<?php
$pageId = (isset($_GET['id'])) ? $_GET['id'] : 0;

if ($pageId != 0) {
	$currPage		 = GetSinglePage($pageId);
	$existArticle	 = GetArticleById($currPage['content_id']);
} else {
	$currPage['page_type'] = -1;
}

$allPages = GetAllPages();
?>


<div>
	<label for="edit_page_select">Editing Page:</label>
	<input type="checkbox" style="visibility: hidden;" />

	<select name="page_id" id="edit_page_select">
		<option value="">Choose page to edit...</option>
		<?
		foreach ($allPages as $akey => $aval) {
			if ($PAGE_TYPES[$aval['page_type']] != 'article' || $aval['is_list'] != '0') {
				continue;
			}
			?>
			<option value="<? echo $aval['id']; ?>" 
					<? echo ($pageId == $aval['id']) ? 'selected="selected"' : ''; ?>>
						<? echo $aval['name']; ?>
			</option>
			<?
		}
		?>
	</select>
	<br><br><br><br>
</div>

<?
if ($pageId != 0) {
	if ($PAGE_TYPES[$aval['page_type']] === 'article' || $aval['is_list'] === '0') {
		require_once 'php/article-editor.php';
	}
}
?>

<script type = "text/javascript" src = "js/cmsSitePages.js"></script>