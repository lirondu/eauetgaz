<?php
$homePosts = GetHomePageWorkPosts();
?>
<p class="cms-note ui-state-highlight ui-corner-all">
	<span class="highlight">Note:</span> Only 'Published' and 'Show-in-home' posts appear on this list.<br>
	If a post is missing, make sure its 'Published' and 'Show-in-home' settings are on.
</p>

<div id="table" class="home-page-sortable">

    <ul class="header">
		<li>Pos</li>
        <li class="title">Work Post</li>
    </ul>

	<?
	foreach ($homePosts as $key => $val) {
		?>
		<ul class="sortable" post-id="<? echo $val['id']; ?>">
			<li>
				<span class="table-position-val"></span>
				<span class="ui-icon ui-icon-arrowthick-2-n-s sort-handler-icon"></span>
			</li>

			<li class="title">
				<span>
					<? echo $val['title_en']; ?>
				</span>

				<img title="<? echo $val['title_en']; ?>" src="<? echo $val['thumbnail']; ?>" />
			</li>
		</ul>
		<?
	}
	?>

</div>


<style>
    div#table {
        width: 45% !important;
    }

    ul.sortable li {
        padding-top: 5px !important;
        padding-bottom: 10px !important;
    }

    ul.sortable li img {
        height: 50px; 
        width: auto; 
        vertical-align: middle; 
        display: inline-block; 
        position: absolute; 
        right: 1%;
    }
</style>


<script type="text/javascript" src="js/cmsWorkPosts.js"></script>