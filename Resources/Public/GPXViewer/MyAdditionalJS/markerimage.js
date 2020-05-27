// This file is based on a saemple script of GPXViewer created by Jürgen Berkemeier
// Lizenz CC BY-NC-SA 4.0
// Jürgen Berkemeier
// www.j-berkemeier.de
// The file was modified for use with the TYPO3 GPXViewer-Plugin by Wolfgang Kleinbach
// wolfgangkleinbach.de
//
// This javascript file has to be included AFTER GPX2GM.js!
//
// This javascript displays waypoints with images whereby the waypoints are shown in the map and the images are displayed in an extra div.
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
	for(var i=0;i<arrayMapid.length;i++) {
		var arrayMap = [];
		arrayMap['marker'] = null;
		arrayMap['mapdiv'] = document.getElementById(arrayMapid[i]);
		arrayMap['img'] = document.querySelector("#" + arrayMapid[i] + "_images img");
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
		arrayMaps[arrayMapid[i]] = arrayMap; // index starts with first mapid: map4731
	}

	window.JB = window.JB || {};
	window.JB.GPX2GM = window.JB.GPX2GM || {};

	// set images/marker/rescale/center
	function setImage(mapid, nr) {
		if(nr < 0) nr = arrayMaps[mapid]['images'].length -1;
		if(nr >= arrayMaps[mapid]['images'].length) nr = 0;
		// when a mapid_images div is available
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

	JB.GPX2GM.callback = function(pars) {
		if(pars.type == "Map_n") {
			if(arrayMaps[pars.id]['img'] != null) {
				arrayMaps[pars.id]['makemap'] = arrayMaps[pars.id]['mapdiv'].makeMap;
				arrayMaps[pars.id]['map'] = arrayMaps[pars.id]['makemap'].GetMap();
			}
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
			// when a mapid_images div is available for the map, where a marker has been clicked.
			if(arrayMaps[pars.id]['img'] != null) {
				var nr = pars.marker.nr;
				arrayMaps[pars.id]['nr'] = setImage(pars.id, nr);
				return false;
			}
		}
		if(pars.type == "Tracks_n") {
			var infofenster = JB.Infofenster(arrayMaps[pars.id]['map'].map);
			infofenster.content(pars.gpxdaten.tracks.track[0].info);
			infofenster.show();
			return;
		}
		return true;
	}
