<?
$awards = GetAboutAwardsByPos();
?>

<div id="table" class="awards-sortable">

	<ul class="header">
		<li>Position</li>
		<li>Year</li>
		<li class="title">Content</li>
		<li>Delete</li>
	</ul>

	<?
	foreach ($awards as $key => $val) {
		?>
		<ul class="sortable" custom-id="<? echo $val['id'] ?>">
			<li>
				<span class="table_icn hidden"></span>
				<span class="ui-icon ui-icon-arrowthick-2-n-s sort-handler-icon"></span>
			</li>

			<li>
				<span class="award-year"><? echo $val['year']; ?></span>
			</li>

			<li class="title">
				<a class="award-content" href="javascript:void(0)">
					<? echo $val['content']; ?>
				</a>
			</li>

			<li>   
				<a href="javascript:void(0);" title="Delete Award"
				   class="delete-award table_icn ui-icon ui-icon-circle-close"></a>
			</li>
		</ul>
		<?
	}
	?>

	<ul>
		<li style="background: none; padding-left: 0.5; width: 98%;">
			<span class="add-about-award table_icn ui-icon ui-icon-plus" title="Add new award"></span>
		</li>
	</ul>

</div>




<!--Jquery UI Dialogs-->

<div id="award_form_dialog" style="font-size: 1.2em;">
    <form action="javascript:void(0)" method="POST" id="award_form">
		<input type="hidden" id="award_form_id" custom-exist-award="false" />
		
		<ul>
			<li>
				<label for="award_form_year">Year</label>
				<input type="text" name="award_form_year" id="award_form_year" />
			</li>
			<li>
				<label for="award_form_content">Content</label>
				<input type="text" name="award_form_content" id="award_form_content" />
			</li>
		</ul>
		
		<input type="submit" style="display: none;" />
	</form>
</div>



<div id="award_delete_dialog" style="font-size: 1.2em;">
	<input type="hidden" id="award_to_delete_id" />
    <p>Are you sure you to Delete the award: '<span id="award_to_delete_name" class="highlight"></span>' ??</p>
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

    div#page-content div#table ul li input.award-content {
        width: calc(100% - 120px); 
        text-align: left; 
        padding-left: 3px; 
        line-height: 25px;
		border: 1px solid #909090;
        border-radius: 5px;
    }

	input.award-content-save {
		position: absolute;
		right: 1%;
		top: 1px;
	}
	
	span.add-about-award:hover {
		cursor: pointer;
	}
	
	
	/* Form Dialog */
	#award_form_dialog form ul li {
		margin-bottom: 10px;
	}
	
	#award_form_dialog form ul li label {
		display: inline-block;
		width: 60px;
	}
	
	#award_form_dialog form ul li #award_form_year {
		width: 50px;
	}
	
	#award_form_dialog form ul li #award_form_content {
		width: 500px;
		border: 1px solid #BFBFBF;
		border-radius: 3px;
		padding: 2px;
	}
</style>


<script type="text/javascript" src="js/cmsAboutAwards.js"></script>