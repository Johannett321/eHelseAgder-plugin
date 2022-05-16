<?php

/**
 * Lager et liste element. Brukes blant annet til "Alle prosjekter" og "Alle arrangementer"
 * @param $title string tittelen som skal brukes
 * @param $description string teksten som står under tittelen.
 * @param $uElement1 string det første elementet under linjen. Kan f.eks være dato
 * @param $uElement2 string det andre elementet under linjen. Kan f.eks være sted
 * @param $image string linken til bilde som skal brukes. Trenger ikke starten av linken, kun slutten
 * @param $linkHref string linken som elementet skal ta deg til.
 * @param string $specialClass dersom det skal være noe ekstra klasser på elementet.
 * @return void
 */
function createLargeListItem($title, $description, $uElement1, $uElement2, $image, $linkHref, $specialClass = "") {
    ?>
    <a href = "<?php echo $linkHref?>">
        <div class = "artikkelKort <?php echo $specialClass?>">
            <?php
            if ($image != null) {
                ?>
                <div class="photoSmall">
                    <?php
                    if (strpos($image, "wp-content")) {
                        $photoUrl = $image;
                    }else {
                        $photoUrl = getPhotoUploadUrl() . $image;
                    }
                    ?>
                    <img src = "<?php echo $photoUrl ?>"/>
                </div>
                <?php
            }
            ?>
            <div class="artikkelkorttekst<?php if ($image == null) echo " nophoto"?>">
                <h5><?php echo $title ?></h5>
                <p><?php echo $description ?></p>
                <div id="additInfo"><?php echo $uElement1 . " · " . $uElement2; ?></div>
            </div>
        </div>
    </a>
    <?php
}

/**
 * Opretter et lite liste element. Brukes blant annet i "arrangementarkiv"
 * @param $title string tittelen på listeobjektet
 * @param $description string beskrivelsen som skla vises under tittelen
 * @param $bottomElement string et lite tekstelement som vises i bunn
 * @param $image string linken til bilde som skal vises. Trenger ikke starten av linken
 * @param $href string linken brukeren skal bli tatt til når de trykker på listeelementet.
 * @param string $specialClass dersom det skal være noe ekstra klasser på elementet.
 * @return void
 */
function createSmallListItem($title, $description, $bottomElement, $image, $href, $specialClass = "") {
    ?>
    <a href = "<?php echo $href ?>">
        <div class = "artikkelKort <?php echo $specialClass?>">
            <?php
            if ($image != null) {
                ?>
                <div class="photoSmall">
                    <?php
                    if (strpos($image, "wp-content")) {
                        $photoUrl = $image;
                    }else {
                        $photoUrl = getPhotoUploadUrl() . $image;
                    }
                    ?>
                    <img src = "<?php echo $photoUrl ?>"/>
                </div>
                <?php
            }
            ?>
            <div class="artikkelkorttekst<?php if ($image == null) echo " nophoto"?>">
                <h5><?php echo $title ?></h5>
                <p><?php echo $description ?></p>
                <div id="additInfo"><?php echo $bottomElement?></div>
            </div>
        </div>
    </a>
    <?php
}

/**
 * Legger til et HTML element som teller characters i et tekstfelt. Den viser brukeren hvor mange tegn som gjenstår
 * @param $textFieldID string id'en til html elementet du vil legge til en teller på.
 * @return void
 */
function addCharacterCounter($textFieldID) {
    ?>
    <span id ="<?php echo $textFieldID . "counter" ?>" class="inputFieldCounter">0/0</span>
    <script type="text/javascript">
        <?php echo $textFieldID . "()"?>

        function <?php echo $textFieldID?>() {
            const inputField = document.getElementById('<?php echo $textFieldID?>');
            const inputFieldCounter = document.getElementById('<?php echo $textFieldID . "counter"?>');
            const fieldMaxLength = inputField.maxLength;

            inputFieldCounter.innerText = inputField.value.length + "/" + fieldMaxLength;

            $(inputField).on("input", function(){
                inputFieldCounter.innerText = inputField.value.length + "/" + fieldMaxLength;
            });
        }
    </script>
    <?php
}

