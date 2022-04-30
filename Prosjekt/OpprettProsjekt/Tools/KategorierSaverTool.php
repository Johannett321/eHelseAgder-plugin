<?php
function addKategorierSaverTool($onlineRevisionNumber) {
    ?>
    <script type="text/javascript">
        clearLocalStorageIfWrongProjectOrTooOld(<?php echo $onlineRevisionNumber?>);

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
            if (!addedCategories.includes(name) || name === "cegenkategori") {
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
                savedLabel.innerText = "Hentet kategorien fra prosjektet";
                console.log("Sletter " + localsave + " fra localStorage, fordi denne er lagret for et annet prosjekt.")
                localStorage.removeItem(localsave + "_time");
                localStorage.removeItem(localsave);
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

            if (editProsjektID === prosjektIDFromLocalStorage) {
                if (localStorage.getItem(localsave) != null) {
                    const currentTextBoxSavedValue = localStorage.getItem(localsave).split(";")[textboxNumber];
                    if (currentTextBoxSavedValue != null) {
                        textbox.value = currentTextBoxSavedValue;
                    }
                    if (sistLagretStorage == null) {
                        savedLabel.innerText = "Hentet kategorien fra prosjektet";
                    }else {
                        savedLabel.innerText = "Hentet utkast fra: " + sistLagretStorage;
                    }
                }else {
                    savedLabel.innerText = "Hentet kategorien fra prosjektet";
                }
            }else {
                savedLabel.innerText = "Hentet kategorien fra prosjektet";
                console.log("Sletter " + localsave + " fra localStorage, fordi denne er lagret for et annet prosjekt.")
                localStorage.removeItem(localsave + "_time");
                localStorage.removeItem(localsave);
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

        function addDropdownSaver(arrayWithBrothers, dropdown, savedLabel, localsave) {
            const urlParams = new URLSearchParams(window.location.search);

            console.log("prosjektID_" + localsave);
            var editProsjektID = urlParams.get('editProsjektID');
            var prosjektIDFromLocalStorage = localStorage.getItem("prosjektID_" + localsave);
            let sistLagretStorage = localStorage.getItem(localsave + "_time");

            //arrayWithBrothers[arrayWithBrothers.length] = textbox;

            if (editProsjektID == null) editProsjektID = "";
            if (prosjektIDFromLocalStorage == null) prosjektIDFromLocalStorage = "";
            if (prosjektIDFromLocalStorage === "null") prosjektIDFromLocalStorage = "";

            if (editProsjektID === prosjektIDFromLocalStorage) {
                if (localStorage.getItem(localsave) != null) {
                    if (sistLagretStorage == null) {
                        savedLabel.innerText = "Hentet kategorien fra prosjektet";
                    }else {
                        savedLabel.innerText = "Hentet utkast fra: " + sistLagretStorage;
                    }
                }else {
                    savedLabel.innerText = "Hentet kategorien fra prosjektet";
                }
            }else {
                savedLabel.innerText = "Hentet kategorien fra prosjektet";
                console.log("Sletter " + localsave + " fra localStorage, fordi denne er lagret for et annet prosjekt.")
                localStorage.removeItem(localsave + "_time");
                localStorage.removeItem(localsave);
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

        function clearLocalStorageIfWrongProjectOrTooOld(onlineRevisionNumber) {
            const urlParams = new URLSearchParams(window.location.search);
            const editProsjektID = urlParams.get('editProsjektID');
            var prosjektIDFromLocalStorage = localStorage.getItem("prosjektID");
            var localRevisionNumber = localStorage.getItem("revision");

            if (prosjektIDFromLocalStorage != null) {
                if (prosjektIDFromLocalStorage !== editProsjektID) {
                    if (!confirm("Ved å redigere dette prosjektet, blir alle utkast overskrevet. Ønsker du fortsatt å redigere?")) {
                        history.back();
                        return;
                    }

                    console.log("Clearer localstorage fordi local prosjektID ikke matcher prosjektID som vi redigerer")
                    localStorage.clear();
                    localRevisionNumber = null;
                }
            }

            if (localRevisionNumber != null) {
                if (parseInt(onlineRevisionNumber) >= parseInt(localRevisionNumber)) {
                    console.log("Clearer localstorage fordi noen har redigert online versjonen, og min versjon er derfor utdatert.")
                    alert("Noen har redigert dette prosjektet etter deg, og ditt utkast er derfor utdatert.")
                    localStorage.clear();
                }
                localStorage.setItem("prosjektID", editProsjektID);
            }else {
                console.log("Online revision: " + onlineRevisionNumber + " local revision: " + localStorage.getItem("revision"));
            }

            localStorage.setItem("revision", "<?php echo $_SESSION['correctLocalRevision']?>");
        }

    </script>
    <?php
}