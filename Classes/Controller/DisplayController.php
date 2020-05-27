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
		// auf W/E prüfen
		if(substr($CoordsArray[2], 0, 1) == 'W' or substr($CoordsArray[3], 0, 1) == 'W') {
			$lon_multiplier = -1;
		} else {
			$lon_multiplier = 1;
		};
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
	 * Index action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction()
	{
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
		$uid = $this->configurationManager->getContentObject()->data['uid'];
		$this->view->assign('uid', $uid);

		// ############################
		// Zusätzliches Javascript für Animation von GPX tracks in einer Karte generieren
		// gpxFileAnimation is a flexform switch, gpxAnimation is a constant
		// gpxAnimation variable is needed as a switch, preset to false
		$gpxAnimation = "false";
		if($this->settings['gpxFileAnimation'] == 'true' or ($this->settings['gpxAnimation'] == 'true' and ($this->settings['gpxFileAnimation'] == 'Default' or $this->settings['gpxFileAnimation'] == ''))) 
		{
			// Assign a switch
			$gpxAnimation = "true";
			// Animations-Icon bestimmen
			// Wenn der Wert aus der Flexform nicht leer oder nicht gleich "Default" ist, dann wird der Flexformwert verwendet
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
		if($this->settings['gpxFileDescriptionToggle'] == 'Default' or $this->settings['gpxFileDescriptionToggle'] == '') {
			// ... dann den Wert für gpxDescriptionToggle aus constants.ts nehmen ...
			$gpxDescriptionToggle = $this->settings['gpxDescriptionToggle'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxDescriptionToggle = $this->settings['gpxFileDescriptionToggle'];
		};
		$this->view->assign('gpxDescriptionToggle', $gpxDescriptionToggle);

		// Inhalt von Description zuweisen
		$gpxFileDescription = $this->settings['gpxFileDescription'];
		$this->view->assign('gpxFileDescription', $gpxFileDescription);

		// ############################
		// CENTERING WITH COORDINATES
		// Werte für MapCoords aus Flexform auslesen
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
		if($this->settings['gpxFileMap_wayp'] == 'Default' or $this->settings['gpxFileMap_wayp'] == '') {
			// ... dann den Wert für gpxMap_wayp aus constants.ts nehmen ...
			$gpxMap_wayp = $this->settings['gpxMap_wayp'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMap_wayp = $this->settings['gpxFileMap_wayp'];
		};
		$this->view->assign('gpxMap_wayp', $gpxMap_wayp);
		// IMAGE-Wegpunkte
		if($this->settings['gpxFileMap_img'] == 'Default' or $this->settings['gpxFileMap_img'] == '') {
			// ... dann den Wert für gpxMap_img aus constants.ts nehmen ...
			$gpxMap_img = $this->settings['gpxMap_img'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMap_img = $this->settings['gpxFileMap_img'];
		};
		$this->view->assign('gpxMap_img', $gpxMap_img);
		// Das gesamte Array für Wegpunkte einlesen
		$wholeArray = $this->settings['waypoints'];

		// Das Array muss existieren und darf nicht leer sein!
		if(isset($wholeArray) and !($wholeArray == '')) {
			// Variablen für Ausgabestrings (Wegpunkte für Images/Icons) resetten
			$gpxMapImages = "";
			$gpxMapIcons = "";
			foreach($wholeArray as $array) {

				// Falls es sich um Bilder mit Geotags handelt
				$geotagged = array('imageGeotagged','imageGeotaggedDir');
				if (in_array($array['container']['settings']['gpxMapWaypointType'], $geotagged)) {
					// Image filename

					if ($array['container']['settings']['gpxMapWaypointImage'] != '') {
//						$imageGeotaggedSource = $array['container']['settings']['gpxMapWaypointImage'];
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
//						$imageGeotaggedSource = substr($array['container']['settings']['gpxMapWaypointImageFolder'], 0, strrpos($array['container']['settings']['gpxMapWaypointImageFolder'], "/"));

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

					// exiftool
					$exif = '';
					eval('$exif=' . `exiftool -php -q -c %+.6f '$imageGeotaggedSource'`);

					// FESTSTELLEN DER SEITENSPRACHE
					// Bis 9.x funktionierte noch dies:
					// $pageLanguage = $GLOBALS['TSFE']->sys_language_isocode);
					// Deprecated seit 9.2 funktioniert aber noch mit 10.4.1
					$pageLanguage = $GLOBALS['TYPO3_REQUEST']->getAttribute('language')->getTwoLetterIsoCode();

					// Sortieren des exiftool-PHP-Arrays mit den Bilddaten nach Dateiname
					$sort = array_column($exif,'SourceFile');
					array_multisort($sort, SORT_ASC, $exif);

					foreach($exif as $exifdata) {
						$sourceFile = $exifdata['SourceFile'];
						$latitude = $exifdata['GPSLatitude'];
						$longitude = $exifdata['GPSLongitude'];

						$imageURL = $exifdata['BaseURL'];
						// Vorbereitung der Ausgabe eines Links über dem Bild in der Karte
						if($imageURL <> '') {
							$gpxMapWaypointLink = ' data-link="' . $imageURL . '"';
						} else {
							$gpxMapWaypointLink = '';
						};

						$imageDescription = $exifdata['ImageDescription'];
						// Ausgabe nur, wenn GPS-Daten vorhanden sind
						if (($latitude <> "") and ($longitude <> "")) {
							// Überprüfen, ob ein mehrsprachiger Eintrag im Feld ImageDescription vorliegt, entsprechend dem Format:
							// DE: Text
							// -----
							// EN: Text
							// Array für den mehrsprachigen Eintrag anlegen
							$imageDescriptionArray = explode('-----', $exifdata['ImageDescription']);
							// Herausfiltern, ob eines der Arrays der aktuellen Sprachauswahl entspricht und in diesem Fall den Beschreibungstext ändern
							foreach($imageDescriptionArray as $id) {
								$id = trim($id, " \t\n\r\0\x0B");
								if($pageLanguage . ":"  == strtolower(substr($id, 0, strlen($pageLanguage)+1))) {
									$imageDescription = nl2br(trim(substr_replace($id, '', 0, strlen($pageLanguage)+1), " "));
								}
							}

							// Ausgabe der Koordinaten in der Wegpunktbeschreibung
							if($array['container']['settings']['gpxMapWaypointCoordsShow'] == "true" or $array['container']['settings']['gpxMapWaypointCoordsShow'] == "") {
								$Coords = "[" . $latitude . " " . $longitude . "]";
								if($imageDescription != "") {
									$Coords = $this->settings['gpxMap_img_coords_in_description_before'] . $Coords;
								}
							} else {
								$Coords = "";
							};

							// Ausgabestring
							$gpxMapImages = $gpxMapImages . 
									'			<img src="' . $sourceFile . '" data-geo="lat:' . $latitude . ',lon:' . $longitude . '" alt="' . $imageDescription . $Coords . '"' . $gpxMapWaypointLink . '>
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
						if($array['container']['settings']['gpxMapWaypointCoordsShow'] == "true" or $array['container']['settings']['gpxMapWaypointCoordsShow'] == "") {
							$Coords = "[" . $latitude . " " . $longitude . "]";
							if($array['container']['settings']['gpxMapWaypointDescription'] != "") {
								$Coords = $this->settings['gpxMap_img_coords_in_description_before'] . $Coords;
							}
						} else {
							$Coords = "";
						};
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
						// Ausgabestrings für Wegpunkte (Images/Icons) erstellen
						if ($array['container']['settings']['gpxMapWaypointType'] == 'image') {

							// sys_file uid für gewähltes Image umwandeln
							$sysFileUid = $array['container']['settings']['gpxMapWaypointImage'];
							// ResourceFactory einlesen
							$resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
							// Angaben aus sys_file auslesen
							$tmpFile = $resourceFactory->getFileObject($sysFileUid);
							// Vollen Dateinamen auslesen
							$gpxMapWaypointImage = 'fileadmin' . $tmpFile->getIdentifier();

							$gpxMapImages = $gpxMapImages . 
#											'<img src="' . $array['container']['settings']['gpxMapWaypointImage'] . '" data-geo="lat:' . $latitude . ',lon:' . $longitude . '" alt="' . $array['container']['settings']['gpxMapWaypointDescriptionHeadline']  . $Coords . '"' . $gpxMapWaypointDescriptionHeadline . $gpxMapWaypointLink . '>
											'<img src="' . $gpxMapWaypointImage . '" data-geo="lat:' . $latitude . ',lon:' . $longitude . '" alt="' . $array['container']['settings']['gpxMapWaypointDescriptionHeadline']  . $Coords . '"' . $gpxMapWaypointDescriptionHeadline . $gpxMapWaypointLink . '>
			';
						} else {
							if((isset($array['container']['settings']['gpxMapWaypointIcon'])) and ($array['container']['settings']['gpxMapWaypointIcon'] <> '')) {
								$gpxMapWaypointIcon = ' data-icon="' . $array['container']['settings']['gpxMapWaypointIcon']  . '"';
							} else {
								$gpxMapWaypointIcon = '';
							};
							$gpxMapIcons = $gpxMapIcons .
											'<div data-geo="lat:' . $latitude . ',lon:' . $longitude . '"' . $gpxMapWaypointIcon . $gpxMapWaypointDescriptionHeadline . $gpxMapWaypointLink . '>' . $array['container']['settings']['gpxMapWaypointDescription'] . $Coords . '</div>
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
			// Ausgabeformatierung: Größenangaben für Höhe und Breite und Spaltenanzahl für Ausgabe
			switch($profilesCount) {
				case 1: $profilesArray = array( "width" => "98%", "height" => "98%", "margin-top" => "1%", "margin-right" => "1%", "cols" => "1"); break;
				case 2: $profilesArray = array( "width" => "98%", "height" => "47.5%", "margin-top" => "1%", "margin-right" => "1%", "cols" => "1"); break;
				case 3: $profilesArray = array( "width" => "98%", "height" => "32%", "margin-top" => "0.5%", "margin-right" => "1%", "cols" => "1"); break;
				case 4: $profilesArray = array( "width" => "48%", "height" => "48%", "margin-top" => "0.75%", "margin-right" => "1%", "cols" => "3"); break;
				case 5: $profilesArray = array( "width" => "98%", "height" => "19%", "margin-top" => "0.3%", "margin-right" => "1%", "cols" => "1"); break;
				case 6: $profilesArray = array( "width" => "48%", "height" => "32%", "margin-top" => "0.5%", "margin-right" => "1%", "cols" => "3"); break;
				case 7: $profilesArray = array( "width" => "32%", "height" => "32%", "margin-top" => "0.6%", "margin-right" => "0.65%", "cols" => "3"); break;
				case 8: $profilesArray = array( "width" => "32%", "height" => "32%", "margin-top" => "0.6%", "margin-right" => "0.65%", "cols" => "3"); break;
				case 9: $profilesArray = array( "width" => "32%", "height" => "32%", "margin-top" => "0.6%", "margin-right" => "0.65%", "cols" => "3"); break;
				case 10: $profilesArray = array( "width" => "32%", "height" => "24%", "margin-top" => "0.4%", "margin-right" => "0.65%", "cols" => "3"); break;
				case 11: $profilesArray = array( "width" => "32%", "height" => "24%", "margin-top" => "0.4%", "margin-right" => "0.65%", "cols" => "3"); break;
				case 12: $profilesArray = array( "width" => "32%", "height" => "24%", "margin-top" => "0.4%", "margin-right" => "0.65%", "cols" => "3"); break;
				case 13: $profilesArray = array( "width" => "32%", "height" => "19%", "margin-top" => "0.4%", "margin-right" => "0.65%", "cols" => "4"); break;
			};
			// Werte für die Profile-Ausgabe zuweisen
			$this->view->assign('profilesNameArray', $profilesNameArray);
			$this->view->assign('profilesCount', $profilesCount);
			$this->view->assign('profilesWidth', $profilesArray["width"]);
			$this->view->assign('profilesHeight', $profilesArray["height"]);
			$this->view->assign('profilesMargin-top', $profilesArray["margin-top"]);
			$this->view->assign('profilesMargin-right', $profilesArray["margin-right"]);
			$this->view->assign('profilesCols', $profilesArray["cols"]);
		}

		// ############################
		// ImageDiv (MarkerImage)
		if($this->settings['gpxFileMap_imgdiv'] == 'Default' or $this->settings['gpxFileMap_imgdiv'] == '') {
			// ... dann den Wert für $gpxMap_imgLayout aus constants.ts nehmen ...
			$gpxMap_imgdiv = $this->settings['gpxMap_imgdiv'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMap_imgdiv = $this->settings['gpxFileMap_imgdiv'];
		}
		$this->view->assign('gpxMap_imgdiv', $gpxMap_imgdiv);
		// Scale
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
		if($this->settings['gpxFileMap_imgdivLayout'] == 'Default' or $this->settings['gpxFileMap_imgdivLayout'] == '') {
			// ... dann den Wert für $gpxMap_imgLayout aus constants.ts nehmen ...
			$gpxMap_imgdivLayout = $this->settings['gpxMap_imgdivLayout'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMap_imgdivLayout = $this->settings['gpxFileMap_imgdivLayout'];
		}
		$this->view->assign('gpxMap_imgdivLayout', $gpxMap_imgdivLayout);
		// Layout for Profiles
		if($this->settings['gpxFileMap_profilesLayout'] == 'Default' or $this->settings['gpxFileMap_profilesLayout'] == '') {
			// ... dann den Wert für gpxMap_profilesLayout aus constants.ts nehmen ...
			$gpxMap_profilesLayout = $this->settings['gpxMap_profilesLayout'];
		} else {
			// ... sonst den Wert aus der Flexform nehmen
			$gpxMap_profilesLayout = $this->settings['gpxFileMap_profilesLayout'];
		}
		$this->view->assign('gpxMap_profilesLayout', $gpxMap_profilesLayout);

		// Check conditions and set variables
		// imgdiv?
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
	}
}
