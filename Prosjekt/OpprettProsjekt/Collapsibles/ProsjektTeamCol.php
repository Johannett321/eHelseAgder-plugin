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
                const nyPerson = createPerson(null, savedTextInfo);
                personer.appendChild(nyPerson);
                scrollToView(nyPerson);
            });

            const leggTilPersonTekst = document.createElement('h6');
            leggTilPersonTekst.innerText = "Legg til ny person";

            leggTilPersonKnapp.appendChild(leggTilPersonTekst);

            function createPerson(personInfo, savedTextInfo) {
                if (personInfo == null) personInfo = "";
                const personInfoSplit = personInfo.split(",");
                console.log("Prosjektteam sier: " + personInfo);

                peopleInProjectTeam += 1;
                const person = document.createElement('div');
                person.name = peopleInProjectTeam;
                person.classList.add('addPerson');

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
                    if (peopleInProjectTeam == 1) {
                        alert("Kan ikke fjerne alle personene i et prosjektteam. Tips: For å slette prosjekt team kategorien, kan du trykke på 'x' symbolet øverst til høyre av kategorien");
                        return
                    }
                    if (confirm("Er du sikker?") == true) {
                        $(person).animate({opacity: '0%', height: '0px'}, function (){$(person).remove();personRemoved(person.name);});
                    }
                });

                const textBoxesIncludingThis = peopleInProjectTeam*4;

                const rolleField = createMultiSaverTextField("Stilling/rolle: ",
                    "cvtmrolle" + peopleInProjectTeam,
                    "Markedskordinator",
                    personInfoSplit[0],
                    prosjektTeamArray,
                    textBoxesIncludingThis-4,
                    savedTextInfo,
                    "prosjektteam");

                const fulltNavnField = createMultiSaverTextField("Fullt navn: ",
                    "cvtmfulltnavn" + peopleInProjectTeam,
                    "Navn Navnesen",
                    personInfoSplit[1],
                    prosjektTeamArray,
                    textBoxesIncludingThis-3,
                    savedTextInfo,
                    "prosjektteam");

                const epostField = createMultiSaverTextField("E-post: ",
                    "cvtmepost" + peopleInProjectTeam,
                    "navn.navnesen@gmail.com",
                    personInfoSplit[2],
                    prosjektTeamArray,
                    textBoxesIncludingThis-2,
                    savedTextInfo,
                    "prosjektteam");

                const mobilField = createMultiSaverTextField("Mobil: ",
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

                rightSide.appendChild(rolleField);
                rightSide.appendChild(fulltNavnField);
                rightSide.appendChild(epostField);
                rightSide.appendChild(mobilField);

                person.appendChild(leftSide);
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
            }

            collapsible.appendChild(personer);
            collapsible.appendChild(leggTilPersonKnapp);
            collapsible.appendChild(savedTextInfo);
            return collapsible;
        }
    </script>
    <?php
}
