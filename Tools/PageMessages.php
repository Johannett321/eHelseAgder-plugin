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
            <button type="button" id = "closePopupButton">Den er god!</button>
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

    <style>
        .popupHolder {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 5;
        }

        .popupBox {
            position: fixed;
            max-width: 700px;
            height: fit-content;
            padding: 20px;

            top: 50%;
            left: 50%;
            right: 0;
            bottom: 0;
            transform: translate(-50%, -50%);
            z-index: 10;

            border-radius: 20px;
            background-color: white;
            color: black;
        }

        .noscroll {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
    </style>
    <?php
}