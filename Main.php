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

//COLLAPSIBLE_EGENDEFINERT=1
//COLLAPSIBLE_LEVERANDØRER=2
//COLLAPSIBLE_PROJECT_TEAM=3
//COLLAPSIBLE_MER_INFO=4
//COLLAPSIBLE_MILEPÆLER=5

require 'Tools/Essentials.php';
require 'Tools/Tools.php';
require 'Tools/CommonHTMLElements.php';

include "SokeSide.php";

include 'Tools/PageMessages.php';
require 'Tools/JavascriptCheckerTool.php';
require 'Tools/UploadFileTool.php';
require 'AdminPanel.php';
require 'Login/LoggInnSide.php';
require 'Login/MinSide.php';
require 'Prosjekt/OpprettProsjekt/OpprettProsjekt.php';
require 'OnPluginActivation.php';
require 'Tools/SQLTool.php';

require 'Prosjekt/ProsjekterTools.php';
require 'Prosjekt/ProsjektListe.php';
require 'Prosjekt/VisProsjekt.php';
require 'Prosjekt/CollapsibleManager.php';

require 'Nyhetsartikkel/OpprettNyhetsartikkel/OpprettNyhetsartikkel.php';
require 'Nyhetsartikkel/NyhetsArkiv.php';
require 'Nyhetsartikkel/VisArtikkel.php';

require 'Arrangement/OpprettArrangement/OpprettArrangement.php';
require 'Arrangement/VisArrangement.php';
require 'Arrangement/ArrangementerListe.php';
require 'Arrangement/ArrangementArkiv.php';

include 'Tools/SocialMediaTool.php';
include 'Login/LoginKnapp.php';

add_action( 'wp_enqueue_scripts', 'enqueue_my_scripts' );

function enqueue_my_scripts() {
    wp_enqueue_style("EHELSEAGDERCSS", plugins_url() . "/eHelseAgderPlugin/style.css");
    wp_enqueue_style("GoogleMaterialIcons", "https://fonts.googleapis.com/icon?family=Material+Icons");

    if (debugModeIsOn()) {
        error_log("WARNING: DEBUG MODE IS ON!");
        //Loader en custom css fil under utvikling.
        wp_enqueue_style("MYCUSTOMDEVCSS", plugins_url() . "/eHelseAgderPlugin/MyCustomStyle.css");
    }
}

error_log("--------------------------------------",0);