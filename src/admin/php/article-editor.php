<?
if (isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	die();
}

$isWriter = (isset($_GET['is-writer'])) ? true : false;

if (!$isWriter) {
	$publishedWriters = GetAllPublishedWriters();
}
?>

<div id="article_editor_container">
	<form id="article_editor" action="javascript:void(0)" method="POST">
		<input type="hidden" name="id" value="<? echo $id; ?>">
		
		<ul>
			<?
			if (!$isWriter) {
				?>
				<input type="hidden" name="is_writer" value="off">

				<li>
					<label for="writer_id">Writer</label>
					<select id="writer_id" name="writer_id">
						<option value="" selected="selected">Please select a writer...</option>
						<?
						foreach ($publishedWriters as $writer) {
							if ($writer['id'] === $existArticle['writer_id']) {
								?>
								<option value="<? echo $writer['id'] ?>" selected><? echo $writer['name'] ?></option>
								<?
							} else {
								?>
								<option value="<? echo $writer['id'] ?>"><? echo $writer['name'] ?></option>
								<?
							}
						}
						?>
					</select>
					<br><br>
				</li>
				<?
			} else {
				?>
				<input type="hidden" name="is_writer" value="on">
				<?
			}
			?>

			<fieldset>
				<legend>English</legend>

				<li>
					<label for="title_en">Title</label>
					<input id="title_en" name="title_en" type="text" placeholder="Please enter a title"
						   value="<? echo $existArticle['title_en']; ?>">
				</li>

				<li>
					<label for="second_title_en">Second Title</label>
					<input id="second_title_en" name="second_title_en" type="text" placeholder="Please enter a title"
						   value="<? echo $existArticle['second_title_en']; ?>">
				</li>

				<li><label class="hidden"></label></li>

				<li>
					<label for="content_en">Content</label>
				</li>

				<li>
					<textarea id="content_en" name="content_en" class="article-ckeditor"><? echo $existArticle['content_en']; ?></textarea>
				</li>
			</fieldset>

			<li>
				<label for="use_de" style="width: 90px; margin: 0">Use German</label>
				<input type="checkbox" id="use_de" name="use_de" <? echo ($existArticle['title_de'] !== '0') ? 'checked' : ''; ?>>
			</li>

			<fieldset id="fieldset_de" custom-hidden="<? echo ($existArticle['title_de'] !== '0') ? 'false' : 'true'; ?>" style="display: none">
				<legend>Deutsch</legend>

				<li>
					<label for="title_de">Title</label>
					<input id="title_de" name="title_de" type="text" placeholder="Please enter a title"
						   value="<? echo ($existArticle['title_de'] !== '0') ? $existArticle['title_de'] : ''; ?>">
				</li>

				<li>
					<label for="second_title_de">Second Title</label>
					<input id="second_title_de" name="second_title_de" type="text" placeholder="Please enter a title"
						   value="<? echo $existArticle['second_title_de']; ?>">
				</li>

				<li><label class="hidden"></label></li>

				<li>
					<label for="content_de">Content</label>
				</li>

				<li>
					<textarea id="content_de" name="content_de" class="article-ckeditor"><? echo $existArticle['content_de']; ?></textarea>
				</li>
			</fieldset>

			<li>
				<label for="use_it" style="width: 90px; margin: 0">Use Italian</label>
				<input type="checkbox" id="use_it" name="use_it" <? echo ($existArticle['title_it'] !== '0') ? 'checked' : ''; ?>>
			</li>

			<fieldset id="fieldset_it" custom-hidden="true" style="display: none">
				<legend>Italian</legend>

				<li>
					<label for="title_it">Title</label>
					<input id="title_it" name="title_it" type="text" placeholder="Please enter a title"
						   value="<? echo ($existArticle['title_it'] !== '0') ? $existArticle['title_it'] : ''; ?>">
				</li>

				<li>
					<label for="second_title_it">Second Title</label>
					<input id="second_title_it" name="second_title_it" type="text" placeholder="Please enter a title"
						   value="<? echo $existArticle['second_title_it']; ?>">
				</li>

				<li><label class="hidden"></label></li>

				<li>
					<label for="content_it">Content</label>
				</li>

				<li>
					<textarea id="content_it" name="content_it" class="article-ckeditor"><? echo $existArticle['content_it']; ?></textarea>
				</li>
			</fieldset>

			<fieldset>
				<legend>Gallery</legend>
				<? include 'php/gallery.php'; ?>
			</fieldset>

			<li>
				<input type="submit" value="Submit" id="article_editor_submit" />
			</li>
		</ul>
	</form>
</div>

<link rel="stylesheet" href="css/article-editor.css" type="text/css" media="screen">
<script type="text/javascript" src="./js/article-editor.js"></script>