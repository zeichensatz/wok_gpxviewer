<?php

declare(strict_types=1);

namespace Wok\WokGpxviewer\Updates;

//use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\RepeatableInterface;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

final class FlexformUpgradeWizard implements UpgradeWizardInterface, RepeatableInterface
{
    /**
     * Return the identifier for this wizard
     * This should be the same string as used in the ext_localconf.php class registration
     */
    public function getIdentifier(): string
    {
        return 'wokGpxviewer_flexformUpgradeWizard';
    }

    /**
     * Return the speaking name of this wizard
     */
    public function getTitle(): string
    {
        return 'Flexform Upgrade Wizard for GPXViewer [wok_gpxviewer]';
    }

    /**
     * Return the description for this wizard
     */
    public function getDescription(): string
    {
        return 'Flexform for file selection has to be changed for TYPO3 12 upgrade';
    }

    /**
     * Execute the update
     *
     * Called when a wizard reports that an update is necessary
     */
    public function executeUpdate(): bool
    {
        // Add your logic here
        $records = $this->getMigrationRecords();
        $this->flexFormService = GeneralUtility::makeInstance(FlexFormService::class);

        foreach ($records as $record) {
            $flexFormData = GeneralUtility::xml2array($record['pi_flexform']);

            // Gibt ein Array nur mit den Flexform-Werten aus
//            $flexForm = $this->flexFormService->convertFlexformContentToArray($record['pi_flexform']);
//            debug($flexForm);

            // uid
            debug($record['uid']);

            // settings.gpxFile muss vorhanden sein und darf nicht "" sein
            if(isset($flexFormData['data']['options']['lDEF']['settings.gpxFile']['vDEF']) AND $flexFormData['data']['options']['lDEF']['settings.gpxFile']['vDEF'] <> '') {
//                debug($flexFormData['data']['options']['lDEF']['settings.gpxFile']['vDEF']);
                // settings.gpxFile kann mehrere Einträge enthalten
                $gpxFileArray = explode(",",$flexFormData['data']['options']['lDEF']['settings.gpxFile']['vDEF']);
                // Für jeden Eintrag in $gpxFileArray muss in der sys_file_reference ein Verweis eingetragen werden, 
                // wobei der Wert im $gpxFileArray dem sys_file entspricht
                // benötigt wird pid (uid des CE), tablesname (tt_content), fieldname (settings.gpxFile), sorting_foreign (das ist ein Zähler für die Sortierung), CE, sys_file (Wert), 
            }

            // Wenn ein settings.waypoints vorhanden ist
            if(isset($flexFormData['data']['s_Waypoints']['lDEF']['settings.waypoints']['el'])) {
            //    debug($flexFormData['data']['s_Waypoints']['lDEF']['settings.waypoints']['el']);
                $counter = 1;
                foreach ($flexFormData['data']['s_Waypoints']['lDEF']['settings.waypoints']['el'] as $element) {
//                    debug($element);
                    // Nur wenn settings.gpxMapWaypoint ungleich "" ist, muss eine Migration erfolgen
                    if($element['container']['el']['settings.gpxMapWaypointImage']['vDEF'] <> '') {
                        debug($element['container']['el']['settings.gpxMapWaypointImage']['vDEF']);
                    }
                    ++$counter;
                }
            }

            // Zuletzt Update des Feldes pi_flexform der tt_content
#            $this->updateContentElement($record['uid'], $newFlexform);
 


        }

/*
#        debug('TEST: ' . $records);
        $testarray = $this->getMigrationRecords();

#        $flexFormData = GeneralUtility::xml2array($record['pi_flexform']);
            $flexFormData = GeneralUtility::xml2array($testarray['750']['pi_flexform']);
#        debug($flexFormData);
        debug($flexFormData['data']['options']['lDEF']['settings.gpxFile']['vDEF']);
        # Anzahl der Dateien über array feststellen
        $flexFormData['data']['options']['lDEF']['settings.gpxFile']['vDEF'] = '1';
        $newFlexformData = GeneralUtility::array2xml($flexFormData);
        debug($newFlexformData);
*/
        return true;
    }

    /**
     * Is an update necessary?
     *
     * Is used to determine whether a wizard needs to be run.
     * Check if data for migration exists.
     *
     * @return bool Whether an update is required (TRUE) or not (FALSE)
     */
    public function updateNecessary(): bool
    {
        // Add your logic here
        return $this->checkIfWizardIsRequired();
    }

    public function checkIfWizardIsRequired(): bool
    {
        return count($this->getMigrationRecords()) > 0;
    }

    /**
     * Returns all records for list_type "wokgpxviewer_gpxtracks"
     */
    protected function getMigrationRecords(): array
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        return $queryBuilder
            ->select('uid', 'list_type', 'pi_flexform')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'list_type',
                    $queryBuilder->createNamedParameter('wokgpxviewer_gpxtracks')
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * Updates pi_flexform of the given content element UID
     *
     * @param int $uid
     * @param string $flexform
     */
    protected function updateContentElement(int $uid, string $flexform): void
    {
        debug($uid);
        debug($flexform);

/*
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->update('tt_content')
            ->set('pi_flexform', $flexform)
            ->where(
                $queryBuilder->expr()->in(
                    'uid',
                    $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT)
                )
            )
            ->executeStatement();
*/
    }

    /**
     * Returns an array of class names of prerequisite classes
     *
     * This way a wizard can define dependencies like "database up-to-date" or
     * "reference index updated"
     *
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        // Add your logic here
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }

}
