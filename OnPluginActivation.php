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
    deleteDir("wp-content/uploads/eHelseAgderPlus/");
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
        project_name varchar(150) NOT NULL,
        undertittel varchar(150),
        bilde varchar(150),
        ledernavn varchar(45),
        ledermail varchar(70),
        ledertlf varchar(25),
        prosjektstart varchar(24),
        prosjektslutt varchar(24),
        prosjekteierkommuner varchar(50),
        sokerkommuner varchar(250),
        samarbeidspartnere varchar(250),
        project_text varchar(1750) NOT NULL,
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
        egendefinert_navn varchar(75),
        innhold varchar(3450),
        collapsible_type varchar(150),
        link varchar(250),
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
        ingress varchar(250),
        bilde varchar (150),
        skrevet_av varchar (150),
        endret_av varchar(150),
        rolle varchar (150),
        dato_skrevet date,
        dato_endret date,
        tilknyttet_prosjekt smallint(5),
        innhold varchar(15500),
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
        kort_besk varchar(250),
        bilde varchar (150),
        start_dato date,
        slutt_dato date,
        sted varchar(150),
        arrangor varchar(150),
        kontaktperson varchar(150),
        kontaktperson_mail varchar(150),
        innhold varchar(15500),
        pamelding_link varchar(550),
        vedlegg varchar(2050),
        publisert smallint,
        PRIMARY KEY (id)
    );";

    createTable($formatted_table_name, $sqlCommand);
}