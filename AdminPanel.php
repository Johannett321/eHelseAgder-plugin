<?php

add_action("admin_menu", "addMenu");
add_action( 'wp_dashboard_setup', 'wpdocs_add_dashboard_widgets' );

function wpdocs_add_dashboard_widgets() {
    wp_add_dashboard_widget( 'dashboard_widget', 'eHelseAgder+', 'dashboard_widget_function' );
}

function dashboard_widget_function() {
    ?>
    <h1>Velkommen til adminpanelet for eHelseAgder!</h1>
    <p>Her kan du laste ned admin guiden som beskriver hvordan man gjør en rekke ting i admin panelet.</p>
    <a href="<?php echo wp_upload_dir()['baseurl'] . "/eHelseAgderPlus/adminguide.pdf"?>" download>Last ned adminguide</a>
    <?php
}

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
            <img class = "pageImage" src = "../../../wp-content/uploads/eHelseAgderPlus/PluginLogo.png"/>
            <div class = "tittelLine">Statistikk</div>

            <div class = "innholdsBox">
                <h1>Generelt</h1>
                <p>Dette er litt generell statistikk om nettsiden</p>
                <table>
                    <?php
                    global $wpdb;
                    $prosjekter = $wpdb->get_results("SELECT id FROM " . getProsjekterDatabaseRef());
                    $nyhetsartikler = $wpdb->get_results("SELECT id FROM " . getNyhetsartiklerDatabaseRef());
                    $arrangementer = $wpdb->get_results("SELECT id FROM " . getArrangementerDatabaseRef());
                    $changes = $wpdb->get_results("SELECT id FROM " . getChangelogDatabaseRef() . " ORDER BY id DESC LIMIT 1");

                    ?>
                    <tr>
                        <td>Antall prosjekter</td>
                        <td><?php echo sizeof($prosjekter)?></td>
                    </tr>
                    <tr>
                        <td>Antall nyhetsartikler</td>
                        <td><?php echo sizeof($nyhetsartikler)?></td>
                    </tr>
                    <tr>
                        <td>Antall arrangementer</td>
                        <td><?php echo sizeof($arrangementer)?></td>
                    </tr>
                    <tr>
                        <td>Antall endringer på siden</td>
                        <td><?php echo $changes[0]->id?></td>
                    </tr>
                </table>
            </div>

            <div class = "innholdsBox">
                <h1>Topp 10 nyhetsartikler</h1>
                <p>Her er en liste over nyhetsartikler og deres lesertall, i synkende rekkefølge.</p>
                <table>
                    <tr>
                        <th>Artikkelens navn</th>
                        <th>Lesertall</th>
                    </tr>
                    <?php
                    global $wpdb;
                    $query = "SELECT tittel, antall_lesere FROM " . getNyhetsartiklerDatabaseRef() . " ORDER BY antall_lesere DESC LIMIT 10";
                    $resultater = $wpdb->get_results($query);
                    foreach ($resultater as $resultat) {
                        ?>
                        <tr>
                            <td><?php echo $resultat->tittel ?></td>
                            <td><?php echo $resultat->antall_lesere ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>

            <div class = "tittelLine">Sletting</div>

            <div class = "innholdsBox">
                <h1>Sletting av dokumenter</h1>
                <p>Dersom du ønsker å slett noen dokumenter blir du nødt til å koble til FTP området.</p>
                <p>
                    Dersom du ønsker å slette noen filer som har blitt lastet opp før den nye nettside, åpner du denne mappen på FTP området:
                    <br/>
                    www/wp-content/uploads/minefiler/
                </p>
                <p>
                    Dersom du ønsker å slette noen filer som er fra den gamle nettsiden, åpner du denne mappen på FTP området:
                    <br/>
                    www/wp-content/uploads/minefiler/GamleFiler/
                </p>
            </div>
            <div class="innholdsBox">
                <h1>Slette alt</h1>
                <form id = "myform" action = "../wp-json/ehelseagderplugin/api/installerPlugin" method ="POST">
                    <p>
                        Dersom du ønsker å resette eHelseAgder+ og all data som er fylt ut, gjør du dette her. Ved å fortsette blir alle prosjekter,
                        nyhetsartikler og arrangementer slettet. For å bekrefte at du ønsker å slette alt, må du skrive
                        <i>"Slett alt"</i> (uten anførselstegn) i tekstboksen under.
                    </p>
                    <h3>Vil du slette alt?</h3>
                    <input id = "confirmField" type="text" placeholder="Skriv her"/>
                    <div class="resetContainer">
                        <input id = "slettAltKnapp" type = "button" class = "button" value="Reinstaller plugin"/>
                    </div>
                    <?php
                    if (pageIsInDevelopment()) {
                        ?>
                        <br/>
                        <button type="button" id = "enrollButton" class="button">Registrer dev enhet</button>
                        <?php
                    }
                    ?>
                </form>
            </div>
            <div class = "credits">
                Copyright © <?php echo date("Y"); ?> NextGen. Alle rettigheter forbeholdes.
            </div>
        </div>

        <style>
            body {
                background-color: #EEEEEE !important;
            }

            table {
                margin-left: auto;
                margin-right: auto;
                text-align: center;
                background-color: #DDDDDD;
            }

            th {
                min-width: 100px;
                border: 1px solid #888888;
                background-color: #AAAAAA;
            }

            tr {
                height: 30px;
            }

            td {
                border: 1px solid #888888;
                padding: 10px;
            }

            .pageCenter {
                text-align: center;
            }

            .pageImage {
                width: 400px;
                margin-top: 100px;
                margin-bottom: 50px;
            }

            .tittelLine {
                width: 700px;
                padding: 20px;

                margin-top: 20px;
                margin-left: auto;
                margin-right: auto;

                text-align: center;
                border-radius: 10px;
                font-size: 20px;
                font-weight: bold;
            }

            .innholdsBox {
                width: 700px;
                padding: 20px;

                margin-top: 20px;
                margin-left: auto;
                margin-right: auto;

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

            <?php
            if (pageIsInDevelopment()) {
                ?>
                const enrollButton = document.getElementById('enrollButton');
                enrollButton.onclick = function () {
                    if (confirm("Er du sikker på at du vil registrere denne dev enheten?")) {
                        setCookie("DevelopmentDeviceEnrolled", "true", 100);
                        alert("Utviklingsenhet registrert! Du har nå tilgang til nettsiden!");

                        location.reload();

                        function setCookie(cname, cvalue, exdays) {
                            const d = new Date();
                            d.setTime(d.getTime() + (exdays*24*60*60*1000));
                            let expires = "expires="+ d.toUTCString();
                            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                        }
                    }
                }
                <?php
            }
            ?>
        </script>
    <?php
}

function showAdminMessage($message) {
    ?>
    <div class = "adminInfo">
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