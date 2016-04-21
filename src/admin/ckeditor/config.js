/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    
    config.enterMode = CKEDITOR.ENTER_BR;
    
	config.toolbar = [
		{ name: 'document', items: [ 'Source'] },
		{ name: 'tools', items: [ 'ShowBlocks', 'Maximize' ] },
		{ name: 'links', items: [ 'Image', 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'paste', items: [ 'PasteText', 'PasteFromWord' ] },
		{ name: 'actions', items: [ 'Undo', 'Redo' ] },
		{ name: 'editing', items: [ 'Find', '-', 'Scayt' ] },
		{ name: 'about', items: [ 'About' ] },
		'/',
		{ name: 'clear', items: [ 'RemoveFormat' ] },
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript' ] },
		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'paragraph', items: [ 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
	];
};
