<?php

function install_plugin() {
    create_table_prosjekter();
    create_table_collapsible();
    return "eHelseAgder+ installert! Vennligst gå inn på wp-admin på nytt";
}

function create_table_prosjekter() {
    $formatted_table_name = getFormattedTableName("eha_prosjekter");

    $sqlCommand = "CREATE TABLE IF NOT EXISTS $formatted_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        project_name varchar(100) NOT NULL,
        undertittel varchar(100),
        ledernavn varchar(35),
        ledermail varchar(60),
        ledertlf varchar(15),
        prosjektstart varchar(14),
        prosjektslutt varchar(14),
        kostnadsramme varchar(14),
        project_text varchar(1700) NOT NULL,
        publisert int(1),
        PRIMARY KEY  (id)
    ) $charset_collate;";

    createTable($formatted_table_name, $sqlCommand);
}

function create_table_collapsible() {
    $formatted_table_name = getFormattedTableName("eha_collapsible");

    $sqlCommand = "CREATE TABLE IF NOT EXISTS $formatted_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        egendefinert_navn varchar(65),
        innhold varchar(3400),
        collapsible_type varchar(100),
        link varchar(200),
        fil_id smallint,
        prosjekt_id mediumint(9) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    createTable($formatted_table_name, $sqlCommand);
}