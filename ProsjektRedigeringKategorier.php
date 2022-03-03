<?php

session_start();

require 'PubliserProsjekt.php';

validateFieldsFromPage1();

function validateFieldsFromPage1() {
    saveFieldToSession("pname");
    saveFieldToSession("psubtitle");
    saveFieldToSession("pleadername");
    saveFieldToSession("pleaderemail");
    saveFieldToSession("pleaderphone");
    saveFieldToSession("project_start");
    saveFieldToSession("project_end");
    saveFieldToSession("cost");
    saveFieldToSession("psummary");
}

function saveFieldToSession($fieldToSave) {
    if (isset($_POST[$fieldToSave])) {
        $_SESSION[$fieldToSave] = $_POST[$fieldToSave];
    }
}

add_shortcode( 'prosjektredigeringkategorier', 'prosjektredigeringkategorier');

function prosjektredigeringkategorier( $atts ) {
    //kreverInnlogging();
    leggTilInformasjonFelt();
}

function leggTilInformasjonFelt() {
    $postURL = "";
    if (isset($_GET['editProsjektID'])) {
        $postURL = "../../wp-json/ehelseagderplugin/api/publiser_prosjekt?editProsjektID=" . $_GET['editProsjektID'];
    }else {
        $postURL = "../../wp-json/ehelseagderplugin/api/publiser_prosjekt";
    }
    ?>
    <form action="<?php echo $postURL ?>" method="post">
        <div class="addCustomField">
            <h5 class="mainTitle">Legg til informasjon om prosjektet (<?php echo $_SESSION["pname"] ?>):</h5>
            <p>Under kan du legge til informasjon du ønsker å dele om prosjektet ved hjelp av ulike kategorier. Finner du
                ikke kategorien du leter etter kan du velge «legg til egen kategori» for å definere kategori selv. </p>
            <p>Den nye kategorien vil dukke opp over ^</p>
            <select id="collapsibleChooser" name="collapsibleChooser">
                <option value="" disabled selected>Velg kategori</option>
                <!--<option value="carrangementer">Arrangementer</option>-->
                <!--<option value="cbildegalleri">Bildegalleri</option>-->
                <option value="cleverandorer">Leverandører</option>
                <option value="cmerinfo">Mer informasjon om prosjektet</option>
                <option value="cmilepaeler">Milepæler</option>
                <!--<option value="cmål">Mål</option>-->
                <!--<option value="cmålgruppe">Målgruppe</option>-->
                <!--<option value="cnedlastbaredokumenter">Nedlastbare dokumenter</option>-->
                <option value="cprosjektteam">Prosjekt-team</option>
                <!--<option value="cforskning">Relevant forskning</option>-->
                <!--<option value="csamarbeidspartnere">Samarbeidspartnere</option>-->
                <!--<option value="cstatus">Status</option>-->
                <!--<option value="cvideoer">Videoer</option>-->
                <option value="cegenkategori" style="font-weight:600;">+ Legg til egen kategori</option>
            </select>
            <button id="addCategoryButton" class="addInfoButton" type="button">Legg til informasjon</button>
            <div class = "hidden inlineBlock" id = "categoryAlreadyAdded">
                <h5 class = "inlineBlock" id = "categoryAlreadyAddedText">Allerede lagt til</h5>
                <img src = "https://i0.wp.com/degreessymbolmac.com/wp-content/uploads/2020/02/check-mark-2025986_1280.png?fit=1280%2C945&ssl=1"/>
            </div>
        </div>
        <div id="collapsibles">

        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <center>
            <h4>Er du klar til å gjøre siden offentlig?</h4>
            <input type="submit" class = "button" id = "submitButton" value="Publiser">
        </center>
    </form>
<style>
    .hidden {
        display:none !important;
    }

    .requiredPart {
        padding: 20px;
        background-color: #EEEEEE;
        border-radius: 10px;
    }

    .small_input {
        width: 100%;
        height: 30px;
        margin-bottom: 20px;
    }

    h5 {
        margin: 0px;
        padding: 0px;
    }

    .inlineBlock {
        display: inline-block;
    }

    .projectLeader {
        width: 400px;
        padding: 20px;
        margin: 20px;
        margin-left: 0px;
        background-color: #AAFFAA;
        border-radius: 10px;
    }

    .addCustomField {
        margin: 20px;
    }

    .addInfoButton {
        border-radius: 200px;
        padding: 10px;
        border: none;
        background-color: #666666;
        color: white;
        font-size: 17px;
        margin-left: 20px;
    }

    #categoryAlreadyAdded {
        font-size: 17px;
        padding: 10px;
        margin-left: 20px;
        opacity: 0.3;
    }

    #categoryAlreadyAdded img {
        width: 20px;
        height: 20px;
    }

    .mainTitle {
        padding-top: 20px;
    }

    select {
        height: 40px;
        width: 300px;
        border-radius: 5px;
        padding: 10px
    }

    .collapsible h5 {
        padding-bottom: 10px;
    }

    .removedCol {
        transform: translateX(100vw);
    }

    .collapsible {
        background-color: #EFF7EA;
        padding: 20px;
        margin-top: 20px;
        box-shadow: 2px 2px 10px #555555;

        -webkit-animation: fadein 0.5s;
        /* Safari, Chrome and Opera > 12.1 */
        -moz-animation: fadein 0.5s;
        /* Firefox < 16 */
        -ms-animation: fadein 0.5s;
        /* Internet Explorer */
        -o-animation: fadein 0.5s;
        /* Opera < 12.1 */
        animation: fadein fadeout 0.5s;
    }

    .collapsible textarea {
        width: 100%;
        min-height: 200px;
        font-size: 17px;
        padding: 10px;
    }

    .collapsible .textFieldContainer {
        width: 100%;
    }

    .collapsible .textFieldContainer input {
        width: 100%;
    }

    .collapsible hr {
        margin-top: 10px;
        margin-bottom: 10px;
        background-color: #698161;
        color: #698161;
    }

    .savedText {
        color: gray;
    }

    .removeCollapsibleButton {
        background: none;
        border: none;
        float: right;
        opacity: 80%;
        transition: 0.1s ease;
    }

    .removeCollapsibleButton img {
        width: 30px;
        height: 30px;
    }

    .removeCollapsibleButton:hover {
        scale: 1.1;
        opacity: 100%;
        cursor: pointer;
    }

    .addPersonButton {
        margin-top: 20px;
        width: 100%;
        background-color: #D0E6C8;
    }

    .addPersonButton h5 {
        width: 100%;
        text-align: center;
    }

    .personLeftCol {
        display: table-cell;
        margin: 0em;
        padding: 1em;
        height: auto;
        vertical-align: middle;
    }

    .personLeftCol h5 {
        text-align: center;
        letter_spacing: normal;
        font-weight: 400;
    }

    .personRightCol {
        width: 100%;
        display: table-cell;
        margin: 0em;
        padding: 1em;
        height: auto;
        vertical-align: middle;
    }

    .personProfilBilde {
        width: 120px;
        height: 120px;
        border-radius: 100%;
        background-color: #999999;

        margin-left: auto;
        margin-right: auto;
    }

    .collapsibleCustomTitle {
        width:100%;
        padding: 10px;
        font-size: 20px;
    }

    @keyframes fadein {
        from {
            scale: 0.8;
            opacity: 0;
        }

        to {
            scale: 1;
            opacity: 1;
        }
    }

    /* Firefox < 16 */
    @-moz-keyframes fadein {
        from {
            scale: 0.8;
            opacity: 0;
        }

        to {
            scale: 1;
            opacity: 1;
        }
    }

    /* Safari, Chrome and Opera > 12.1 */
    @-webkit-keyframes fadein {
        from {
            scale: 0.8;
            opacity: 0;
        }

        to {
            scale: 1;
            opacity: 1;
        }
    }

    /* Internet Explorer */
    @-ms-keyframes fadein {
        from {
            scale: 0.8;
            opacity: 0;
        }

        to {
            scale: 1;
            opacity: 1;
        }
    }

    /* Opera < 12.1 */
    @-o-keyframes fadein {
        from {
            scale: 0.8;
            opacity: 0;
        }

        to {
            scale: 1;
            opacity: 1;
        }
    }
