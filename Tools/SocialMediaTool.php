<?php

add_shortcode( 'sc_sharebuttons', 'sc_sharebuttons');

function sc_sharebuttons () {
    if (areElementorBufferingObjects()) return;
    implementAllSMShareButtons();
}

function implementAllSMShareButtons() {
    implementTwitterInShareButton();
    implementFacebookShareButton();
    implementLinkedinShareButton();
}

function implementFacebookShareButton() {
    implementSingleShareButton("Del på Facebook", "https://www.facebook.com/sharer/sharer.php?u=" . home_url(add_query_arg(NULL,NULL )), "facebookShareButton");
}

function implementTwitterInShareButton() {
    implementSingleShareButton("Del på Twitter", "https://twitter.com/intent/tweet?text=" . home_url(add_query_arg(NULL,NULL )), "twitterShareButton");
}

function implementLinkedinShareButton() {
    implementSingleShareButton("Del på Linkedin", "https://www.linkedin.com/sharing/share-offsite/?url=" . home_url(add_query_arg(NULL,NULL )), "linkedinShareButton");
}

function implementSingleShareButton($buttonText, $buttonLink, $cssID) {
    removePageMessageIfPresent();
    ?><div class="deleKnapper">
    <a href="<?php echo $buttonLink ?>" target="_blank" id = "myFacebookShareButtonLink">
        <div class = "deleknapp" id = "<?php echo $cssID ?>">
            <?php echo $buttonText ?>
        </div>
    </a>
    </div>
    <?php
}