<style>
    .requiredPart, .sammendragContainer {
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }

    .requiredPart {
        padding: 20px;
        background-color: #eef7e9;
        border-radius: 10px;
    }

    .small_input {
        height: 30px;
        border-radius: 5px;
        margin-bottom: 17px;
        font-size: 14px;
        color: #595959;
        width: 90%;
    }

    .small_input {
        width: 100%;
        height: 30px;
        margin-bottom: 20px;
    }

    h1, h2, h3, h4, h5, h6 {
        margin: 0px;
        padding: 0px;
    }

    h1 {
        font-size: 3.5rem;
        font-weight: 700;
        line-height: 1.138888889;
    }

    h2 {
        font-size: 3rem;
        font-weight: 700;
    }

    h3 {
        font-size: 2.5rem;
        font-weight: 700;
    }

    h4 {
        font-size: 2rem;
        font-weight: 700;
    }

    h5 {
        font-size: 1.5rem;
        font-weight: 400;
    }

    h6 {
        font-size: 1rem;
        letter-spacing: 0.03125em;
        font-weight: 400;
    }

    p {
        line-height: 1.5;
        margin: 0 0 1em 0;
        font-size: 0.875rem;
        font-weight: 400;
    }

    .projectLeader {
        padding: 20px;
        margin: 20px;
        margin-left: 0px;
        border-radius: 10px;
        background-color: #aed1a4;
        width: 80%;
        height: 20%;
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

    .requiredPart, .sammendragContainer {
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }

    .requiredPart {
        padding: 20px;
        background-color: #eef7e9;
        border-radius: 10px;
    }

    .small_input {
        height: 30px;
        border-radius: 5px;
        margin-bottom: 17px;
        font-size: 14px;
        color: #595959;
        width: 90%;
    }

    h1, h2, h3, h4, h5, h6 {
        margin: 0px;
        padding: 0px;
    }

    h1 {
        font-size: 3.5rem;
        font-weight: 700;
        line-height: 1.138888889;
    }

    h2 {
        font-size: 3rem;
        font-weight: 700;
    }

    h3 {
        font-size: 2.5rem;
        font-weight: 700;
    }

    h4 {
        font-size: 2rem;
        font-weight: 700;
    }

    h5 {
        font-size: 1.5rem;
        font-weight: 400;
    }

    h6 {
        font-size: 1rem;
        letter-spacing: 0.03125em;
        font-weight: 400;
    }

    p {
        line-height: 1.5;
        margin: 0 0 1em 0;
        font-size: 0.875rem;
        font-weight: 400;
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