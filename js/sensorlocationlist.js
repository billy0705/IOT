fetch('/api/dht/locationlist.php')
    .then(res => res.json())
    .then(data => {
        console.log(data)
        var divCount = data.locationCounts;
        for (var i = 0; i < divCount; i++) {
            var div = document.createElement('div');
            div.className = 'sensordashboard'
            var a = document.createElement('a');
            a.style = 'display:block; width:10%; font-size:1em;;'
            a.textContent = data.locationLists[i].locationID;
            div.appendChild(a);
            var a = document.createElement('a');
            a.style = 'display:block; width:18%; font-size:1em;'
            a.textContent = data.locationLists[i].locationName;
            div.appendChild(a);
            var a = document.createElement('a');
            a.style = 'display:block; width:8%; font-size:1em;'
            a.textContent = data.locationLists[i].total;
            div.appendChild(a);
            var a = document.createElement('a');
            a.style = 'display:block; width:8%; font-size:1em;'
            a.textContent = data.locationLists[i].active;
            div.appendChild(a);
            var a = document.createElement('a');
            a.style = 'display:block; width:8%; font-size:1em;'
            a.textContent = data.locationLists[i].stop;
            div.appendChild(a);
            var a = document.createElement('a');
            a.style = 'display:block; width:15%; font-size:1em;'
            a.textContent = data.locationLists[i].temperature;
            if (data.locationLists[i].tStatus != 0) {
                a.className = 'down';
            }
            else {
                a.className = 'active';
            }
            div.appendChild(a);
            var a = document.createElement('a');
            a.style = 'display:block; width:10px; font-size:1em;'
            div.appendChild(a);
            var a = document.createElement('a');
            a.style = 'display:block; width:15%; font-size:1em;'
            a.textContent = data.locationLists[i].humidity;
            if (data.locationLists[i].hStatus != 0) {
                a.className = 'down';
            }
            else {
                a.className = 'active';
            }
            div.appendChild(a);
            var div_right = document.createElement('div');
            div_right.className = 'sensordashboard-right'
                var a = document.createElement('a');
                a.href = './locationStatusBoard/locationStatusBoard.php?locationid=' + data.locationLists[i].locationID;
                a.className = 'modify';
                a.textContent = 'DashBoard';
                div_right.appendChild(a)
            div.appendChild(div_right);
            document.getElementById('sensor-location-container').appendChild(div);
            document.getElementById('sensor-location-container').appendChild(document.createElement('hr'));
        }
    });

console.log(".js")