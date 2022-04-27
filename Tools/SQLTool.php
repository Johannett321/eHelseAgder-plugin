<?php

function getFormattedTableName($tableName) {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $formatted_table_name = $wpdb->prefix . $tableName;
    return $formatted_table_name;
}

function createTable($formatted_table_name, $sqlCommand) {
    error_log("Opretter SQL tabell: " . $formatted_table_name);

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sqlCommand );
}

function getProsjekterDatabaseRef() {
    return getFormattedTableName("eha_prosjekter");
}

function getDraftProsjekterDatabaseRef() {
    return getFormattedTableName("eha_prosjekter_utkast");
}

function getCollapsiblesDatabaseRef() {
    return getFormattedTableName("eha_collapsible");
}

function getDraftCollapsibleDatabaseRef() {
    return getFormattedTableName("eha_collapsible_utkast");
}

function getNyhetsartiklerDatabaseRef() {
    return getFormattedTableName("eha_nyhetsartikler");
}

function getDraftNyhetsartiklerDatabaseRef() {
    return getFormattedTableName("eha_nyhetsartikler_utkast");
}

function getArrangementerDatabaseRef() {
    return getFormattedTableName("eha_arrangementer");
}

function getDraftArrangementerDatabaseRef() {
    return getFormattedTableName("eha_arrangementer_utkast");
}

function getChangelogDatabaseRef() {
    return getFormattedTableName("eha_changelog");
}

/*----------- LAGRE NOE I DATABASEN ---------------
function insertIntoTable($formatted_table_name, $columns_and_value) {
    global $wpdb;
    $wpdb->insert($formatted_table_name, array("project_name" => "testProsjekt"), array("%s"));
}
*/

/*----------- LESE NOE FRA DATABASEN ---------------
function readFromTable() {
    $posts = $wpdb->get_results("SELECT project_name FROM $formatted_table_name
    ORDER BY ID ASC LIMIT 0,4");
    return $posts[0]->project_name;
}
*/