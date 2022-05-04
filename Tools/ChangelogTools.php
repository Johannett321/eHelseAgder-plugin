<?php

add_shortcode('sc_nyeste_oppdateringer', 'sc_nyeste_oppdateringer');

/**
 * Legger til en hendelse i endringsloggen som vises på forsiden av nettsiden. For eksemptel ved opprettelse av prosjekt.
 * Legger ikke til hendelsen dersom den er for lik den forrige, og skjedde i samme døgn
 * @param $title mixed
 * @param $description mixed
 * @param $href mixed
 */
function addEventToChangelog($title, $description, $href) {
    global $wpdb;

    $lastEntry = $wpdb->get_results("SELECT * FROM " . getChangelogDatabaseRef() . " ORDER BY id DESC LIMIT 1")[0];

    $startDato = strtotime(date('Y-m-d H:i:s'));
    $sluttDato = strtotime($lastEntry->dato);

    $datediff = $sluttDato - $startDato;
    $difference = floor($datediff/(60*60*24));

    if ($lastEntry->tittel == $title
        && $lastEntry->beskrivelse == $description
        && $difference == 0) {
        error_log("For likt forrige entry. Sletter forrige entry");
        $wpdb->delete(getChangelogDatabaseRef(), array("id"=>$lastEntry->id), array("%d"));
    }

    $data = array("tittel" => $title,
        "beskrivelse"=>$description,
        "href"=>$href);
    $format = array("%s", "%s", "%s");
    $wpdb->insert(getChangelogDatabaseRef(), $data, $format);
}

function sc_nyeste_oppdateringer() {
    if (areElementorBufferingObjects()) return;
    global $wpdb;
    $changelog = $wpdb->get_results("SELECT * FROM " . getChangelogDatabaseRef() . " ORDER BY id DESC LIMIT 20");

    ?>
    <div class="changelog" id = "changelog">
        <div class = "changelogTitle">
            <div>Nyeste oppdateringer</div>
            <span class="material-icons" id = "statusPil">chevron_right</span>
        </div>
        <?php
        foreach ($changelog as $changelogItem) {
            ?>
            <div class = "verticalLine"></div>
            <a href = "<?php echo $changelogItem->href ?>" class = "changelogItem">
                <div>
                    <h5><?php echo $changelogItem->tittel ?></h5>
                    <p><?php echo $changelogItem->beskrivelse ?></p>
                    <div class = "changelogTime"> <?php echo getNoneImportantDisplayTimestampFormat($changelogItem->dato) ?></div>
                </div>
            </a>
            <?php
        }

        if (sizeof($changelog) < 1 && areWeEditingWithElementor()) {
            ?>
            <div class="changelogItem">
                <h5>Her vil alle endringer på nettsiden vises horisontalt bortover</h5>
            </div>
            <?php
        }
        ?>
    </div>

    <div class = "changelogArrows changelogBeginningArrow" id = "changelogCanScrollViewLeft">
        <div class="changelogArrowBackground"></div>
        <span class="material-icons" style="font-size: 40px !important;">chevron_left</span>
    </div>

    <div class = "changelogArrows changelogEndArrow" id = "changelogCanScrollViewRight">
        <div class="changelogArrowBackground"></div>
        <span class="material-icons" style="font-size: 40px !important;">chevron_right</span>
    </div>

    <script type="text/javascript">
        const changelogCanScrollViewRight = document.getElementById('changelogCanScrollViewRight');
        const changelogCanScrollViewLeft = document.getElementById('changelogCanScrollViewLeft');
        const changelog = document.getElementById('changelog');

        changelogCanScrollViewRight.onclick = function () {
            changelog.scrollLeft = changelog.scrollLeft+100;

            let scrollAmount = 0;
            let slideTimer = setInterval(function(){
                changelog.scrollLeft += 50;
                scrollAmount += 50;
                if(scrollAmount >= 500){
                    window.clearInterval(slideTimer);
                }
            }, 25);
        }

        changelogCanScrollViewLeft.onclick = function () {
            changelog.scrollLeft = changelog.scrollLeft-100;

            let scrollAmount = 0;
            let slideTimer = setInterval(function(){
                changelog.scrollLeft -= 50;
                scrollAmount -= 50;
                if(scrollAmount <= -500){
                    window.clearInterval(slideTimer);
                }
            }, 25);
        }

        changelog.onscroll = function () {
            console.log("scrolleft: " + changelog.scrollLeft);
            console.log("width: " + $(changelog).width());

            if (changelog.scrollLeft >= $(changelog).width()-900) {
                $(changelogCanScrollViewRight).fadeOut("fast");
            }else {
                $(changelogCanScrollViewRight).fadeIn("fast");
            }

            if (changelog.scrollLeft <= 200) {
                $(changelogCanScrollViewLeft).fadeOut("fast");
            }else {
                $(changelogCanScrollViewLeft).fadeIn("fast");
            }
        }
    </script>
    <?php
}