var GlobalHelper = {
	GetUrlParameterByName: function (name, url) {
		if (!url) {
			url = location;
		}

		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");

		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
		var results = regex.exec(url);

		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	},
	
	CalculateNumOfColumns: function() {
		var winW = $(window).width();
		var wideScreenWidth = 1100;
		//var numOfColumns = (winW > wideScreenWidth) ? 4 : 3;
		var numOfColumns = 0;
		
		if (winW > 900) {
			numOfColumns = 3;
		} else if (winW > 600) {
			numOfColumns = 2;
		} else {
			numOfColumns = 1;
		}
	
		return numOfColumns;
	},

	CalculateColumnsWidth: function(numOfColumns) {
		var winW = $(window).width();
		var actualColumnWidth = Math.floor(winW / numOfColumns) - 0.15;
		
		return actualColumnWidth;
	}
	
}