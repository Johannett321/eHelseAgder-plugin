<?php

function install_plugin() {
    error_log("------- REINSTALLERING AV PLUGIN -------");
    dropAllTables();
    create_table_prosjekter();
    create_table_collapsible();
    create_table_nyhetsartikler();
    wp_redirect("../../../wp-admin/admin.php?page=prosjekter&message=Ferdig! Pluginen er innstallert på nytt!");
    exit;
}

function dropAllTables() {
    $tables[0] = getProsjekterDatabaseRef();
    $tables[1] = getNyhetsartiklerDatabaseRef();
    $tables[2] = getCollapsiblesDatabaseRef();

    for ($i  = 0; $i < sizeof($tables); $i++) {
        error_log("Sletter SQL tabell: " . $tables[$i]);
        $sqlCommand = "DROP TABLE IF EXISTS $tables[$i]";
        global $wpdb;
        $wpdb->query($sqlCommand);
    }
}

function create_table_prosjekter() {
    $formatted_table_name = getProsjekterDatabaseRef();

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
        samarbeidspartnere varchar(40),
        project_text varchar(1700) NOT NULL,
        publisert int(1),
        PRIMARY KEY  (id)
    );";

    createTable($formatted_table_name, $sqlCommand);
}

function create_table_collapsible() {
    $formatted_table_name = getCollapsiblesDatabaseRef();

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
    $formatted_table_name = getNyhetsartiklerDatabaseRef();

    $sqlCommand = "CREATE TABLE IF NOT EXISTS $formatted_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        tittel varchar(100),
        ingress varchar(200),
        bilde varchar (100),
        skrevet_av varchar (100),
        endret_av varchar(100),
        rolle varchar (100),
        dato_skrevet varchar(100),
        dato_endret varchar(100),
        tilknyttet_prosjekt smallint(5),
        innhold varchar(15000),
        publisert smallint,
        antall_lesere int,
        PRIMARY KEY (id)
    );";

    createTable($formatted_table_name, $sqlCommand);
}