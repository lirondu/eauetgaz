var ClientAgent = {
	
	// Add css function
	AddCssLink: function (path, id) {
		var body = document.getElementsByTagName('body')[0];
		var link = document.createElement('link');

		link.rel = 'stylesheet';
		link.type = 'text/css';
		link.href = path;		

		if (id !== undefined) {
			link.id = id;
		}
		
		body.appendChild(link);
	},
	
	// Remove CSS function
	RemoveCssLink: function (id) {
		var body = document.getElementsByTagName('body')[0];
		var el = document.getElementById(id);
		
		if (el !== undefined && el !== null) {
			body.removeChild(el);
		}
	}

};


/*##### HANDLE DESKTOP OR MOBILE #####*/
var tabletAgents = /iPad|Android/i;
var phoneAgents = /Android.*Mobile|Mobile.*Android|BlackBerry|iPhone|iPod|Opera Mini|IEMobile/i;

if (navigator.userAgent.match(phoneAgents)) {
    ClientAgent.AddCssLink('css/phone.css');
	ClientAgent.platform = 'phone';
} else if (navigator.userAgent.match(tabletAgents)) {
	ClientAgent.AddCssLink('css/tablet.css');
	ClientAgent.platform = 'tablet';
} else {
	ClientAgent.platform = 'desktop';
}
