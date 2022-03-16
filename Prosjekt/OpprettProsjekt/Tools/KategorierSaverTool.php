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
                    localStorage.removeItem("opprettedeCollapsibles");
                }else {
                    localStorage.setItem("opprettedeCollapsibles", newAddedCategoriesString);
                }
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
            }
        }

        function loadAddedCollapsibles() {
            let addedCategories = localStorage.getItem("opprettedeCollapsibles");
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
                localStorage.clear();
            }
        }

        function getSavedText() {
            const lagretText = document.createElement('span');
            lagretText.classList.add('savedText');
            lagretText.innerText = "...";
            return lagretText;
        }

        function localProsjektIDMatchesUrlProsjektID() {
            const urlParams = new URLSearchParams(window.location.search);
            const editProsjektID = urlParams.get('editProsjektID');
            const prosjektIDFromLocalStorage = localStorage.getItem("prosjektID");
            return editProsjektID === prosjektIDFromLocalStorage;
        }

        function addTextSaver(textbox, savedLabel, localsave) {
            const urlParams = new URLSearchParams(window.location.search);
            const editProsjektID = urlParams.get('editProsjektID');
            const prosjektIDFromLocalStorage = localStorage.getItem("prosjektID");
            var sistLagretStorage = localStorage.getItem(localsave + "_time");

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
            const editProsjektID = urlParams.get('editProsjektID');
            const prosjektIDFromLocalStorage = localStorage.getItem("prosjektID");
            var sistLagretStorage = localStorage.getItem(localsave + "_time");

            arrayWithBrothers[arrayWithBrothers.length] = textbox;

            if (editProsjektID == prosjektIDFromLocalStorage) {
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

    </script>
    <?php
}