/**
 * Legger til en informasjonsknapp på siden, som viser en informasjonsboks når brukeren hovrer musen over knappen
 * @param $randomID string En tilfeldig id som brukes når javascript skal opprette metodene, uten at det blir konflikter på siden.
 * @param $innhold string teksten som skal stå i info boksen
 * @return void
 */
function addInfoBox($randomID, $innhold) {
    ?>
    <span class="material-icons infoButton" id = "<?php echo $randomID?>infoButton">
        info
    </span>
    <div class = "hovedInfoBox hidden" id = "<?php echo $randomID?>hovedInfoBox">
        <?php echo $innhold ?>
    </div>

    <script type="text/javascript">
        <?php echo $randomID . "()"?>

        function <?php echo $randomID ?>() {
            const infoButton = document.getElementById('<?php echo $randomID?>infoButton');
            const hovedInfoBox = document.getElementById('<?php echo $randomID?>hovedInfoBox');

            $(infoButton).mouseenter(function() {
                hovedInfoBox.classList.remove("hidden");
            }).mouseleave(function() {
                hovedInfoBox.classList.add("hidden");
            });
        }
    </script>

    <style>
        .infoButton {
            cursor: default;
        }
    </style>
    <?php
}

function addSubmitButtonWithVerification($formId, $requiredFields, $notRequiredFields) {
    ?>
    <div class = "buttons">
        <button type = "button" class = "button" id = "submitButton" value = "Videre">Fortsett</button>
    </div>
    <script type="text/javascript">
        const myForm = document.getElementById('<?php echo $formId ?>');

        $('#submitButton').click(function() {
            verifyFields();

            function verifyFields() {
                <?php
                foreach ($requiredFields as $field) {
                    ?>
                    if (document.getElementById('<?php echo $field?>').value.length === 0) {
                        alert("Vennligst fyll ut alle feltene som er markert med *");
                        return;
                    }
                    if (stringContainsIllegalChars(document.getElementById('<?php echo $field?>').value)) {
                        alert("Du kan ikke bruke tegnene '--!--' eller ';' i teksten du skrev i feltet: <?php echo $field ?>")
                        return;
                    }
                <?php
                }
                foreach ($notRequiredFields as $field) {
                ?>
                    if (stringContainsIllegalChars(document.getElementById('<?php echo $field?>').value)) {
                        alert("Du kan ikke bruke tegnene '--!--' eller ';' i teksten du skrev i feltet: <?php echo $field ?>")
                        return;
                    }
                <?php
                }
                ?>

                myForm.submit();
            }
        });

        function stringContainsIllegalChars(myString) {
            if (myString.includes(";")) {
                return true;
            }
            if (myString.includes("--!--")) {
                return true;
            }
            return false;
        }
    </script>
    <?php
}

/**
 * Synkroniserer høyden på bilde med kort oppsummert boksen ved siden av på for eksempel prosjektsiden.
 */
function insertSyncCoverPhotoAndSummaryJS() {
    ?>
    <script type="text/javascript">
        const coverPhoto = document.getElementById('coverPhoto');
        const coverPhotoImg = document.getElementById('coverPhotoImg');
        const oppsummert = document.getElementById('oppsummert');

        console.log("Setting heigth to: " + $(oppsummert).height())
        $(coverPhotoImg).height($(oppsummert).innerHeight());
        $(coverPhoto).height($(oppsummert).innerHeight());
    </script>
    <?php
}

/**
 * Setter inn en a tag foran linker i tekst, slik at disse blir klikkbare.
 * @param $elementID
 */
function transformLinkInTextToClickableJS($elementID) {
    ?>
    <script type="text/javascript">
        console.log("Transforming...")
        document.getElementById('<?php echo $elementID?>').innerHTML = document.getElementById('<?php echo $elementID?>').innerHTML.replace(/(\b(https?|ftp|file):\/\/[-A-Z0-9+ÆØÅ&@#\/%?=~_|!:,.;]*[-A-Z0-9+ÆØÅ&@#\/%=~_|])/ig, "<a href='$1'>$1</a>");
        console.log(document.getElementById('<?php echo $elementID?>').innerHTML);
    </script>
    <?php
}
