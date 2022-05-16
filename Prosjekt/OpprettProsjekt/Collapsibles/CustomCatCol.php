<?php
function addCustomCatCol() {
    ?>
    <script type="text/javascript">
        var customColCounter = 0;

        function createCustomCatCol(egendefinertNavn, innhold) {
            if (innhold == null) innhold = "";
            if (egendefinertNavn == null) egendefinertNavn = "";

            let imageUrl = "";

            if (innhold.includes("#ADDIMAGE;")) {
                imageUrl = innhold.split("#ADDIMAGE;")[1];
                innhold = innhold.split("#ADDIMAGE;")[0];
            }

            const collapsible = createCollapsibleWithoutTitle();

            customColCounter += 1;

            collapsible.name = "cegenkategori" + customColCounter;
            if (innhold == "") {
                saveAddedCategory(collapsible.name);
            }

            const field = document.createElement('input');
            field.classList.add("collapsibleCustomTitle");
            field.id = "cvcustomtitle" + customColCounter;
            field.name = "cvcustomtitle" + customColCounter;
            field.type = "text";
            field.placeholder = "Hva skal kategorien hete?"
            field.value = egendefinertNavn;
            field.maxLength = 75;

            //oppdater 'name' feltet når brukeren skriver inn et navn
            $(document).ready(function(){
                $("#cvcustomtitle" + customColCounter).on("input", function(){
                    $(collapsible).attr('value', $(this).val());
                });
            });
            collapsible.appendChild(field);

            collapsible.appendChild(getImageUploadButton(imageUrl));

            const textField = document.createElement('textarea');
            textField.name = "cvcustomdesc" + customColCounter;
            textField.value = innhold;
            collapsible.appendChild(textField);

            const savedTextInfo = getSavedText();
            addTextSaver(field, savedTextInfo, "c" + field.id + "_ls");
            addTextSaver(textField, savedTextInfo, "c" + textField.name + "_ls");
            collapsible.appendChild(savedTextInfo);
            collapsibles.appendChild(collapsible);
            scrollToView(collapsible);
        }

        function getImageUploadButton(preloadedImageUrl) {
            let holder = document.createElement('div');
            holder.classList.add('uploadPhoto');
            holder.id = "customCol" + customColCounter + "_uploadPhotoButton";

            let fakeButton = document.createElement('div');
            fakeButton.classList.add('lastOppBildeKnapp');
            fakeButton.id = "customColFakeUploadButton" + customColCounter;

            $(fakeButton).click(function (event) {
                let numberClicked = event.currentTarget.id.split("customColFakeUploadButton")[1];
                console.log("Button was clicked");
                $('#customColActualUploadButton' + numberClicked).click();
            });

            let fakeButtonText = document.createElement('h5');
            fakeButtonText.innerText = "Last opp bilde";

            let fakeButtonIcon = document.createElement('i');
            fakeButtonIcon.classList.add('material-icons');
            fakeButtonIcon.innerText = "upload";

            fakeButton.appendChild(fakeButtonText);
            fakeButton.appendChild(fakeButtonIcon);

            holder.appendChild(fakeButton);

            let customCatImage = document.createElement('input');
            customCatImage.type = "file";
            customCatImage.classList.add('hidden');
            customCatImage.name = "CustomCatImage" + customColCounter;
            customCatImage.accept = "image/*";
            customCatImage.id = "customColActualUploadButton" + customColCounter;
            customCatImage.onchange=function (event) {
                loadFile(event)
            }
            holder.appendChild(customCatImage);

            let output = document.createElement('img');
            output.id = "customColPhotoOutput" + customColCounter;
            if (preloadedImageUrl !== "") {
                output.src = "<?php echo getPhotoUploadUrl()?>" + preloadedImageUrl;
            }

            holder.appendChild(output);

            let pathToOldPhoto = document.createElement('input');
            pathToOldPhoto.type = "text";
            pathToOldPhoto.name = "CustomCatOldImage" + customColCounter;
            pathToOldPhoto.value = preloadedImageUrl;
            pathToOldPhoto.classList.add('hidden');

            holder.appendChild(pathToOldPhoto);

            const loadFile = function(event) {
                const output = document.getElementById('customColPhotoOutput' + event.currentTarget.id.split("customColActualUploadButton")[1]);
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
            };
            return holder;
        }
    </script>
    <?php
}