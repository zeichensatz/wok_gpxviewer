// This file is based on a saemple script of GPXViewer created by Jürgen Berkemeier
// Lizenz CC BY-NC-SA 4.0
// Jürgen Berkemeier
// www.j-berkemeier.de
// The file was modified for use with the TYPO3 GPXViewer-Plugin by Wolfgang Kleinbach
// wolfgangkleinbach.de
//
// With this javascript code, you can easily realize animationed markers along GPX tracks with GPXViewer
// AND waypoint with images, whereby the waypoints are shown in the map and the images are displayed in an extra div.
//
// This javascript file has to be included AFTER GPX2GM.js!
//
// To use animated markers, you only have to add an additional class to the GPXViewer map div:
// 	<div id="map123" class="animated_MoveMarker gpxview:example.gpx:Karte">
// The "animated_" classname can be listed anywhere in the classList
// "MoveMarker" is the name of the marker pic, you like to use for the animation
// The map div id MUST always be named "map" followed by a number, i.e. "map123"
//
// To use waypoints with images whereby the waypoints are shown in the map and the images are displayed in an extra div:
// The extra images div MUST have the name structure of "mapid_images".
// Example for HTML structure:
// 	<div id="map123" class="gpxview:example.gpx:Karte">
// 		<div id='map123_img"> ... here you need waypoints with images of course ...</div>
// 		<div id="map123_images" data-scale="10">
//			<p><button>Previous</button> / <button>Next</button></p>
//			<figure>
//				<img alt=" ">
//				<figcaption></figcaption>
//			</figure>
//		</div>
// 	</div>
// The argument "data-scale=VALUE" in the div with the id "map123_images" changes the scaling of the map. The value is in km.

	"use strict";
	// ################
	// This part is for animation of markers
	// ################
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


	// ################
	// This part is for images div for image markers
	// ################
	var scale = "10"; // set standard for scaling in km

	// get divs with classname "gpxview:"
	var divs = document.querySelectorAll("div[class*='gpxview:']");

	// get GPXViewer mapdivs
	var arrayMapid = [];
	for(var i=0;i<divs.length;i++) {
		// get array of mapdiv ids
		arrayMapid.push(divs[i].id);
	}

	// get html parts and store in arrayMaps with "id" of maps as index
	var arrayMaps = [];
	var validMapids = [];
	for(var i=0;i<arrayMapid.length;i++) {
		var arrayMap = [];
		arrayMap['img'] = document.querySelector("#" + arrayMapid[i] + "_images img");
		// If there's arrayMap['img'] = null, there's no _images div provided. Therefore skipping the rest of the definitions
		if(arrayMap['img'] != null) {
			arrayMap['marker'] = null;
			arrayMap['mapdiv'] = document.getElementById(arrayMapid[i]);
			arrayMap['figcaption'] = document.querySelector("#" + arrayMapid[i] + "_images figcaption");
			arrayMap['buttons'] = document.querySelectorAll("#" + arrayMapid[i] + "_images button");
			arrayMap['scale'] = document.querySelector("#" + arrayMapid[i] + "_images").getAttribute("data-scale");
			if (arrayMap['scale'] == null || arrayMap['scale']=="") {
				arrayMap['scale'] = scale;
			}
			arrayMap['ct'] = 0;
			arrayMap['nr'] = 0;
			arrayMap.push('map');
			arrayMap.push('makemap');
			arrayMap['images'] = [];
		};
		arrayMaps[arrayMapid[i]] = arrayMap; // index starts with first mapid: map4731
	}

	window.JB = window.JB || {};
	window.JB.GPX2GM = window.JB.GPX2GM || {};

	// set images/marker/rescale/center
	function setImage(mapid, nr) {
		if(nr < 0) nr = arrayMaps[mapid]['images'].length -1;
		if(nr >= arrayMaps[mapid]['images'].length) nr = 0;
		if(arrayMaps[mapid]['img'] != null) {
			arrayMaps[mapid]['img'].src = arrayMaps[mapid]['images'][arrayMaps[mapid]['images'][nr].marker.nr].src;
			arrayMaps[mapid]['figcaption'].innerHTML = arrayMaps[mapid]['images'][nr].text;
			if(arrayMaps[mapid]['marker']) JB.RemoveElement(arrayMaps[mapid]['marker']);
			arrayMaps[mapid]['marker'] = arrayMaps[mapid]['map'].Marker({lat:arrayMaps[mapid]['images'][nr].coord.lat,lon:arrayMaps[mapid]['images'][nr].coord.lon},JB.icons.Kreis)[0];
			arrayMaps[mapid]['makemap'].Rescale(arrayMaps[mapid]['images'][nr].coord.lat,arrayMaps[mapid]['images'][nr].coord.lon,arrayMaps[mapid]['scale']);
		}
		return nr;
	}

	// get mapid/switch from button element
	function setMap(ele) {
		var params = [];
		params = ele.value.split(",");
		var mapid = params[0];
		// switch: what to do if button previous/next
		if(params[1] == 0) {
			arrayMaps[mapid]['nr'] = setImage(mapid, arrayMaps[mapid]['nr'] - 1);
		} else {
			arrayMaps[mapid]['nr'] = setImage(mapid, arrayMaps[mapid]['nr'] + 1);
		}
	}

	// set up buttons for each map with images
	for(var i=0;i<arrayMapid.length;i++) {
		var mapid = arrayMapid[i];
		if(arrayMaps[mapid]['img'] != null) {
			// set up parameters for function setMap first
			arrayMaps[mapid]['buttons'][0]['value'] = mapid + ',' + '0';
			arrayMaps[mapid]['buttons'][1]['value'] = mapid + ',' + '1';
			// attach button function
			arrayMaps[mapid]['buttons'][0].onclick = function(){setMap(this)};
			arrayMaps[mapid]['buttons'][1].onclick = function(){setMap(this)};
		}
	}

	// This callback function is containing code for both: animation AND markerImage
	JB.GPX2GM.callback = function(pars) {
		JB.Debug_Info("callback",pars.id+" "+pars.type,false);

		// This part is for marker animation
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

		// This part is for markerImage
		// For markerimage there must exist a div "mapid_images img"
		if(arrayMaps[pars.id]['img'] != null) {
			if(pars.type == "Map_n") {
					arrayMaps[pars.id]['makemap'] = arrayMaps[pars.id]['mapdiv'].makeMap;
					arrayMaps[pars.id]['map'] = arrayMaps[pars.id]['makemap'].GetMap();
			}
			if(pars.type == "created_Marker_Bild") {
				arrayMaps[pars.id]['images'][arrayMaps[pars.id]['ct']] = {src: pars.src, text: pars.text, marker: pars.marker, coord: pars.coord};
				pars.marker.nr = arrayMaps[pars.id]['ct'];
				// first picture will be set here
				if(arrayMaps[pars.id]['ct']==0) {
					setImage(pars.id, arrayMaps[pars.id]['ct']);
				}
				arrayMaps[pars.id]['ct']++;
				return;
			}
			if(pars.type == "click_Marker_Bild") {
					var nr = pars.marker.nr;
					arrayMaps[pars.id]['nr'] = setImage(pars.id, nr);
					return false;
			}
		}
/*
		if(pars.type == "Tracks_n") {
			var infofenster = JB.Infofenster(arrayMaps[pars.id]['map'].map);
			infofenster.content(pars.gpxdaten.tracks.track[0].info);
			infofenster.show();
			return;
		}
*/
		return true;
	}
