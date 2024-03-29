var urlParams = new URLSearchParams(window.location.search);
var bu = urlParams.get("bu");

url = '/api/dht/locationlist.php?bu=' + bu;

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

fetch(url)
	.then(res => {
		// console.log(res);
		return res.json();
	})
	.then(data => {
		console.log(data)
		var divCount = data.locationCounts;
		for (var i = 0; i < divCount; i++) {
			var div = document.createElement('div');
			div.className = 'sensor-location list-content'
				var divItem = document.createElement('div');
				divItem.className= 'sensor-location-locationID list-item';
				var a = document.createElement('a');
					a.textContent = data.locationLists[i].locationID;
				divItem.appendChild(a);
			div.appendChild(divItem);
				var divItem = document.createElement('div');
				divItem.className= 'sensor-location-locationName list-item';
					var a = document.createElement('a');
					a.textContent = data.locationLists[i].locationName;
				divItem.appendChild(a);
			div.appendChild(divItem);
				var divItem = document.createElement('div');
				divItem.className= 'sensor-location-total list-item';
					var a = document.createElement('a');
					a.textContent = data.locationLists[i].total;
				divItem.appendChild(a);
			div.appendChild(divItem);
				var divItem = document.createElement('div');
				divItem.className= 'sensor-location-active list-item';
					var a = document.createElement('a');
					a.textContent = data.locationLists[i].active;
				divItem.appendChild(a);
			div.appendChild(divItem);
				var divItem = document.createElement('div');
				divItem.className= 'sensor-location-stop list-item';
					var a = document.createElement('a');
					a.textContent = data.locationLists[i].stop;
				divItem.appendChild(a);
			div.appendChild(divItem);
				var divItem = document.createElement('div');
					var a = document.createElement('a');
					a.textContent = data.locationLists[i].temperature;
					a.className = 'value-status';
				divItem.appendChild(a);
				divItem.className= 'sensor-location-temperature list-item';
				if (data.locationLists[i].tStatus != 0) {
					console.log(data.locationLists[i].tStatus);
					divItem.classList.add('abnormal');
				}
				else {
					console.log(data.locationLists[i].tStatus);
					divItem.classList.add('normal');
				}
			div.appendChild(divItem);
				var divItem = document.createElement('div');
					var a = document.createElement('a');
					a.className = 'value-status';
					a.textContent = data.locationLists[i].humidity;
				divItem.appendChild(a);
				divItem.className= 'sensor-location-humidity list-item';
				if (data.locationLists[i].hStatus != 0) {
					divItem.classList.add('abnormal');
				}
				else {
					divItem.classList.add('normal');
				}
			div.appendChild(divItem);
				var divItem = document.createElement('div');
				divItem.className = 'sensor-location-dashboard list-item'
					var a = document.createElement('a');
					a.className = 'a-link-btn';
					a.href = './locationStatusBoard/locationStatusBoard.html?locationid=' + data.locationLists[i].locationID;
					a.textContent = 'Detail';
				divItem.appendChild(a);
			div.appendChild(divItem)
			document.getElementById('sensor-location-table').appendChild(div);
			// document.getElementById('sensor-location-table').appendChild(document.createElement('hr'));
		}
	});


	window.onload = function () {
		setInterval(function (){
			location.reload();
			console.log("reload")
		}, 120000);
		// setInterval(printSensorData,120000);
	}
