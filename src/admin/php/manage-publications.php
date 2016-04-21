<?
$publications = GetPublicationsPublished();
?>

<div id="table" class="pubs-sortable">

	<ul class="header">
		<li>Position</li>
		<li class="title">Title</li>
		<li>Delete</li>
	</ul>

	<?
	foreach ($publications as $key => $val) {
		?>
		<ul class="sortable" custom-id="<? echo $val['id'] ?>">
			<li>
				<span class="table_icn hidden"></span>
				<span class="ui-icon ui-icon-arrowthick-2-n-s sort-handler-icon"></span>
			</li>

			<li class="title">
				<a class="publication-title" href="index.php?page-name=edit-publication&id=<? echo $val['id'] ?>">
					<? echo $val['title']; ?>
				</a>
			</li>

			<li>   
				<a href="javascript:void(0)" title="Delete Publication"
				   class="delete-publication table_icn ui-icon ui-icon-circle-close">
				</a>
			</li>
		</ul>
		<?
	}
	?>

</div>




<!--Jquery UI Dialogs-->

<div id="pub_delete_dialog" style="font-size: 1.2em;">
	<input type="hidden" id="pub_to_delete_id" />
    <p>Are you sure you to Delete the publication: '<span id="pub_to_delete_name" class="highlight"></span>' ??</p>
</div>




<style>
    .ui-icon {
        -ms-transform: scale(1.1); /* IE 9 */
        -webkit-transform: scale(1.1); /* Chrome, Safari, Opera */
        transform: scale(1.1);
    }

	div#page-content div#table ul li.title {
		padding-left: 1%;
	}
</style>


<script type="text/javascript" src="js/cmsPublications.js"></script>