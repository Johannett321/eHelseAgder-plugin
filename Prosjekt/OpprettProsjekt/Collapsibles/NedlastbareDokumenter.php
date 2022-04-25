<?php
function addNedlastbareDokCol() {
    ?>
    <script type="text/javascript">
        var numberOfFileUploadButtons = 0;
        var fileList;
        var addFileButton;
        var maxFiler;

        function createNedlastbareDokumenterCol(innhold) {
            if (innhold == null) innhold = "";

            const collapsible = createCollapsibleWithTitle("Nedlastbare dokumenter", "cnedlastbaredokumenter");
            if (collapsible == null) return;

            const fileUploadUIHandler = getFileUploadUIHandler(innhold, 20);

            collapsible.appendChild(fileUploadUIHandler);
            collapsibles.appendChild(collapsible);
            scrollToView(collapsible);
        }

        function getFileUploadUIHandler(myNetworkFiles, maxFilesAllowed) {
            const uiHandler = document.createElement('div');
            uiHandler.classList.add('uploadFiles');

            addFileButton = document.createElement('button');
            addFileButton.id = "addFileButton";
            addFileButton.innerText = "Legg til fil"
            addFileButton.type = "button";

            fileList = document.createElement('div');
            fileList.id = "fileList";

            maxFiler = document.createElement('div');
            maxFiler.id = "maxfiler";
            maxFiler.classList.add('hidden')
            maxFiler.innerText = "Du har nådd maksimum antall filer";

            const networkFilesString = myNetworkFiles;
            var networkFiles;

            if (networkFilesString !== "") {
                networkFiles = networkFilesString.split(";");

                for (var i = 0; i < networkFiles.length; i++) {
                    createNetworkFileBox(networkFiles[i], maxFilesAllowed);
                }
            }


            addFileButton.onclick = function () {
                createFileUploadBox(maxFilesAllowed);
            }
            uiHandler.appendChild(fileList);
            uiHandler.appendChild(addFileButton);
            uiHandler.appendChild(maxFiler);
            return uiHandler;
        }

        function createFileUploadBox(maxFilesAllowed) {
            const lastUploadButton = fileList.lastChild;
            if (lastUploadButton != null) {
                if (lastUploadButton.firstChild.files != null) {
                    if (lastUploadButton.firstChild.files.length === 0) {
                        alert("Du kan kun laste opp en fil av gangen")
                        return;
                    }
                }
            }

            if (numberOfFileUploadButtons !== maxFilesAllowed) {
                numberOfFileUploadButtons ++;
                const singleFileHolder = document.createElement('div');
                singleFileHolder.classList.add("uploadedFile");

                var uploadButton = document.createElement('input');
                uploadButton.type = "file";
                uploadButton.name = "fil" + numberOfFileUploadButtons;

                const removeButton = getRemoveButton();
                removeButton.onclick = function () {
                    if (confirm("Er du sikker på at du vil slette denne filen?") === true) {
                        $(singleFileHolder).animate({opacity: '0%', height: '0px'}, function (){$(singleFileHolder).remove(); notifyAFileWasRemoved(maxFilesAllowed)});
                    }
                }

                singleFileHolder.append(uploadButton);
                singleFileHolder.append(removeButton);
                fileList.appendChild(singleFileHolder);

                checkIfMaxFileLimitReached(maxFilesAllowed);
            }
        }

        function createNetworkFileBox(filepath, maxFilesAllowed) {
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
                    $(singleFileHolder).animate({opacity: '0%', height: '0px'}, function (){$(singleFileHolder).remove(); notifyAFileWasRemoved(maxFilesAllowed)});
                }
            }

            singleFileHolder.append(networkFile);
            singleFileHolder.append(networkFileText);
            singleFileHolder.append(removeButton);
            fileList.appendChild(singleFileHolder);

            checkIfMaxFileLimitReached(maxFilesAllowed);
        }

        function getRemoveButton() {
            const removeIcon = document.createElement('span');
            removeIcon.classList.add("material-icons");
            removeIcon.classList.add("removeFileButton")
            removeIcon.innerText = "close";
            return removeIcon;
        }

        function notifyAFileWasRemoved(maxFilesAllowed) {
            numberOfFileUploadButtons--;

            for (var i = 0; i < fileList.children.length; i++) {
                fileList.children[i].name = "fil" + (i+1);
            }

            checkIfMaxFileLimitReached(maxFilesAllowed);
        }

        function checkIfMaxFileLimitReached(maxFilesAllowed) {
            if (numberOfFileUploadButtons === maxFilesAllowed) {
                addFileButton.disabled = true;
                maxFiler.classList.remove("hidden");
            }else {
                addFileButton.disabled = false;
                maxFiler.classList.add("hidden");
            }
        }
    </script>
    <?php
}

function getNedlastbareDokumenterViewCollapsible($collapsibleInfo) {
    $filer = explode(";", $collapsibleInfo->innhold);
    for ($i = 0; $i < sizeof($filer); $i++) {
        ?>
        <a href = "<?php echo getFilesUploadUrl() . $filer[$i] ?>" download><div><?php echo explode("/", $filer[$i])[1] ?></div></a>
        <?php
    }
}