<?php


// Functions

function PrintTableRow($id) {
	echo '<ul class="sortable" custom-id="' . $id . '">';
}


function PrintRowPosition() {
	?>
	<li>
		<span class="table-position-val"></span>
		<span class="ui-icon ui-icon-arrowthick-2-n-s sort-handler-icon"></span>
	</li>
	<?
}


function PrintRowTitle($id, $title) {
	?>
	<li class="title">
		<a href="index.php?page-name=edit-work-post&id=<? echo $id; ?>">
			<? echo $title; ?>
		</a>
	</li>
	<?
}


function PrintRowPublished($id, $published) {
	if ($published == '1') {
		?>
		<li>
			<input type="checkbox" class="show-in-posts" checked="checked" title="Show in Works page" />
			<input type="hidden" class="position-id" value="<? echo $id; ?>" />
		</li>
		<?
	} else {
		?>
		<li>
			<input type="checkbox" class="show-in-posts" title="Show in Works page" />
			<input type="hidden" class="position-id" value="<? echo $id; ?>" />
		</li>
		<?
	}
}


function PrintRowDeleteBtn($id, $title) {
	?>
	<li>
		<a href="javascript:void(0);" title="Delete Post" class="del-post-button ui-icon ui-icon-circle-close"></a>
		<input type="hidden" class="post-id" value="<? echo $id; ?>" />
		<input type="hidden" class="post-name" value="<? echo $title; ?>" />
	</li>

	</ul>
	<?
}
?>
<div id="table" class="manage_work_posts">

    <ul class="header">
		<li>Position</li>
        <li class="title">Title</li>
        <li>Published</li>
        <li>Delete</li>
    </ul>

	<?
	$all_posts_arr = GetAllWorkPostsOrderd();

	foreach ($all_posts_arr as $key => $val) {
		PrintTableRow($val['id']);
		PrintRowPosition();
		PrintRowTitle($val['id'], $val['title_en']);
		PrintRowPublished($val['id'], $val['published']);
		PrintRowDeleteBtn($val['id'], $val['title_en']);
	}
	?>

</div>



<div id="confirm-post-del-dialog" style="font-size: 1.2em;">
    <p>
        Deleting a post is irreversible!!
        <br/> Instead, you can un-publish it, so it will not be shown on the site...
        <br/>
        <br/>
    </p>
    <p></p>
    <input type="hidden" id="post-del-id" value="" />
</div>


<script type="text/javascript" src="js/cmsWorkPosts.js"></script>