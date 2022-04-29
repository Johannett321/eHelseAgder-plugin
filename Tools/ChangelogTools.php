<?php

add_shortcode('sc_nyeste_oppdateringer', 'sc_nyeste_oppdateringer');

/**
 * Legger til en hendelse i endringsloggen som vises på forsiden av nettsiden. For eksemptel ved opprettelse av prosjekt.
 * @param $title mixed
 * @param $description mixed
 * @param $href mixed
 */
function addEventToChangelog($title, $description, $href) {
    global $wpdb;
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
    <div class="changelog">
        <div class = "changelogItem">
            <div class="changelogTitle">Nyeste oppdateringer</div>
            <span class="material-icons">chevron_right</span>
        </div>
        <?php
        foreach ($changelog as $changelogItem) {
            ?>
            <div class = "verticalLine"></div>
            <a href = "<?php echo $changelogItem->href ?>">
                <div class = "changelogItem">
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
    <?php
}