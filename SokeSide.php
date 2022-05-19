<?php

add_shortcode('sc_nyhets_sok_widget', 'sc_nyhets_sok_widget');
add_shortcode('sc_prosjekter_sok_widget', 'sc_prosjekter_sok_widget');
add_shortcode('sc_arrangementer_sok_widget', 'sc_arrangementer_sok_widget');
add_shortcode('sc_dokumenter_sok_widget', 'sc_dokumenter_sok_widget');
add_shortcode('sc_auto_search_widget', 'sc_auto_search_widget');

function sc_auto_search_widget() {
    if (areElementorBufferingObjects()) return;
    if (isset($_GET['it'])) {
        switch ($_GET['it']) {
            case "prosjekter":
                sc_prosjekter_sok_widget();
                break;
            case "arrangementer":
                sc_arrangementer_sok_widget();
                break;
            case "nyhetsartikler":
                sc_nyhets_sok_widget();
                break;
        }
    }
}

function sc_nyhets_sok_widget() {
    if (areElementorBufferingObjects()) return;
    $searchDropdownOptions = array("Tittel", "Forfatter", "Innhold (Tar lenger tid)");
    $searchDropdownOptionsIDs = array("tittel", "skrevet_av", "innhold");

    addSearchWidget("nyhetsartikler", $searchDropdownOptions, $searchDropdownOptionsIDs);
}

function sc_prosjekter_sok_widget() {
    if (areElementorBufferingObjects()) return;
    $searchDropdownOptions = array("Prosjektnavn", "Prosjektleder",  "Prosjekteier", "Innhold (Tar lenger tid)");
    $searchDropdownOptionsIDs = array("project_name", "ledernavn", "prosjekteierkommuner", "project_text");

    addSearchWidget("prosjekter", $searchDropdownOptions, $searchDropdownOptionsIDs);
}

function sc_arrangementer_sok_widget() {
    if (areElementorBufferingObjects()) return;
    $searchDropdownOptions = array("Tittel", "Kort beskrivelse", "Sted", "Arrangør", "Innhold (Tar lenger tid)");
    $searchDropdownOptionsIDs = array("tittel", "kort_besk", "sted", "arrangor", "innhold");

    addSearchWidget("arrangementer", $searchDropdownOptions, $searchDropdownOptionsIDs);
}

function sc_dokumenter_sok_widget() {
    if (areElementorBufferingObjects()) return;
    addSearchWidget("dokumenter", null, null);
}

