<?php

add_shortcode('sc_message_display', 'sc_message_display');

function sc_message_display() {
    if (areElementorBufferingObjects()) return;
    if (areWeEditingWithElementor()) {
        showCompleteMessage("Her vil viktige meldinger vises!");
        return;
    }
    if (isset($_GET['message'])) {
        showCompleteMessage($_GET['message']);
    }else if (isset($_GET['errorMessage'])) {
        showErrorMessage($_GET['errorMessage']);
    }
}

/**
 * Genererer en HTML blokk med en egendefinert completemelding
 * @param string Meldingen som skal vises
 */
function showCompleteMessage($message) {
    ?>
    <div class = "infoBlokk">
        <span class="material-icons">
            done
        </span>
        <h5><?php echo $message ?></h5>
    </div>
    <?php
}

/**
 * Genererer en HTML blokk med en egendefinert errormelding
 * @param string Meldingen som skal vises
 */
function showErrorMessage($message) {
    ?>
    <div class = "infoBlokk">
        <span class="material-icons">
            error
        </span>
        <h6><?php echo $message ?></h6>
    </div>
    <?php
}

/**
 * Fjerner page messages dersom det er noen.
 */
function removePageMessageIfPresent() {
    if (isset($_GET['message'])) {
        ?>
        <script type="text/javascript">

            if (typeof oldDocTitle === 'undefined') {
                const oldDocTitle = window.location + '';
                console.log("Old doc: " + oldDocTitle);
                const parameters = oldDocTitle.split("?")[1] + '';
                const parametersArray = parameters.split("&");
                var newDocTitle = "";
                for (var i = 0; i < parametersArray.length; i++) {
                    const currentParSplit = parametersArray[i].split("=");
                    if (currentParSplit[0] === "message") {
                        newDocTitle = oldDocTitle.replace("message=" + currentParSplit[1],"");
                        console.log("Replacing: " + "message=" + currentParSplit[1])
                        break;
                    }
                }

                console.log("New doc: " + newDocTitle);
                window.history.replaceState({}, newDocTitle);
            }
        </script>
        <?php
        return;
    }
}

function createPopupBox($title, $message) {
    ?>
    <div class = "popupHolder" id = "popupHolder">
        <div style="background-color: black; width: 100%; height: 100%; opacity: 30%;"></div>
        <div class = "popupBox">
            <h3><?php echo $title ?></h3>
            <p><?php echo $message ?></p>
            <button type="button" id = "backButtonPopup"><i class="material-icons">arrow_back</i>Tilbake til redigering</button>
            <button type="button" id = "closePopupButton">Til forhåndsvisning</button>
        </div>
    </div>

    <script type = "text/javascript">
        const closebutton = document.getElementById("closePopupButton");
        const backButtonPopup = document.getElementById('backButtonPopup');
        const popupHolder = document.getElementById("popupHolder");

        document.body.classList.add("noscroll");

        backButtonPopup.onclick = function () {
            history.back();
        }

        closebutton.onclick = function () {
            popupHolder.classList.add("hidden");
            document.body.classList.remove("noscroll");
        }
    </script>
    <?php
}