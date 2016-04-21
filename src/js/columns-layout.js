var ColumnsLayout = {
	
	//Static Flag - if numOfColumns changed
	numOfColumnsFlag: 0,

	columnsMode: {
		onlyGallery: 0,
		textWithSeeAlso: 1,
	},

	SetColumnsLayout: function (mode) {
		var numOfColumns = GlobalHelper.CalculateNumOfColumns();

		if (numOfColumns === ColumnsLayout.numOfColumnsFlag) {
			return;
		}

		ColumnsLayout.numOfColumnsFlag = numOfColumns;

		var currentColumnClass = '';
		switch (numOfColumns) {
			case 1:
				currentColumnClass = 'single';
				break;

			case 2:
				currentColumnClass = 'double';
				break;

			case 3:
				currentColumnClass = 'triple';
				break;

			default:
				break;
		}
		
		$('div.single-column').removeClass('single');
		$('div.single-column').removeClass('double');
		$('div.single-column').removeClass('triple');
		
		$('div.single-column').addClass(currentColumnClass);
		return;
		

		var currentSingleClass = (numOfColumns === 3) ? 'one-third' : 'quarter';
		var removeSingleClass = (numOfColumns === 3) ? 'quarter' : 'one-third';
		var currentDoubleClass = (numOfColumns === 3) ? 'one-third-double' : 'quarter-double';
		var removeDoubleClass = (numOfColumns === 3) ? 'quarter-double' : 'one-third-double';


		$('div.single-column:nth-child(1)').addClass(currentSingleClass);
		$('div.single-column:nth-child(1)').removeClass(removeSingleClass);


		switch (mode) {
			case ColumnsLayout.columnsMode.onlyGallery:
				$('div.single-column').addClass(currentSingleClass);
				$('div.single-column').removeClass(removeSingleClass);
				break;

			case ColumnsLayout.columnsMode.textWithSeeAlso:
				$('div.single-column:nth-child(2)').addClass(currentDoubleClass);
				$('div.single-column:nth-child(2)').removeClass(removeDoubleClass);

				if (numOfColumns === 4) {
					$('div.single-column:nth-child(3)').show();
					$('div.single-column:nth-child(3)').addClass(currentSingleClass);
					$('div.single-column:nth-child(3)').removeClass(removeSingleClass);;
				} else {
					$('div.single-column:nth-child(3)').hide();
				}

				break;

			default:
				break;
		}

	}

};