function addSearchWidget($nameOfPage, $searchDropdownOptions, $searchDropdownOptionsIDs) {
    ?>
    <form class = "searchField requiredPart" method="POST" id = "myform">
        <h3>Søk i alle <?php echo $nameOfPage ?> <?php if (isset($_GET['year'])) echo "fra " . $_GET['year']?></h3>
        <input type = "text" class = "small_input" id = "searchfield" name = "searchfield" placeholder="Søk"/>
        <?php
        if ($searchDropdownOptions != null) {
            ?>
            <select id = "dropdown">
                <option value="nocat" disabled selected>Velg kategori å søke i</option>
                <?php
                for ($i = 0; $i < sizeof($searchDropdownOptions); $i++) {
                    ?>
                    <option value = "<?php echo $searchDropdownOptionsIDs[$i] ?>"><?php echo $searchDropdownOptions[$i] ?></option>
                    <?php
                }
                ?>
            </select>
            <?php
        }
        ?>
        <button type = "button" id = "submitButton" class = "button">Søk</button>
    </form>

    <script type="text/javascript">
        const submitButton = document.getElementById("submitButton");
        const searchfield = document.getElementById("searchfield");
        const dropdown = document.getElementById("dropdown");
        const form = document.getElementById("myform");

        $(document).ready(function() {
            $(window).keydown(function(event) {
                if (event.keyCode === 13) {
                    submitPressed();
                }
            })
        });
        submitButton.onclick = function () {
            if (dropdown != null) {
                if (dropdown.value === "nocat") {
                    alert("Du må velge en kategori å søke i")
                    return;
                }
            }
            submitPressed();
        }

        function submitPressed() {
            if (searchfield.value.length < 3) {
                alert("Du må skrive minst 3 bokstaver for å søke")
                return;
            }

            let field = "";
            if (dropdown != null) {
                field = dropdown.value;
            }

            form.action = "../../../../../../sok?q=" + searchfield.value + "&field=" + field + "&it=<?php echo $nameOfPage?>";

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
    if (areElementorBufferingObjects()) return;
    if (areWeEditingWithElementor()) {
        ?>
        <div><h5>Her vil resultatene fra et søk vises</h5></div>
        <?php
        return;
    }
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
        case 'dokumenter':
            dokumentSok();
            return;
    }

    $query = "SELECT * FROM " . $tableName . " WHERE " . $_GET['field'] . " LIKE '%" . $searchFor . "%'";

    if (isset($_GET['year'])) {
        $year = $_GET['year'];
        switch ($_GET['it']) {
            case "nyhetsartikler":
                $query .= " AND dato_skrevet >= '" . $year . "-01-01'" .
                    " AND dato_skrevet < '" . ($year+1) . "-01-01'";
                break;
            case "prosjekter":
                $query .= " AND prosjektstart >= " . $year .
                    " AND prosjektstart < " . ($year+1);
                break;
            case "arrangementer":
                $query .= " AND start_dato >= '" . $year . "-01-01'" .
                    " AND start_dato < '" . ($year+1) . "-01-01'";
                break;
        }
    }

    global $wpdb;
    $results = $wpdb->get_results($query);

    ?>
    <div class = "artikkelKortHolder">
        <?php
        switch ($innholdsType) {
            case 'nyhetsartikler':
                foreach($results as $result) {
                    createLargeListItem($result->tittel,
                        $result->ingress,
                        getDisplayDateFormat($result->dato_skrevet),
                        $result->skrevet_av,
                        $result->bilde,
                        "nyheter/vis-artikkel/?artikkelID=" . $result->id);
                }
                break;
            case 'prosjekter':
                foreach($results as $result) {
                    createLargeListItem($result->project_name,
                        $result->undertittel,
                        $result->prosjekteierkommuner,
                        $result->prosjektstart,
                        $result->bilde,
                        "prosjekter/prosjektside/?prosjektID=" . $result->id);
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
            case 'dokumenter':
                dokumentSok();
                break;
        }
        ?>
    </div>
    <?php

    if ($results == null) {
        ?>
        <h5 style = "width: 60%;">Ingen resultater funnet</h5>
        <?php
    }
}

function dokumentSok() {
    $results = getAllFilesInFolderAndSubfolders("", $_GET['q'], -1);
    ?>
    <div class = "artikkelKortHolder">
        <?php
        foreach ($results as $result) {
            $fileNameSeparated = explode(".", $result['filename']);
            $fileType = $fileNameSeparated[sizeof($fileNameSeparated)-1];
            switch ($fileType) {
                case "pdf":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/pdf.png";
                    $specialClass = "pdf dok";
                    break;
                case "pptx":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/powerpoint.png";
                    $specialClass = "powerpoint dok";
                    break;
                case "docx":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/word.png";
                    $specialClass = "word dok";
                    break;
                case "xlsx":
                case "xls":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/excel.png";
                    $specialClass = "excel dok";
                    break;
                default:
                    $photoUrl = null;
                    $specialClass = "ukjentDok dok";
                    break;
            }
            createLargeListItem($result['filename'], "Trykk her for å laste ned", $result['dateModified'], $result['fileSizeMB'] . " MB", $photoUrl, getFilesUploadUrl() . $result['path'], $specialClass);
        }
        ?>
    </div>
    <?php

    if ($results == null) {
        ?>
        <h5 style = "width: 60%;">Ingen resultater funnet</h5>
        <?php
    }
}