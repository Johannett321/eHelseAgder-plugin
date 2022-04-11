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