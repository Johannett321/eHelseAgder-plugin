<?php
add_shortcode( 'sc_opprett_arrangement', 'sc_opprett_arrangement');

require "PupliserArrangement.php";
require "OpprettArrangementTools.php";
include "SlettArrangement.php";

securePageWithLogin('opprett-arrangement');
thisPageRequiresCookies('opprett-arrangement');

function sc_opprett_arrangement() {
    error_log("Redigerer nå opprett nyhetsartikkel");
    $loadedArrangement = getEditingEvent();

    if (isset($_GET['editEventID'])) {
        $postURL = "../../../../wp-json/ehelseagderplugin/api/lagre_utkast_arrangement?editEventID=" . $_GET['editEventID'];
    }else {
        $postURL = "../../../../wp-json/ehelseagderplugin/api/lagre_utkast_arrangement";
    }
    ?>

    <?php
    if ($loadedArrangement != null) {
        ?>
        <a href = "../../../wp-json/ehelseagderplugin/api/slett_arrangement?eventID=<?php echo $_GET['editEventID']?>"><button>Slett arrangement</button></a>
        <?php
    }
    ?>
    <form action = "<?php echo $postURL?>" method = "post" id = "minform" enctype="multipart/form-data">
        <div class = "innhold">
            <h3 class = "mainTitle">Opprett arrangement</h3>
            <!-- OPPLASTING AV BILDE -->
            <h4>Velg forsidebilde</h4>
            <div class="uploadPhoto" id = "uploadPhotoButton">
                <div>
                    <h5>Last opp bilde</h5>
                    <i class="material-icons">upload</i>
                </div>
                <input class = "hidden" type="file" name = "bilde" accept="image/*" onchange="loadFile(event)" id = "actualUploadButton">
                <img id="output" src = "<?php echo getPhotoUploadUrl() . $loadedArrangement->bilde ?>"/>
                <script>
                    const loadFile = function(event) {
                        const output = document.getElementById('output');
                        output.src = URL.createObjectURL(event.target.files[0]);
                        output.onload = function() {
                            URL.revokeObjectURL(output.src) // free memory
                        }
                    };

                    const uploadPhotoButton = document.getElementById('uploadPhotoButton');

                    uploadPhotoButton.onclick = function () {
                        document.getElementById('actualUploadButton').click();
                    }
                </script>
            </div>

            <label for="tittel" class = "labelForInput">Navn på arrangement*</label>
            <input type="text" id="tittel" name="tittel" placeholder="Webinar: Digitale helsetjenester for alle" class = "small_input" maxlength="55" value = "<?php echo $loadedArrangement->tittel?>"><?php addCharacterCounter("tittel");?>
            <label for="kort_besk" class = "labelForInput">En kort setning om arrangementet*</label>
            <?php addInfoBox("kortsetning", "Denne setningen skal gi leseren en kort forståelse av hva arrangementet handler om");?>
            <input type="text" id="kort_besk" name="kort_besk" placeholder="Navn navnesen kaster lys på fremtiden for legemidler i et nytt webinar om digital legemiddelhåndtering" class = "small_input" maxlength="200" value = "<?php echo $loadedArrangement->kort_besk?>"><?php addCharacterCounter("kort_besk");?>

            <?php
            $dagensDato = date("Y-m-d");

            if (isset($_GET['editEventID'])) {
                $startDato = $loadedArrangement->start_dato;
                $sluttDato = $loadedArrangement->slutt_dato;
            }else {
                $startDato = $dagensDato;
                $sluttDato = $dagensDato;
            }
            ?>
            <label for="startdato" class = "labelForInput">Starter*</label>
            <input type = "date" id = "startdato" name = "startdato" value="<?php echo $startDato?>">
            <!--start_klokkeslett-->
            <label for="start_klokkeslett" class = "labelForInput">Klokkeslettet det starter</label>
            <?php addInfoBox("klokkeslett", "Her velger du klokkeslettet det starter. Dersom dette ikke er bestemt enda, kan du skrive ca. klokkeslett, og skrive i 'Informasjon om arrangementet' at det ikke er bestemt enda.");?>
            <input type = "time" id = "start_klokkeslett" name = "start_klokkeslett" value="<?php echo $loadedArrangement->start_klokkeslett?>">
            <label for="sluttdato" class = "labelForInput">Slutter*</label>
            <input type = "date" id = "sluttdato" name = "sluttdato" value="<?php echo $sluttDato?>">

            <label for="sted" class = "labelForInput">Sted*</label>
            <input type="text" id="sted" name="sted" placeholder="Kristiansand" class = "small_input" maxlength="50" value = "<?php echo $loadedArrangement->sted?>"><?php addCharacterCounter("sted");?>
            <label for="arrangor" class = "labelForInput">Arrangør*</label>
            <input type="text" id="arrangor" name="arrangor" placeholder="Kristiansand kommune" class = "small_input" maxlength="100" value = "<?php echo $loadedArrangement->arrangor?>"><?php addCharacterCounter("arrangor");?>
            <label for="kontaktperson" class = "labelForInput">Kontaktperson*</label>
            <input type="text" id="kontaktperson" name="kontaktperson" placeholder="Navn Navnesen" class = "small_input" maxlength="100" value = "<?php echo $loadedArrangement->kontaktperson?>"><?php addCharacterCounter("kontaktperson");?>
            <label for="kontaktmail" class = "labelForInput">E-post til Kontaktperson*</label>
            <input type="text" id="kontaktmail" name="kontaktmail" placeholder="navn.navnesen@gmail.com" class = "small_input" maxlength="100" value = "<?php echo $loadedArrangement->kontaktperson_mail?>"><?php addCharacterCounter("kontaktmail");?>

            <div class = "sammendragContainer">
                <label for = "psummary" class = "labelForInput">Informasjon om arrangementet*</label>
                <?php addInfoBox("informasjonOmArrangementInfo", "Her skriver du informasjon om arrangementet. Om du har et program i eget dokument kan dette lastes opp i feltet for program/andre eksterne vedlegg. Om arrangementet ditt foreløpig ikke har noe påmeldingslink, kan dette være lurt å informere om her");?>
                <textarea id = "psummary" name="psummary" form="minform" maxlength="3400" placeholder="Her kan du skrive selve artikkelen"><?php echo $loadedArrangement->innhold?></textarea><?php addCharacterCounter("psummary");?>
            </div>

            <label for="pamelding" class = "labelForInput">Link til ekstern påmelding</label>
            <?php addInfoBox("eksternpamelding", "Hvis du ikke enda har noen link til ekstern påmelding, kan dette legges til senere ved å redigere arrangementet og legge til link. Det kan være lurt å legge til informasjon om  dette i «Informasjon om arrangementet». ");?>
            <input type="text" id="pamelding" name="pamelding" placeholder="https://www.ticketmaster.no/event/webinar-dhfa-2033-billetter/614599" class = "small_input" maxlength="500" value = "<?php echo $loadedArrangement->pamelding_link?>"><?php addCharacterCounter("pamelding");?>
            <label for = "uploadFiles" class = "labelForInput">Program/andre eksterne vedlegg</label>
            <?php getMultiFileUploadListHTMLElement(5, $loadedArrangement->vedlegg); ?>
        </div>

        <center>
            <?php
            addSubmitButtonWithVerification("minform", array("tittel", "kort_besk", "sted", "arrangor", "kontaktperson", "kontaktmail", "psummary"), array("pamelding"));
            ?>
        </center>
    </form>

    <script type="text/javascript">
        const startDatePicker = document.getElementById('startdato');
        const endDatePicker = document.getElementById('sluttdato');

        startDatePicker.onchange = function () {
            endDatePicker.min = startDatePicker.value;
            if (endDatePicker.value < startDatePicker.value) {
                endDatePicker.value = startDatePicker.value;
            }
        }
    </script>
    <?php
}

function getEditingEvent() {
    $eventID = $_GET['editEventID'];
    error_log("Received eventID: " . $eventID);
    $formatted_table_name = getArrangementerDatabaseRef();

    if ($eventID != null) {
        global $wpdb;
        $query = "SELECT * FROM " . $formatted_table_name . " WHERE id = " . $eventID;
        $article = $wpdb->get_results($query);

        return $article[0];
    }
}