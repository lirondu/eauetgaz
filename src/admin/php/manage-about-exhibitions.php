<?
$exhibYears = GetAboutExhibitionsYears();

$exhibPerYear = [];
foreach ($exhibYears as $key => $val) {
	$exhibPerYear[$val] = GetAboutExhibitions($val);
}
?>

<div id="table">

	<?
	foreach ($exhibPerYear as $key => $val) {
		?>
		<div class="year_exhib_box" style="margin-bottom: 25px;">
			<h2 class="exhibition_year" custom-year="<? echo $key; ?>">
				<? echo $key; ?>
				<span class="del_exhib_year ui-icon ui-icon-circle-close"
					  style="display: inline-block; margin-left: 15px;"></span>
			</h2>

			<ul class="header">
				<li>Pos</li>
				<li class="title" style="padding-left: 0.5%; text-align: center;">Content</li>
				<li>Solo</li>
				<li>Delete</li>
			</ul>

			<?
			foreach ($val as $jkey => $jval) {
				?>
				<ul class="sortable" custom-id="<? echo $jval['id']; ?>">
					<li>
						<span class="table-position-val"></span>
						<span class="ui-icon ui-icon-arrowthick-2-n-s sort-handler-icon"></span>
					</li>
					
					<li class="title" style="padding-left: 0.5%;">
<!--						<span class="sort-handler">
							<span class="ui-icon ui-icon-arrowthick-2-n-s sort-handler-icon"></span>
						</span>-->

						<input type="text" name="exhib_content" class="exhib_content"
							   stored-value="<? echo $jval['content']; ?>"
							   value="<? echo $jval['content']; ?>" />

						<input type="hidden" class="exhib-id" value="<? echo $jval['id']; ?>" />
						<input type="button" value="Save Content" class="exhib_save_content ui_btn" disabled="disabled" />
					</li>

					<li>
						<input type="checkbox" name="exhib_solo" class="exhib_solo"
							   <? echo ($jval['solo'] == '1') ? 'checked="checked"' : ''; ?> />

						<input type="hidden" class="exhib-id" value="<? echo $jval['id']; ?>" />
					</li>

					<li>
						<a href="javascript:void(0);" title="Delete Exhibition"
						   class="del-about-exhib table_icn ui-icon ui-icon-circle-close"></a>

						<input type="hidden" class="exhib-id" value="<? echo $jval['id']; ?>" />
					</li>
				</ul>
				<?
			}
			?>
			<ul>
				<li style="background: none; padding-left: 0.5; width: 75%;">
					<span class="add_about_exhib table_icn ui-icon ui-icon-plus" title="Add new exhibition"></span>
				</li>
			</ul>

		</div>
		<?
	}
	?>

    <ul>
        <li style="background: none; text-align: left; width: auto;">
            <span class="add_about_exhib_year ui_btn" title="Add new exhibition year">Add Exhibition Year</span>
        </li>
    </ul>

</div>




<!--Jquery UI Dialogs-->

<div id="del_exhib_dialog" style="font-size: 1.2em;">
    <p>Are you sure you to Delete the exhibition '<span id="del_exhib_name" class="highlight"></span>' ??</p>
    <p>This action is irreversible!!</p>
    <input type="hidden" id="exhib-del-id" />
</div>

<div id="year_exist_err">
    <p>The Year '<span id="error_dupl_year" style="font-weight: bold;"></span>' already exist</p>
</div>


<div id="add_year_dialog" style="font-size: 1.2em;">
    <label for="new_year">Year</label>
    <input type="text" name="new_year" id="new_year" maxlength="4" size="4" />
</div>


<div id="del_year_dialog" style="font-size: 1.2em;">
    <p>Are you sure you to Delete the year '<span id="del_year" class="highlight"></span>' ??</p>
    <p>It will delete the whole year and its content!! This action is irreversible!!</p>
</div>




<style>
    .ui-icon {
        -ms-transform: scale(1.1); /* IE 9 */
        -webkit-transform: scale(1.1); /* Chrome, Safari, Opera */
        transform: scale(1.1);
    }

    span.del_exhib_year:hover,
    span.add_about_exhib:hover {
        cursor: pointer;
    }

    div#page-content div#table ul li input.exhib_content {
        width: calc(100% - 115px); 
        text-align: left; 
        padding-left: 3px; 
        line-height: 25px; 
        /*margin-left: 30px;*/
    }

    ul.sortable li input.exhib_save_content {
        width: 100px;
    }

    span.add_about_exhib_year {
        height: 25px;
        padding: 5px;
    }
</style>


<script type="text/javascript" src="js/cmsAboutExhib.js"></script>