/* global GlobalHelper */

$(function () {
	ColumnsLayout.SetColumnsLayout(ColumnsLayout.columnsMode.textWithSeeAlso);
	$(window).resize(function () {
		ColumnsLayout.SetColumnsLayout(ColumnsLayout.columnsMode.textWithSeeAlso);
	});
	
});