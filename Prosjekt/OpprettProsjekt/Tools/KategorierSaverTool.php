<?php
function addKategorierSaverTool() {
    ?>
    <script type="text/javascript">
        function colHasBeenDeletedLocally(colname) {
            var fjernedeCollapsiblesString = localStorage.getItem("fjernedeCollapsibles");
            if (fjernedeCollapsiblesString == null) fjernedeCollapsiblesString = "";

            const fjernedeCollapsibles = fjernedeCollapsiblesString.split(";");

            if (fjernedeCollapsibles.includes(colname)) return true;
            return false;
        }

        function removeCategoryFromRemovedCollapsibles(collapsibleName) {
            var deletedCategories = localStorage.getItem("fjernedeCollapsibles");
            if (deletedCategories == null) deletedCategories = "";

            //Hvis kategorien er listet som en av de slettede kategoriene
            if (deletedCategories.includes(collapsibleName)) {
                let deletedCategoriesSplit = deletedCategories.split(';');
                var newDeletedCategoriesString = "";

                //Legge til alle kategorier som ikke er den ønskede kategorien i en string separert med semikolon
                for (let i = 0; i < deletedCategoriesSplit.length; i++) {
                    if (deletedCategoriesSplit[i] !== collapsibleName) {
                        if (newDeletedCategoriesString !== "") {
                            newDeletedCategoriesString += ";";
                        }
                        newDeletedCategoriesString += deletedCategoriesSplit[i];
                    }
                }

                //Sett den nye stringen som listen over fjernede collapsibles
                if (newDeletedCategoriesString === "") {
                    localStorage.removeItem("fjernedeCollapsibles");
                }else {
                    localStorage.setItem("fjernedeCollapsibles", newDeletedCategoriesString);
                }
                saveLocalProsjektID();
            }
        }

        function saveDeletedCollapsible(name, fieldsToReset) {
            var deletedCategories = localStorage.getItem("fjernedeCollapsibles");
            if (deletedCategories == null) deletedCategories = "";
            if (deletedCategories !== "") {
                deletedCategories += ";";
            }
            if (!deletedCategories.includes(name)) {
                deletedCategories += name;
                localStorage.setItem("fjernedeCollapsibles", deletedCategories);
            }

            for (var i = 0; i < fieldsToReset.length; i++) {
                localStorage.removeItem(fieldsToReset[i]);
            }

            saveLocalProsjektID();

            removeCategoryFromAddedCategories(name);
        }

        function removeCategoryFromAddedCategories(collapsibleName) {
            var addedCategories = localStorage.getItem("opprettedeCollapsibles");
            if (addedCategories == null) addedCategories = "";

            //Hvis kategorien er listet som en av de opprettede kategoriene
            if (addedCategories.includes(collapsibleName)) {
                let addedCategoriesSplit = addedCategories.split(';');
                var newAddedCategoriesString = "";

                //Legge til alle kategorier som ikke er den ønskede kategorien i en string separert med semikolon
                for (let i = 0; i < addedCategoriesSplit.length; i++) {
                    if (addedCategoriesSplit[i] !== collapsibleName) {
                        if (newAddedCategoriesString !== "") {
                            newAddedCategoriesString += ";";
                        }
                        newAddedCategoriesString += addedCategories[i];
                    }
                }

                //Sett den nye stringen som listen over lagt til collapsibles
                if (newAddedCategoriesString === "") {
                    console.log("Lagrer opprettedeCollapsibles som: " + newAddedCategoriesString)
                    localStorage.removeItem("opprettedeCollapsibles");
                }else {
                    console.log("Lagrer opprettedeCollapsibles som: " + newAddedCategoriesString)
                    localStorage.setItem("opprettedeCollapsibles", newAddedCategoriesString);
                }

                saveLocalProsjektID();
            }
        }

        function saveAddedCategory(name) {
            var addedCategories = localStorage.getItem("opprettedeCollapsibles");
            if (addedCategories == null) addedCategories = "";
            if (addedCategories !== "") {
                addedCategories += ";";
            }
            if (!addedCategories.includes(name)) {
                addedCategories += name;
                localStorage.setItem("opprettedeCollapsibles", addedCategories);
                saveLocalProsjektID();
            }
        }

        function loadAddedCollapsibles() {
            let addedCategories = localStorage.getItem("opprettedeCollapsibles");
            if (addedCategories == null || addedCategories === "") {
                return;
            }
            let addedCategoriesSplit = addedCategories.split(";");
            for (let i = 0; i < addedCategoriesSplit.length; i++) {
                createCollapsibleType(addedCategoriesSplit[i]);
            }
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
                console.log("Clearer localstorage fordi local prosjektID ikke matcher prosjektID som vi redigerer")
                localStorage.clear();
            }
        }

        function localProsjektIDMatchesUrlProsjektID(prosjektIDSpecialSaveLocation) {
            const urlParams = new URLSearchParams(window.location.search);
            var editProsjektID = urlParams.get('editProsjektID');
            var prosjektIDFromLocalStorage = "";
            if (prosjektIDSpecialSaveLocation == null) {
                prosjektIDFromLocalStorage = localStorage.getItem("prosjektID");
            }else {
                prosjektIDFromLocalStorage = localStorage.getItem(prosjektIDSpecialSaveLocation);
            }


            if (editProsjektID == null) editProsjektID = "";
            if (prosjektIDFromLocalStorage == null) prosjektIDFromLocalStorage = "";
            if (prosjektIDFromLocalStorage === "null") prosjektIDFromLocalStorage = "";

            return editProsjektID === prosjektIDFromLocalStorage;
        }

        function saveLocalProsjektID() {
            const urlParams = new URLSearchParams(window.location.search);
            let prosjektIDSaveLocations = ["prosjektID"];
            //, "prosjektID_milepaeler", "prosjektID_prosjektteam"
            let editProsjektID = urlParams.get('editProsjektID');
            for (let i = 0; i < prosjektIDSaveLocations.length; i++) {
                localStorage.setItem(prosjektIDSaveLocations[i], editProsjektID);
            }
        }

        /*
        ------------------- SAVERS -------------------
         */

        function getSavedText() {
            const lagretText = document.createElement('span');
            lagretText.classList.add('savedText');
            lagretText.innerText = "...";
            return lagretText;
        }

        function addTextSaver(textbox, savedLabel, localsave) {
            const urlParams = new URLSearchParams(window.location.search);
            var editProsjektID = urlParams.get('editProsjektID');
            var prosjektIDFromLocalStorage = localStorage.getItem("prosjektID");
            var sistLagretStorage = localStorage.getItem(localsave + "_time");

            if (editProsjektID == null) editProsjektID = "";
            if (prosjektIDFromLocalStorage == null) prosjektIDFromLocalStorage = "";
            if (prosjektIDFromLocalStorage === "null") prosjektIDFromLocalStorage = "";

            console.log("Hi")
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
                console.log("Cleared localstorage, because we are not on the same project")
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

        function addSpecialSaver(arrayWithBrothers, textbox, textboxNumber, savedLabel, localsave) {
            const urlParams = new URLSearchParams(window.location.search);
            var editProsjektID = urlParams.get('editProsjektID');
            var prosjektIDFromLocalStorage = localStorage.getItem("prosjektID_" + localsave);
            let sistLagretStorage = localStorage.getItem(localsave + "_time");

            arrayWithBrothers[arrayWithBrothers.length] = textbox;

            if (editProsjektID == null) editProsjektID = "";
            if (prosjektIDFromLocalStorage == null) prosjektIDFromLocalStorage = "";
            if (prosjektIDFromLocalStorage === "null") prosjektIDFromLocalStorage = "";

            //TODO: Prøv i morgen:
            //TODO: 1. Legg til milepæl
            //TODO: 2. Skriv noe i den
            //TODO: 3. Refresh og sjekk om det er lagret.
            //TODO: Deretter kan du teste:
            //TODO: 1. Sørg for at localstorage er tom
            //TODO: 2. Prøv å refresh. Hvorfor står det ikke noe i "Milepæler" boksen og i "Prosjekt team" Boksen når disse skulle hatt tekst i følge databasen.
            if (editProsjektID === prosjektIDFromLocalStorage) {
                if (localStorage.getItem(localsave) != null) {
                    const currentTextBoxSavedValue = localStorage.getItem(localsave).split(";")[textboxNumber];
                    if (currentTextBoxSavedValue != null) {
                        textbox.value = currentTextBoxSavedValue;
                    }
                    if (sistLagretStorage == null) {
                        savedLabel.innerText = "...";
                    }else {
                        savedLabel.innerText = "Hentet utkast fra: " + sistLagretStorage;
                    }
                }
            }else {
                console.log("Clearer localstorage, ettersom prosjektID ikke matcher det som er lagret i localstorage")
                localStorage.clear();
            }

            $(textbox).on("input", function(){
                const d = new Date();
                lastKeypress = d.getTime();

                savedLabel.innerText = "...";
                setTimeout(function() {
                    const dt = new Date();
                    if (dt.getTime() > lastKeypress + 250) {
                        saveSpecialFields(arrayWithBrothers,savedLabel,localsave);
                    }
                }, 300);
            });
        }

        function saveSpecialFields(arrayWithBrothers,savedLabel,localsave) {
            const urlParams = new URLSearchParams(window.location.search);
            const editProsjektID = urlParams.get('editProsjektID');

            const dt = new Date();
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
            localStorage.setItem("prosjektID_" + localsave, editProsjektID);
            localStorage.setItem(localsave + "_time", fulltime);
            var saveValue = "";
            for (var i = 0; i < arrayWithBrothers.length; i++) {
                if (document.body.contains(arrayWithBrothers[i])) {
                    if (saveValue.length > 0) {
                        saveValue += ";";
                    }
                    saveValue += arrayWithBrothers[i].value;
                }
            }
            localStorage.setItem(localsave, saveValue);
        }

        function addDropdownSaver(dropdown, savedLabel, localsave) {
            const urlParams = new URLSearchParams(window.location.search);
            var editProsjektID = urlParams.get('editProsjektID');
            var prosjektIDFromLocalStorage = localStorage.getItem("prosjektID_" + localsave);
            let sistLagretStorage = localStorage.getItem(localsave + "_time");

            if (editProsjektID == null) editProsjektID = "";
            if (prosjektIDFromLocalStorage == null) prosjektIDFromLocalStorage = "";
            if (prosjektIDFromLocalStorage === "null") prosjektIDFromLocalStorage = "";

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
                console.log("Clearer LocalStorage siden vi ikke redigerer samme prosjekt som vi har i LocalStorage")
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

    </script>
    <?php
}