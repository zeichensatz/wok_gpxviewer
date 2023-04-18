<?php
namespace Wok\WokGpxviewer\Controller;

/***
 *
 * This file is part of the "GPXViewer Extension" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020
 *
 ***/

// Müssen für die Umwandlung der Dateinamen aus den Settings eingebunden werden
use \TYPO3\CMS\Frontend\Resource\FilePathSanitizer;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * DisplayController
 */
class DisplayController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
	/**
	 * Compute GPS Coordinates
	 *
	 * @param string $CoordsOrigin
	 * @param string $CoordsFormat
	 * @return array Decimal GPS Coordinates
	 */
	protected function computeCoords($CoordsOrigin,$CoordsFormat)
	{
		// Variable resetten
		$CoordsArray = array();
		// Koordinaten-Array im Original
		$CoordsArray = explode(" ", $CoordsOrigin);
		// auf N/S prüfen
		if(substr($CoordsArray[0], 0, 1) == 'S') {
			$lat_multiplier = -1;
		} else {
			$lat_multiplier = 1;
		};

		// Array definieren
		if(!isset($CoordsArray[2])) {
			$CoordsArray[2] = '';
		}
		if(!isset($CoordsArray[3])) {
			$CoordsArray[3] = '';
		}
		// auf W/E prüfen
		if(substr($CoordsArray[2], 0, 1) == 'W' or substr($CoordsArray[3], 0, 1) == 'W') {
			$lon_multiplier = -1;
		} else {
			$lon_multiplier = 1;
		};
		// Sekundenzeichen entfernen!
		$CoordsOrigin = str_replace('"', '', $CoordsOrigin);
		// auf Zahlenwerte reduziertes Koordinaten-Array erstellen
		$replace = array("S", "N", "°", "'", "W", "E", ",");
		$CoordsArray = explode(" ", str_replace($replace, "", $CoordsOrigin));
		// Von überflüssigen Zeichen bereinigte Koordinatenwerte in Array übergeben
		switch($CoordsFormat) {
			case "degreetime": 
				// Degreetime -> Decimal
				$latitude = ($CoordsArray[0] + ($CoordsArray[1] + $CoordsArray[2] / 60) / 60) * $lat_multiplier;
				$longitude = ($CoordsArray[3] + ($CoordsArray[4] + $CoordsArray[5] / 60) / 60) * $lon_multiplier;
				break;
			case "degreedezimalmin": 
				// Degree decimal minutes -> Decimal
				$latitude = ($CoordsArray[0] + $CoordsArray[1] / 60) * $lat_multiplier;
				$longitude = ($CoordsArray[2] + $CoordsArray[3] / 60) * $lon_multiplier;
				break;
			default:
				// Decimal
				$latitude = $CoordsArray[0];
				$longitude = $CoordsArray[1];
				break;
		};
		if($CoordsOrigin != "") {
			$CoordsDezimal[0] = rtrim(number_format($latitude,5),'0');
			$CoordsDezimal[1] = rtrim(number_format($longitude,5),'0');
		};
		return $CoordsDezimal;
	}

	/**
	 * Return imageDescription
	 *
	 * @param string $imageDescriptionString
	 * @return string $imageDescription
	 */
	protected function getImageDescription($imageDescriptionString)
	{
		// Überprüfen, ob ein mehrsprachiger Eintrag im Feld ImageDescription vorliegt, entsprechend dem Format:
		// DE: Text
		// -----
		// EN: Text
		// Array für den mehrsprachigen Eintrag anlegen
		$imageDescriptionArray = explode('-----', $imageDescriptionString);
		// Herausfiltern, ob eines der Arrays der aktuellen Sprachauswahl entspricht und in diesem Fall den Beschreibungstext ändern
		$imageDescription = "";
		foreach($imageDescriptionArray as $id) {
			$id = trim($id, " \t\n\r\0\x0B");
			if($this->pageLanguage . ":"  == strtolower(substr($id, 0, strlen($this->pageLanguage)+1))) {
				$imageDescription = nl2br(trim(substr_replace($id, '', 0, strlen($this->pageLanguage)+1), " "));
			}
		}
		// Wenn keine Sprachtypische Beschreibung vorhanden ist, dann eventuell vorhandene (multilinguale) Beschreibung nehmen
		if($imageDescription == '' and $imageDescriptionArray[0] != '') {
			$imageDescription = $imageDescriptionArray[0];
		}
		return $imageDescription;
	}

	/**
	 * Return Coords
	 *
	 * @param string $condition1
	 * @param string $condition2
	 * @return string $Coord
	 */
	protected function getCoords($condition1, $condition2, $latitude, $longitude)
	{
		// Ausgabe der Koordinaten in der Wegpunktbeschreibung
		if($condition1 == "true" or $condition1 == "") {
			$Coords = "[" . $latitude . " " . $longitude . "]";
			if($condition2 != "") {
				$Coords = $this->settings['gpxMap_img_coords_in_description_before'] . $Coords;
			}
		} else {
			$Coords = "";
		};
		return $Coords;
	}

	/**
	 * Index action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction()
	{
		$gpxMapImages = '';
		$gpxMapIcons = '';
		$imageDescriptionText = '';

		// Move all constants in subarrays to first level: JB.GPX2GM.*
		foreach ($this->settings['constants']['JB']['GPX2GM'] as $key => $value) {
			$this->settings['constants']["JB.GPX2GM.".$key] = $value;
		}
		// Delete subarrays
		unset($this->settings['constants']["JB"]);
		// Compare settings from constants with GPXViewer defaults: Difference is the minimum of changes
		$settingsMin = array_diff_assoc($this->settings['constants'], $this->settings['defaults']);

		// Create javascript for GPXViewer setup
		$newline = "\n";
		$settingsString = "";
		$settingsStringMin = "";

		// Exception for Tcols and Rcols, which are arrays
		$exceptions = array('Tcols','Rcols');

		// Create string in relation to debug
		if($this->settings['debug'] == 'true') {
		// Create javascript for ALL GPXViewer settings
			foreach ($this->settings['constants'] as $key => $value) {
				$settingsStringPartOne = '	'. $key .' = ';
				if($value == 'true' or $value == 'false' or in_array($key, $exceptions)) {
					$settingsStringPartTwo = $value . ';';
				} else {
					$settingsStringPartTwo = '"' . $value . '";';
				}
				$settingsString = $settingsString . $settingsStringPartOne . $settingsStringPartTwo . $newline;
			}
			$jsSettings = $settingsString;
		} else {
			// Create javascript only for changed default GPXViewer settings
			foreach ($settingsMin as $key => $value) {
				$settingsStringPartOne = '	'. $key .' = ';
				if($value == 'true' or $value == 'false' or in_array($key, $exceptions)) {
					$settingsStringPartTwo = $value . ';';
				} else {
					$settingsStringPartTwo = '"' . $value . '";';
				}
				$settingsStringMin = $settingsStringMin . $settingsStringPartOne . $settingsStringPartTwo . $newline;
			}
			$jsSettings = $settingsStringMin;
		}
		// Assign javascript settings
		$this->view->assign('jsSettings', $jsSettings);

		// ############################
		// UID (needed as id for content elements)
		// This might throw a deprecation message which can be ignored, see here:
		// https://stackoverflow.com/questions/56463377/deprecationmessage-getting-content-object-in-controller
		$uid = $this->configurationManager->getContentObject()->data['uid'];
		$this->view->assign('uid', $uid);

		// ############################
		// Zusätzliches Javascript für Animation von GPX tracks in einer Karte generieren
		// gpxFileAnimation is a flexform switch, gpxAnimation is a constant
		// gpxAnimation variable is needed as a switch, preset to false
		$gpxAnimation = "false";
		if(!isset($this->settings['gpxFileAnimation'])) {
			$this->settings['gpxFileAnimation'] = '';
		}
		if($this->settings['gpxFileAnimation'] == 'true' or ($this->settings['gpxAnimation'] == 'true' and ($this->settings['gpxFileAnimation'] == 'Default' or $this->settings['gpxFileAnimation'] == ''))) 
		{
			// Assign a switch
			$gpxAnimation = "true";
			// Animations-Icon bestimmen
			// Wenn der Wert aus der Flexform nicht leer oder nicht gleich "Default" ist, dann wird der Flexformwert verwendet
			if(!isset($this->settings['gpxFileAnimationIcon'])) {
				$this->settings['gpxFileAnimationIcon'] = '';
			}
			if($this->settings['gpxFileAnimationIcon'] != "" and $this->settings['gpxFileAnimationIcon'] != "Default") {
				$gpxFileAnimationIcon = $this->settings['gpxFileAnimationIcon'];
			} else {
				$gpxFileAnimationIcon = $this->settings['gpxAnimationIcon'];
			};
			// Assign the moveMarker
			$this->view->assign('gpxFileAnimationIcon', $gpxFileAnimationIcon);
		}
		// assign switch for animation of markers
		$this->view->assign('gpxAnimation', $gpxAnimation);

		// ############################
		// GPXFILE
		// Numerisch(e) Wert(e) für gpxFile aus Flexform auslesen und vollständige Namen aus sys_file auslesen
		$gpxFile = $this->settings['gpxFile'];

		// Wenn kein Wert in $gpxFile enthalten ist, dann wird kein Track ausgegeben, eventuell sind aber manuell Punkte definiert
		if($gpxFile == '') {
			// keine GPX-Dateien für die Ausgabe
			$gpxFilesCount = 0;
		} else {
			// Kommaseparierte Liste von uids in array umwandeln
			$fileArray = explode(',', $gpxFile);
			// ResourceFactory einlesen
			//$resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
			$resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
			// Für jede uid den Namen aus der sys_file holen
			foreach ($fileArray as $key => $file) {
				$tmpFile = $resourceFactory->getFileObject($file);
				// Hier braucht es anstelle von "/fileadmin" noch eine automatische Zuordnung des Verzeichnisses
				$newFileArray[$key] = '/fileadmin' . $tmpFile->getIdentifier();
			}
			// Vollständige Namen in einem kommaseparierten String umwandeln
			$gpxFile = implode(',', $newFileArray);
			// Anzahl der GPX-Dateien feststellen
			$gpxFilesCount = count($newFileArray);
		}
		// Werte zuweisen
		$this->view->assign('gpxFile', $gpxFile);
		// Counter: Wie viele gpxFiles sind es?
		$this->view->assign('gpxFilesCount', $gpxFilesCount);

		// ############################
		// MAPTYPE
		if(!isset($this->settings['gpxFileMapType'])) {
			$this->settings['gpxFileMapType'] = '';
		}
		// Wenn in der Flexform die Auswahl "Default" für MapType erfolgt ist oder kein Wert vorhanden ist (alte Content elemente) ...
		if($this->settings['gpxFileMapType'] == 'Default' or $this->settings['gpxFileMapType'] == '') {
			// ... dann den Wert für gpxMapType aus constants.ts nehmen ...
			$gpxMapType = $this->settings['gpxMapType'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMapType = $this->settings['gpxFileMapType'];
		};
		$this->view->assign('gpxMapType', $gpxMapType);

		// ############################
		// DOWNLOADLINK
		if(!isset($this->settings['gpxFileDownloadLink'])) {
			$this->settings['gpxFileDownloadLink'] = '';
		}
		if($this->settings['gpxFileDownloadLink'] == 'Default' or $this->settings['gpxFileDownloadLink'] == '') {
			// ... dann den Wert für gpxDownloadLink aus constants.ts nehmen ...
			$gpxDownloadLink = $this->settings['gpxDownloadLink'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxDownloadLink = $this->settings['gpxFileDownloadLink'];
		};
		$this->view->assign('gpxDownloadLink', $gpxDownloadLink);

		// ############################
		// DESCRIPTION
		// Description on/off
		if(!isset($this->settings['gpxFileDescriptionToggle'])) {
			$this->settings['gpxFileDescriptionToggle'] = '';
		}
		if($this->settings['gpxFileDescriptionToggle'] == 'Default' or $this->settings['gpxFileDescriptionToggle'] == '') {
			// ... dann den Wert für gpxDescriptionToggle aus constants.ts nehmen ...
			$gpxDescriptionToggle = $this->settings['gpxDescriptionToggle'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxDescriptionToggle = $this->settings['gpxFileDescriptionToggle'];
		};
		$this->view->assign('gpxDescriptionToggle', $gpxDescriptionToggle);

		// Inhalt von Description zuweisen
		if(!isset($this->settings['gpxFileDescription'])) {
			$this->settings['gpxFileDescription'] = '';
		}
		$gpxFileDescription = $this->settings['gpxFileDescription'];
		$this->view->assign('gpxFileDescription', $gpxFileDescription);

		// ############################
		// CENTERING WITH COORDINATES
		// Werte für MapCoords aus Flexform auslesen
		if(!isset($this->settings['gpxMapCoordsCenter'])) {
			$this->settings['gpxMapCoordsCenter'] = '';
		}
		if(!isset($this->settings['gpxMapCoordsCenterFormat'])) {
			$this->settings['gpxMapCoordsCenterFormat'] = '';
		}
		if(!isset($this->settings['gpxMapCoordsCenterRadius'])) {
			$this->settings['gpxMapCoordsCenterRadius'] = '';
		}
		$gpxMapCoordsCenter = $this->settings['gpxMapCoordsCenter'];
		$gpxMapCoordsCenterFormat = $this->settings['gpxMapCoordsCenterFormat'];
		$gpxMapCoordsCenterRadius = $this->settings['gpxMapCoordsCenterRadius'];
		// String für Koordinaten-Zentrierung zusammenstellen
		// Erfolgt nur, wenn alle Daten für Zentrierung vorhanden sind
		if($gpxMapCoordsCenter != '' and $gpxMapCoordsCenterFormat != '' and $gpxMapCoordsCenterRadius != '') {
			// GPS Formate auf Decimal umrechnen
			$CoordsDecimalArray = $this->computeCoords($gpxMapCoordsCenter, $gpxMapCoordsCenterFormat);
			$latitude = $CoordsDecimalArray[0];
			$longitude = $CoordsDecimalArray[1];
			// String erstellen
			$gpxMapCoordsCenter = 'data-geo="centerlat:' . $latitude . ',centerlon:' . $longitude . ',radius:' . $this->settings['gpxMapCoordsCenterRadius']  . '" ';
		} else {
			// Fehlt ein Wert, dann erfolgt keine Ausgabe
			$gpxMapCoordsCenter = '';
		};
		// Wert zuweisen
		$this->view->assign('gpxMapCoordsCenter', $gpxMapCoordsCenter);

		// ############################
		// WEGPUNKTE
		// ICON-Wegpunkte
		if(!isset($this->settings['gpxFileMap_wayp'])) {
			$this->settings['gpxFileMap_wayp'] = '';
		}
		if($this->settings['gpxFileMap_wayp'] == 'Default' or $this->settings['gpxFileMap_wayp'] == '') {
			// ... dann den Wert für gpxMap_wayp aus constants.ts nehmen ...
			$gpxMap_wayp = $this->settings['gpxMap_wayp'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMap_wayp = $this->settings['gpxFileMap_wayp'];
		};
		$this->view->assign('gpxMap_wayp', $gpxMap_wayp);

		// IMAGE-Wegpunkte
		if(!isset($this->settings['gpxFileMap_img'])) {
			$this->settings['gpxFileMap_img'] = '';
		}
		if($this->settings['gpxFileMap_img'] == 'Default' or $this->settings['gpxFileMap_img'] == '') {
			// ... dann den Wert für gpxMap_img aus constants.ts nehmen ...
			$gpxMap_img = $this->settings['gpxMap_img'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMap_img = $this->settings['gpxFileMap_img'];
		};
		$this->view->assign('gpxMap_img', $gpxMap_img);

		// Das gesamte Array für Wegpunkte einlesen
		if(isset($this->settings['waypoints'])) {
			$wholeArray = $this->settings['waypoints'];
		};
		// Das Array muss existieren und darf nicht leer sein!
		if(isset($wholeArray) and !($wholeArray == '')) {
			// FESTSTELLEN DER SEITENSPRACHE
			// Bis 9.x funktionierte noch dies:
			// $pageLanguage = $GLOBALS['TSFE']->sys_language_isocode);
			// Deprecated seit 9.2 funktioniert aber noch mit 10.4.1
			$this->pageLanguage = $GLOBALS['TYPO3_REQUEST']->getAttribute('language')->getTwoLetterIsoCode();
			// Variablen für Ausgabestrings (Wegpunkte für Images/Icons) resetten
			$gpxMapImages = "";
			$gpxMapIcons = "";
			foreach($wholeArray as $array) {
				if(!isset($array['container']['settings']['gpxMapWaypointCoordsShow'])) {
					$array['container']['settings']['gpxMapWaypointCoordsShow'] = '';
				}
				if($array['container']['settings']['gpxMapWaypointCoordsShow'] != '' and $array['container']['settings']['gpxMapWaypointCoordsShow'] != "Default") {
					$coordsShow = $array['container']['settings']['gpxMapWaypointCoordsShow'];
				} else {
					$coordsShow = $this->settings['gpxMap_img_coords'];
				}
				// Bestimmen von $photoSize für PhotoStation-Zugriffe (PhotoStation 6 Bild oder Album)
				if(!isset($array['container']['settings']['gpxMapWaypointPhotoStationPhotoSize'])) {
					$array['container']['settings']['gpxMapWaypointPhotoStationPhotoSize'] = '';
				}
				if($array['container']['settings']['gpxMapWaypointPhotoStationPhotoSize'] != '' and $array['container']['settings']['gpxMapWaypointPhotoStationPhotoSize'] != "Default") {
					$photoSize = $array['container']['settings']['gpxMapWaypointPhotoStationPhotoSize'];
				} else {
					$photoSize = $this->settings['gpxMap_imgPhotoStationPhotoSize'];
				}
				//Falls es sich um ein PhotoStation 6-Bild handelt:
				if ($array['container']['settings']['gpxMapWaypointType'] == 'imageGeotaggedPS' and ($this->settings['gpxMap_profilesPSaddr'] != '' or $array['container']['settings']['gpxMapWaypointPhotoStationAddr'] != '')) {
					if($array['container']['settings']['gpxMapWaypointPhotoStationAddr'] != '') {
						$serverAddr = $array['container']['settings']['gpxMapWaypointPhotoStationAddr'];
					} else {
						$serverAddr = $this->settings['gpxMap_profilesPSaddr'];
					}
					$image = $array['container']['settings']['gpxMapWaypointImagePS'];
					// reset jsonArray
					$jsonArray = array();
					exec("curl '" . $serverAddr . "/photo/webapi/photo.php?api=SYNO.PhotoStation.Photo&method=getinfo&version=1&limit=50&type=photo&id=" . $image . "&additional=photo_exif&gps&offset=0'", $jsonArray);
					$jsonPHParray = json_decode($jsonArray[0], true);
					// Überprüfen, ob die PhotoStation-Abfrage erfolgreich war
					if($jsonPHParray['success'] == 'true') {
						// Hier sollte vielleicht auch ein Check der GPS-Daten rein?? Kann nur funktionieren, wenn das Bild über GPS-Daten verfügt.
						$item = $jsonPHParray['data'][0];
						$sourceFile = $serverAddr . "/photo/webapi/thumb.php?api=SYNO.PhotoStation.Thumb&method=get&version=1&size=" . $photoSize . "&id=" . $image;
						$latitude = $item['additional']['photo_exif']['gps']['lat']; // Kann auch in $items['info']['lat'] stehen
						$longitude = $item['additional']['photo_exif']['gps']['lng']; // Kann auch in $items['info']['lng'] stehen
						$gpxMapWaypointLink = ""; // Checken!!! Kann hier ein Link verwendet werden? Eigentlich nicht, oder?
						// Get image description from a multilangual string
						$imageDescription = $this->getImageDescription($item['info']['description']);
						// Ausgabe der Koordinaten in der Wegpunktbeschreibung
						$Coords = $this->getCoords($coordsShow, $imageDescription, $latitude, $longitude);
						// Ausgabestring
						$gpxMapImages = $gpxMapImages . 
								'			<img src="' . $sourceFile . '" data-geo="lat:' . $latitude . ',lon:' . $longitude . '" alt="' . $imageDescription . $Coords . '"' . $gpxMapWaypointLink . '>
				';
					}
				}
				//Falls es sich um ein PhotoStation 6-Album handelt:
				if ($array['container']['settings']['gpxMapWaypointType'] == 'imageGeotaggedPSDir' and ($this->settings['gpxMap_profilesPSaddr'] != '' or $array['container']['settings']['gpxMapWaypointPhotoStationAddr'] != '')) {
					if($array['container']['settings']['gpxMapWaypointPhotoStationAddr'] != '') {
						$serverAddr = $array['container']['settings']['gpxMapWaypointPhotoStationAddr'];
					} else {
						$serverAddr = $this->settings['gpxMap_profilesPSaddr'];
					}
					$album = $array['container']['settings']['gpxMapWaypointImageFolderPS'];
					exec("curl '" . $serverAddr . "/photo/webapi/album.php?api=SYNO.PhotoStation.Album&method=list&version=1&limit=150&type=photo&id=" . $album . "&additional=photo_exif&gps&offset=0'", $jsonArray);
					$jsonPHParray = json_decode($jsonArray[0], true);
					// Überprüfen, ob die PhotoStation-Abfrage erfolgreich war
					if($jsonPHParray['success'] == 'true') {
						$items = $jsonPHParray['data']['items'];
						foreach($items as $item) {
							// Check if GPS coordinates are found
							if(isset($item['additional']['photo_exif']['gps']['lat']) AND isset($item['additional']['photo_exif']['gps']['lng'])) {
								$sourceFile = $serverAddr . "/photo/webapi/thumb.php?api=SYNO.PhotoStation.Thumb&method=get&version=1&size=" . $photoSize . "&id=" . $item['id'];
								$latitude = $item['additional']['photo_exif']['gps']['lat']; // Kann auch in $items['info']['lat'] stehen
								$longitude = $item['additional']['photo_exif']['gps']['lng']; // Kann auch in $items['info']['lng'] stehen
								$gpxMapWaypointLink = ""; // Checken!!! Kann hier ein Link verwendet werden? Eigentlich nicht, oder?
								// Get image description from a multilangual string
								$imageDescription = $this->getImageDescription($item['info']['description']);
								// Ausgabe der Koordinaten in der Wegpunktbeschreibung
								$Coords = $this->getCoords($coordsShow, $imageDescription, $latitude, $longitude);
								// Ausgabestring
								$gpxMapImages = $gpxMapImages . 
									'			<img src="' . $sourceFile . '" data-geo="lat:' . $latitude . ',lon:' . $longitude . '" alt="' . $imageDescription . $Coords . '"' . $gpxMapWaypointLink . '>
				';
							}
						}
					}
				}
				// Falls es sich um Bilder mit Geotags handelt
				$geotagged = array('imageGeotagged','imageGeotaggedDir');
				if (in_array($array['container']['settings']['gpxMapWaypointType'], $geotagged)) {
					// Es handelt sich um eine Bilddatei
					if ($array['container']['settings']['gpxMapWaypointImage'] != '') {
						// sys_file uid für Image in Dateiname umwandeln
						$sysFileUid = $array['container']['settings']['gpxMapWaypointImage'];
						// ResourceFactory einlesen
						$resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
						// Angaben aus sys_file auslesen
						$tmpFile = $resourceFactory->getFileObject($sysFileUid);
						// Vollen Dateinamen auslesen
						$imageGeotaggedSource = 'fileadmin' . $tmpFile->getIdentifier();
					}
					// Wenn es ein Verzeichnis ist
					if ($array['container']['settings']['gpxMapWaypointType'] == 'imageGeotaggedDir') {
						// sys_file uid für gewähltes Image umwandeln
						$sysFileUid = $array['container']['settings']['gpxMapWaypointImageFolder'];
						// ResourceFactory muss hier wiederholt gebraucht
						$resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
						// Angaben aus sys_file auslesen
						$tmpFile = $resourceFactory->getFileObject($sysFileUid);
						// Vollen Dateinamen auslesen
						$imageGeotaggedSource = 'fileadmin' . $tmpFile->getIdentifier();
						// Dateinamen abschneiden: Übrig bleibt Verzeichnisname
						$imageGeotaggedSource = substr($imageGeotaggedSource, 0, strrpos($imageGeotaggedSource, "/"));
					}
					// exiftool Abfrage
					$exif = '';
					eval('$exif=' . `exiftool -php -q -c %+.6f '$imageGeotaggedSource'`);
					// Sortieren des exiftool-PHP-Arrays mit den Bilddaten nach Dateiname
					$sort = array_column($exif,'SourceFile');
					array_multisort($sort, SORT_ASC, $exif);
					// Für alle Bilddaten
					foreach($exif as $exifdata) {
						$sourceFile = $exifdata['SourceFile'];
						if(!isset($exifdata['GPSLatitude'])) {
							$exifdata['GPSLatitude'] = '';
						}
						$latitude = $exifdata['GPSLatitude'];
						if(!isset($exifdata['GPSLongitude'])) {
							$exifdata['GPSLongitude'] = '';
						}
						$longitude = $exifdata['GPSLongitude'];
						if(!isset($exifdata['BaseURL'])) {
							$exifdata['BaseURL'] = '';
						}
						$imageURL = $exifdata['BaseURL'];
						// Vorbereitung der Ausgabe eines Links über dem Bild in der Karte
						if($imageURL <> '') {
							$gpxMapWaypointLink = ' data-link="' . $imageURL . '"';
						} else {
							$gpxMapWaypointLink = '';
						};
//						$imageDescription = $exifdata['ImageDescription'];
						// Ausgabe nur, wenn GPS-Daten vorhanden sind
						if (($latitude <> "") and ($longitude <> "")) {
							// Get image description from a multilangual string
							if(!isset($exifdata['ImageDescription'])) {
								$exifdata['ImageDescription'] = '';
							}
							$imageDescription = $this->getImageDescription($exifdata['ImageDescription']);
							// Ausgabe der Koordinaten in der Wegpunktbeschreibung
							$Coords = $this->getCoords($coordsShow, $imageDescription, $latitude, $longitude);
							// Ausgabestring, bei im mit einem führenden "/", da sonst die Namen nicht vollständig
							$gpxMapImages = $gpxMapImages . 
									'			<img src="/' . $sourceFile . '" data-geo="lat:' . $latitude . ',lon:' . $longitude . '" alt="' . $imageDescription . $Coords . '"' . $gpxMapWaypointLink . '>
				';
						};
					};
				} else {
					// Für den Fall, dass es sich um Bilder oder Icons mit Koordinatenangaben handelt
					// GPS Formate auf Decimal umrechnen
					// Wegpunkt-Koordinaten und -Format auslesen
					$CoordsOrigin = $array['container']['settings']['gpxMapWaypointCoords'];
					$CoordsFormat = $array['container']['settings']['gpxMapWaypointCoordsFormat'];
					// Aufruf der Koordinaten-Umrechnung
					// IF, da sonst läuft die Abfrage einmal zu viel durch. $wholeArray muss noch mal überprüft werden, falls es Probleme gibt!!!
					if($CoordsOrigin != "" and $CoordsFormat != "") {
						$CoordsDecimalArray = $this->computeCoords($CoordsOrigin, $CoordsFormat);
						$latitude = $CoordsDecimalArray[0];
						$longitude = $CoordsDecimalArray[1];
						// Ausgabe der Koordinaten in der Wegpunktbeschreibung
						$Coords = $this->getCoords($coordsShow, $array['container']['settings']['gpxMapWaypointDescription'], $latitude, $longitude);
						// Vorbereitung der Ausgabe der Headline in der Wegpunktbeschreibung
						if((isset($array['container']['settings']['gpxMapWaypointDescriptionHeadline'])) and ($array['container']['settings']['gpxMapWaypointDescriptionHeadline'] <> '')) {
							$gpxMapWaypointDescriptionHeadline = ' data-name="' . $array['container']['settings']['gpxMapWaypointDescriptionHeadline']  . '"';
						} else {
							$gpxMapWaypointDescriptionHeadline = '';
						};
						// Vorbereitung der Ausgabe eines Links in der Wegpunktbeschreibung
						if((isset($array['container']['settings']['gpxMapWaypointLink'])) and ($array['container']['settings']['gpxMapWaypointLink'] <> '')) {
							$gpxMapWaypointLink = ' data-link="' . $array['container']['settings']['gpxMapWaypointLink']  . '"';
						} else {
							$gpxMapWaypointLink = '';
						};


						// Ausgabestrings für Wegpunkte: Emoji
						if (($array['container']['settings']['gpxMapWaypointType'] == 'emoji') and ($array['container']['settings']['gpxMapWaypointEmoji'] <> '')) {
							$gpxMapWaypointEmoji = ' data-icon="' . $array['container']['settings']['gpxMapWaypointEmoji']  . '"';
							$gpxMapIcons = $gpxMapIcons .
											'<div data-geo="lat:' . $latitude . ',lon:' . $longitude . '"' . $gpxMapWaypointEmoji . $gpxMapWaypointDescriptionHeadline . $gpxMapWaypointLink . '>' . $array['container']['settings']['gpxMapWaypointDescription'] . $Coords . '</div>
			';
						};

						if ((isset($array['container']['settings']['gpxMapWaypointIcon'])) and ($array['container']['settings']['gpxMapWaypointIcon'] <> '')) {
							$gpxMapWaypointIcon = ' data-icon="' . $array['container']['settings']['gpxMapWaypointIcon']  . '"';
							$gpxMapIcons = $gpxMapIcons .
											'<div data-geo="lat:' . $latitude . ',lon:' . $longitude . '"' . $gpxMapWaypointIcon . $gpxMapWaypointDescriptionHeadline . $gpxMapWaypointLink . '>' . $array['container']['settings']['gpxMapWaypointDescription'] . $Coords . '</div>
			';
						};
						// Ausgabestrings für Wegpunkte (Images/Icons) erstellen
						if ($array['container']['settings']['gpxMapWaypointType'] == 'image') {
							// sys_file uid für gewähltes Image umwandeln
							$sysFileUid = $array['container']['settings']['gpxMapWaypointImage'];
							// ResourceFactory einlesen
							$resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
							// Angaben aus sys_file auslesen
							$tmpFile = $resourceFactory->getFileObject($sysFileUid);
							// Vollen Dateinamen auslesen
							$gpxMapWaypointImage = '/fileadmin' . $tmpFile->getIdentifier();
							$gpxMapImages = $gpxMapImages . 
											'<img src="' . $gpxMapWaypointImage . '" data-geo="lat:' . $latitude . ',lon:' . $longitude . '" alt="' . $array['container']['settings']['gpxMapWaypointDescriptionHeadline']  . $Coords . '"' . $gpxMapWaypointDescriptionHeadline . $gpxMapWaypointLink . '>
			';
						};
					};
				};
			};
		};
		// Werte zuweisen
		$this->view->assign('gpxMapImages', $gpxMapImages);
		$this->view->assign('gpxMapIcons', $gpxMapIcons);
		$this->view->assign('imageDescriptionText', $imageDescriptionText);

		// ############################
		// PROFILES
		// Profiles on/off
		if(!isset($this->settings['gpxFileMap_profiles'])) {
			$this->settings['gpxFileMap_profiles'] = '';
		}
		if($this->settings['gpxFileMap_profiles'] == 'Default' or $this->settings['gpxFileMap_profiles'] == '') {
			// ... dann den Wert für gpxMap_profiles aus constants.ts nehmen ...
			$gpxMap_profiles = $this->settings['gpxMap_profiles'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMap_profiles = $this->settings['gpxFileMap_profiles'];
		};
		
		$this->view->assign('gpxMap_profiles', $gpxMap_profiles);
		if($gpxMap_profiles == 'true') {
			// Vorbereitung für die Profilausgabe
			if(!isset($this->settings['gpxFileMap_sorting'])) {
				$this->settings['gpxFileMap_sorting'] = '';
			}
			if($this->settings['gpxFileMap_sorting'] != "") {
				$gpxMap_sorting = $this->settings['gpxFileMap_sorting'];
			} else {
				$gpxMap_sorting = $this->settings['gpxMap_sorting'];
			}
			// Sortierte, kommaseparierte Liste in Array übergeben
			$profilesNameArray = array_map('trim',explode(",",$gpxMap_sorting));
			// Anzahl der aktivierte Profile feststellen
			$profilesCount = 0;
			$profilesCount = count($profilesNameArray);
			// Ausgabe der Profile in Tabellen
			// Standard-Angabe für Spalten für jeweilige Anzahl von Profilen einlesen
			$profilesCols = array_map('trim',explode(",",$this->settings['gpxMap_profilesCols']));
			// Hier eine Prüfung, ob Spaltenangabe im Content Element vorgenommen wurden
			if(!isset($this->settings['gpxFileMap_profilesCols'])) {
				$this->settings['gpxFileMap_profilesCols'] = null;
			}
			if($this->settings['gpxFileMap_profilesCols'] != null and $this->settings['gpxFileMap_profilesCols'] != 'Default') {
				$profilesCols[$profilesCount-1] = $this->settings['gpxFileMap_profilesCols'];
			}
			// Ganzzahlige Division von Profilanzahl durch Spalten zum Errechnen der Zeilenanzahl
			$profilesRows = intdiv($profilesCount, $profilesCols[$profilesCount-1]);
			// Modulo Division von Profilanzahl durch Spalten prüfen und falls ein Rest vorhanden, die Zeilenanzahl um 1 erhöhen
			if($profilesCount % $profilesCols[$profilesCount-1] > 0 ) { 
				$profilesRows++;
			};
			// Höhe des Profile-Divs geteilt durch Zeilenanzahl - 4px für Ränder ergibt die Höhe EINES Profils
			// Bei $this->settings['gpxviewer-profiles-height'] müssen überflüssig "px" gelöscht werden
//			$profileHeight = $this->settings['gpxviewer-profiles-height'] / $profilesRows - 4;
			$profileHeight = str_replace('px', '', $this->settings['gpxviewer-profiles-height']) / $profilesRows - 4;
			// Werte für die Ausgabe zu weisen
			$this->view->assign('profilesNameArray', $profilesNameArray);
			$this->view->assign('profilesCols', $profilesCols[$profilesCount-1]);
			$this->view->assign('profileHeight', $profileHeight ."px");
			// Optional in case if layout would be build in a different way
			// $this->view->assign('profilesRows', $profilesRows);
			// $this->view->assign('profilesHeight', $this->settings['gpxviewer-profiles-height']);
		}

		// ############################
		// ImageDiv (MarkerImage)
		if(!isset($this->settings['gpxFileMap_imgdiv'])) {
			$this->settings['gpxFileMap_imgdiv'] = '';
		}
		if($this->settings['gpxFileMap_imgdiv'] == 'Default' or $this->settings['gpxFileMap_imgdiv'] == '') {
			// ... dann den Wert für $gpxMap_imgLayout aus constants.ts nehmen ...
			$gpxMap_imgdiv = $this->settings['gpxMap_imgdiv'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMap_imgdiv = $this->settings['gpxFileMap_imgdiv'];
		}
		$this->view->assign('gpxMap_imgdiv', $gpxMap_imgdiv);
		// Scale
		if(!isset($this->settings['gpxFileMap_imgdivScale'])) {
			$this->settings['gpxFileMap_imgdivScale'] = '';
		}
		if($this->settings['gpxFileMap_imgdivScale'] == '' or !isset($this->settings['gpxFileMap_imgdivScale'])) {
			// ... dann den Wert für $gpxMap_imgLayout aus constants.ts nehmen ...
			$gpxMap_imgdivScale = $this->settings['gpxMap_imgdivScale'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMap_imgdivScale = $this->settings['gpxFileMap_imgdivScale'];
		}
		$this->view->assign('gpxMap_imgdivScale', $gpxMap_imgdivScale);

		// ############################
		// LAYOUT
		// Layout for Images
		if(!isset($this->settings['gpxFileMap_imgdivLayout'])) {
			$this->settings['gpxFileMap_imgdivLayout'] = '';
		}
		if($this->settings['gpxFileMap_imgdivLayout'] == 'Default' or $this->settings['gpxFileMap_imgdivLayout'] == '') {
			// ... dann den Wert für $gpxMap_imgLayout aus constants.ts nehmen ...
			$gpxMap_imgdivLayout = $this->settings['gpxMap_imgdivLayout'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMap_imgdivLayout = $this->settings['gpxFileMap_imgdivLayout'];
		}
		if(!isset($this->settings['gpxFileMap_profilesLayout'])) {
			$this->settings['gpxFileMap_profilesLayout'] = '';
		}
		// Layout for Profiles
		if($this->settings['gpxFileMap_profilesLayout'] == 'Default' or $this->settings['gpxFileMap_profilesLayout'] == '') {
			// ... dann den Wert für gpxMap_profilesLayout aus constants.ts nehmen ...
			$gpxMap_profilesLayout = $this->settings['gpxMap_profilesLayout'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMap_profilesLayout = $this->settings['gpxFileMap_profilesLayout'];
		}
		// Check conditions and set variables
		// imgdiv?
		$textpicPosition = "normal";
		if($gpxMapImages != '' && $gpxMap_img == 'true' && $gpxMap_imgdiv == 'true') {
			$textpicPosition = $gpxMap_imgdivLayout;
			$imgdiv = 'true';
		} else {
			$imgdiv = 'false';
		}
		$this->view->assign('imgdiv', $imgdiv);
		// profiles?
		if ($gpxMap_profiles == 'true' and $gpxFile != '' and $profilesCount != '0') {
			$profiles = 'true';
			if($imgdiv == 'false') {
				$textpicPosition = $gpxMap_profilesLayout;
			}
		} else {
			$profiles = 'false';
		}
		$this->view->assign('profiles', $profiles);
		// set layout variable
		$this->view->assign('textpicPosition', $textpicPosition);
		// in case there is a imgdiv AND profiles
		$profilesType = "text";
		if($imgdiv == 'true' AND $profiles == 'true') {
			if($textpicPosition == "below" or $textpicPosition == "right") {
				$profilesType = "gallery";
			}
		}
		$this->view->assign('profilesType', $profilesType);
		// create an additional classname
		$addClassname = "gpx";
		if ($imgdiv == 'true') {
			$addClassname = $addClassname . "-img";
		}
		if ($profiles == 'true') {
			$addClassname = $addClassname . "-pro";
		}
		$addClassname = $addClassname . "-" . $textpicPosition;
		$this->view->assign('addClassname', $addClassname);
	}
}
