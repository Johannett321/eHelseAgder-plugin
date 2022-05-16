<?php

add_shortcode('sc_dokumenter_stor_liste', 'sc_dokumenter_stor_liste');
add_shortcode('sc_dokumenter_stor_liste_tittel', 'sc_dokumenter_stor_liste_tittel');
add_shortcode('sc_dokumenter_stor_liste_knapp', 'sc_dokumenter_stor_liste_knapp');

function sc_dokumenter_stor_liste_tittel() {
    if (!isset($_GET['alledokumenter'])) {
        ?>
        <center><h2>Siste 10 dokumenter</h2></center>
        <?php
    }else {
        ?>
        <center><h2>Alle dokumenter</h2></center>
        <?php
    }
}

function sc_dokumenter_stor_liste_knapp() {
    if (!isset($_GET['alledokumenter'])) {
        ?>
        <center><a href = "?alledokumenter=true"><button type = "button">Vis alle dokumenter</button></a></center>
        <?php
    }
}

function sc_dokumenter_stor_liste() {
    if (areElementorBufferingObjects()) return;
    if (areWeEditingWithElementor()) {
        ?>
        <center><h5>Her vil de siste dokumentene som har blitt lastet opp vises</h5></center>
        <?php
        return;
    }
    ?>
    <div class = "artikkelKortHolder">
        <?php
        $limit = -1;
        if (!isset($_GET['alledokumenter'])) {
            $limit = 10;
        }
        $documents = getAllFilesInFolderAndSubfolders("", "", $limit);

        foreach ($documents as $currentDoc) {
            $fileNameSeparated = explode(".", $currentDoc['filename']);
            $fileType = $fileNameSeparated[sizeof($fileNameSeparated)-1];
            switch ($fileType) {
                case "pdf":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/pdf.png";
                    $specialClass = "pdf dok";
                    break;
                case "pptx":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/powerpoint.png";
                    $specialClass = "powerpoint dok";
                    break;
                case "docx":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/word.png";
                    $specialClass = "word dok";
                    break;
                case "xlsx":
                case "xls":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/excel.png";
                    $specialClass = "excel dok";
                    break;
                default:
                    $photoUrl = null;
                    $specialClass = "ukjentDok dok";
                    break;
            }
            createLargeListItem($currentDoc['filename'], "Trykk her for å laste ned", $currentDoc['dateModified'], $currentDoc['fileSizeMB'] . " MB", $photoUrl, getFilesUploadUrl() . $currentDoc['path'], $specialClass);
        }
        ?>
    </div>
    <?php
}