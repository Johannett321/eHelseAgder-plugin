<?php

/**
 * Genererer en HTML blokk med en egendefinert completemelding
 * @param string Meldingen som skal vises
 */
function showCompleteMessage($message) {
    ?>
    <div class = "infoBlokk">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <span class="material-icons">
            error
        </span>
        <h5><?php echo $message ?></h5>
    </div>
    <?php
}

function createPopupBox($title, $message) {
    ?>
    <div class = "popupHolder" id = "popupHolder">
        <div style="background-color: black; width: 100%; height: 100%; opacity: 30%;"></div>
        <div class = "popupBox">
            <h3><?php echo $title ?></h3>
            <p><?php echo $message ?></p>
            <button type="button" id = "closePopupButton">Til forhåndsvisning</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script type = "text/javascript">
        const closebutton = document.getElementById("closePopupButton");
        const popupHolder = document.getElementById("popupHolder");

        document.body.classList.add("noscroll");

        closebutton.onclick = function () {
            popupHolder.classList.add("hidden");
            document.body.classList.remove("noscroll");
        }
    </script>
    <?php
}