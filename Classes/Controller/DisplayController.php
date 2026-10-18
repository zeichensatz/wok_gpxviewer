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
use TYPO3\CMS\Frontend\Resource\FilePathSanitizer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Resource\ResourceFactory;



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
	 * Returns all records for list_type "wokgpxviewer_gpxtracks"
	 */
	protected function getTranslatedRecord(int $uid, int $language): array
	{
		$connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
		$queryBuilder = $connectionPool->getQueryBuilderForTable('tt_content');
		$queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

		return $queryBuilder
		->select('uid', 'pid', 'tstamp', 'crdate', 'sys_language_uid', 'list_type', 'pi_flexform')
		->from('tt_content')
		->where(
			$queryBuilder->expr()->eq(
				'l18n_parent', $queryBuilder->createNamedParameter($uid),
				'hidden', $queryBuilder->createNamedParameter(0),
				'deleted', $queryBuilder->createNamedParameter(0),
				'sys_language_uid', $queryBuilder->createNamedParameter($language),
				'list_type', $queryBuilder->createNamedParameter('wokgpxviewer_gpxtracks')
			)
		)
		->executeQuery()
		->fetchAllAssociative();
	}

	/**
	 * Return file or folder id from a flexform link entry
	 *
	 * @param string $condition1
	 * @param string $condition2
	 * @return string $Coord
	 */
	protected function getFlexformIdentifier($flexformLinkString)
	{
debug($flexformLinkString, "1: ");
$flexformLinkString = "t3://folder?uid=3369";
						if (!empty($flexformLinkString)) {
							// Prüfen, ob es sich um eine moderne t3://folder Verknüpfung handelt
							if (str_starts_with($flexformLinkString, 't3://folder')) {
debug("True");
								try {
									// Native PHP-Funktionen nutzen, um die Query-Parameter zu zerlegen
									$parsedUrl = parse_url($flexformLinkString);
debug($parsedUrl, "2: ");
									$queryParams = [];
									if (isset($parsedUrl['query'])) {
										parse_str($parsedUrl['query'], $queryParams);
									}
debug($queryParams, "3: ");
									// Storage-UID und Verzeichnispfad aus den Parametern extrahieren
									$storageUid = isset($queryParams['storage']) ? (int)$queryParams['storage'] : 1;
debug($storageUid, "4: ");
									$folderIdentifier = isset($queryParams['identifier']) ? urldecode($queryParams['identifier']) : '';
debug($folderIdentifier, "5: ");
									if (!empty($folderIdentifier)) {
										// Die ResourceFactory ist in TYPO3 13 unverändert verfügbar
										$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
debug($resourceFactory, "6: ");
										// Kombinierten Identifier bauen (z.B. "1:/pageResources/motorcycle/...")
										$combinedIdentifier = $storageUid . ':' . $folderIdentifier;

										// Ordner-Objekt aus dem Core holen
										$folderObject = $resourceFactory->getFolderObjectFromCombinedIdentifier($combinedIdentifier);

										// Den relativen Pfad als String auslesen ("fileadmin/pageResources/...")
										// ltrim und rtrim entfernen den führenden und abschließenden Slash
										$finalFolderUrl = ltrim(rtrim($folderObject->getPublicUrl(), '/'), '/');
									}
								} catch (\Exception $e) {
									// Falls der Ordner auf der Festplatte nicht existiert, Fehler abfangen
									$finalFolderUrl = '';
								}
							} else {
								// Abwärtskompatibilität: Falls im Altsystem bereits ein nativer Pfad eingetragen war
								$finalFolderUrl = rtrim($flexformLinkString, '/');
							}
						}
debug($finalFolderUrl, "5: ");
return($finalFolderUrl);
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
		// Holt das Inhaltselement direkt aus dem Request-Objekt des Controllers
		$currentContentObject = $this->request->getAttribute('currentContentObject');
		// @extensionScannerIgnoreLine
		$uid = $currentContentObject ? $currentContentObject->data['uid'] : 0;
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
		//debug('uid: ' . $uid);

		// Get current selected language ID,values 0 (=de) or 1 (=en)
		$languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
		$languageId = $languageAspect->getId();
//		debug("LanguageId: ". $languageId);

		// Wenn es eine andere Sprache als der Standard ist, dann muss die richtige CE-uid gesucht werden
		if($languageId <> 0) {
		    $query = $this->getTranslatedRecord($uid, $languageId);
//		    debug($query);
		    // Wenn die Suche nach einem übersetzten Record nicht erfolgreich ist, dann muss auf das Fallback zurückgegriffen werden
		    if(count($query) <> 0) {
			$uid = $query[0]['uid'];
		    };
//		    debug('uid-NEU: ' . $uid);
		}

		// Hier werden die Dateien abgefragt.
		$fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');
		$fileObjects = $fileRepository->findByRelation('tt_content', 'settings.gpxFile', $uid);
		$newFileArray = [];
		foreach ($fileObjects as $fileObject) {
		    array_push($newFileArray, '/fileadmin' . $fileObject->getIdentifier());
		}
//		debug($newFileArray);
		$gpxFilesCount = count($newFileArray);
//		debug('gpxFilesCount: ' . $gpxFilesCount);

		// Vollständige Namen in einem kommaseparierten String umwandeln
		$gpxFile = implode(',', $newFileArray);
//		debug($gpxFile);

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
			// Holt die Sprachbezeichnung "de" oder "en" direkt aus dem Request-Objekt des Controllers
			$languageAttribute = $this->request->getAttribute('language');
			$this->pageLanguage = $languageAttribute ? $languageAttribute->getLocale()->getLanguageCode() : 'de';
//			debug($this->pageLanguage);

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

//debug($array['container']);
				// Falls es sich um Bilder mit Geotags handelt
				$geotagged = array('imageGeotagged','imageGeotaggedDir');
				if (in_array($array['container']['settings']['gpxMapWaypointType'], $geotagged)) {
					// Es handelt sich um eine Bilddatei
//					if ($array['container']['settings']['gpxMapWaypointImage'] != '') {
					if ($array['container']['settings']['gpxMapWaypointType'] == 'imageGeotagged') {
						$flexformLinkString = $array['container']['settings']['gpxMapWaypointImage'];
						$finalFolderUrl = '';
						$fileUid = 0;

//						if (!empty($flexformLinkString) && str_starts_with($flexformLinkString, 't3://file')) {
						if (!empty($flexformLinkString)) {
							if (str_starts_with($flexformLinkString, 't3://file')) {

								// 1. Query-String auslesen ('uid=3938')
								$queryString = parse_url($flexformLinkString, PHP_URL_QUERY);

								if (!empty($queryString)) {
									$queryParams = [];
									parse_str($queryString, $queryParams);

									if (isset($queryParams['uid'])) {
										$fileUid = (int)$queryParams['uid'];

										try {
											// 2. ResourceFactory holen & Datei-Objekt über die UID laden
											$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
											$fileObject = $resourceFactory->getFileObject($fileUid);

											// 3. Den kompletten Dateinamen mit Pfad auslesen
											$fileName = ltrim($fileObject->getPublicUrl(), '/');
                
										} catch (\Exception $e) {
											// Fängt Fehler ab, falls die Datei physisch vom Server gelöscht wurde
											$fileName = '';
										}
									}
								}
							} else {
								// Abwärtskompatibilität: Falls im Altsystem bereits ein nativer Pfad eingetragen war
								$fileUid = (int)$flexformLinkString;
								debug($fileUid);

							}
						}
						$imageGeotaggedSource = $fileName;
					}

					// Wenn es ein Verzeichnis ist
					if ($array['container']['settings']['gpxMapWaypointType'] == 'imageGeotaggedDir') {
						// Deine Ausgangsvariable (inkl. Bereinigung von eventuellen Zeilenumbrüchen/Leerzeichen)
						$flexformLinkString = $array['container']['settings']['gpxMapWaypointImageFolder'];
						$finalFolderUrl = '';
						if (!empty($flexformLinkString)) {
							// Prüfen, ob es sich um eine moderne t3://folder Verknüpfung handelt
							if (str_starts_with($flexformLinkString, 't3://folder')) {
								try {
									// Native PHP-Funktionen nutzen, um die Query-Parameter zu zerlegen
									$parsedUrl = parse_url($flexformLinkString);
									$queryParams = [];
									if (isset($parsedUrl['query'])) {
										parse_str($parsedUrl['query'], $queryParams);
									}
									// Storage-UID und Verzeichnispfad aus den Parametern extrahieren
									$storageUid = isset($queryParams['storage']) ? (int)$queryParams['storage'] : 1;
									$folderIdentifier = isset($queryParams['identifier']) ? urldecode($queryParams['identifier']) : '';
									if (!empty($folderIdentifier)) {
										// Die ResourceFactory ist in TYPO3 13 unverändert verfügbar
										$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);

										// Kombinierten Identifier bauen (z.B. "1:/pageResources/motorcycle/...")
										$combinedIdentifier = $storageUid . ':' . $folderIdentifier;

										// Ordner-Objekt aus dem Core holen
										$folderObject = $resourceFactory->getFolderObjectFromCombinedIdentifier($combinedIdentifier);

										// Den relativen Pfad als String auslesen ("fileadmin/pageResources/...")
										// ltrim und rtrim entfernen den führenden und abschließenden Slash
										$finalFolderUrl = ltrim(rtrim($folderObject->getPublicUrl(), '/'), '/');
									}
								} catch (\Exception $e) {
									// Falls der Ordner auf der Festplatte nicht existiert, Fehler abfangen
									$finalFolderUrl = '';
								}
							} else {
								// Abwärtskompatibilität: Falls im Altsystem bereits eine Image-Datei (uid) eingetragen war
								$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
								$fileObject = $resourceFactory->getFileObject($flexformLinkString);
								$finalFolderUrl = ltrim(dirname($fileObject->getPublicUrl()), '/');
							}
						}
						$imageGeotaggedSource = $finalFolderUrl;
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
							$flexformLinkString = $array['container']['settings']['gpxMapWaypointImage'];
							$fileUid = 0;
							if (!empty($flexformLinkString) && str_starts_with($flexformLinkString, 't3://file')) {
								// 1. Zerlegt den String in seine URL-Bestandteile (liefert den Query-Teil: 'uid=3938')
								$queryString = parse_url($flexformLinkString, PHP_URL_QUERY);
								if (!empty($queryString)) {
									$queryParams = [];
									// 2. Parsed den Query-String in ein sauberes PHP-Array
									parse_str($queryString, $queryParams);

									// 3. Extrahiert die UID und wandelt sie zur Sicherheit in einen Integer um
									if (isset($queryParams['uid'])) {
										$fileUid = (int)$queryParams['uid'];
									}
								} 
							} else {
								// Sonst ist es eine file Uid in der alten Form
								$fileUid = (int)$flexformLinkString;
							}
							$resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
							$fileObject = $resourceFactory->getFileObject($fileUid);

							// Vollen Dateinamen auslesen
							$gpxMapWaypointImage = '/fileadmin' . $fileObject->getIdentifier();
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

		return $this->htmlResponse();
	}
}
