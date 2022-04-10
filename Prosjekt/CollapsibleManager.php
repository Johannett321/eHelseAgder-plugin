<?php

function getCollapsibleName($collapsibleType, $customName) {
    if ($customName != null) {
        return $customName;
    }

    switch($collapsibleType) {
        case 1:
            return "Egendefinert";
            break;
        case 2:
            return "Leverandører";
            break;
        case 3:
            return "Prosjekt-team";
            break;
        case 4:
            return "Mer informasjon om prosjektet";
            break;
        case 5:
            return "Milepæler";
            break;
        case 6:
            return "Nedlastbare dokumenter";
            break;
    }
}

function getHtmlContentForCollapsible($collapsible) {
    if ($collapsible->collapsible_type == 1 || $collapsible->collapsible_type == 2 || $collapsible->collapsible_type == 4) {
        return nl2br($collapsible->innhold);
    }else if ($collapsible->collapsible_type == 5) {
        //Milepæler
        getMilepaelerCollapsible($collapsible);
    }else if ($collapsible->collapsible_type == 3) {
        getProsjektTeametCollapsible($collapsible);
    }else if ($collapsible->collapsible_type == 6) {
        getNedlastbareDokumenterViewCollapsible($collapsible);
    }
}

function getProsjektTeametCollapsible($collapsible) {
    $people = explode(";", $collapsible->innhold);
    for ($i = 0; $i < sizeof($people); $i++) {
        $rows = explode(",", $people[$i]);
        ?>
            <div class = "inliner">
                <img src = "https://www.oseyo.co.uk/wp-content/uploads/2020/05/empty-profile-picture-png-2-2.png"/>
                <div class = "textFields">
                    <h5><?php echo $rows[0]?></h5>
                    <h6><?php echo $rows[1]?></h6>
                    <p><?php echo $rows[2]?></p>
                    <p>mobil: <?php echo $rows[3]?></p>
                </div>
            </div>
        <?php
    }
}

function getMilepaelerCollapsible($collapsible) {
    ?>
        <table>
            <tr>
                <th id="milepælTittel">Milepæl</th>
                <th id="milepælKontakt">Ansvarlig kontaktperson</th>
                <th id="milepælDato">Dato</th>
            </tr>
            <?php
                $rows = explode(";", $collapsible->innhold);
                for ($i = 0; $i < sizeof($rows); $i++) {
                    $rowParams = explode(",", $rows[$i]);
                    ?>
                    <tr>
                        <td>
                            <?php 
                                switch($rowParams[1]) {
                                    case "1":
                                        ?>
                                        <div class = "redBlob blob"></div>
                                        <?php
                                        break;
                                    case "2":
                                        ?>
                                        <div class = "yellowBlob blob"></div>
                                        <?php
                                        break;
                                    case "3":
                                        ?>
                                        <div class = "greenBlob blob"></div>
                                        <?php
                                        break;
                                }
                                echo $rowParams[0];
                            ?>
                        </td>
                        <td>
                            <?php echo $rowParams[2]; ?>
                        </td>
                        <td>
                            <?php echo $rowParams[3]; ?>
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </table>
    <?php
}
?>