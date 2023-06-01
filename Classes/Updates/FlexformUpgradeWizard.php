<?php

declare(strict_types=1);

namespace Wok\WokGpxviewer\Updates;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\RepeatableInterface;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Install\Updates\ChattyInterface;

#[UpgradeWizard('flexformUpgradeWizard')]
class FlexformUpgradeWizard implements UpgradeWizardInterface, RepeatableInterface, ChattyInterface
{
    /**
     * @var OutputInterface
     */
    protected $output;

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    /**
     * Return the identifier for this wizard
     * This should be the same string as used in the ext_localconf.php class registration
     */
/*
    public function getIdentifier(): string
    {
        return 'flexformUpgradeWizard';
    }
*/
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
        // Get records which have to be updated
        $records = $this->getMigrationRecords();

        // This is only needed if flexform content should be converted ta an array
//        $this->flexFormService = GeneralUtility::makeInstance(FlexFormService::class);

        foreach ($records as $record) {
            // Get Flexform date from field pi_flexform
            $flexFormData = GeneralUtility::xml2array($record['pi_flexform']);

            // Gibt ein Array nur mit den Flexform-Werten aus
//            $flexForm = $this->flexFormService->convertFlexformContentToArray($record['pi_flexform']);

            // Check if settings.gpxFile is available in the flexform and make sure value isn't empty ""
            // Only for these conditions a migration will be performed
            if(isset($flexFormData['data']['options']['lDEF']['settings.gpxFile']['vDEF']) AND $flexFormData['data']['options']['lDEF']['settings.gpxFile']['vDEF'] <> '') {
//                debug($flexFormData['data']['options']['lDEF']['settings.gpxFile']['vDEF']);
                // settings.gpxFile can be filled with sys_file numbers separated with comma
                $gpxFileArray = explode(",",$flexFormData['data']['options']['lDEF']['settings.gpxFile']['vDEF']);

                // For every value in $gpxFileArray an entry in table sys_file_reference has to be generated 
                // Values in $gpxFileArray are referencing to uid of table sys_file
                // value for keeping track of sorting
                $sorting = 0;
                foreach ($gpxFileArray as $gpxFile) {
                    ++$sorting;
                    // Create entries for GPX-files in table sys_file_reference
                    // following values are needed:
                    // pid
                    // uid_local (sys_file uid)
                    // uid_foreign (uid of content element)
                    // tablenames (tt_content)
                    // fieldname (settings.gpxFile)
                    // sorting_foreign (counter for sorting)
                    $this->createSysFileReference($record['pid'], intval($gpxFile), $record['uid'], $record['tstamp'], $record['crdate'], 'tt_content', 'settings.gpxFile', $sorting);
                }

                // Finally the field pi_flexform in table tt_content has to be updated
                // Update field settings.gpxFile with number of related files
                $flexFormData['data']['options']['lDEF']['settings.gpxFile']['vDEF'] = count($gpxFileArray);

                // Generate new flexform for field pi_flexform
                $newFlexform = GeneralUtility::array2xml($flexFormData);

                // The previous flexform generation deletes the "." in settings.gpx... and have to be restored by the following line
                $newFlexform = str_replace('settingsgpx', 'settings.gpx', $newFlexform);

                // Update tt_content field pi_flexform
                $this->updateContentElement($record['uid'], $newFlexform);

            }

/*
   Funktioniert leider nicht so. Muss komplett geändert werden.
   Das wäre für die Einträge der Wegpunkte ...
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
*/

        }

        // Finally display a message
        if (count($records) > 0) {
            $this->output->writeln('Performing ' . count($records) . ' changes in table tt_content field pi_flexform.');
        }

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
            ->select('uid', 'pid', 'tstamp', 'crdate', 'sys_language_uid', 'list_type', 'pi_flexform')
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
     * Adds sys_file_reference entries for GPX files
     *
     * @param int $pid
     * @param int $uid_local
     * @param int $uid_foreign
     * @param int $tstamp
     * @param int $crdate
     * @param string $tablename
     * @param string $field
     * @param int $sorting
     */
    protected function createSysFileReference(int $pid, int $uid_local, int $uid_foreign, int $tstamp, int $crdate, string $tablename, string $field, int $sorting): void
    {
//        $string = "PID: " . $pid . " uid_local (sys_file): " . $uid_local . " uid_foreign (CE uid): " . $uid_foreign . " " . $tablename . " " . $field . " Sort: " . $sorting;
//        debug($string);

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');
        $queryBuilder->insert('sys_file_reference')
            ->values([
                'tstamp' => $tstamp,
                'crdate' => $crdate,
                'pid' => $pid,
                'uid_local' => $uid_local,
                'tablenames' => $tablename,
                'uid_foreign' => $uid_foreign,
                'fieldname' => $field
            ])->execute();
    }

    /**
     * Updates pi_flexform in table tt_content for the uid of the given content element
     *
     * @param int $uid
     * @param string $flexform
     */
    protected function updateContentElement(int $uid, string $flexform): void
    {
//        debug($uid);
//        debug($flexform);

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
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }


}
