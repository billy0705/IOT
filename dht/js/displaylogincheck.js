$.ajax({
	url: '/api/loginstatus.php',
	type: 'GET',
	async: false,
	dataType: 'json',
	success: function (response) {
		loginStatus = response.success === true
		if (loginStatus) {
			if (bu == response.auth || response.auth === "admin"){
				console.log("Login");
			}
			else {
				console.log("Insufficient permissions");
				alert("Insufficient permissions");
				window.location.href = dht_home + '/displayDashboard/';
			}
		}
		else {
			console.log("Logout");
			alert("Please Login");
			window.location.href = dht_home + '/displayDashboard/';
			
		}
	},
	error: function (error) {
		console.error('AJAX GET error:', error);
	}
});