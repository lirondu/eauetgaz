var CmsConfig = {
	elfinderAdminConnector: 'elFinder-2.1.6/elfinder.php',
	
	elfinderGuestConnector: 'elFinder-2.1.6/php/connectorGuest.php',
	
	elfinderUiOptions: {
		toolbar: [
			['mkdir'],
			['getfile'],
			['search'],
			['view'],
			['sort'],
			['help']
		],
		tree: {
			// expand current root on init
			openRootOnLoad: true,
			// expand current work directory on open
			openCwdOnOpen: true,
			// auto load current dir parents
			syncTree: true
		},
		navbar: {
			minWidth: 150,
			maxWidth: 500
		},
		cwd: {
			// display parent folder with ".." name :)
			oldSchool: false,
			// file info columns displayed
			listView: {
				columns: ['perm', 'date', 'size', 'kind'],
				columnsCustomName: {}
			}
		}
	}
	
};