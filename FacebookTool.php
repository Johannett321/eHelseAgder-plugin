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
    <script type = "text/javascript">
        const myFacebookShareButtonLink = document.getElementById('myFacebookShareButtonLink');
        myFacebookShareButtonLink.href += window.location.href;
    </script>
    <?php
}