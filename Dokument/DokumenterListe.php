<?php

add_shortcode('sc_dokumenter_stor_liste', 'sc_dokumenter_stor_liste');

function sc_dokumenter_stor_liste() {
    if (areElementorBufferingObjects()) return;
    ?>
    <div class = "artikkelKortHolder">
        <?php
        $documents = getAllFilesInFolderAndSubfolders("", "", 10);
        foreach ($documents as $currentDoc) {
            $fileNameSeparated = explode(".", $currentDoc['filename']);
            $fileType = $fileNameSeparated[sizeof($fileNameSeparated)-1];
            switch ($fileType) {
                case "pdf":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/pdf.jpg";
                    break;
                case "pptx":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/powerpoint.jpg";
                    break;
                case "docx":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/word.jpg";
                    break;
                case "xlsx":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/excel.jpg";
                    break;
            }
            createLargeListItem($currentDoc['filename'], "Trykk her for å laste ned", $currentDoc['dateModified'], $currentDoc['fileSizeMB'] . " MB", $photoUrl, getFilesUploadUrl() . $currentDoc['path']);
        }
        ?>
    </div>
    <?php
}

/*
 * ?>
    <div class = "artikkelKortHolder">
        <?php
        foreach ($results as $result) {
            $fileNameSeparated = explode(".", $result['filename']);
            $fileType = $fileNameSeparated[sizeof($fileNameSeparated)-1];
            switch ($fileType) {
                case "pdf":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/pdf.jpg";
                    break;
                case "pptx":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/powerpoint.jpg";
                    break;
                case "docx":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/word.jpg";
                    break;
                case "xlsx":
                    $photoUrl = "../../../wp-content/uploads/eHelseAgderPlus/excel.jpg";
                    break;
            }
            createLargeListItem($result['filename'], "Trykk her for å laste ned", $result['dateModified'], $result['fileSizeMB'] . " MB", $photoUrl, getFilesUploadUrl() . $result['path']);
        }
        ?>
    </div>
    <?php

    if ($results == null) {
        ?>
        <h5 style = "width: 60%;">Ingen resultater funnet</h5>
        <?php
    }
 */