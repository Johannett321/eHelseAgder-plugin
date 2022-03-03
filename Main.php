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
require 'ProsjektRedigering.php';
require 'OnPluginActivation.php';
require 'SQLTool.php';
require 'ProsjektListe.php';
require 'ProsjektSide.php';
require 'CollapsibleManager.php';
require 'style.php';

error_log("--------------------------------------",0);

function cPrint($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('" . $output . "');</script>";
}

function kreverInnlogging() {
    if (htmlspecialchars($_POST["uname"]) == "johannett321" && htmlspecialchars($_POST["password"]) == "julebrus") {
        cPrint("Riktig innlogging");
    }else {
        ?>
        <script>alert("Feil innloggingsinfo!");window.location.href = '../logg-inn/';</script>
        <?php
        exit;
    }
}