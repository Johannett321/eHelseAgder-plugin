<?php
add_shortcode( 'sc_opprett_nyhetsartikkel', 'sc_opprett_nyhetsartikkel');

//ShortCode_Opprett_Nyhetsartikkel
function sc_opprett_nyhetsartikkel() {
    ?>
    <form action = "" method = "post" id = "minform">
        <div class = "requiredPart">
            <h3 class = "mainTitle">Kort om nyheten</h3>
            <label for="tittel" class = "labelForInput">Tittel:</label>
            <input type="text" id="tittel" name="tittel" placeholder="Vi har signert kontrakt!" class = "small_input" value = "<?php echo $loadedProsjekt['projectName']?>">
            <label for="ingress" class = "labelForInput">Ingress:</label>
            <input type="text" id="ingress" name="ingress" placeholder="Etter mange måneder med venting, har endelig kontrakten med Min Bedrift AS blitt signert." class = "small_input" value = "<?php echo $loadedProsjekt['undertittel']?>">
            <div class = "uthevetBoksForm" id = "kildeboks">
                <h4>Kildekritikk</h4>
                <label for="skrevetav" class = "labelForInput">Skrevet av:</label>
                <input type="text" id="skrevetav" name="skrevetav" placeholder="Navn Navnesen" class = "small_input" value = "<?php echo $loadedProsjekt['ledernavn']?>">
                <label for="datoskrevet" class = "labelForInput">Dato skrevet:</label>
                <input type="text" id="datoskrevet" name="datoskrevet" placeholder="08.10.2019" class = "small_input" value = "<?php echo $loadedProsjekt['ledermail']?>">
            </div>
        </div>

        <div class = "sammendragContainer">
            <label for = "psummary" class = "labelForInput">Innhold</label>
            <textarea id = "psummary" name="psummary" form="minform" maxlength="1700" placeholder="Her kan du skrive selve artikkelen"><?php echo $loadedProsjekt['project_text']?></textarea>
        </div>

        <center>
            <input type = "submit" class = "button" id = "submitButton" value = "Videre">
        </center>
    </form>
    <?php
}