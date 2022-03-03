<?php

function getFormattedTableName($tableName) {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $formatted_table_name = $wpdb->prefix . $tableName;
    return $formatted_table_name;
}

function createTable($formatted_table_name, $sqlCommand) {
    error_log("Oppretter database...",0);

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sqlCommand );
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