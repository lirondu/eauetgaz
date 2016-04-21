<?
$article	 = GetArticleById($pageId);
$year		 = (isset($_GET['year'])) ? $_GET['year'] : -1;
$hasGerman	 = ($article['second_title_de'] !== '0') ? true : false;
$hasItalian	 = ($article['second_title_it'] !== '0') ? true : false;
?>

<link rel="stylesheet" href="./css/article.css">

<!--Colomuns elements for js clone-->
<div id="columns_container">

	<div id="gallery_column" class="single-column">
		<? echo $article['gallery_content']; ?>
	</div>

	<div id="text_column" class="single-column">

		<div id="text_container">
			<ol class="breadcrumb">
				<li>
					<a href="<? echo GetMenuPageLink($pageMenuName); ?>">
						<? echo $pageMenuName; ?>
					</a>
				</li>

				<?
				if ($pageMenuName === 'Artists' && $year !== -1) {
					?>
					<li>
						<a href="/index?type=artists&menu-name=Artists&year=<? echo $year; ?>">
							<? echo $year; ?>
						</a>
					</li>
					<?
				}
				?>
			</ol>

			<?
			if ($adminSession) {
				?>
				<form method="POST" action="javascript:void(0)" id="article_inline_form">
					<?
				}
				?>

				<h2 class="text_header cms-editable-text" edit-field="title_en" tooltip="Main title *">
					<?= $article['title_en'] ?>
				</h2>

				<?
				if ($article['is_writer'] !== '1') {
					$writer = GetEntry('writers', $article['writer_id']);
					?>
					<div>
						<p class="author_header">
							<span>Text by
								<a href="/index?type=article&menu-name=Writers&id=<? echo $writer['article_id']; ?>"
								   class="author_name cms-editable-list" edit-list="writers" edit-active="<?= $writer['id'] ?>"
								   edit-field="writer_id" tooltip="Select writer *">
									   <? echo $writer['name']; ?>
								</a>
							</span>
						</p>

						<p class="other_lang" id="other_lang_en">
							<span>This text in
								<a id="goto_english" href="javascript:void(0)">English</a>
							</span>
						</p>

						<?
						if ($hasGerman) {
							?>
							<p class="other_lang" id="other_lang_de">
								<span>This text in
									<a id="goto_german" href="javascript:void(0)">German</a>
								</span>
							</p>
							<?
						}

						if ($hasItalian) {
							?>
							<p class="other_lang" id="other_lang_it"><span>This text in <a id="goto_italian" href="javascript:void(0)">Italian</a></span></p>
							<?
						}
						?>

					</div>
					<?
				}


				if ($adminSession) {
					?>
					<div id="cms_inline_lang_sel">
						<input type="checkbox" checked="checked" disabled="disabled">
						<label><a id="goto_english" href="javascript:void(0)">English</a></label>

						<input type="checkbox" name="has_de" id="has_de" <?= ($hasGerman) ? 'checked="checked"' : '' ?>>
						<label><a id="goto_german" href="javascript:void(0)" class="<?= (!$hasGerman) ? 'disabled' : '' ?>">German</a></label>

						<input type="checkbox" name="has_it" id="has_it" <?= ($hasItalian) ? 'checked="checked"' : '' ?>>
						<label><a id="goto_italian" href="javascript:void(0)" class="<?= (!$hasItalian) ? 'disabled' : '' ?>">Italian</a></label>
					</div>
					<?
				}
				?>

				<!-- English -->
				<div id="article_content_en">

					<div class="clear-both" style="overflow:auto;">
						<h3 class="secondary_title cms-editable-text" edit-field="second_title_en"
							tooltip="Secondary title (optional)">
								<? echo ($article['second_title_en'] !== '0') ? $article['second_title_en'] : ''; ?>
						</h3>
					</div>


					<p class="article-content cms-editable-editor" id="article-content" edit-field="content_en"
					   tooltip="English Content *">
						   <? echo $article['content_en']; ?>
					</p>

				</div>


				<!-- German -->
				<div id="article_content_de">
					<h3 class="secondary_title cms-editable-text" edit-field="second_title_de"
						tooltip="Secondary title (optional)">
							<? echo ($article['second_title_de'] !== '0') ? $article['second_title_de'] : ''; ?>
					</h3>

					<p class="article-content cms-editable-editor" edit-field="content_de" tooltip="German Content *">
						<? echo $article['content_de']; ?>
					</p>
				</div>


				<!-- Italian -->
				<div id="article_content_it">
					<h3 class="secondary_title cms-editable-text" edit-field="second_title_it"
						tooltip="Secondary title (optional)">
							<? echo ($article['second_title_it'] !== '0') ? $article['second_title_it'] : ''; ?>
					</h3>


					<p class="article-content cms-editable-editor" edit-field="content_it" tooltip="Italian Content *">
						<? echo $article['content_it']; ?>
					</p>
				</div>


				<?
				if ($adminSession) {
					?>
				</form>
				<?
			}
			?>

		</div>

	</div>
</div>


<?
if ($adminSession) {
	$allWriters			 = GetAllPublishedWriters();
	$writersNamesList	 = '';
	$writersIdsList		 = '';

	foreach ($allWriters as $key => $writer) {
		$writersNamesList .= $writer['name'];
		$writersIdsList .= $writer['id'];

		if ($key !== count($allWriters) - 1) {
			$writersNamesList .= ',';
			$writersIdsList .= ',';
		}
	}
	?>
	<input type="hidden" id="edit_id" value="<?= $article['id'] ?>">
	<input type="hidden" id="edit_table" value="article">
	<input type="hidden" id="edit_writers_names" value="<?= $writersNamesList ?>">
	<input type="hidden" id="edit_writers_ids" value="<?= $writersIdsList ?>">
	<?
}
?>