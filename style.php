<?php

global $debugMode;

if ($debugMode) {
    add_action( 'wp', 'addglobalcss' );
}else {
    add_shortcode( 'sc_styling', 'addglobalcss' );
}

function addglobalcss() {?>

<style>

    .inlineBlock {
        display: inline-block;
    }

    .savedText {
        color: grey;
        font-size: 14px;
        font-family: Lato;
        margin: 5px;
    }

    #categoryAlreadyAdded {
        font-size: 17px;
        padding: 10px;
        margin-left: 20px;
        opacity: 0.3;
    }

    /* Progress bar ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––*/
    .infoBlokk, .progressBar {
        margin-left: auto;
        margin-right: auto;

    }

    .infoBlokk .material-icons, .infoBlokk h5 {
        display: inline-block;
    }

    .infoBlokk h5 {
        font-weight: 400;
        margin-left: 7px;
        line-height: 24px;
        vertical-align: middle;
    }

    .infoBlokk p {
        margin-left: 35px;
        margin-bottom: 0;
    }

    .infoBlokk {
        height: auto;
        width: 80%;
        padding: 20px;
        background-color: #f3f8f2;
        border-radius: 18px;
        margin-bottom: 60px;
        border: 1px solid #e8f2e5;
    }

    .progressBar {
        display: block;
        width: 60%;
        text-align: center;
        margin-top: 35px;
        margin-bottom: 10px;
    }

    #steg1 .bar {
        width:33%;
    }

    #steg2 .bar {
        width:66%;
    }

    #steg2 .progressBar {
        margin-top: 10em;
        width: 60%;
    }

    .progressBar .stegText {
        font-size: 14px;
        display: inline-block;
        margin-bottom: 10px;
        line-height: 20px;
        margin-left: 0;
        width: 150px;
    }

    #step1 {
        float: left;
        font-weight: 600;
        color: #0B843E;

    }

    #step2 {
        color: #B5DCBB;

    }

    #steg2 #step2 {
        font-weight: 600;
        color: #0B843E;
    }

    #step3 {
        float: right;
        color: #B5DCBB;

    }

    .material-icons, #infoHead {
        display: inline-block;
        vertical-align: middle;
    }

    .border {
        background-color: #daeddd;
        width: 90%;
        margin: 0 auto;
    }

    .bar {
        height:2.5px;
        color:#fff;
        background-color:#0B843E;
    }

    #bottomProgress {
        height: 220px;
        width: 80%;
        padding: 20px;
        background-color: unset;
        border-radius: 18px;
        margin-top: 100px;
        border: none;
    }

    /* Innhold -------------------------------------------------------------------*/
    .innhold {
        border: 1px solid #e8f2e5;
        border-radius: 18px;
        width: 80%;
        margin: 0 auto;
        box-shadow: 5px 5px 2px #e8f2e5;
        padding: 5em;
    }

    .projectText {
        font-size: 20px;
    }


    /* Last opp bilde ------------------------------------------------------------*/

    .uploadPhoto, .coverPhoto {
        height: 300px;
        background-color: #fbfcfb;
        border: 1px solid #d9ead4 ;
        margin: 0 !important;
    }

    .uploadPhoto {
        width: 100% !important;
        border-radius: 18px;
    }

    .uploadPhoto h5 {
        text-align: center;
        line-height: 300px;
        vertical-align: middle;
        color: grey !important;
    }


    /* ProsjektRedigering ––––––––––––––––––––––––––––––––––––––––––––––––––––––––*/
    .requiredPart, .addCustomField, .uploadPhoto, .sammendragContainer {
        margin-left: auto;
        margin-right: auto;
    }

    #submitButton, .addInfoButton {
        background-color: #0B843E;
        text-transform: capitalize;
        color: #fff;
        transition: all 0.5s;
    }

    #submitButton:hover, .addInfoButton:hover {
        color: #fff;
        background-color: #0B843EBA;
        font-weight: 700;
    }

    #submitButton {
        height: 50px;
        width: 200px;
        border-radius: 30px;
        margin-top: 7% !important;
        padding: 0px !important;
    }

    /* Kort om prosjektet */
    .requiredPart h3, .sammendragContainer h3, #photoPlaceholder h3 {
        margin: 20px 0;
    }

    .requiredPart h4{
        margin-bottom: 1rem;
    }

    .labelForInput {
        margin-top: 30px;
    }

    .requiredPart {
        padding: 30px;
        background-color: #f3f8f2;
        border-radius: 18px;
        border: 1px solid #e8f2e5;
        margin-top: 5em;
    }

    #minform input[type="text"], .milepael input[type="text"], .collapsible input[type="text"]{
        height: 30px;
        border-radius: 5px;
        margin: 0em;
        margin-bottom: 17px;
        font-size: 14px;
        color: #595959;
    }

    .small_input {
        height: 30px;
        border-radius: 5px;
        margin-bottom: 17px;
        font-size: 14px;
        color: #595959;
        max-width: 100% !important;
    }

