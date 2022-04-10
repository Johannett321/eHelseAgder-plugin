<?php

add_shortcode('sc_search_widget', 'sc_search_widget');
function sc_search_widget() {
    ?>
    <form class = "searchField requiredPart" method="POST" id = "myform">
        <h3>Søk i alle nyhetsartikler <?php if (isset($_GET['year'])) echo "fra " . $_GET['year']?></h3>
        <input type = "text" class = "small_input" id = "searchfield" name = "searchfield" placeholder="Søk"/>
        <select id = "dropdown">
            <option value = "tittel">Tittel</option>
            <option value = "skrevet_av">Forfatter</option>
            <option value = "innhold">Innhold (Tar lenger tid)</option>
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
            form.action = "../../../../../../sok?q=" + searchfield.value + "&field=" + dropdown.value;

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
    if (!isset($_GET['field']) || !isset($_GET['q'])) {
        showErrorMessage("Siden ble ikke lastet på riktig måte");
        return;
    }

    $searchFor = $_GET['q'];

    ?>
    <h3 id="søkTittel">Søkeresultater for <?php echo $searchFor?> <?php if (isset($_GET['year'])) echo " fra " . $_GET['year']?></h3>
    <?php
    $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef() . " WHERE " . $_GET['field'] . " LIKE '%" . $searchFor . "%'";

    if (isset($_GET['year'])) {
        $year = $_GET['year'];
        $query .= " AND dato_skrevet >= '" . $year . "-01-01'" .
            " AND dato_skrevet < '" . ($year+1) . "-01-01'";
    }

    global $wpdb;
    $results = $wpdb->get_results($query);

    foreach($results as $result) {
        createShortArticle($result);
    }
}