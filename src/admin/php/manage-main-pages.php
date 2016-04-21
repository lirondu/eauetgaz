<?


// Functions

function PrintTableRow($id) {
	echo '<ul class="sortable" custom-id="' . $id . '">';
}


function PrintRowTitle($id, $title, $type, $isList) {
	global $PAGE_TYPES;

	if ($PAGE_TYPES[$type] !== 'article' || $isList !== '0') {
		?>
		<li class="title">
			<span><? echo $title; ?></span>
			<span class="highlight row-title-info">(Not article)</span>
		</li>
		<?
	} else {
		?>
		<li class="title">
			<a href="index.php?page-name=edit-page&id=<? echo $id; ?>">
				<span><? echo $title; ?></span>
			</a>
		</li>
		<?
	}
}


function PrintRowPublished($id, $published) {
	global $nonChangablePagesIds;
	global $nonChangableEditablePagesIds;

	if (in_array($id, $nonChangablePagesIds) || in_array($id, $nonChangableEditablePagesIds)) {
		?>
		<li>
			<input type="checkbox" class="show-in-menu" checked="checked" disabled="disabled" title="Show in menu" />
		</li>
		<?
	} else if ($published == '1') {
		?>
		<li>
			<input type="checkbox" class="show-in-menu" checked="checked" title="Show in menu" />
			<input type="hidden" class="position-id" value="<? echo $id; ?>" />
		</li>
		<?
	} else {
		?>
		<li>
			<input type="checkbox" class="show-in-menu" title="Show in menu" />
			<input type="hidden" class="position-id" value="<? echo $id; ?>" />
		</li>
		<?
	}
}


function PrintRowPosition() {
	?>
	<li>
		<span class="table-position-val"></span>
		<span class="ui-icon ui-icon-arrowthick-2-n-s sort-handler-icon"></span>
	</li>
	<?
}


function PrintRowDeleteBtn($id, $title) {
	global $nonChangablePagesIds;
	global $nonChangableEditablePagesIds;
	?>
	<li>
		<?
		if (in_array($id, $nonChangablePagesIds) || in_array($id, $nonChangableEditablePagesIds)) {
			?>
			<a href="javascript:void(0);" title="Delete Page" class="table_icn hidden"></a>
			<?
		} else {
			?>
			<a href="javascript:void(0);" title="Delete Page" class="del-page-button ui-icon ui-icon-circle-close"></a>
			<input type="hidden" class="page-id" value="<? echo $id; ?>" />
			<input type="hidden" class="page-name" value="<? echo $title; ?>" />
			<?
		}
		?>
	</li>

	</ul>
	<?
}
?>



<div id="table">

    <ul class="header">
		<li>Position</li>
        <li class="title">Title</li>
        <li>Published</li>
        <li>Delete</li>
    </ul>

	<?
	$all_pages_arr = GetAllPages();

	foreach ($all_pages_arr as $key => $val) {
		PrintTableRow($val['id']);
		PrintRowPosition();
		PrintRowTitle($val['id'], $val['name'], $val['page_type'], $val['is_list']);
		PrintRowPublished($val['id'], $val['published']);
		PrintRowDeleteBtn($val['id'], $val['name']);
	}
	?>

	<ul>
		<li style="background: none; padding-left: 0.5; width: 98%;">
			<!--<span id="add_menu_page" class="table_icn ui-icon ui-icon-plus" title="Add new page"></span>-->
			<button id="add_menu_page" class="btn btn-default"> + </button>
		</li>
	</ul>

</div>




<!--Jquery UI Dialogs-->

<div id="confirm-page-del-dialog" style="font-size: 1.2em;">
    <p>
        Deleting a page is irreversible!!<br/>
        Instead, you can un-publish it, so it will not be shown on the site...<br/><br/>
    </p>
    <p></p>
    <input type="hidden" id="page-id" value="" />
</div>


<!--<div id="confirm_under_const" style="font-size: 1.2em;">
    <p>
        This action will disable the site and put "Under Construction" message instead !<br/>
        Are you sure?
    </p>
</div>-->


<style>
	#add_menu_page {
		font-size: 2em;
		padding: 1px 10px;
		margin-top: 15px;
	}
</style>


<script type="text/javascript" src="js/cmsSitePages.js"></script>