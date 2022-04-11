<?php

add_shortcode('sc_nyhets_sok_widget', 'sc_nyhets_sok_widget');
add_shortcode('sc_prosjekter_sok_widget', 'sc_prosjekter_sok_widget');
add_shortcode('sc_arrangementer_sok_widget', 'sc_arrangementer_sok_widget');

function sc_nyhets_sok_widget() {
    $searchDropdownOptions = array("Tittel", "Forfatter", "Innhold (Tar lenger tid)");
    $searchDropdownOptionsIDs = array("tittel", "skrevet_av", "innhold");

    addSearchWidget("nyhetsartikler", $searchDropdownOptions, $searchDropdownOptionsIDs);
}

function sc_prosjekter_sok_widget() {
    $searchDropdownOptions = array("Prosjektnavn", "Prosjekteier", "Innhold (Tar lenger tid)");
    $searchDropdownOptionsIDs = array("project_name", "prosjekteierkommuner", "innhold");

    addSearchWidget("prosjekter", $searchDropdownOptions, $searchDropdownOptionsIDs);
}

function sc_arrangementer_sok_widget() {
    $searchDropdownOptions = array("Tittel", "Kort beskrivelse", "Sted", "Arrangør", "Innhold (Tar lenger tid)");
    $searchDropdownOptionsIDs = array("tittel", "kort_besk", "sted", "arrangor", "innhold");

    addSearchWidget("arrangementer", $searchDropdownOptions, $searchDropdownOptionsIDs);
}

function addSearchWidget($nameOfPage, $searchDropdownOptions, $searchDropdownOptionsIDs) {
    ?>
    <form class = "searchField requiredPart" method="POST" id = "myform">
        <h3>Søk i alle <?php echo $nameOfPage ?> <?php if (isset($_GET['year'])) echo "fra " . $_GET['year']?></h3>
        <input type = "text" class = "small_input" id = "searchfield" name = "searchfield" placeholder="Søk"/>
        <select id = "dropdown">
            <?php
            for ($i = 0; $i < sizeof($searchDropdownOptions); $i++) {
                ?>
                <option value = "<?php echo $searchDropdownOptionsIDs[$i] ?>"><?php echo $searchDropdownOptions[$i] ?></option>
                <?php
            }
            ?>
        </select>
        <button type = "button" id = "submitButton" class = "button">Søk</button>
    </form>

    <script type="text/javascript">
        const submitButton = document.getElementById("submitButton");
        const searchfield = document.getElementById("searchfield");
        const dropdown = document.getElementById("dropdown");
        const form = document.getElementById("myform");

        submitButton.onclick = function () {
            if (searchfield.value.length < 3) {
                alert("Du må skrive minst 3 bokstaver for å søke")
                return;
            }
            form.action = "../../../../../../sok?q=" + searchfield.value + "&field=" + dropdown.value + "&it=<?php echo $nameOfPage?>";

            const year = (new URLSearchParams(window.location.search)).get("year");
            if (year != null) {
                form.action += "&year=" + year;
            }

            form.submit();
        }
    </script>
    <?php
}

add_shortcode('sc_sok_resultater','sc_sok_resultater');

function sc_sok_resultater() {
    //it = innholdstype
    if (!isset($_GET['field']) || !isset($_GET['q']) || !isset($_GET['it'])) {
        showErrorMessage("Siden ble ikke lastet på riktig måte");
        return;
    }

    $searchFor = $_GET['q'];

    ?>
    <h3 id="søkTittel">Søkeresultater for <?php echo $searchFor?> <?php if (isset($_GET['year'])) echo " fra " . $_GET['year']?></h3>
    <?php
    $innholdsType = $_GET['it'];
    switch ($innholdsType) {
        case 'nyhetsartikler':
            $tableName = getNyhetsartiklerDatabaseRef();
            break;
        case 'prosjekter':
            $tableName = getProsjekterDatabaseRef();
            break;
        case 'arrangementer':
            $tableName = getArrangementerDatabaseRef();
            break;
    }

    $query = "SELECT * FROM " . $tableName . " WHERE " . $_GET['field'] . " LIKE '%" . $searchFor . "%'";

    if (isset($_GET['year'])) {
        $year = $_GET['year'];
        $query .= " AND dato_skrevet >= '" . $year . "-01-01'" .
            " AND dato_skrevet < '" . ($year+1) . "-01-01'";
    }

    global $wpdb;
    $results = $wpdb->get_results($query);

    switch ($innholdsType) {
        case 'nyhetsartikler':
            foreach($results as $result) {
                createLargeListItem($result->tittel,
                $result->ingress,
                getDisplayDateFormat($result->dato_skrevet),
                $result->skrevet_av,
                $result->bilde,
                "alle-nyhetsartikler/vis-artikkel/?artikkelID=" . $result->id);
            }
            break;
        case 'prosjekter':
            foreach($results as $result) {
                createLargeListItem($result->project_name,
                    $result->undertittel,
                    $result->prosjekteierkommuner,
                    $result->prosjektstart,
                    $result->bilde,
                    "alle-prosjekter/prosjektside/?prosjektID=" . $result->id);
            }
            break;
        case 'arrangementer':
            foreach($results as $result) {
                createLargeListItem($result->tittel,
                    $result->kort_besk,
                    getDisplayDateFormat($result->start_dato),
                    $result->sted,
                    $result->bilde,
                    "vis-arrangement/?eventID=" . $result->id);
            }
            break;
    }
}