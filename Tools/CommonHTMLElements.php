<?php

/**
 * Lager et liste element. Brukes blant annet til "Alle prosjekter" og "Alle arrangementer"
 * @param $title string tittelen som skal brukes
 * @param $description string teksten som står under tittelen.
 * @param $uElement1 string det første elementet under linjen. Kan f.eks være dato
 * @param $uElement2 string det andre elementet under linjen. Kan f.eks være sted
 * @param $image string linken til bilde som skal brukes. Trenger ikke starten av linken, kun slutten
 * @param $linkHref string linken som elementet skal ta deg til.
 * @return void
 */
function createLargeListItem($title, $description, $uElement1, $uElement2, $image, $linkHref) {
    ?>
    <a href = "<?php echo $linkHref?>">
        <div class = "largeListCard">
            <div class="photoSmall">
                <img src = "<?php echo getPhotoUploadUrl() . $image ?>"/>
            </div>
            <div class="artikkelkorttekst">
                <h5><?php echo $title ?></h5>
                <p><?php echo $description ?></p>
                <hr>
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
 * @return void
 */
function createSmallListItem($title, $description, $bottomElement, $image, $href) {
    ?>
    <a href = "<?php echo $href ?>">
        <div class = "artikkelKort">
            <div class="photoSmall">
                <img src = "<?php echo getPhotoUploadUrl() . $image ?>"/>
            </div>
            <div class="artikkelkorttekst">
                <h5><?php echo $title ?></h5>
                <p><?php echo $description ?></p>
                <div id="additInfo"><?php echo $bottomElement?></div>
            </div>
        </div>
    </a>
    <?php
}

/**
 * Legger til eth HTML element som teller characters i et tekstfelt. Den viser brukeren hvor mange tegn som gjenstår
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
    <style>
        .inputFieldCounter {
            position: sticky;
            float: right;
            margin-right: 5px;
            transform: translate(0, -170%);

            font-size: 15px;
            color: gray;
        }
    </style>
    <?php
}