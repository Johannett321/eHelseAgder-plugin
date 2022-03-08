<?php
/*
Plugin Name: eHelseAgder+
Plugin URI:
Description: En spesiallaget plugin for eHelseAgder.no
Author: Johan
Author URI: https://johansvartdal.com
Version: 1.0.0
*/

if ( ! defined( 'ABSPATH') ) {
    exit;
}

$testVar = "HEIHEI";

//COLLAPSIBLE_EGENDEFINERT=1
//COLLAPSIBLE_LEVERANDØRER=2
//COLLAPSIBLE_PROJECT_TEAM=3
//COLLAPSIBLE_MER_INFO=4
//COLLAPSIBLE_MILEPÆLER=5

require 'AdminPanel.php';
require 'LoggInn.php';
require 'Prosjekt/OpprettProsjekt/ProsjektRedigering.php';
require 'OnPluginActivation.php';
require 'SQLTool.php';
require 'Prosjekt/ProsjektListe.php';
require 'Prosjekt/ProsjektSide.php';
require 'Prosjekt/CollapsibleManager.php';
require 'style.php';
require 'Nyhetsartikkel/OpprettNyhetsartikkel/OpprettNyhetsartikkel.php';

error_log("--------------------------------------",0);

function kreverInnlogging() {
    if (htmlspecialchars($_POST["uname"]) == "johannett321" && htmlspecialchars($_POST["password"]) == "julebrus") {
        error_log("RIKTIG INNLOGGING!");
    }else {
        ?>
        <script>alert("Feil innloggingsinfo!");window.location.href = '../logg-inn/';</script>
        <?php
        exit;
    }
}

function getProsjekterDatabaseRef() {
    return getFormattedTableName("eha_prosjekter");
}

function getCollapsiblesDatabaseRef() {
    return getFormattedTableName("eha_collapsible");
}

function getNyhetsartiklerDatabaseRef() {
    return getFormattedTableName("eha_nyhetsartikler");
}