<?php
add_action( 'wp', 'addglobalcss' );
function addglobalcss() {?>
<style>

    .mainTitle {
        padding-top: 5px;
    }

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
    .infoBlokk, #steg2 {
        margin-left: auto;
        margin-right: auto;

    }
    .infoBlokk {
        background: #eff7ea;
        height: 150px;
        width: 50%;
        padding: 30px 40px;

    }

    #steg2 {
        display: block;
        width: 100% !important;
        text-align: center;
        margin-top: 3%;
    }
    .stegText {
        font-size: 14px !important;
        display: inline-block;
        margin: 0 3.5% 2% 3.5%;
    }
    #step1 {
        text-align: left;
        font-weight: 600;
        color: #0B843E;

    }
    #step2 {
        text-align: center;
        color: #8CBE7E;

    }
    #step3 {
        text-align: right;
        color: #8CBE7E;

    }
    textBox {
        width: 50% !important;
    }
    .material-icons, #infoHead {
        display: inline-block;
        vertical-align: middle !important;
    }
    .border {
        border:1px solid #8CBE7E;
    }
    .bar {
        height:20px;
        width:33%;
        color:#fff;
        background-color:#0B843E;
    }



    /* ProsjektRedigering ––––––––––––––––––––––––––––––––––––––––––––––––––––––––*/
    .requiredPart, .sammendragContainer, .addCustomField {
        width: 60%;
        margin-left: auto;
        margin-right: auto;
    }

    #submitButton {
        background-color: #8ac082;
        height: 50px;
        width: 200px;
        border-radius: 30px;
        margin-top: 7% !important;
        padding: 0px !important;
        text-transform: capitalize;
        color: #000;
    }
    #submitButton:hover {
        color: #fff;
        background-color: #0B843E;
        font-weight: 700;
    }

    /* Kort om prosjektet */
    .requiredPart {
        margin-top: 50px;
        margin-bottom: 60px;
        padding: 20px;
        background-color: #eef7e9;
        border-radius: 10px;
    }

    .requiredPart h3, .requiredPart h4{
        margin-bottom: 1rem;
    }

    #minform input[type="text"], .milepael input[type="text"], .collapsible input[type="text"]{
        height: 30px;
        border-radius: 5px;
        margin: 0.5em;
        margin-bottom: 17px !important;
        font-size: 14px;
        color: #595959;
        width: 90%;
    }

    .labelForInput {
        margin-left: 0.5em;
    }

    .small_input {
        height: 30px;
        border-radius: 5px;
        margin-bottom: 17px;
        font-size: 14px;
        color: #595959;
        width: 90%;
    }

/* Prosjektleder-boks */
    .projectLeader {
        padding: 20px;
        margin: 30px 0px 20px 0px;
        border-radius: 10px;
        background-color: #aed1a4;
        width: 70%;
}

/* Sammendrag */

    #psummary {
        font-family: Lato;
        width: 100%;
        font-size: 14px;
        color: #595959;
        margin: 7px 0 0 7px;
    }

    .sammendragContainer {
        padding: 20px;

    }



    /* ProsjektRedigeringKategorier ––––––––––––––––––––––––––––––––––––––––––––––*/
    .addCustomField p {
        font-size: 14px;
        margin-top: 1.5em;
        margin-bottom: 1.5em;
    }

    #collapsibleChooser {
        font-family: Lato;
        font-size: 1.3rem;
        color: grey;
    }

    .addInfoButton {
        height: 4.5rem;
        width: 20rem;
        font-family: Lato;
        font-size: 14px;
        padding: 5px;
        border-radius: 200px;
        border-style: solid;
        border-width: 1px;
        background-color: #E6F3DF;
        color: #0B843E;
        margin-left: 20px;
    }

    .addInfoButton:hover {
        border: none;
        background-color: #0B843E;
        font-weight: 700;
        color: #fff;
    }

    #categoryAlreadyAdded, #categoryAlreadyAdded img{
        display: inline-block;
    }

    #categoryAlreadyAdded img {
        width: 15px;
        height: 15px;
        margin-left: 10px;
        vertical-align: center;
    }

    #chooseLine {
        margin-bottom: 7rem;
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
        background-color: #EFF7EA;
        padding: 20px;
        margin-top: 20px;
        margin-bottom: 20px;
        box-shadow: 1px 1px 5px #3e6633;
        width: 60%;
        margin-left: auto;
        margin-right: auto;

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
        width: 100%;
        min-height: 200px;
        margin-top: 5px !important;
        border-radius: 5px;
        padding: 10px;
        font-size: 1.3rem;
    }

    .collapsible textarea {
        width: 100%;
        min-height: 200px;
        font-size: 1.4rem;
        padding: 10px;
        font-family: Lato;
        letter-spacing: 0.1px !important;
        word-spacing: 0.5px !important;
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

    .addPersonButton h6 {
        font-size: 20px !important;
        font-weight: 700 !important;
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