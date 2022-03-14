<?php

function addMilepaelerCol() {
    ?>
    <script type="text/javascript">
        var milepaelCounter = 0;

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

            const leggTilMilepaelTekst = document.createElement('h6');
            leggTilMilepaelTekst.innerText = "Legg til ny milepæl";

            leggTilMilepaelKnapp.appendChild(leggTilMilepaelTekst);

            collapsible.appendChild(milepaeler);
            collapsible.appendChild(leggTilMilepaelKnapp);

            function createMilepael(currentMilepaelInfo, savedTextInfo) {
                if (currentMilepaelInfo == null) currentMilepaelInfo = "";
                const milepaelInfoSplit = currentMilepaelInfo.split(",");

                const currentMilepael = document.createElement('div');
                currentMilepael.classList.add("milepael");

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
                currentMilepael.append(removeMilepaelButton);

                return currentMilepael;
            }

            collapsible.appendChild(savedTextInfo);
            collapsibles.appendChild(collapsible);
            scrollToView(collapsible);
        }
    </script>
    <?php
}
