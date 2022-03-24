<?php

add_action("admin_menu", "addMenu");


function addMenu() {
    add_menu_page("eHelseAgder+", "eHelseAgder+", 4, "prosjekter", "prosjekterMenu");
}

function prosjekterMenu() {
    ?>
    <h3>Her kommer administrasjonspanelet for eHelseAgder+</h3>
    <form action = "../wp-json/ehelseagderplugin/api/installerPlugin" method ="POST">
        <input type = "submit" value="Kjør førstegangsinstallasjon av plugin"/>
    </form>
    <?php
}

add_action( 'rest_api_init', 'add_install_plugin_post_receiver');

function add_install_plugin_post_receiver(){
    register_rest_route( 'ehelseagderplugin/api', '/installerPlugin', array(
        'methods' => 'POST',
        'callback' => 'install_plugin',
    ));
}