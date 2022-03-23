<?php

function uploadFileAndGetName($uploadButtonName) {
    $imageUploadsPath = "wp-content/uploads/minebilder/";

    //Sjekker om brukeren har lagt til en fil, hvis ikke return null
    if ($_FILES[$uploadButtonName]["name"] != null && $_FILES[$uploadButtonName]["name"] != "") {
        error_log("Brukeren har lagt ved et bilde!");
        $filename = $_FILES[$uploadButtonName]["name"];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = generateRandomString(20).".".$extension;

        $tempname = $_FILES[$uploadButtonName]["tmp_name"];
        //TODO: Få den til å ikke lagre på en lokal adresse
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

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getPhotoUploadUrl() {
    return wp_upload_dir()['baseurl'] . '/minebilder/';
}