<?php

function addMilepaelerCol() {
    ?>
    <script type="text/javascript">
        var milepaelCounter = 0;
        const milepaelArray = [];

        function createMilepaelerCol(innhold) {
            if (innhold == null) innhold = "";

            const collapsible = createCollapsibleWithTitle("Milepæler", "cmilepaeler");
            if (collapsible == null) return;
            const milepaeler = document.createElement('div');

            const savedTextInfo = getSavedText();

            const milepaelSavedInfo = localStorage.getItem("milepaeler");
            if (localProsjektIDMatchesUrlProsjektID("prosjektID_milepaeler")) {
                if (milepaelSavedInfo != null) {
                    //Vi har lagret en cache på milepaeler for dette prosjektet
                    milepaelerSavedInfoSplit = milepaelSavedInfo.split(";");

                    let antallMilepaeler = 1;
                    if (milepaelerSavedInfoSplit.length > 0) antallMilepaeler = milepaelerSavedInfoSplit.length / 3;
                    console.log(antallMilepaeler);

                    for (var i = 0; i < antallMilepaeler; i++) {
                        console.log("Saved info milepaeler: " + savedTextInfo)
                        const milepael = createMilepael(null, savedTextInfo);
                        milepaeler.appendChild(milepael);
                    }
                }
            }else {
                if (innhold === "") {
                    //Prosjektet blir ikke redigert, så vi laster bare en milepael slik som i malen
                    const milepael = createMilepael(null, savedTextInfo);
                    milepaeler.appendChild(milepael);
                }else {
                    const innholdSplit = innhold.split(";");
                    for (let i = 0; i < innholdSplit.length; i++) {
                        const milepael = createMilepael(innholdSplit[i], savedTextInfo);
                        milepaeler.appendChild(milepael);
                    }
                }
            }

            const leggTilMilepaelKnapp = document.createElement('button');
            leggTilMilepaelKnapp.classList.add('addPersonButton');
            leggTilMilepaelKnapp.type = "button";
            leggTilMilepaelKnapp.addEventListener("click", function () {
                for(var i = 1; i < 30; i++) {
                    if (document.getElementById('cmtittel'+i) == null) {
                        break;
                    }
                    if (document.getElementById('cmtittel'+i).value === "") {
                        alert("Du må fylle ut tittelen på alle de forrige milepælene, før du kan legge til en ny!");
                        return;
                    }
                }

                const nyMilepael = createMilepael(null, savedTextInfo);
                milepaeler.appendChild(nyMilepael);
                scrollToView(nyMilepael);
            });

            const leggTilMilepaelTekst = document.createElement('h6');
            leggTilMilepaelTekst.innerText = "Legg til ny milepæl";

            leggTilMilepaelKnapp.appendChild(leggTilMilepaelTekst);

            collapsible.appendChild(milepaeler);
            collapsible.appendChild(leggTilMilepaelKnapp);

            function createMilepael(currentMilepaelInfo, savedTextInfo) {
                if (currentMilepaelInfo == null) currentMilepaelInfo = "";
                const milepaelInfoSplit = currentMilepaelInfo.split("--!--");
                console.log("Milepaeler sier: " + currentMilepaelInfo);

                milepaelCounter += 1;
                const currentMilepael = document.createElement('div');
                currentMilepael.classList.add("milepael");
                currentMilepael.name = milepaelCounter;

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
                if (currentMilepaelInfo === "") disabledOption.selected = true;
                disabledOption.innerText = "Velg status";

                doneOption.value = "3";
                if (milepaelInfoSplit[1] === "3") doneOption.selected = true;
                doneOption.innerText = "Ferdig";

                ongoingOption.value = "2";
                if (milepaelInfoSplit[1] === "2") ongoingOption.selected = true;
                ongoingOption.innerText = "Pågående";

                notStartedOption.value = "1";
                if (milepaelInfoSplit[1] === "1") notStartedOption.selected = true;
                notStartedOption.innerText = "Ikke startet";

                const label = document.createElement('label');
                label.for = "milepaeldropdown" + milepaelCounter;
                label.innerText = "Status*";

                const removeMilepaelButton = document.createElement('button');
                removeMilepaelButton.type = "button";
                removeMilepaelButton.innerText = "Fjern milepæl";
                $(removeMilepaelButton).click(function (e) {
                    if (confirm("Er du sikker på at du vil slette milepælen?") == true) {
                        $(currentMilepael).animate({opacity: '0%', height: '0px'}, function (){$(currentMilepael).remove();milepaelRemoved(currentMilepael.name)});
                    }
                });

                dropdown.appendChild(disabledOption);
                dropdown.appendChild(doneOption);
                dropdown.appendChild(ongoingOption);
                dropdown.appendChild(notStartedOption);

                container.appendChild(label);
                container.appendChild(dropdown);

                addDropdownSaver(dropdown, savedTextInfo, "cmdropdown" + milepaelCounter, "milepaeler");

                const textBoxesIncludingThis = milepaelCounter*3;

                const titleField = createMultiSaverTextField("Tittel*",
                    "cmtittel" + milepaelCounter,
                    "Signert avtale",
                    milepaelInfoSplit[0],
                    milepaelArray,
                    textBoxesIncludingThis-3,
                    savedTextInfo,
                    "milepaeler");

                const kontaktpersonField = createMultiSaverTextField("Kontaktperson",
                    "cmcontact" + milepaelCounter,
                    "navn.navnesen@gmail.com",
                    milepaelInfoSplit[2],
                    milepaelArray,
                    textBoxesIncludingThis-2,
                    savedTextInfo,
                    "milepaeler");

                const dateField = createMultiSaverTextField("Dato",
                    "cmdate" + milepaelCounter,
                    "31.10.2022",
                    milepaelInfoSplit[3],
                    milepaelArray,
                    textBoxesIncludingThis-1,
                    savedTextInfo,
                    "milepaeler");



                currentMilepael.append(container);
                currentMilepael.append(titleField);
                currentMilepael.append(kontaktpersonField);
                currentMilepael.append(dateField);
                currentMilepael.append(removeMilepaelButton);

                return currentMilepael;
            }

            collapsible.appendChild(savedTextInfo);
            collapsibles.appendChild(collapsible);
            scrollToView(collapsible);

            function milepaelRemoved(milepaelNumber) {
                milepaelCounter -= 1;
                saveSpecialFields(milepaelArray,savedTextInfo,"milepaeler");
                correctMilepaelerFieldNames();
            }

            function correctMilepaelerFieldNames() {
                const milepaelerFields = document.getElementsByClassName("milepael");
                for (let i = 0; i < milepaelerFields.length; i++) {
                    const correctNumber = i+1;
                    const dropdown = milepaelerFields[i].getElementsByTagName('select')[0];
                    const tittelField = milepaelerFields[i].getElementsByTagName('input')[0];
                    const contactPersonField = milepaelerFields[i].getElementsByTagName('input')[1];
                    const dateField = milepaelerFields[i].getElementsByTagName('input')[2];

                    correctIDAndName(dropdown, "milepaeldropdown" + correctNumber)
                    correctIDAndName(tittelField, "cmtittel" + correctNumber)
                    correctIDAndName(contactPersonField, "cmcontact" + correctNumber)
                    correctIDAndName(dateField, "cmdate" + correctNumber)

                    function correctIDAndName(object, correctValue) {
                        object.id = correctValue;
                        object.name = correctValue;
                    }
                }
            }
        }
    </script>
    <?php
}