/* Prosjektleder-boks */
    .uthevetBoksForm {
        padding: 20px;
        margin: 60px 0;
        border-radius: 10px;
        background-color: #d9ead4;
        width: 70%;
}

    #prosjLederInputList {
        list-style-type: none;
        margin-left: 0;
    }

    #prosjLederInputList li label, #prosjLederInputList li input {
        display: inline-block;
    }

    .uthevetBoksForm li input {
        width: 70%;
        margin-bottom: 10px !important;
    }

    .uthevetBoksForm li label {
        width: 80px;
        margin-top: 10px !important;
    }

    .uthevetBoksForm ul {
        margin: 0;
    }

    #prosjLederInputList li {
        margin-left: 10px;
    }

/* Sammendrag */

    #psummary {
        font-family: Lato;
        font-size: 14px;
        color: #595959;
        margin: 0 !important;
        max-width: 100%;
        height: 200px;
    }

    .sammendragContainer {
        padding: 30px;
        border-radius: 18px;

    }



    /* ProsjektRedigeringKategorier ––––––––––––––––––––––––––––––––––––––––––––––*/
    .addCustomField p {
        font-size: 14px;
    }

    #collapsibleChooser {
        font-family: Lato;
        font-size: 1.3rem;
        color: grey;
        background-color: white;
        border-radius: 8px;
        height: 40px;
        width: 70%;
    }

    .addInfoButton {
        height: 40px;
        width: 20rem;
        font-family: Lato;
        font-size: 14px;
        padding: 5px;
        border-radius: 30px;
        border-width: 1px;
        margin-left: 20px;
    }

    #chooseLine {
        margin: 40px auto;
        border-bottom: 2px solid #e8f2e5;
        padding: 0 0 30px 0;
    }

    #chooseLine #addCategoryButton {
        float: right;
    }


    /* Collapsibles –––––––––––––––––––––––––––––––––––––––––––––––––––*/

    select {
        height: 40px;
        width: 300px;
        border-radius: 5px;
        padding: 10px
        font-size: 14px;
    }

    #minform {
        margin-bottom:30px !important;
    }
    .hidden {
        display:none !important;
    }

    .collapsible {
        padding: 20px;
        margin: 5em auto;
        background-color: #f3f8f2;
        border-radius: 18px;
        border: 1px solid #e8f2e5;

        -webkit-animation: fadein 0.5s;
        /* Safari, Chrome and Opera > 12.1 */
        -moz-animation: fadein 0.5s;
        /* Firefox < 16 */
        -ms-animation: fadein 0.5s;
        /* Internet Explorer */
        -o-animation: fadein 0.5s;
        /* Opera < 12.1 */
        animation: fadein 0.5s;
    }

    .collapsible h5 {
        font-size: 2rem !important;
        margin-bottom: 20px;
    }

    .collapsible h5, .removeCollapsibleButton img {
        display: inline-block !important;
    }

    .removeCollapsibleButton {
        background: none;
        border: none;
        float: right;
        opacity: 80%;
        transition: 0.1s ease;
        padding: 0px;
    }

    .removeCollapsibleButton img {
        width: 15px;
        height: 15px;
    }

    .removeCollapsibleButton:hover {
        scale: 1.2;
        opacity: 100%;
        cursor: pointer;
    }

    .collapsible textarea {
        max-width: 100%;
        min-height: 200px;
        margin: 0 auto;
        margin-top: 5px !important;
        border-radius: 5px;
        padding: 10px;
        font-size: 1.3rem;
    }

    .collapsible h5 {
        padding-bottom: 10px;
    }

    .removedCol {
        transform: translateX(100vw);
    }

    .collapsible .textFieldContainer {
        width: 100%;
    }

    .collapsible .textFieldContainer input {
        width: 100%;
    }

    .collapsible hr {
        margin-top: 10px;
        margin-bottom: 10px;
        background-color: #698161;
        color: #698161;
    }

    /* Milepæler (collapsible) */
    .milepael button, .personRightCol button {
        height: 40px;
        width: 100%;
        font-size: 14px;
        padding: 2px;
        margin-top: 30px;
        float: right;
        border-radius: 10px ;
        background: repeating-linear-gradient(
                45deg,
                #e5e5e5,
                #e5e5e5 10px,
                #eef5ec 10px,
                #f2f2f2 20px
        );
        border-style: dashed;
        border-width: 0.5px;
        border-color: #698161;
        color: black;
    }

    .milepael select {
        font-size: 1.3rem;
        color: grey;
        background-color: #ffffff;
        margin-left: 7px;
    }

    .milepael label {
        margin-top: 20px;
    }

    .addPersonButton {
        border-radius: 10px;
        font-size: 18px;
        margin-bottom: 10px;
    }


    /* Person-collapsible */

    .addPersonButton {
        margin-top: 20px;
        width: 100%;
        background-color: #D0E6C8;
    }

    .addPersonButton h5 {
        width: 100%;
        text-align: center;
    }

    .personLeftCol {
        display: table-cell;
        margin: 0em;
        padding: 1em;
        height: auto;
        vertical-align: middle;
    }

    .personLeftCol h5 {
        text-align: center;
        letter_spacing: normal;
        font-weight: 400;
    }

    .personRightCol {
        width: 100%;
        display: table-cell;
        margin: 0em;
        padding: 1em;
        height: auto;
        vertical-align: middle;
    }

    .personProfilBilde {
        width: 120px;
        height: 120px;
        border-radius: 100%;
        background-color: #999999;

        margin-left: auto;
        margin-right: auto;
    }

    @keyframes fadein {
        from {
            scale: 0.8;
            opacity: 0;
        }

        to {
            scale: 1;
            opacity: 1;
        }
    }



    /* Prosjektside ------------------------------------------------------*/
    .oppsummert {

    }

    .collapsibles .collapsible{
        border-radius: 8px;
        height: 60px;
        margin-top: 5px;
        margin-bottom: 0;
    }

    .collapsibles .content{
        margin: 0 auto;
    }

    .collapsibles {
        width: 60%;
        margin: 0 auto;
    }



    /* Nettleser tilpassning –––––––––––––––––––––––––––––––––––––––––––––––––*/

    /* Firefox < 16 */
    @-moz-keyframes fadein {
        from {
            scale: 0.8;
            opacity: 0;
        }

        to {
            scale: 1;
            opacity: 1;
        }
    }

    /* Safari, Chrome and Opera > 12.1 */
    @-webkit-keyframes fadein {
        from {
            scale: 0.8;
            opacity: 0;
        }

        to {
            scale: 1;
            opacity: 1;
        }
    }

    /* Internet Explorer */
    @-ms-keyframes fadein {
        from {
            scale: 0.8;
            opacity: 0;
        }

        to {
            scale: 1;
            opacity: 1;
        }
    }

    /* Opera < 12.1 */
    @-o-keyframes fadein {
        from {
            scale: 0.8;
            opacity: 0;
        }

        to {
            scale: 1;
            opacity: 1;
        }
    }
</style>
<?php
}
?>