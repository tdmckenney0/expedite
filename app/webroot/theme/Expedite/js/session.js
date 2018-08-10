jQuery(function() { 
	/* Session Control Function: Checks to see if the log in is still valid. */
	setInterval(function() { 
		$.get('/expedite/users/users/isSessionValid.json?' + Math.random(), function(e) { 
			if(!e.alive) {
				location.reload();
			}
		});
	}, 60000);
});