</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    (function () {
        const collapsibles = document.getElementById('collapsibles');
        const categoryChooser = document.getElementById('collapsibleChooser');
        const addCategoryButton = document.getElementById('addCategoryButton');

        const categoryAlreadyAdded = document.getElementById('categoryAlreadyAdded');
        const categoryAlreadyAddedText = document.getElementById('categoryAlreadyAddedText');

        $("#collapsibleChooser").change(function () {
            selectionOptionChanged();
        });

        var customColCounter = 0;
        var peopleInProjectTeam = 0;
        var milepaelCounter = 0;

        addCategoryButton.addEventListener("click", function () {
            if (categoryChooser.value == 'cleverandorer') {
                createLeverandorerCol();
                selectionOptionChanged();
                saveListOfCollapsibles();
            }else if (categoryChooser.value == 'cprosjektteam') {
                createProsjektTeamCol();
                selectionOptionChanged();
                saveListOfCollapsibles();
            }else if (categoryChooser.value == 'cegenkategori') {
                createCustomCatCol();
                selectionOptionChanged();
                saveListOfCollapsibles();
            }else if (categoryChooser.value == 'cmerinfo') {
                createMerInfoCol();
                selectionOptionChanged();
                saveListOfCollapsibles();
            }else if (categoryChooser.value == 'cmilepaeler') {
                createMilepaelerCol();
                selectionOptionChanged();
                saveListOfCollapsibles();
            }
        });

        function selectionOptionChanged() {
            if (isCategoryAlreadyAdded(categoryChooser.value)) {
                addCategoryButton.classList.add('hidden');
                categoryAlreadyAdded.classList.remove('hidden');
                categoryAlreadyAddedText.innerText = categoryChooser.options[categoryChooser.selectedIndex].text + " lagt til";
            }else {
                addCategoryButton.classList.remove('hidden');
                categoryAlreadyAdded.classList.add('hidden');
            }
        }

        <?php
            //Dersom man skal redigere et prosjekt
            if (isset($_GET['editProsjektID'])) {
                error_log("ProsjektID is set");
                $prosjektID = $_GET['editProsjektID'];
                $formatted_table_name = getFormattedTableName('eha_collapsible');

                global $wpdb;
                $query = "SELECT * FROM " . $formatted_table_name . " WHERE prosjekt_id = " . $prosjektID;
                $collapsiblesFound = $wpdb->get_results($query);
                error_log("Found collapsibles: " . sizeof($collapsiblesFound));

                for ($i = 0; $i < sizeof($collapsiblesFound); $i++) {
                    $innhold = $collapsiblesFound[$i]->innhold;
                    $innhold = str_replace("\r", '', $innhold);
                    $innhold = str_replace("\n", '\n', $innhold);

                    switch($collapsiblesFound[$i]->collapsible_type) {
                        case 1:
                            //Custom kategori
                            $customName = $collapsiblesFound[$i]->egendefinert_navn;
                            $customName = str_replace("\r", '', $customName);
                            $customName = str_replace("\n", '\n', $customName);

                            ?>
                            createCustomCatCol("<?php $customName?>", "<?php$innhold?>");
                            <?php
                            break;
                        case 2:
                            //leverandører
                            ?>
                            if (!colHasBeenDeletedLocally("cleverandorer")) {
                                createLeverandorerCol("<?php$innhold?>");
                            }
                            <?php
                            break;
                        case 3:
                            //Prosjekt-team
                            ?>
                            createProsjektTeamCol("<?php$innhold?>");
                            <?php
                            break;
                        case 4:
                            //Mer informasjon om prosjektet
                            ?>
                            createMerInfoCol("<?php$innhold?>");
                            <?php
                            break;
                        case 5:
                            //Milepæler
                            ?>
                            createMilepaelerCol("<?php$innhold?>");
                            <?php
                            break;
                    }
                }
            }
        ?>

        //HER KAN VI LOADE LISTEN MED COLLAPSIBLES SOM ER LAGT TIL, OG LAGE DISSE

        function colHasBeenDeletedLocally(colname) {
            var fjernedeCollapsiblesString = localStorage.getItem("fjernedeCollapsibles");
            if (fjernedeCollapsiblesString == null) fjernedeCollapsiblesString = "";

            const fjernedeCollapsibles = fjernedeCollapsiblesString.split(";");

            if (fjernedeCollapsibles.includes(colname)) return true;
            return false;
        }
        

        function scrollToView(view) {
            view.scrollIntoView({
                behavior: "smooth",
                block: "center",
                inline: "nearest"
            });
        }

        function isCategoryAlreadyAdded(categoryName, shouldAlert) {
            for (let i = 0; i < collapsibles.children.length; i++) {
                if (collapsibles.children[i].name == categoryName) {
                    if (shouldAlert) {
                        alert("Denne kategorien er allerede lagt til. Den kan ikke legges til to ganger.");
                    }
                    return true;
                }else {
                    console.log(collapsibles.children[i].name + " is not the same as " + categoryName);
                }
            }
            return false;
        }

        function createCollapsibleWithTitle(titleText, name) {
            if (isCategoryAlreadyAdded(name, true)) return null;

            const collapsible = createCollapsibleWithoutTitle();
            collapsible.name = name;

            const title = document.createElement('h5');
            title.innerText = titleText;

            collapsible.appendChild(title);
            return collapsible;
        }

        function createCollapsibleWithoutTitle() {
            const collapsible = document.createElement('div');
            collapsible.classList.add('collapsible');

            const removeCollapsibleButton = document.createElement('button');
            removeCollapsibleButton.type = "button";
            removeCollapsibleButton.innerHTML = '<img src="https://www.nicepng.com/png/full/242-2425648_close-remove-delete-exit-cross-cancel-trash-comments.png" />';
            removeCollapsibleButton.classList.add('removeCollapsibleButton');
            $(removeCollapsibleButton).click(function (e) {
                if (confirm("Er du sikker?") == true) {
                    $(collapsible).animate({opacity: '0%', height: '0px'}, function (){$(collapsible).remove(); selectionOptionChanged();saveListOfCollapsibles();});
                }
            });

            collapsible.appendChild(removeCollapsibleButton);
            return collapsible;
        }

        function createTextFieldWithLabel(title, name) {
            return createTextFieldWithLabel(title, name, "");
        }

        function createTextFieldWithLabel(title, name, placeholder, fieldContent, savedTextLabel) {
            if (fieldContent == null) fieldContent = "";

            const container = document.createElement('div');
            container.classList.add('textFieldContainer');

            const field = document.createElement('input');
            field.id = name;
            field.name = name;
            field.type = "text";
            field.value = fieldContent;
            if (placeholder != null) {
                field.placeholder = placeholder;
            }

            addTextSaver(field, savedTextLabel, name);

            const label = document.createElement('label');
            label.for = name;
            label.innerText = title;

            container.appendChild(label);
            container.appendChild(field);
            return container;
        }

        var lastKeypress = 0;

        function createLeverandorerCol(savedText) {
            if (savedText == null) {
                savedText = "";
            }
            const collapsible = createCollapsibleWithTitle("Leverandører", "cleverandorer");
            if (collapsible == null) return;

            const textField = document.createElement('textarea');
            textField.name = "cleverandørtekst"
            textField.value = savedText;

            const savedTextInfo = getSavedText();
            addTextSaver(textField, savedTextInfo, "cleverandorer_ls");

            collapsible.appendChild(textField);
            collapsible.appendChild(savedTextInfo);
            
            collapsibles.appendChild(collapsible);
            scrollToView(collapsible);
        }

        function addTextSaver(textbox, savedLabel, localsave) {
            const urlParams = new URLSearchParams(window.location.search);
            const editProsjektID = urlParams.get('editProsjektID');
            const prosjektIDFromLocalStorage = localStorage.getItem("prosjektID");
            var sistLagretStorage = localStorage.getItem(localsave + "_time");

            if (editProsjektID == prosjektIDFromLocalStorage) {
                if (localStorage.getItem(localsave) != null) {
                    textbox.value = localStorage.getItem(localsave);

                    if (sistLagretStorage == null) {
                        savedLabel.innerText = "...";
                    }else {
                        savedLabel.innerText = "Hentet utkast fra: " + sistLagretStorage;
                    }
                }
            }else {
                localStorage.clear();
            }
            $(textbox).on("input", function(){
                const d = new Date();
                lastKeypress = d.getTime();

                savedLabel.innerText = "...";
                setTimeout(function() {
                    var dt = new Date();
                    if (dt.getTime() > lastKeypress + 250) {
                        let year = dt.getFullYear();
                        let month = dt.getMonth() + 1;
                        let day = dt.getDate();

                        let hours = dt.getHours().toString();
                        let minutes = dt.getMinutes().toString();
                        if (minutes.length == 1) {
                            minutes = "0" + minutes;
                        }
                        if (hours.length == 1) {
                            hours = "0" + hours;
                        }
                        var time = hours + ":" + minutes;
                        var fulltime = day + "." + month + "." + year + " " + hours + ":" + minutes;
                        savedLabel.innerText = "Sist lagret: " + time;
                        localStorage.setItem("prosjektID", editProsjektID);
                        localStorage.setItem(localsave, textbox.value);
                        localStorage.setItem(localsave + "_time", fulltime);
                    }
                }, 300);
            });
        }

        function addDropdownSaver(dropdown, savedLabel, localsave) {
            const urlParams = new URLSearchParams(window.location.search);
            const editProsjektID = urlParams.get('editProsjektID');
            const prosjektIDFromLocalStorage = localStorage.getItem("prosjektID");
            var sistLagretStorage = localStorage.getItem(localsave + "_time");

            if (editProsjektID == prosjektIDFromLocalStorage) {
                if (localStorage.getItem(localsave) != null) {
                    dropdown.value = localStorage.getItem(localsave);

                    if (sistLagretStorage == null) {
                        savedLabel.innerText = "...";
                    }else {
                        savedLabel.innerText = "Hentet utkast fra: " + sistLagretStorage;
                    }
                }
            }else {
                localStorage.clear();
            }
            $(dropdown).on("change", function(){
                const d = new Date();
                lastKeypress = d.getTime();

                savedLabel.innerText = "...";
                setTimeout(function() {
                    var dt = new Date();
                    if (dt.getTime() > lastKeypress + 250) {
                        let year = dt.getFullYear();
                        let month = dt.getMonth() + 1;
                        let day = dt.getDate();

                        let hours = dt.getHours().toString();
                        let minutes = dt.getMinutes().toString();
                        if (minutes.length == 1) {
                            minutes = "0" + minutes;
                        }
                        if (hours.length == 1) {
                            hours = "0" + hours;
                        }
                        var time = hours + ":" + minutes;
                        var fulltime = day + "." + month + "." + year + " " + hours + ":" + minutes;
                        savedLabel.innerText = "Sist lagret: " + time;
                        localStorage.setItem("prosjektID", editProsjektID);
                        localStorage.setItem(localsave, dropdown.value);
                        localStorage.setItem(localsave + "_time", fulltime);
                    }
                }, 300);
            });
        }

        function saveListOfCollapsibles() {
            const localsave = "listofcollapsibles"
            
            localStorage.setItem("prosjektID", editProsjektID);
            
            const listOfCollapsibles = document.getElementsByClassName('collapsible');
            var listOfCollapsiblesString = "";

            var arrayOfCollapsibles = new Array();
            for (let i = 0; i < listOfCollapsibles.length; i++) {
                if (listOfCollapsiblesString != "") {
                    listOfCollapsiblesString += ";";
                }

                listOfCollapsiblesString += listOfCollapsibles[i].name;
            }

            localStorage.setItem(localsave, listOfCollapsiblesString);
        }

        function loadListOfCollapsibles() {
            const urlParams = new URLSearchParams(window.location.search);
            const editProsjektID = urlParams.get('editProsjektID');
            const prosjektIDFromLocalStorage = localStorage.getItem("prosjektID");

            if (editProsjektID == prosjektIDFromLocalStorage) {
                if (localStorage.getItem(localsave) != null) {
                    //LOAD COLLAPSIBLES
                }
            }else {
                localStorage.clear();
            }
        }

        function getSavedText() {
            const lagretText = document.createElement('span');
            lagretText.classList.add('savedText');
            lagretText.innerText = "...";
            return lagretText;
        }

        function createCustomCatCol(egendefinertNavn, innhold) {
            if (innhold == null) innhold = "";
            if (egendefinertNavn == null) egendefinertNavn = "";

            const collapsible = createCollapsibleWithoutTitle();

            customColCounter += 1;

            collapsible.name = "cegenkategori" + customColCounter;

            const field = document.createElement('input');
            field.classList.add("collapsibleCustomTitle");
            field.id = "cvcustomtitle" + customColCounter;
            field.name = "cvcustomtitle" + customColCounter;
            field.type = "text";
            field.placeholder = "Hva skal kategorien hete?"
            field.value = egendefinertNavn;

            //oppdater 'name' feltet når brukeren skriver inn et navn
            $(document).ready(function(){
                $("#cvcustomtitle" + customColCounter).on("input", function(){
                    $(collapsible).attr('value', $(this).val()); 
                });
            });
            collapsible.appendChild(field);
                
            const textField = document.createElement('textarea');
            textField.name = "cvcustomdesc" + customColCounter;
            textField.value = innhold;
            collapsible.appendChild(textField);

            const savedTextInfo = getSavedText();
            addTextSaver(field, savedTextInfo, "c" + field.id + "_ls");
            addTextSaver(textField, savedTextInfo, "c" + textField.name + "_ls");
            collapsible.appendChild(savedTextInfo);

            collapsibles.appendChild(collapsible);
            scrollToView(collapsible);
        }

        function createMerInfoCol(innhold) {
            if (innhold == null) innhold = "";

            const collapsible = createCollapsibleWithTitle("Mer informasjon om prosjektet", "cmerinfo");
            if (collapsible == null) return;

            const textField = document.createElement('textarea');
            textField.name = "cmerinfotekst"
            textField.value = innhold;

            collapsible.appendChild(textField);

            const savedTextInfo = getSavedText();
            addTextSaver(textField, savedTextInfo, "c" + "merinfo" + "_ls");
            collapsible.appendChild(savedTextInfo);

            collapsibles.appendChild(collapsible);
            scrollToView(collapsible);
        }

        function createMilepaelerCol(innhold) {
            if (innhold == null) innhold = "";

            const collapsible = createCollapsibleWithTitle("Milepæler", "cmilepaeler");
            if (collapsible == null) return;

            const milepaeler = document.createElement('div');

            const savedTextInfo = getSavedText();

            var milepaelerSplit = innhold.split(";");

            if (innhold.length == 0) {
                //Vi redigerer ikke et prosjekt, så det er ingen milepaeler å loade
                const milepael = createMilepael(null, savedTextInfo);
                milepaeler.append(milepael);
            }else {
                for (let i = 0; i < milepaelerSplit.length; i++) {
                    const milepael = createMilepael(milepaelerSplit[i], savedTextInfo);
                    milepaeler.append(milepael);
                }
            }

            const leggTilMilepaelKnapp = document.createElement('button');
            leggTilMilepaelKnapp.classList.add('addPersonButton');
            leggTilMilepaelKnapp.type = "button";
            leggTilMilepaelKnapp.addEventListener("click", function () {
                const nyMilepael = createMilepael(null, savedTextInfo);
                milepaeler.appendChild(nyMilepael);
                scrollToView(nyMilepael);
            });

            const leggTilMilepaelTekst = document.createElement('h5');
            leggTilMilepaelTekst.innerText = "Legg til ny milepæl";

            leggTilMilepaelKnapp.appendChild(leggTilMilepaelTekst);

            collapsible.appendChild(milepaeler);
            collapsible.appendChild(leggTilMilepaelKnapp);

            function createMilepael(currentMilepaelInfo, savedTextInfo) {
                if (currentMilepaelInfo == null) currentMilepaelInfo = "";
                const milepaelInfoSplit = currentMilepaelInfo.split(",");

                const currentMilepael = document.createElement('div');

                milepaelCounter += 1;

                if (milepaelCounter != 1) {
                    const line = document.createElement('hr');
                    currentMilepael.appendChild(line);
                }

                const container = document.createElement('div');
                container.classList.add('textFieldContainer');

                const dropdown = document.createElement('select');
                const disabledOption = document.createElement('option');
                const doneOption = document.createElement('option');
                const ongoingOption = document.createElement('option');
                const notStartedOption = document.createElement('option');

                dropdown.name = "milepaeldropdown" + milepaelCounter;
                dropdown.id = "milepaeldropdown" + milepaelCounter;

                disabledOption.value = "Velg status";
                disabledOption.disabled = "disabled";
                if (currentMilepaelInfo == "") disabledOption.selected = true;
                disabledOption.innerText = "Velg status";

                doneOption.value = "3";
                if (milepaelInfoSplit[1] == "3") doneOption.selected = true;
                doneOption.innerText = "Ferdig";

                ongoingOption.value = "2";
                if (milepaelInfoSplit[1] == "2") ongoingOption.selected = true;
                ongoingOption.innerText = "Pågående";

                notStartedOption.value = "1";
                if (milepaelInfoSplit[1] == "1") notStartedOption.selected = true;
                notStartedOption.innerText = "Ikke startet";

                const label = document.createElement('label');
                label.for = "milepaeldropdown" + milepaelCounter;
                label.innerText = "Status: ";

                const removeMilepaelButton = document.createElement('button');
                removeMilepaelButton.type = "button";
                removeMilepaelButton.innerText = "Fjern milepæl";
                $(removeMilepaelButton).click(function (e) {
                    if (confirm("Er du sikker?") == true) {
                        $(currentMilepael).animate({opacity: '0%', height: '0px'}, function (){$(currentMilepael).remove();});
                    }
                });

                dropdown.appendChild(disabledOption);
                dropdown.appendChild(doneOption);
                dropdown.appendChild(ongoingOption);
                dropdown.appendChild(notStartedOption);

                container.appendChild(removeMilepaelButton);
                container.appendChild(label);
                container.appendChild(dropdown);

                addDropdownSaver(dropdown, savedTextInfo, "cmdropdown" + milepaelCounter);

                const titleField = createTextFieldWithLabel("Tittel: ", "cmtittel" + milepaelCounter, "Signert avtale", milepaelInfoSplit[0], savedTextInfo);
                const kontaktpersonField = createTextFieldWithLabel("Kontaktperson: ", "cmcontact" + milepaelCounter, "navn.navnesen@gmail.com", milepaelInfoSplit[2], savedTextInfo);
                const dateField = createTextFieldWithLabel("Dato: ", "cmdate" + milepaelCounter, "31.10.2022", milepaelInfoSplit[3], savedTextInfo);

                currentMilepael.append(container);
                currentMilepael.append(titleField);
                currentMilepael.append(kontaktpersonField);
                currentMilepael.append(dateField);

                return currentMilepael;
            }

            collapsible.appendChild(savedTextInfo);
            collapsibles.appendChild(collapsible);
            scrollToView(collapsible);
        }

        function createProsjektTeamCol(innhold) {
            const collapsible = getProsjektTeamCollapsible(innhold);
            collapsibles.appendChild(collapsible);
            scrollToView(collapsible);
        }

        function getProsjektTeamCollapsible(innhold) {
            if (innhold == null) innhold = "";

            const collapsible = createCollapsibleWithTitle("Prosjekt-team", "cprosjektteam");
            if (collapsible == null) return;
            const personer = document.createElement('div');

            const savedTextInfo = getSavedText();

            if (innhold == "") {
                //Prosjektet blir ikke redigert, så vi laster bare en person slik som i malen
                const person = createPerson(null, savedTextInfo);
                personer.appendChild(person);
            }else {
                const innholdSplit = innhold.split(";");
                for (let i = 0; i < innholdSplit.length; i++) {
                    const person = createPerson(innholdSplit[i], savedTextInfo);
                    personer.appendChild(person);
                }
            }

            const leggTilPersonKnapp = document.createElement('button');
            leggTilPersonKnapp.classList.add('addPersonButton');
            leggTilPersonKnapp.type = "button";
            leggTilPersonKnapp.addEventListener("click", function () {
                const nyPerson = createPerson(null, savedTextInfo);
                personer.appendChild(nyPerson);
                scrollToView(nyPerson);
            });

            const leggTilPersonTekst = document.createElement('h5');
            leggTilPersonTekst.innerText = "Legg til ny person";

            leggTilPersonKnapp.appendChild(leggTilPersonTekst);

            function createPerson(personInfo, savedTextInfo) {
                if (personInfo == null) personInfo = "";

                const personInfoSplit = personInfo.split(",");

                peopleInProjectTeam += 1;
                const person = document.createElement('div');

                const leftSide = document.createElement('div');
                leftSide.classList.add('personLeftCol');

                const uploadPictureButton = document.createElement('div');
                uploadPictureButton.classList.add('personProfilBilde');
                leftSide.appendChild(uploadPictureButton);

                const uploadPictureText = document.createElement('h5');
                uploadPictureText.innerText = "Last opp bilde"
                leftSide.appendChild(uploadPictureText);

                const rightSide = document.createElement('div');
                rightSide.classList.add('personRightCol');

                const removePersonButton = document.createElement('button');
                removePersonButton.type = "button";
                removePersonButton.innerText = "Fjern person";
                removePersonButton.id = "";
                removePersonButton.name = "";
                $(removePersonButton).click(function (e) {
                    if (confirm("Er du sikker?") == true) {
                        $(person).animate({opacity: '0%', height: '0px'}, function (){$(person).remove();});
                    }
                });

                const rolleField = createTextFieldWithLabel("Stilling/rolle: ", "cvtmrolle" + peopleInProjectTeam, "Markedskordinator", personInfoSplit[0], savedTextInfo);
                const fulltNavnField = createTextFieldWithLabel("Fullt navn: ", "cvtmfulltnavn" + peopleInProjectTeam, "Navn Navnesen", personInfoSplit[1], savedTextInfo);
                const epostField = createTextFieldWithLabel("E-post: ", "cvtmepost" + peopleInProjectTeam, "navn.navnesen@gmail.com", personInfoSplit[2], savedTextInfo);
                const mobilField = createTextFieldWithLabel("Mobil: ", "cvtmmobil" + peopleInProjectTeam, "902 26 981", personInfoSplit[3], savedTextInfo);

                if (peopleInProjectTeam != 1) {
                    const line = document.createElement('hr');
                    person.appendChild(line);
                }

                rightSide.appendChild(removePersonButton);
                rightSide.appendChild(rolleField);
                rightSide.appendChild(fulltNavnField);
                rightSide.appendChild(epostField);
                rightSide.appendChild(mobilField);

                person.appendChild(leftSide);
                person.appendChild(rightSide);

                return person;
            }

            collapsible.appendChild(personer);
            collapsible.appendChild(leggTilPersonKnapp);
            collapsible.appendChild(savedTextInfo);
            return collapsible;
        }
    })();
</script>
<?php
}