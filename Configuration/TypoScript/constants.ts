# customsubcategory=1000=Resources
# customsubcategory=1050=Basic Settings
# customsubcategory=1100=General Settings
# customsubcategory=1120=GPXViewer Waypoints
# customsubcategory=1121=GPXViewer Profiles
# customsubcategory=1122=Scss Layout Settings (only working with bootstrap-package!)
# customsubcategory=1130=Javascript Settings
# customsubcategory=1300=Templates
# customsubcategory=1400=Storage

// Extends bootstrap_package settings to use the ScssPHP parser, which is included in bootstrap_package
plugin.bootstrap_package {
	settings {
		scss {
			# cat=GPXViewer: Basic/1122/2182; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-height.label
			gpxviewer-height = 600px
			# cat=GPXViewer: Basic/1122/2183; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-profiles-height.label
			gpxviewer-profiles-height = 600px
			# cat=GPXViewer: Basic/1122/2184; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-images-height.label
			gpxviewer-images-height = 600px
			# cat=GPXViewer: Basic/1122/2185; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-width.label
			gpxviewer-width = 100%
			# cat=GPXViewer: Basic/1122/2186; type=options[dotted=dotted,dashed=dashed,solid=solid,double=double,none=none]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-border-style.label
			gpxviewer-border-style = solid
			# cat=GPXViewer: Basic/1122/2187; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-border-width.label
			gpxviewer-border-width = 1px
			# cat=GPXViewer: Basic/1122/2188; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-border-color.label
			gpxviewer-border-color = $primary
			# cat=GPXViewer: Basic/1122/2189; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-button-bg-color.label
			gpxviewer-button-bg-color = $secondary
			# cat=GPXViewer: Basic/1122/2190; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-button-bg-color-hover.label
			gpxviewer-button-bg-color-hover = $primary
			# cat=GPXViewer: Basic/1122/2191; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-button-color-hover.label
			gpxviewer-button-color-hover = white
			# cat=GPXViewer: Basic/1122/2192; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-images-bg-color.label
			gpxviewer-images-bg-color = black
			# cat=GPXViewer: Basic/1122/2193; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-images-text-color.label
			gpxviewer-images-text-color = transparent
			# cat=GPXViewer: Basic/1122/2194; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-profiles-bg-color.label
			gpxviewer-profiles-bg-color = transparent
			# cat=GPXViewer: Basic/1122/2195; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-gpxviewer-bg-color.label
			gpxviewer-gpxviewer-bg-color = transparent
			# cat=GPXViewer: Basic/1122/2196; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-content-bg-color.label
			gpxviewer-content-bg-color = transparent
			# cat=GPXViewer: Basic/1122/2197; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-content-text-color.label
			gpxviewer-content-text-color = black
			# cat=GPXViewer: Basic/1122/2198; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-description-bg-color.label
			gpxviewer-description-bg-color = transparent
			# cat=GPXViewer: Basic/1122/2199; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-description-text-color.label
			gpxviewer-description-text-color = black
			# cat=GPXViewer: Basic/1122/2200; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.scss.gpxviewer-description-border.label
			gpxviewer-description-border = false
		}
	}
}
// Here start the plugin settings
plugin.tx_wokgpxviewer_gpxtracks {
	gpxviewer {
		// Resources
		# cat=GPXViewer: Basic/1000/2110; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.jsSourceFile.label
		jsSourceFile=EXT:wok_gpxviewer/Resources/Public/GPXViewer/GPXViewer6.15.1/GM_Utils/GPX2GM.js
		# cat=GPXViewer: Basic/1000/2130; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.cssFile.label
		cssFile=EXT:wok_gpxviewer/Resources/Public/Scss/Theme/theme.scss
		# cat=GPXViewer: Basic/1000/2131; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.jsSourceFile4shimg.label
		jsSourceFile4shimg=EXT:wok_gpxviewer/Resources/Public/GPXViewer/GPXViewer6.15.1/GM_Utils/shimg.js
		# cat=GPXViewer: Basic/1000/2132; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.jsSourceAdditionalJS.label
		jsSourceAdditionalJS=EXT:wok_gpxviewer/Resources/Public/GPXViewer/MyAdditionalJS/animation+markerimage.js

		// Basic Settings
		# cat=GPXViewer: Basic/1050/2135; type=options[GoogleMaps=gm,OSM=osm]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.mapapi.label
		mapapi = osm
		# cat=GPXViewer: Basic/1050/2136; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.apiKeyGoogleMaps.label
		apiKeyGoogleMaps=
		# cat=GPXViewer: Basic/1050/2137; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.apiKeyOSM_Cycle.label
		apiKeyOSM_Cycle=
		# cat=GPXViewer: Basic/1050/2138; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.apiKeyOSM_Landscape.label
		apiKeyOSM_Landscape=
		# cat=GPXViewer: Basic/1050/2138; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.apiKeyOSM_Outdoors.label
		apiKeyOSM_Outdoors=

		// General Settings
		# cat=GPXViewer: Basic/1100/2140; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.Map=Karte,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.Satellite=Satellit,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.Hybrid=Hybrid,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.Terrain=Oberflaeche,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.OSM=OSM,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.OSMDE=OSMDE,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.OSM_Cycle=OSM_Cycle,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.OSM_Landscape=OSM_Landscape,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.OSM_Outdoors=OSM_Outdoors,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.OPENTOPO=OPENTOPO,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.TopPlusOpen=TopPlusOpen,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.OPEN_Sea=OPEN_Sea,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.Hiking=Hiking,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.Cycling=Cycling,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.options.Keine_Karte=Keine_Karte]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMapType.label
		gpxMapType = Karte
		# cat=GPXViewer: Basic/1100/2141; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxDownloadLink.label
		gpxDownloadLink=true
		# cat=GPXViewer: Basic/1100/2142; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxAnimation.label
		gpxAnimation = false
		# cat=GPXViewer: Basic/1100/2143; type=options[MoveMarker=MoveMarker, motorbike42_l2r=motorbike42_l2r, motorbike42_r2l=motorbike42_r2l, cycling42_l2r=cycling42_l2r, cycling42_r2l=cycling42_r2l, fourbyfour42_l2r=fourbyfour42_l2r, fourbyfour42_r2l=fourbyfour42_r2l, hiking42_l2r=hiking42_l2r, hiking42_r2l=hiking42_r2l, jogging42_l2r=jogging42_l2r, jogging42_r2l=jogging42_r2l, aircraftsmall42_l2r=aircraftsmall42_l2r, aircraftsmall42_r2l=aircraftsmall42_r2l, car42_l2r=car42_l2r, car42_r2l=car42_r2l, convertible42_l2r=convertible42_l2r, convertible42_r2l=convertible42_r2l, cruiseship42_l2r=cruiseship42_l2r, cruiseship42_r2l=cruiseship42_r2l, helicopter42_l2r=helicopter42_l2r, helicopter42_r2l=helicopter42_r2l, plane42_l2r=plane42_l2r, plane42_r2l=plane42_r2l]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxAnimationIcon.label
		gpxAnimationIcon = motorbike42_r2l
		# cat=GPXViewer: Basic/1100/2144; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxDescriptionToggle.label
		gpxDescriptionToggle=false
		# cat=GPXViewer: Basic/1100/2145; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.debug.label
		debug = false

		// Waypoints
		# cat=GPXViewer: Basic/1120/2160; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_img.label
		gpxMap_img = true
		# cat=GPXViewer: Basic/1120/2161; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_wayp.label
		gpxMap_wayp = true
		# cat=GPXViewer: Basic/1120/2162; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_img_coords.label
		gpxMap_img_coords = false
		# cat=GPXViewer: Basic/1120/2163; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_img_coords_in_description_before.label
		gpxMap_img_coords_in_description_before = <br />
		# cat=GPXViewer: Basic/1120/2164; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.shimg.label
		shimg = false
		# cat=GPXViewer: Basic/1120/2165; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_imgdiv.label
		gpxMap_imgdiv = false
		# cat=GPXViewer: Basic/1120/2166; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_imgdivLayout.options.above=above,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_imgdivLayout.options.below=below,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_imgdivLayout.options.left=left,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_imgdivLayout.options.right=right]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_imgdivLayout.label
		gpxMap_imgdivLayout = above
		# cat=GPXViewer: Basic/1120/2167; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_imgdivScale.label
		gpxMap_imgdivScale = 10
		# cat=GPXViewer: Basic/1120/2168; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.small=small,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.large=large]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_imgPhotoStationPhotoSize.label
		gpxMap_imgPhotoStationPhotoSize = large
		# cat=GPXViewer: Basic/1120/2169; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxCheckimagename.label
		gpxCheckimagename = true

		// Profiles
		# cat=GPXViewer: Basic/1121/2170; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_sorting.label
		gpxMap_sorting = hp,hpt,sp,spt,vp,vpt,hrp,hrpt,cadp,cadpt,atempp,atemppt,wpt
		# cat=GPXViewer: Basic/1121/2171; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_profiles.label
		gpxMap_profiles = false
		# cat=GPXViewer: Basic/1121/2172; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_profilesLayout.options.above=above,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_profilesLayout.options.below=below,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_profilesLayout.options.left=left,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_profilesLayout.options.right=right]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_profilesLayout.label
		gpxMap_profilesLayout = above
		# cat=GPXViewer: Basic/1121/2173; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_profilesCols.label
		gpxMap_profilesCols = 1,1,1,3,1,3,3,3,3,3,3,3,4
		# cat=GPXViewer: Basic/1121/2174; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMap_profilesPSaddr.label
		gpxMap_profilesPSaddr = https://fotos.wolfgangkleinbach.de

		// Advanced Javascript Settings
		# cat=GPXViewer: Advanced/1130/2200; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxDoclang.options.auto=auto,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxDoclang.options.German=de,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxDoclang.options.English=en,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxDoclang.options.Spanish=es,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxDoclang.options.Italian=it]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxDoclang.label
		gpxDoclang = auto
		# cat=GPXViewer: Advanced/1130/2201; type=options[m/km=si,mile/ft=enus,NM/ft=air,sm/ft=water]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxUnit.label
		gpxUnit = si
		# cat=GPXViewer: Advanced/1130/2202; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShowmaptypecontroll.label
		gpxShowmaptypecontroll = true
		# cat=GPXViewer: Advanced/1130/2203; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxScrollwheelzoom.label
		gpxScrollwheelzoom = true
		# cat=GPXViewer: Advanced/1130/2204; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxFullscreenbutton.label
		gpxFullscreenbutton = false
		# cat=GPXViewer: Advanced/1130/2205; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxCurrentlocationbutton.label
		gpxCurrentlocationbutton = false
		# cat=GPXViewer: Advanced/1130/2206; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTrafficbutton.label
		gpxTrafficbutton = false
		# cat=GPXViewer: Advanced/1130/2207; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTrafficonload.label
		gpxTrafficonload = true
		# cat=GPXViewer: Advanced/1130/2208; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxLegende.label
		gpxLegende = true
		# cat=GPXViewer: Advanced/1130/2209; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxLegende_fnm.label
		gpxLegende_fnm = true
		# cat=GPXViewer: Advanced/1130/2210; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxLegende_fnm_lm.label
		gpxLegende_fnm_lm = false
		# cat=GPXViewer: Advanced/1130/2211; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxLegende_rr.label
		gpxLegende_rr = true
		# cat=GPXViewer: Advanced/1130/2212; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxLegende_trk.label
		gpxLegende_trk = true
		# cat=GPXViewer: Advanced/1130/2213; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxLegende_rte.label
		gpxLegende_rte = true
		# cat=GPXViewer: Advanced/1130/2214; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxLegende_wpt.label
		gpxLegende_wpt = true
		# cat=GPXViewer: Advanced/1130/2215; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxLegende_info.label
		gpxLegende_info = false
		# cat=GPXViewer: Advanced/1130/2216; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxGpxtracks.label
		gpxGpxtracks = true
		# cat=GPXViewer: Advanced/1130/2217; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxGpxrouten.label
		gpxGpxrouten = true
		# cat=GPXViewer: Advanced/1130/2218; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxGpxwegpunkte.label
		gpxGpxwegpunkte = true
		# cat=GPXViewer: Advanced/1130/2219; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTracks_verbinden.label
		gpxTracks_verbinden = false
		# cat=GPXViewer: Advanced/1130/2220; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTracks_dateiuebergreifend_verbinden.label
		gpxTracks_dateiuebergreifend_verbinden = false
		# cat=GPXViewer: Advanced/1130/2221; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTracksort.label
		gpxTracksort = true
		# cat=GPXViewer: Advanced/1130/2222; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxDateitrenner.label
		gpxDateitrenner = ,
		# cat=GPXViewer: Advanced/1130/2223; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxReadspeed.label
		gpxReadspeed = true
		# cat=GPXViewer: Advanced/1130/2224; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxSpeedfaktor.label
		gpxSpeedfaktor = 3.6
		# cat=GPXViewer: Advanced/1130/2225; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxHfaktor.label
		gpxHfaktor = 1
		# cat=GPXViewer: Advanced/1130/2226; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxSfaktor.label
		gpxSfaktor = 1
		# cat=GPXViewer: Advanced/1130/2227; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxVfaktor.label
		gpxVfaktor = 1
		# cat=GPXViewer: Advanced/1130/2228; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxWfaktor.label
		gpxWfaktor = 1
		# cat=GPXViewer: Advanced/1130/2229; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTfaktor.label
		gpxTfaktor = 1
		# cat=GPXViewer: Advanced/1130/2230; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxToffset.label
		gpxToffset = 0
		# cat=GPXViewer: Advanced/1130/2231; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxUnwraplon.label
		gpxUnwraplon = false
		# cat=GPXViewer: Advanced/1130/2232; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTrackover.label
		gpxTrackover = true
		# cat=GPXViewer: Advanced/1130/2233; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTrackclick.label
		gpxTrackclick = true
		# cat=GPXViewer: Advanced/1130/2234; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTrackmarker.label
		gpxTrackmarker = 
		# cat=GPXViewer: Advanced/1130/2235; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxRoutemarker.label
		gpxRoutemarker = 
		# cat=GPXViewer: Advanced/1130/2236; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShwpname.label
		gpxShwpname = true
		# cat=GPXViewer: Advanced/1130/2237; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShwptooltip.label
		gpxShwptooltip = false
		# cat=GPXViewer: Advanced/1130/2238; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShwpcmt.label
		gpxShwpcmt = true
		# cat=GPXViewer: Advanced/1130/2239; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShwpdesc.label
		gpxShwpdesc = false
		# cat=GPXViewer: Advanced/1130/2240; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShwptime.label
		gpxShwptime = false
		# cat=GPXViewer: Advanced/1130/2241; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShwpshadow.label
		gpxShwpshadow = true
		# cat=GPXViewer: Advanced/1130/2242; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxWpcluster.label
		gpxWpcluster = false
		# cat=GPXViewer: Advanced/1130/2243; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxBildpfad.label
		gpxBildpfad = 
		# cat=GPXViewer: Advanced/1130/2244; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxGpxpfad.label
		gpxGpxpfad = 
		# cat=GPXViewer: Advanced/1130/2245; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxDefaulticon.label
		gpxDefaulticon = 
		# cat=GPXViewer: Advanced/1130/2246; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxBildwegpunkticon.label
		gpxBildwegpunkticon = Bild
		# cat=GPXViewer: Advanced/1130/2247; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrcmt.label
		gpxShtrcmt = false
		# cat=GPXViewer: Advanced/1130/2248; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrdesc.label
		gpxShtrdesc = false
		# cat=GPXViewer: Advanced/1130/2249; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrx.label
		gpxShtrx = true
		# cat=GPXViewer: Advanced/1130/2250; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrt.label
		gpxShtrt = true
		# cat=GPXViewer: Advanced/1130/2251; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrtwob.label
		gpxShtrtwob = false
		# cat=GPXViewer: Advanced/1130/2252; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrtabs.label
		gpxShtrtabs = false
		# cat=GPXViewer: Advanced/1130/2253; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrtges.label
		gpxShtrtges = false
		# cat=GPXViewer: Advanced/1130/2254; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrtgeswob.label
		gpxShtrtgeswob = false
		# cat=GPXViewer: Advanced/1130/2255; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrv.label
		gpxShtrv = true
		# cat=GPXViewer: Advanced/1130/2256; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrpace.label
		gpxShtrpace = false
		# cat=GPXViewer: Advanced/1130/2257; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrh.label
		gpxShtrh = true
		# cat=GPXViewer: Advanced/1130/2258; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrrr.label
		gpxShtrrr = true
		# cat=GPXViewer: Advanced/1130/2259; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrs.label
		gpxShtrs = true
		# cat=GPXViewer: Advanced/1130/2260; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrhr.label
		gpxShtrhr = true
		# cat=GPXViewer: Advanced/1130/2261; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrcad.label
		gpxShtrcad = true
		# cat=GPXViewer: Advanced/1130/2262; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtratemp.label
		gpxShtratemp = true
		# cat=GPXViewer: Advanced/1130/2263; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrvmitt.label
		gpxShtrvmitt = false
		# cat=GPXViewer: Advanced/1130/2264; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrvmittwob.label
		gpxShtrvmittwob = false
		# cat=GPXViewer: Advanced/1130/2265; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrvmittpace.label
		gpxShtrvmittpace = false
		# cat=GPXViewer: Advanced/1130/2266; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrvmittpacewob.label
		gpxShtrvmittpacewob = false
		# cat=GPXViewer: Advanced/1130/2267; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMovevmin.label
		gpxMovevmin = 1
		# cat=GPXViewer: Advanced/1130/2268; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxArrowtrack.label
		gpxArrowtrack = false
		# cat=GPXViewer: Advanced/1130/2269; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxArrowtrackcol.label
		gpxArrowtrackcol = 
		# cat=GPXViewer: Advanced/1130/2270; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShrtcmt.label
		gpxShrtcmt = false
		# cat=GPXViewer: Advanced/1130/2271; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShrtdesc.label
		gpxShrtdesc = false
		# cat=GPXViewer: Advanced/1130/2272; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrstart.label
		gpxShtrstart = false
		# cat=GPXViewer: Advanced/1130/2273; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShtrziel.label
		gpxShtrziel = false
		# cat=GPXViewer: Advanced/1130/2274; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShrtstart.label
		gpxShrtstart = false
		# cat=GPXViewer: Advanced/1130/2275; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxShrtziel.label
		gpxShrtziel = false
		# cat=GPXViewer: Advanced/1130/2276; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxArrowroute.label
		gpxArrowroute = false
		# cat=GPXViewer: Advanced/1130/2277; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxArrowroutecol.label
		gpxArrowroutecol = 
		# cat=GPXViewer: Advanced/1130/2278; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxArrowsymbol.label
		gpxArrowsymbol = ➤
		# cat=GPXViewer: Advanced/1130/2279; type=int[10-149]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxGroesseminibild.label
		gpxGroesseminibild = 60
		# cat=GPXViewer: Advanced/1130/2280; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxDisplaycolor.label
		gpxDisplaycolor = false
		# cat=GPXViewer: Advanced/1130/2281; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxLaengen3d.label
		gpxLaengen3d = false
		# cat=GPXViewer: Advanced/1130/2282; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxUsegpxbounds.label
		gpxUsegpxbounds = false
		# cat=GPXViewer: Advanced/1130/2283; type=int+; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxHglattlaen.label
		gpxHglattlaen = 500
		# cat=GPXViewer: Advanced/1130/2284; type=int+; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxVglattlaen.label
		gpxVglattlaen = 100
		# cat=GPXViewer: Advanced/1130/2285; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxVglatt.label
		gpxVglatt = false
		# cat=GPXViewer: Advanced/1130/2286; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxHglatt.label
		gpxHglatt = false
		# cat=GPXViewer: Advanced/1130/2287; type=int+; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTdiff.label
		gpxTdiff = 0
		# cat=GPXViewer: Advanced/1130/2288; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.On=true,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.options.Off=false]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTkorr.label
		gpxTkorr = true
		# cat=GPXViewer: Advanced/1130/2289; type=int[10-30]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxMaxzoomemove.label
		gpxMaxzoomemove = 30
		# cat=GPXViewer: Advanced/1130/2290; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxPlotframecol.label
		gpxPlotframecol = black
		# cat=GPXViewer: Advanced/1130/2291; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxPlotgridcol.label
		gpxPlotgridcol = gray
		# cat=GPXViewer: Advanced/1130/2292; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxPlotlabelcol.label
		gpxPlotlabelcol = black
		# cat=GPXViewer: Advanced/1130/2293; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxPlotmarkercol.label
		gpxPlotmarkercol = black
		# cat=GPXViewer: Advanced/1130/2294; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxProfilfillopac.label
		gpxProfilfillopac = 0
		# cat=GPXViewer: Advanced/1130/2295; type=options[LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTrcolmod.options.none=,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTrcolmod.options.altitude=h,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTrcolmod.options.slope=s,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTrcolmod.options.speed=v,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTrcolmod.options.cadence=cad,LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTrcolmod.options.heartrate=hr]; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTrcolmod.label
		gpxTrcolmod = 
		# cat=GPXViewer: Advanced/1130/2296; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTcols.label
		gpxTcols = ["#ff0000","#00ff00","#0000ff","#eeee00","#ff00ff","#00ffff","#000000"]
		# cat=GPXViewer: Advanced/1130/2297; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxRcols.label
		gpxRcols = ["#800000","#008000","#000080","#808000","#800080","#008080","#808080"]
		# cat=GPXViewer: Advanced/1130/2298; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxOcol.label
		gpxOcol = #000000
		# cat=GPXViewer: Advanced/1130/2299; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxOwidth.label
		gpxOwidth = 3.0
		# cat=GPXViewer: Advanced/1130/2300; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTwidth.label
		gpxTwidth = 2.0
		# cat=GPXViewer: Advanced/1130/2301; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxRwidth.label
		gpxRwidth = 2.0
		# cat=GPXViewer: Advanced/1130/2302; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxTopac.label
		gpxTopac = 0.8
		# cat=GPXViewer: Advanced/1130/2303; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxRopac.label
		gpxRopac = 0.8
		# cat=GPXViewer: Advanced/1130/2304; type=type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxLinktarget.label
		gpxLinktarget = 
		# cat=GPXViewer: Advanced/1130/2305; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.gpxPopup_Pars.label
		gpxPopup_Pars = width=900,height=790,screenX=970,screenY=0,status=yes,scrollbars=yes

	}

	view {
		# cat=GPXViewer: Basic/1300/2910; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.templateRootPath.label
		templateRootPath = EXT:wok_gpxviewer/Resources/Private/Templates/
		# cat=GPXViewer: Basic/1300/2920; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.partialRootPath.label
		partialRootPath = EXT:wok_gpxviewer/Resources/Private/Partials/
		# cat=GPXViewer: Basic/1300/2930; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.layoutRootPath.label
		layoutRootPath = EXT:wok_gpxviewer/Resources/Private/Layouts/
	}
	persistence {
		# cat=GPXViewer: Basic/1400/2930; type=string; label=LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang.xlf:constants.storagePid.label
		storagePid =
	}
}
