/* global ColumnsLayout */
/* global GlobalHelper */
var lastNumOfColumns = 0;

function ArrangeColumnsAccordingToWidth() {
	var numOfColumns = GlobalHelper.CalculateNumOfColumns();
	var artistsColumns = $('#page_columns');

	if (numOfColumns === lastNumOfColumns) {
		return;
	}
		
	// set last num of columns - static flag
	lastNumOfColumns = numOfColumns;
	
	// fill artists data into array
	var artists = [];
	$('div.single-artist').each(function () {
		artists.push({
			'id': $(this).find('div.id').html(),
			'name': $(this).find('div.name').html(),
			'thumb': $(this).find('div.thumb').html(),
		});
	});
	
	// Fill container with columns
	artistsColumns.html('');
	for (var i = 0; i < numOfColumns; i++) {
		var singleColumn = $('#single_column').clone();

		singleColumn.html('');
		singleColumn.removeAttr('id');
		artistsColumns.append(singleColumn);
	}
	
	// Fill columns with artists
	for (var i = 0; i < artists.length; i++) {
		var singleArtistContainer = $('#single_artist_container').clone();

		singleArtistContainer.removeAttr('id');
		singleArtistContainer.find('a').attr('href', '/index?type=article&menu-name=Artists&id=' + artists[i].id);
		singleArtistContainer.find('span.artist-name').html(artists[i].name);
		singleArtistContainer.find('img.artist-thumb').attr('src', artists[i].thumb);
		singleArtistContainer.find('img.artist-thumb').attr('alt', artists[i].thumb);
		singleArtistContainer.find('img.artist-thumb').attr('title', artists[i].thumb);

		var currentColumn = 0;
		if ((i + 1) <= numOfColumns) {
			currentColumn = i + 1;
		} else {
			currentColumn = ((i + 1) % numOfColumns !== 0) ? (i + 1) % numOfColumns : numOfColumns;
		}

		$('div.single-column:nth-child(' + currentColumn + ')').append(singleArtistContainer);
	}
	
	// Handle picture hover
	$('div.single-artist-container a').hover(function () {
		$(this).find('span').addClass('artist-hover');
	}, function () {
		$(this).find('span').removeClass('artist-hover');
	});
}




/***** WINDOW LOAD *****/
$(function () {
	ColumnsLayout.SetColumnsLayout(ColumnsLayout.columnsMode.onlyGallery);
	ArrangeColumnsAccordingToWidth();

	$(window).resize(function () {
		ColumnsLayout.SetColumnsLayout(ColumnsLayout.columnsMode.onlyGallery);
		ArrangeColumnsAccordingToWidth();
	});
});