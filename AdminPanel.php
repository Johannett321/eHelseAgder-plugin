<?php

add_action("admin_menu", "addMenu");


function addMenu() {
    add_menu_page("eHelseAgder+", "eHelseAgder+", 4, "prosjekter", "prosjekterMenu");
}

function prosjekterMenu() {
    ?>
        <div class = "pageCenter">
            <?php
            if (isset($_GET['message'])) {
                showAdminMessage($_GET['message']);
            }
            ?>
            <div class="innholdsBox">
                <div class = "centerer">
                    <img src = "../../../wp-content/uploads/eHelseAgderPluss/PluginLogo.png"/>
                    <h1>Viktig informasjon!</h1>
                    <form id = "myform" action = "../wp-json/ehelseagderplugin/api/installerPlugin" method ="POST">
                        <p>
                            Denne siden resetter pluginen og all data som er fylt ut. Ved å fortsette blir alle prosjekter,
                            nyhetsartikler og arrangementer slettet. For å bekrefte at du ønsker å slette alt, må du skrive
                            <i>"Slett alt"</i> (uten anførselstegn) i tekstboksen under.
                        </p>
                        <h3>Vil du slette alt?</h3>
                        <input id = "confirmField" type="text" placeholder="Skriv her"/>
                        <div class="resetContainer">
                            <input id = "slettAltKnapp" type = "button" class = "button" value="Reinstaller plugin"/>
                        </div>
                    </form>
                </div>
                <div class = "credits">
                    Copyright © <?php echo date("Y"); ?> NextGen. Alle rettigheter forbeholdes.
                </div>
            </div>
        </div>

        <style>
            body {
                background-color: #EEEEEE !important;
            }

            .pageCenter {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .innholdsBox {
                width: 700px;
                height: 500px;
                padding: 20px;

                text-align: center;
                background-color: white;
                box-shadow: #555555 0px 2px 10px;
                border-radius: 10px;
            }

            .centerer {
                margin-top: 50px;
            }

            .innholdsBox img {
                width: 300px;
            }

            .innholdsBox p {
                width: 500px;
                font-size: 17px;
                margin-left: auto;
                margin-right: auto;
            }

            .innholdsBox h1 {
                margin-top: 30px;
            }

            .innholdsBox h3 {
                margin-top: 30px;
            }

            .resetContainer {
                margin-top: 10px;
            }

            .credits {
                width: 700px;
                position: absolute;
                left: 50%;
                bottom: 10px;
                transform: translateX(-50%);
                font-size: 13px;
                color: gray;
            }

            .adminInfo {
                width: 100%;
                background-color: #f3f8f2;;
                margin: 0px 0px 20px 0px;
                box-shadow: #BBBBBB 0px 2px 10px;

                border-radius: 10px;
                border-color: #7cc48c;
                border-width: 2px;
                border-style: solid;

                font-size: 18px;
                text-align: center;
            }

            .adminInfo h5 {
                display: inline-block;
            }
        </style>

        <script type="text/javascript">
            const deleteButton = document.getElementById('slettAltKnapp');
            const confirmField = document.getElementById('confirmField');
            const myform = document.getElementById('myform');

            deleteButton.onclick = function() {
                if (confirmField.value == "Slett alt") {
                    if (confirm("Er du sikker på at du vil slette alle prosjekter, nyhetsartikler og arrangementer?")) {
                        myform.submit();
                    }
                }else {
                    alert("Skriv 'Slett alt' i boksen over for å bekrefte");
                }
            }
        </script>
    <?php
}

function showAdminMessage($message) {
    ?>
    <div class = "adminInfo">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <span class="material-icons">
            done
        </span>
        <h5><?php echo $message ?></h5>
    </div>
    <?php
}

add_action( 'rest_api_init', 'add_install_plugin_post_receiver');

function add_install_plugin_post_receiver(){
    register_rest_route( 'ehelseagderplugin/api', '/installerPlugin', array(
        'methods' => 'POST',
        'callback' => 'install_plugin',
    ));
}