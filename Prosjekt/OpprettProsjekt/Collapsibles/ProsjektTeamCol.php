<?php

function addProsjektTeamCol() {
    ?>
    <script type="text/javascript">
        var peopleInProjectTeam = 0;
        const prosjektTeamArray = [];

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

            const prosjektTeamSavedInfo = localStorage.getItem("prosjektteam");
            if (localProsjektIDMatchesUrlProsjektID("prosjektID_prosjektteam")) {
                if (prosjektTeamSavedInfo != null) {
                    //Vi har lagret en cache på prosjektteamet for dette prosjektet
                    prosjektTeamSavedInfoSplit = prosjektTeamSavedInfo.split(";");

                    let antallPersoner = 1;
                    if (prosjektTeamSavedInfoSplit.length > 0) antallPersoner = prosjektTeamSavedInfoSplit.length / 4;
                    console.log(antallPersoner);

                    for (var i = 0; i < antallPersoner; i++) {
                        const person = createPerson(null, savedTextInfo);
                        personer.appendChild(person);
                    }
                }
            }else {
                if (innhold === "") {
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
            }

            const leggTilPersonKnapp = document.createElement('button');
            leggTilPersonKnapp.classList.add('addPersonButton');
            leggTilPersonKnapp.type = "button";
            leggTilPersonKnapp.addEventListener("click", function () {
                for(var i = 1; i < 30; i++) {
                    if (document.getElementById('cvtmfulltnavn'+i) == null) {
                        break;
                    }
                    if (document.getElementById('cvtmfulltnavn'+i).value === "") {
                        alert("Du må fylle ut navn på alle personene du har lagt til, før du kan legge til flere personer.");
                        return;
                    }
                }
                const nyPerson = createPerson(null, savedTextInfo);
                personer.appendChild(nyPerson);
                scrollToView(nyPerson);
            });

            const leggTilPersonTekst = document.createElement('h6');
            leggTilPersonTekst.innerText = "Legg til ny person";

            leggTilPersonKnapp.appendChild(leggTilPersonTekst);

            function createPerson(personInfo, savedTextInfo) {
                if (personInfo == null) personInfo = "";
                const personInfoSplit = personInfo.split("--!--");
                console.log("Prosjektteam sier: " + personInfo);

                peopleInProjectTeam += 1;
                const person = document.createElement('div');
                person.name = peopleInProjectTeam;
                person.classList.add('addPerson');

                const rightSide = document.createElement('div');
                rightSide.classList.add('personRightCol');

                const removePersonButton = document.createElement('button');
                removePersonButton.type = "button";
                removePersonButton.innerText = "Fjern person";
                removePersonButton.id = "";
                removePersonButton.name = "";
                $(removePersonButton).click(function (e) {
                    if (peopleInProjectTeam == 1) {
                        alert("Kan ikke fjerne alle personene i et prosjektteam. Tips: For å slette prosjekt team kategorien, kan du trykke på 'x' symbolet øverst til høyre av kategorien");
                        return
                    }
                    if (confirm("Er du sikker på at du vil slette medlemmet?") == true) {
                        $(person).animate({opacity: '0%', height: '0px'}, function (){$(person).remove();personRemoved(person.name);});
                    }
                });

                const textBoxesIncludingThis = peopleInProjectTeam*4;

                const fulltNavnField = createMultiSaverTextField("Fullt navn*",
                    "cvtmfulltnavn" + peopleInProjectTeam,
                    "Navn Navnesen",
                    personInfoSplit[0],
                    prosjektTeamArray,
                    textBoxesIncludingThis-4,
                    savedTextInfo,
                    "prosjektteam");

                const rolleField = createMultiSaverTextField("Stilling/rolle",
                    "cvtmrolle" + peopleInProjectTeam,
                    "Markedskordinator",
                    personInfoSplit[1],
                    prosjektTeamArray,
                    textBoxesIncludingThis-3,
                    savedTextInfo,
                    "prosjektteam");

                const epostField = createMultiSaverTextField("E-post",
                    "cvtmepost" + peopleInProjectTeam,
                    "navn.navnesen@gmail.com",
                    personInfoSplit[2],
                    prosjektTeamArray,
                    textBoxesIncludingThis-2,
                    savedTextInfo,
                    "prosjektteam");

                const mobilField = createMultiSaverTextField("Mobil",
                    "cvtmmobil" + peopleInProjectTeam,
                    "902 26 981",
                    personInfoSplit[3],
                    prosjektTeamArray,
                    textBoxesIncludingThis-1,
                    savedTextInfo,
                    "prosjektteam");

                if (peopleInProjectTeam !== 1) {
                    const line = document.createElement('hr');
                    person.appendChild(line);
                }

                rightSide.appendChild(fulltNavnField);
                rightSide.appendChild(rolleField);
                rightSide.appendChild(epostField);
                rightSide.appendChild(mobilField);

                person.appendChild(rightSide);
                person.appendChild(removePersonButton);

                return person;
            }

            /*TODO:
            I stedenfor å skrive localStorage.removeItem, kan jeg heller skrive:
            localStorage.setItem("NAVN", "GONE");
            deretter kan jeg i delen hvor den loades skrive følgende:
            for (int i = 0; i  < liste.length; i++)
            if (liste[i] == "GONE") i -= 1;
             */

            function personRemoved(personNumber) {
                peopleInProjectTeam -= 1;
                saveSpecialFields(prosjektTeamArray,savedTextInfo,"prosjektteam")
                correctProsjektTeamFieldNames();
            }

            function correctProsjektTeamFieldNames() {
                const prosjektTeamFields = document.getElementsByClassName("addPerson");
                for (let i = 0; i < prosjektTeamFields.length; i++) {
                    const correctNumber = i+1;
                    const fullNameField = prosjektTeamFields[i].getElementsByTagName('input')[0];
                    const roleField = prosjektTeamFields[i].getElementsByTagName('input')[1];
                    const eMailField = prosjektTeamFields[i].getElementsByTagName('input')[2];
                    const phoneField = prosjektTeamFields[i].getElementsByTagName('input')[3];

                    correctIDAndName(fullNameField, "cvtmfulltnavn" + correctNumber)
                    correctIDAndName(roleField, "cvtmrolle" + correctNumber)
                    correctIDAndName(eMailField, "cvtmepost" + correctNumber)
                    correctIDAndName(phoneField, "cvtmmobil" + correctNumber)

                    function correctIDAndName(object, correctValue) {
                        object.id = correctValue;
                        object.name = correctValue;
                    }
                }
            }

            collapsible.appendChild(personer);
            collapsible.appendChild(leggTilPersonKnapp);
            collapsible.appendChild(savedTextInfo);
            return collapsible;
        }
    </script>
    <?php
}
