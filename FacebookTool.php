<?php

add_shortcode( 'sc_fb_sharebutton', 'sc_fb_sharebutton');

function sc_fb_sharebutton () {
    implementFacebookShareButton();
}

function implementFacebookShareButton() {
    ?>
    <a href="https://www.facebook.com/sharer/sharer.php?u=" target="_blank" id = "myFacebookShareButtonLink">
        <div class = "facebook-deleknapp" id = "myFacebookShareButton">
            Del på Facebook
        </div>
    </a>
    <style>
        .facebook-deleknapp {
            width: 200px;
            padding-top: 10px;
            padding-bottom: 10px;
            border-radius: 50px;
            box-shadow: 0px 2px 5px #898F9C;
            text-align: center;
            background-color: #4267B2;
            color: white;
            transition-duration: 0.2s;
        }

        .facebook-deleknapp:hover {
            transform: scale(1.04);
            box-shadow: 0px 5px 5px #898F9C;
            background-color: #274279;
        }
    </style>
    <script type = "text/javascript">
        const myFacebookShareButtonLink = document.getElementById('myFacebookShareButtonLink');
        myFacebookShareButtonLink.href += window.location.href;
    </script>
    <?php
}