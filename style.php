<style>

    /* Progress bar ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––*/
    .infoBlokk, #steg2 {
        margin-left: auto;
        margin-right: auto;

    }
    .infoBlokk {
        background:
                #eff7ea;
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
    .requiredPart, .sammendragContainer {
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

    #minform input[type="text"] {
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
        height: 60%;
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









    .addCustomField {
        margin: 20px;
    }

    .addInfoButton {
        border-radius: 200px;
        padding: 10px;
        border: none;
        background-color: #666666;
        color: white;
        font-size: 17px;
        margin-left:20px;
    }

    select {
        height: 40px;
        width: 300px;
        border-radius: 5px;
        padding: 10px
    }

    textarea {
        width: 100%;
        min-height: 200px;
        margin-top: 5px;
        border-radius: 10px;
        padding: 10px;
        font-size: 15px;
    }

    #minform {
        margin-bottom:30px !important;
    }
    .hidden {
        display:none !important;
    }



    .inlineBlock {
        display: inline-block;
    }

    .addCustomField {
        margin: 20px;
    }

    .addInfoButton {
        border-radius: 200px;
        padding: 10px;
        border: none;
        background-color: #666666;
        color: white;
        font-size: 17px;
        margin-left: 20px;
    }

    #categoryAlreadyAdded {
        font-size: 17px;
        padding: 10px;
        margin-left: 20px;
        opacity: 0.3;
    }

    #categoryAlreadyAdded img {
        width: 20px;
        height: 20px;
    }

    .mainTitle {
        padding-top: 5px;
    }

    select {
        height: 40px;
        width: 300px;
        border-radius: 5px;
        padding: 10px
    }

    .collapsible h5 {
        padding-bottom: 10px;
    }

    .removedCol {
        transform: translateX(100vw);
    }

    .collapsible {
        background-color: #EFF7EA;
        padding: 20px;
        margin-top: 20px;
        box-shadow: 2px 2px 10px #555555;

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

    .collapsible textarea {
        width: 100%;
        min-height: 200px;
        font-size: 17px;
        padding: 10px;
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

    .savedText {
        color: gray;
    }

    .removeCollapsibleButton {
        background: none;
        border: none;
        float: right;
        opacity: 80%;
        transition: 0.1s ease;
    }

    .removeCollapsibleButton img {
        width: 30px;
        height: 30px;
    }

    .removeCollapsibleButton:hover {
        scale: 1.1;
        opacity: 100%;
        cursor: pointer;
    }

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

    .collapsibleCustomTitle {
        width:100%;
        padding: 10px;
        font-size: 20px;
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