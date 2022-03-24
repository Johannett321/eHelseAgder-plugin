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

global $debugMode;
$debugMode = false;

global $runningOnLocalHost;
$runningOnLocalHost = true;

require 'UploadFileTool.php';
require 'AdminPanel.php';
require 'Login/LoggInn.php';
require 'Prosjekt/OpprettProsjekt/ProsjektRedigering.php';
require 'OnPluginActivation.php';
require 'SQLTool.php';
require 'Prosjekt/ProsjektListe.php';
require 'Prosjekt/ProsjektSide.php';
require 'Prosjekt/CollapsibleManager.php';
require 'Nyhetsartikkel/OpprettNyhetsartikkel/OpprettNyhetsartikkel.php';
require 'Nyhetsartikkel/ListNyhetsartikler.php';
require 'Nyhetsartikkel/VisArtikkel.php';
include 'FacebookTool.php';

if ($debugMode) {
    //Loader en custom css fil under utvikling.
    wp_enqueue_style("MYCUSTOMDEVCSS", plugins_url() . "/eHelseAgderPlugin/MyCustomStyle.css");
}

wp_enqueue_style("EHELSEAGDERCSS", plugins_url() . "/eHelseAgderPlugin/style.css");

error_log("--------------------------------------",0);

function getProsjekterDatabaseRef() {
    return getFormattedTableName("eha_prosjekter");
}

function getCollapsiblesDatabaseRef() {
    return getFormattedTableName("eha_collapsible");
}

function getNyhetsartiklerDatabaseRef() {
    return getFormattedTableName("eha_nyhetsartikler");
}