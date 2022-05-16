<?php

/**
 * Flytter et bilde som er lastet opp til wp-content/uploads/minebilder/ med et tilfeldig navn.
 * @param $uploadButtonName string navnet på knappen som laster opp bilde.
 * @return string|null Returnerer path til bildet dersom det ble suksessfult lastet opp, ellers null.
 */
function uploadImageAndGetName($uploadButtonName) {
    $imageUploadsPath = "wp-content/uploads/minebilder/";

    //Sjekker om brukeren har lagt til en fil, hvis ikke return null
    if ($_FILES[$uploadButtonName]["name"] != null && $_FILES[$uploadButtonName]["name"] != "") {
        error_log("Brukeren har lagt ved et bilde!");
        $filename = $_FILES[$uploadButtonName]["name"];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = generateRandomString(20).".".$extension;

        $tempname = $_FILES[$uploadButtonName]["tmp_name"];
        $folder = $imageUploadsPath.$filename;

        if (move_uploaded_file($tempname, $folder)) {
            //Bildet ble lastet opp suksessfullt
            error_log("Bildet lastet opp suksessfullt! Returnerer: " . $filename);
            return $filename;
        }else{
            //Feilet med å laste opp bilde
            error_log("Feilet med å laste opp bilde!");
            return null;
        }
    }
    return null;
}

/**
 * Flytter en fil fra temp mappen til wp-content/uploads/minefiler/ettilfeldigmappenavn/navnet på filen.
 * @param $uploadButtonName string navnet på knappen som laster opp filen.
 * @return string|null Returnerer path til filen dersom det ble suksessfult lastet opp, ellers null.
 */
function uploadFileAndGetName($randomFolderName, $uploadButtonName) {
    $fileUploadsPath = "wp-content/uploads/minefiler/" . $randomFolderName . "/";

    //Sjekker om brukeren har lagt til en fil, hvis ikke return null
    if ($_FILES[$uploadButtonName] != null && $_FILES[$uploadButtonName]["name"] != null && $_FILES[$uploadButtonName]["name"] != "") {
        $filename = $_FILES[$uploadButtonName]["name"];
        error_log("Brukeren har lagt ved en fil: " . $filename);

        $tempname = $_FILES[$uploadButtonName]["tmp_name"];
        $folder = $fileUploadsPath . $filename;

        if (move_uploaded_file($tempname, $folder)) {
            //Bildet ble lastet opp suksessfullt
            error_log("Filen lastet opp suksessfullt! Returnerer: " . $randomFolderName . "/" . $filename);
            return $randomFolderName . "/" . $filename;
        }else{
            //Feilet med å laste opp bilde
            error_log("Feilet med å laste opp filen!" . $randomFolderName . "/" . $filename);
            return null;
        }
    }else if (isset($_POST[$uploadButtonName])) {
        return $_POST[$uploadButtonName];
    }
    return null;
}

/**
 * Genererer en random string med lengden som parameteret sier
 * @param $length int lengden på den tilfeldige stringen.
 * @return string den randomme stringen som er generert
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * @return string Returnerer linken til mappen hvor bilder blir lastet opp.
 */
function getPhotoUploadUrl() {
    return wp_upload_dir()['baseurl'] . '/minebilder/';
}

/**
 * @return string Returnerer linken til mappen hvor bilder blir lastet opp.
 */
function getFilesUploadUrl() {
    return wp_upload_dir()['baseurl'] . '/minefiler/';
}

/**
 * Returnerer et HTML element med mulighet for å laste opp filer.
 * @param $maxFilesAllowed int antallet filer som kan lastes opp.
 * @param $loadedFilesFromEdit string listen over filer
 */
