<?php

function install_plugin() {
    error_log("------- REINSTALLERING AV PLUGIN -------");
    deleteAllUploads();
    createUploadsDirectory();
    dropAllTables();
    create_table_prosjekter();
    create_table_collapsible();
    create_table_nyhetsartikler();
    create_table_arrangementer();
    createPluginImages();
    wp_redirect("../../../wp-admin/admin.php?page=prosjekter&message=Ferdig! Pluginen er innstallert på nytt!");
    exit;
}

function createPluginImages() {
    mkdir("wp-content/uploads/eHelseAgderPlus");

    // Get array of all source files
    $files = scandir("wp-content/plugins/eHelseAgderPlugin/images");
    // Identify directories
    $source = "wp-content/plugins/eHelseAgderPlugin/images/";
    $destination = "wp-content/uploads/eHelseAgderPlus/";
    // Cycle through all source files
    foreach ($files as $file) {
        if (in_array($file, array(".",".."))) continue;
        // If we copied this successfully, mark it for deletion
        if (!copy($source.$file, $destination.$file)) {
            error_log("Feilet med å flytte fil: " . $source.$file);
        }
    }
}

function deleteAllUploads(){
    deleteDir("wp-content/uploads/minefiler/");
    deleteDir("wp-content/uploads/minebilder/");
}

function createUploadsDirectory(){
    mkdir("wp-content/uploads/minefiler");
    mkdir("wp-content/uploads/minebilder");
}

function dropAllTables() {
    $tables[0] = getProsjekterDatabaseRef();
    $tables[1] = getDraftProsjekterDatabaseRef();
    $tables[2] = getNyhetsartiklerDatabaseRef();
    $tables[3] = getDraftNyhetsartiklerDatabaseRef();
    $tables[4] = getCollapsiblesDatabaseRef();
    $tables[5] = getArrangementerDatabaseRef();
    $tables[6] = getDraftArrangementerDatabaseRef();

    for ($i  = 0; $i < sizeof($tables); $i++) {
        error_log("Sletter SQL tabell: " . $tables[$i]);
        $sqlCommand = "DROP TABLE IF EXISTS $tables[$i]";
        global $wpdb;
        $wpdb->query($sqlCommand);
    }
}

function create_table_prosjekter() {
    createProsjekterTable(getProsjekterDatabaseRef());
    createProsjekterTable(getDraftProsjekterDatabaseRef());
}

function createProsjekterTable($formatted_table_name) {
    $sqlCommand = "CREATE TABLE IF NOT EXISTS $formatted_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        project_name varchar(100) NOT NULL,
        undertittel varchar(100),
        bilde varchar(100),
        ledernavn varchar(35),
        ledermail varchar(60),
        ledertlf varchar(15),
        prosjektstart varchar(14),
        prosjektslutt varchar(14),
        prosjekteierkommuner varchar(40),
        sokerkommuner varchar(200),
        samarbeidspartnere varchar(200),
        project_text varchar(1700) NOT NULL,
        publisert int(1),
        PRIMARY KEY  (id)
    );";

    createTable($formatted_table_name, $sqlCommand);
}

function create_table_collapsible() {
    createCollapsibleTable(getCollapsiblesDatabaseRef());
    createCollapsibleTable(getDraftCollapsibleDatabaseRef());
}

function createCollapsibleTable($formatted_table_name) {
    $sqlCommand = "CREATE TABLE IF NOT EXISTS $formatted_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        egendefinert_navn varchar(65),
        innhold varchar(3400),
        collapsible_type varchar(100),
        link varchar(200),
        fil_id smallint,
        prosjekt_id mediumint(9) NOT NULL,
        PRIMARY KEY (id)
    );";

    createTable($formatted_table_name, $sqlCommand);
}

function create_table_nyhetsartikler() {
    createNyhetsArtiklerTable(getNyhetsartiklerDatabaseRef());

    createNyhetsArtiklerTable(getDraftNyhetsartiklerDatabaseRef());
}

function createNyhetsArtiklerTable($formatted_table_name) {
    $sqlCommand = "CREATE TABLE IF NOT EXISTS $formatted_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        tittel varchar(100),
        ingress varchar(200),
        bilde varchar (100),
        skrevet_av varchar (100),
        endret_av varchar(100),
        rolle varchar (100),
        dato_skrevet date,
        dato_endret date,
        tilknyttet_prosjekt smallint(5),
        innhold varchar(15000),
        publisert smallint,
        antall_lesere int,
        PRIMARY KEY (id)
    );";

    createTable($formatted_table_name, $sqlCommand);
}

function create_table_arrangementer() {
    createArrangementerTable(getArrangementerDatabaseRef());

    createArrangementerTable(getDraftArrangementerDatabaseRef());
}

function createArrangementerTable($formatted_table_name) {
    $sqlCommand = "CREATE TABLE IF NOT EXISTS $formatted_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        tittel varchar(100),
        kort_besk varchar(200),
        bilde varchar (100),
        start_dato date,
        slutt_dato date,
        sted varchar(100),
        arrangor varchar(100),
        kontaktperson varchar(100),
        kontaktperson_mail varchar(100),
        innhold varchar(15000),
        pamelding_link varchar(500),
        vedlegg varchar(2000),
        publisert smallint,
        PRIMARY KEY (id)
    );";

    createTable($formatted_table_name, $sqlCommand);
}