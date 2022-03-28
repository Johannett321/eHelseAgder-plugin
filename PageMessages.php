<?php

/**
 * Genererer en HTML blokk med en egendefinert errormelding
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