function getMultiFileUploadListHTMLElement($maxFilesAllowed, $loadedFilesFromEdit) {
    ?>
    <div class="uploadFiles" id = "uploadFiles">
        <div id = "fileList"></div>
        <button type="button" id="addFileButton">Legg til fil</button>
        <span class = "hidden" id = "maxfiler">Du har nådd maksimum antall filer</span>
    </div>

    <script type="text/javascript">
        const addFileButton = document.getElementById('addFileButton');
        const fileList = document.getElementById('fileList');
        const maxFiler = document.getElementById('maxfiler');
        const networkFilesString = "<?php echo $loadedFilesFromEdit ?>";
        var networkFiles;

        var numberOfFileUploadButtons = 0;

        if (networkFilesString !== "") {
            networkFiles = networkFilesString.split(";");

            for (var i = 0; i < networkFiles.length; i++) {
                createNetworkFileBox(networkFiles[i]);
            }
        }


        addFileButton.onclick = function () {
            createFileUploadBox();
        }

        function createFileUploadBox() {
            const lastUploadButton = fileList.lastChild;
            if (lastUploadButton != null) {
                if (lastUploadButton.firstChild.files != null) {
                    if (lastUploadButton.firstChild.files.length === 0) {
                        alert("Du kan kun laste opp en fil av gangen")
                        return;
                    }
                }
            }

            if (numberOfFileUploadButtons !== <?php echo $maxFilesAllowed?>) {
                numberOfFileUploadButtons ++;
                const singleFileHolder = document.createElement('div');
                singleFileHolder.classList.add("uploadedFile");

                var uploadButton = document.createElement('input');
                uploadButton.type = "file";
                uploadButton.name = "fil" + numberOfFileUploadButtons;

                const removeButton = getRemoveButton();
                removeButton.onclick = function () {
                    if (confirm("Er du sikker på at du vil slette denne filen?") === true) {
                        $(singleFileHolder).animate({opacity: '0%', height: '0px'}, function (){$(singleFileHolder).remove(); notifyAFileWasRemoved()});
                    }
                }

                singleFileHolder.append(uploadButton);
                singleFileHolder.append(removeButton);
                fileList.appendChild(singleFileHolder);

                checkIfMaxFileLimitReached();
            }
        }

        function createNetworkFileBox(filepath) {
            numberOfFileUploadButtons ++;
            const singleFileHolder = document.createElement('div');
            singleFileHolder.classList.add("uploadedFile");

            var networkFile = document.createElement('input');
            networkFile.type = "text";
            networkFile.name = "fil" + numberOfFileUploadButtons;
            networkFile.readOnly = true;
            networkFile.value = filepath;
            networkFile.classList.add("hidden")

            var networkFileText = document.createElement('div');
            networkFileText.style.fontSize = "15px";
            networkFileText.innerHTML = "<b>" + filepath.split("/")[1] + "</b> (Allerede lastet opp)";

            const removeButton = getRemoveButton();
            removeButton.onclick = function () {
                if (confirm("Er du sikker på at du vil slette denne filen?") === true) {
                    $(singleFileHolder).animate({opacity: '0%', height: '0px'}, function (){$(singleFileHolder).remove(); notifyAFileWasRemoved()});
                }
            }

            singleFileHolder.append(networkFile);
            singleFileHolder.append(networkFileText);
            singleFileHolder.append(removeButton);
            fileList.appendChild(singleFileHolder);

            checkIfMaxFileLimitReached();
        }

        function getRemoveButton() {
            const removeIcon = document.createElement('span');
            removeIcon.classList.add("material-icons");
            removeIcon.classList.add("removeFileButton")
            removeIcon.innerText = "close";
            return removeIcon;
        }

        function notifyAFileWasRemoved() {
            numberOfFileUploadButtons--;

            for (var i = 0; i < fileList.children.length; i++) {
                fileList.children[i].name = "fil" + (i+1);
            }

            checkIfMaxFileLimitReached();
        }

        function checkIfMaxFileLimitReached() {
            if (numberOfFileUploadButtons === <?php echo $maxFilesAllowed?>) {
                addFileButton.disabled = true;
                maxFiler.classList.remove("hidden");
            }else {
                addFileButton.disabled = false;
                maxFiler.classList.add("hidden");
            }
        }
    </script>
    <?php
    //<input type="file" name = "bilde" accept="image/*" onchange="loadFile(event)" id = "actualUploadButton">
}

/**
 * Gjør om en string med filer til en liste over filer
 * @param $fileList String En string med filene separert med komma.
 * @return false|string[] Filene som er inkludert i stringen fra parameteret.
 */
function decodeFileUploadList($fileList) {
    $returnObject = explode(";", $fileList);
    return $returnObject;
}

/**
 * Oppretter en mappe i minefiler mappen
 * @param $folderName string navnet på mappen som skal oppdateres
 * @return string Path til mappen 'wp-content/uploads/minefiler/MAPPENAVN'
 */
function createFileUploadFolder($folderName) {
    mkdir("wp-content/uploads/minefiler/" . $folderName);
    error_log("Opprettet mappe: " . $folderName);
    return "wp-content/uploads/minefiler/" . $folderName . "/";
}

/**
 * Sletter en mappe og alle filene inni
 * @param $dirPath string mappen som skal slettes
 * @return void
 */
function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        error_log("Tried deleting folder: " .  $dirPath . ", but the folder does not exist");
        return;
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

/**
 * @param $folderPath string path til filteret
 * @param $filter string [optional] lar deg kun legge til filer som inneholder dette
 * @return array|false
 */
function getAllFilesInFolderAndSubfolders($folderPath, $filter, $limit) {
    $filesToReturn = [];
    $filesUploadDir = "wp-content/uploads/minefiler/";
    $elementsFound = scandir($filesUploadDir . $folderPath);
    for ($i = 0; $i < sizeof($elementsFound); $i++) {
        if ($elementsFound[$i] == "." || $elementsFound[$i] == ".." || $elementsFound[$i] == "..." || $elementsFound[$i] == ".DS_Store") {
            continue;
        }
        if (is_dir($filesUploadDir. $folderPath . "/" . $elementsFound[$i])) {
            error_log("Scanner direktory: " . $filesUploadDir. $folderPath . "/" . $elementsFound[$i]);
            $limitForSubFolder = $limit;
            if ($limit != -1) {
                $limitForSubFolder = $limit-sizeof($filesToReturn);
            }
            $foundFilesInSubfolder = getAllFilesInFolderAndSubfolders($folderPath . "/" . $elementsFound[$i], $filter, $limitForSubFolder);
            $filesToReturn = array_merge($filesToReturn, $foundFilesInSubfolder);
        }else {
            if ($filter != null && stripos($elementsFound[$i], $filter) === false) {
                //error_log($filter . " Matcher ikke " . $elementsFound[$i]);
                continue;
            }
            array_push($filesToReturn, getFileInfo($folderPath . "/" . $elementsFound[$i]));
        }
    }

    $fileDate = array();
    foreach ($filesToReturn as $key => $row)
    {
        $fileDate[$key] = strtotime($row['dateModified']);
    }
    if (!array_multisort($fileDate, SORT_DESC, $filesToReturn)) error_log("Failed to sort");
    if ($limit != -1 && sizeof($filesToReturn)>$limit) {
        array_splice($filesToReturn, 10);
    }
    return $filesToReturn;
}

function getFileInfo($path) {
    error_log("Returning file: " . basename($path));
    $filesUploadDir = "wp-content/uploads/minefiler/";
    return ["path"=> $path,
        "filename"=>basename($filesUploadDir . $path),
        "dateModified"=>date("d-m-Y", filemtime($filesUploadDir . $path)),
        "fileSizeMB"=>round(filesize($filesUploadDir . $path)/1000/1000, 2)];
}