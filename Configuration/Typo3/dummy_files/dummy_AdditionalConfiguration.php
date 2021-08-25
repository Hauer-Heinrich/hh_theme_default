<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

/*
    !IMPORTANT!
    The file '$databaseCredentialsFile' is not versioned and must be created and changed!
    For security reasons please create the database accesses outside the document roots!

    Die Datei '$databaseCredentialsFile' wird nicht mit Versioniert und muss extra angelegt und geändert werden!
    aus Sicherheitsgründen bitte die Datenbank zugänge außerhalb des document roots anlegen!
*/

$themeDefaultAdditionalConfiguration = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/typo3conf/ext/[ExtensionKey]/Configuration/Typo3/AdditionalConfiguration.php';
if (file_exists($themeDefaultAdditionalConfiguration)) { require_once ($themeDefaultAdditionalConfiguration); }
