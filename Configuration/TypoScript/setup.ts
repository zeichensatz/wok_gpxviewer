plugin.tx_wokgpxviewer_gpxtracks {
	settings {
		// GPXViewer defaults as defined in GM_Utils/GPX2GM_defs.js
		defaults {
			Mapapi = osm
			JB.GPX2GM.GM_Api_key = 
			JB.GPX2GM.OSM_Cycle_Api_Key = 
			JB.GPX2GM.OSM_Landscape_Api_Key = 
			Doclang = auto
			Unit = si
			Showmaptypecontroll = true
			Scrollwheelzoom = true
			Fullscreenbutton = false
			Currentlocationbutton = false
			Trafficbutton = false
			Trafficonload = true
			Legende = true
			Legende_fnm = true
			Legende_fnm_lm = false
			Legende_rr = true
			Legende_trk = true
			Legende_rte = true
			Legende_wpt = true
			Legende_info = false
			Gpxtracks = true
			Gpxrouten = true
			Gpxwegpunkte = true
			Tracks_verbinden = false
			Tracks_dateiuebergreifend_verbinden = false
			Tracksort = true
			Dateitrenner = ,
			Readspeed = true
			Speedfaktor = 3.6
			Hfaktor = 1
			Sfaktor = 1
			Vfaktor = 1
			Wfaktor = 1
			Tfaktor = 1
			Toffset = 0
			Unwraplon = true
			Trackover = true
			Trackclick = true
			Trackmarker = 
			Routemarker = 
			Shwpname = true
			Shwptooltip = false
			Shwpcmt = true
			Shwpdesc = false
			Shwptime = false
			Shwpshadow = true
			Wpcluster = false
			Bildpfad = 
			Gpxpfad = 
			Bildwegpunkticon = Bild
			Shtrcmt = false
			Shtrdesc = false
			Shtrx = true
			Shtrt = true
			Shtrtwob = false
			Shtrtabs = false
			Shtrtges = false
			Shtrtgeswob = false
			Shtrv = true
			Shtrpace = false
			Shtrh = true
			Shtrrr = true
			Shtrs = true
			Shtrhr = true
			Shtrcad = true
			Shtratemp = true
			Shtrvmitt = false
			Shtrvmittwob = false
			Shtrvmittpace = false
			Shtrvmittpacewob = false
			Movevmin = 1
			Arrowtrack = false
			Arrowtrackcol = 
			Shrtcmt = false
			Shrtdesc = false
			Shtrstart = false
			Shtrziel = false
			Shrtstart = false
			Shrtziel = false
			Arrowroute = false
			Arrowroutecol = 
			Arrowsymbol = ➤
			Groesseminibild = 60
			Displaycolor = false
			Laengen3d = false
			Usegpxbounds = false
			Hglattlaen = 500
			Vglattlaen = 100
			Vglatt = false
			Hglatt = false
			Tdiff = 0
			Tkorr = true
			Maxzoomemove = 30
			Plotframecol = black
			Plotgridcol = gray
			Plotlabelcol = black
			Plotmarkercol = black
			Profilfillopac = 0
			Trcolmod = 
			Tcols = ["#ff0000","#00ff00","#0000ff","#eeee00","#ff00ff","#00ffff","#000000"]
			Rcols = ["#800000","#008000","#000080","#808000","#800080","#008080","#808080"]
			Ocol = #000000
			Owidth = 3.0
			Twidth = 2.0
			Rwidth = 2.0
			Topac = 0.8
			Ropac = 0.8
			Linktarget = 
			Popup_Pars = width=900,height=790,screenX=970,screenY=0,status=yes,scrollbars=yes
			Checkimagename = true
		}
		// All GPXViewer settings. Values are set in constants or templates
		constants {
			// Basic Settings
			Mapapi = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.mapapi}
			JB.GPX2GM.GM_Api_key = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.apiKeyGoogleMaps}
			JB.GPX2GM.OSM_Cycle_Api_Key = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.apiKeyOSM_Cycle}
			JB.GPX2GM.OSM_Landscape_Api_Key = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.apiKeyOSM_Landscape}
			// Advanced
			Doclang = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxDoclang}
			Unit = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxUnit}
			Showmaptypecontroll = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShowmaptypecontroll}
			Scrollwheelzoom = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxScrollwheelzoom}
			Fullscreenbutton = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxFullscreenbutton}
			Currentlocationbutton = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxCurrentlocationbutton}
			Trafficbutton = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTrafficbutton}
			Trafficonload = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTrafficonload}
			Legende = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxLegende}
			Legende_fnm = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxLegende_fnm}
			Legende_fnm_lm = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxLegende_fnm_lm}
			Legende_rr = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxLegende_rr}
			Legende_trk = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxLegende_trk}
			Legende_rte = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxLegende_rte}
			Legende_wpt = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxLegende_wpt}
			Legende_info = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxLegende_info}
			Gpxtracks = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxGpxtracks}
			Gpxrouten = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxGpxrouten}
			Gpxwegpunkte = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxGpxwegpunkte}
			Tracks_verbinden = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTracks_verbinden}
			Tracks_dateiuebergreifend_verbinden = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTracks_dateiuebergreifend_verbinden}
			Tracksort = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTracksort}
			Dateitrenner = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxDateitrenner}
			Readspeed = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxReadspeed}
			Speedfaktor = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxSpeedfaktor}
			Hfaktor = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxHfaktor}
			Sfaktor = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxSfaktor}
			Vfaktor = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxVfaktor}
			Wfaktor = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxWfaktor}
			Tfaktor = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTfaktor}
			Toffset = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxToffset}
			Unwraplon = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxUnwraplon}
			Trackover = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTrackover}
			Trackclick = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTrackclick}
			Trackmarker = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTrackmarker}
			Routemarker = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxRoutemarker}
			Shwpname = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShwpname}
			Shwptooltip = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShwptooltip}
			Shwpcmt = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShwpcmt}
			Shwpdesc = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShwpdesc}
			Shwptime = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShwptime}
			Shwpshadow = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShwpshadow}
			Wpcluster = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxWpcluster}
			Bildpfad = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxBildpfad}
			Gpxpfad = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxGpxpfad}
			Bildwegpunkticon = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxBildwegpunkticon}
			Shtrcmt = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrcmt}
			Shtrdesc = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrdesc}
			Shtrx = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrx}
			Shtrt = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrt}
			Shtrtwob = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrtwob}
			Shtrtabs = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrtabs}
			Shtrtges = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrtges}
			Shtrtgeswob = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrtgeswob}
			Shtrv = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrv}
			Shtrpace = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrpace}
			Shtrh = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrh}
			Shtrrr = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrrr}
			Shtrs = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrs}
			Shtrhr = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrhr}
			Shtrcad = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrcad}
			Shtratemp = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtratemp}
			Shtrvmitt = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrvmitt}
			Shtrvmittwob = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrvmittwob}
			Shtrvmittpace = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrvmittpace}
			Shtrvmittpacewob = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrvmittpacewob}
			Movevmin = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMovevmin}
			Arrowtrack = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxArrowtrack}
			Arrowtrackcol = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxArrowtrackcol}
			Shrtcmt = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShrtcmt}
			Shrtdesc = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShrtdesc}
			Shtrstart = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrstart}
			Shtrziel = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShtrziel}
			Shrtstart = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShrtstart}
			Shrtziel = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxShrtziel}
			Arrowroute = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxArrowroute}
			Arrowroutecol = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxArrowroutecol}
			Arrowsymbol = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxArrowsymbol}
			Groesseminibild = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxGroesseminibild}
			Displaycolor = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxDisplaycolor}
			Laengen3d = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxLaengen3d}
			Usegpxbounds = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxUsegpxbounds}
			Hglattlaen = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxHglattlaen}
			Vglattlaen = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxVglattlaen}
			Vglatt = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxVglatt}
			Hglatt = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxHglatt}
			Tdiff = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTdiff}
			Tkorr = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTkorr}
			Maxzoomemove = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMaxzoomemove}
			Plotframecol = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxPlotframecol}
			Plotgridcol = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxPlotgridcol}
			Plotlabelcol = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxPlotlabelcol}
			Plotmarkercol = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxPlotmarkercol}
			Profilfillopac = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxProfilfillopac}
			Trcolmod = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTrcolmod}
			Tcols = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTcols}
			Rcols = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxRcols}
			Ocol = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxOcol}
			Owidth = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxOwidth}
			Twidth = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTwidth}
			Rwidth = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxRwidth}
			Topac = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxTopac}
			Ropac = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxRopac}
			Linktarget = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxLinktarget}
			Popup_Pars = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxPopup_Pars}
			Checkimagename = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxCheckimagename}
		}

		// All settings for GPXViewer plugin
		// Resources
		jsSourceFile = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.jsSourceFile}
		jsSourceFile4shimg = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.jsSourceFile4shimg}
		jsSourceAdditionalJS = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.jsSourceAdditionalJS}
		cssFile = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.cssFile}
		scss = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.scss}

		// General Settings
		gpxMapType = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMapType}
		gpxDownloadLink = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxDownloadLink}
		gpxAnimation = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxAnimation}
		gpxAnimationIcon = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxAnimationIcon}
		gpxDescriptionToggle = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxDescriptionToggle}

		// For Debugging
		debug = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.debug}

		// Waypoints
		gpxMap_img = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_img}
		gpxMap_wayp = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_wayp}
		gpxMap_img_coords = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_img_coords}
		gpxMap_img_coords_in_description_before = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_img_coords_in_description_before}
		shimg = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.shimg}
		gpxMap_imgdiv = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_imgdiv}
		gpxMap_imgdivLayout = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_imgdivLayout}
		gpxMap_imgdivScale = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_imgdivScale}
		gpxMap_imgPhotoStationPhotoSize = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_imgPhotoStationPhotoSize}

		// Profiles
		gpxMap_sorting = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_sorting}
		gpxMap_profiles = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_profiles}
		gpxMap_profilesLayout = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_profilesLayout}
		gpxMap_profilesCols = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_profilesCols}
		gpxMap_profilesPSaddr = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.gpxMap_profilesPSaddr}

		// Import layout variables from bootstrap_package
		gpxviewer-height = {$plugin.bootstrap_package.settings.scss.gpxviewer-height}
		gpxviewer-profiles-height = {$plugin.bootstrap_package.settings.scss.gpxviewer-profiles-height}
		gpxviewer-images-height = {$plugin.bootstrap_package.settings.scss.gpxviewer-images-height}

	}
	view {
		templateRootPaths.0 = EXT:wok_gpxviewer/Resources/Private/Templates/
		templateRootPaths.1 = {$plugin.tx_wokgpxviewer_gpxtracks.view.templateRootPath}
		partialRootPaths.0 = EXT:wok_gpxviewer/Resources/Private/Partials/
		partialRootPaths.1 = {$plugin.tx_wokgpxviewer_gpxtracks.view.partialRootPath}
		layoutRootPaths.0 = EXT:wok_gpxviewer/Resources/Private/Layouts/
		layoutRootPaths.1 = {$plugin.tx_wokgpxviewer_gpxtracks.view.layoutRootPath}
	}
	persistence {
		storagePid = {$plugin.tx_wokgpxviewer_gpxtracks.persistence.storagePid}
		#recursive = 1
	}
	features {
		#skipDefaultArguments = 1
		# if set to 1, the enable fields are ignored in BE context
		ignoreAllEnableFieldsInBe = 0
		# Should be on by default, but can be disabled if all action in the plugin are uncached
		requireCHashArgumentForActionArguments = 1
	}
	mvc {
		#callDefaultActionIfActionCantBeResolved = 1
	}
}

// If scss is set to true, then use scss parser of bootstrap_package instead of a cssFile 
// (defined plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.cssFile)
// scss files are in directory /Resources/Public/Scss/Theme
[{$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.scss} == true]
//	plugin.tx_wokgpxviewer_gpxtracks.settings.cssFile >
	page {
		includeCSS {
			wok_gpxviewer-theme = {$plugin.tx_wokgpxviewer_gpxtracks.gpxviewer.cssFile}
		}
	}
[END]
