<?php

add_shortcode('sc_dokumenter_stor_liste', 'sc_dokumenter_stor_liste');

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
        $documents = getAllFilesInFolderAndSubfolders("", "", 10);
        foreach ($documents as $currentDoc) {
            $fileNameSeparated = explode(".", $currentDoc['filename']);
            $fileType = $fileNameSeparated[sizeof($fileNameSeparated)-1];
            $specialClass = "";
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
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/excel.png";
                    $specialClass = "excel dok";
                    break;
            }
            if ($specialClass == "") {
                $specialClass = "ukjentDok dok";
            }
            createLargeListItem($currentDoc['filename'], "Trykk her for å laste ned", $currentDoc['dateModified'], $currentDoc['fileSizeMB'] . " MB", $photoUrl, getFilesUploadUrl() . $currentDoc['path'], $specialClass);
        }
        ?>
    </div>
    <?php
}