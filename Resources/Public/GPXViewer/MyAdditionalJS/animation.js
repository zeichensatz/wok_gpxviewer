// This file is based on a sample script of GPXViewer created by Jürgen Berkemeier
// Lizenz CC BY-NC-SA 4.0
// Jürgen Berkemeier
// www.j-berkemeier.de
// The file was modified for use with the TYPO3 GPXViewer-Plugin by Wolfgang Kleinbach
// wolfgangkleinbach.de
//
// This file has to be included AFTER GPX2GM.js
//
// With this javascript code, you can easily realize animationed markers along GPX tracks with GPXViewer
//
// To use animated markers, you only have to add an additional class to the GPXViewer map div:
// 	<div id="map123" class="animated_MoveMarker gpxview:example.gpx:Karte">
// The "animated_" classname can be listed anywhere in the classList
// "MoveMarker" is the name of the marker pic, you like to use for the animation
// The map div id MUST always be named "map" followed by a number, i.e. "map123"

	"use strict";

	JB.GPX2GM.callback = function(pars) {
		JB.Debug_Info("callback",pars.id+" "+pars.type,false);
		for(var x=0;x<coords.length;x++) {
			if(pars.id==mapids[x] && pars.type == "Tracks_n") {
				if(!coords[x].length) {
					var tracks = pars.gpxdaten.tracks.track;
					for(var i=0;i<tracks.length;i++)
						for(var j=0;j<tracks[i].daten.length;j++)
							coords[x].push({lat:tracks[i].daten[j].lat,lon:tracks[i].daten[j].lon});
					var mapdiv = document.getElementById(pars.id);
					var map = mapdiv.makeMap.GetMap();
					movemarkers[x] = map.Marker({lat:0,lon:0},JB.icons[markerNames[x]])[0];
				}
			}
		}
		return true;
	} // JB.GPX2GM.callback

	var coords = []; 
	var mapids = [];
	var movemarkers = [];
	var numbers = [];
	var markerNames = [];

	// get divs with classname "animated_*"
	var divs = document.querySelectorAll("div[class*='animated_']");

	// get mapdiv numbers (nos) and markernames, which are defined in the second part of the classname (after "animated_")
	var nos = [];
	for(var i=0;i<divs.length;i++) {
		var div = divs[i];
		// Compare all classes listed with "animated_"
		// if found then get the name of the marker from "animated_MARKERNAME"
		for(var cl=0;cl<div.classList.length;cl++) {
			if(div.classList[cl].substr(0,9) == "animated_") {
				var markerName = div.classList[cl].substr(9,div.classList[cl].length)
			}
		}
		// Finally store markerName in the array markerNames
		markerNames.push(markerName);
		// Get the number of the map div
		var mapno = div.id.substr(3,div.id.length);
		nos.push(mapno);
	}

	// get latlons (coords) etc.
	for(var i=0;i<nos.length;i++) {
		// actual map number
		var no = nos[i];

		window['latlon' + no] = [];
		coords.push(window['latlon' + no]);

		// push mapid into array mapids
		mapids.push('map' + no);
		// define movemarker: it seems not necessary to add "no" here
		movemarkers.push('movemarker' + no);
		// define starting point for each animation; push value in array "numbers"
		numbers.push(0);
	}

	// Muss vor animation-Aufrufen stehen
	var moving = function(x) {
		if(coords[x].length) {
			if(movemarkers[x].setPosition) movemarkers[x].setPosition(new google.maps.LatLng(coords[x][numbers[x]].lat,coords[x][numbers[x]].lon));
			else if(movemarkers[x].setLatLng) movemarkers[x].setLatLng([coords[x][numbers[x]].lat,coords[x][numbers[x]].lon]);
			numbers[x] ++; if(numbers[x]>=coords[x].length) numbers[x]=0;
		}
	}

	var animate = function() {
		for(var i=0;i<mapids.length;i++) {
			moving(i);
		}
		window.requestAnimationFrame(animate);
	};
	animate();
