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
    $buttonLinkBeginning = "https://twitter.com/intent/tweet?text=";
    $pageLinkEncoded = urlencode(home_url(add_query_arg(NULL,NULL )));
    $buttonLink = $buttonLinkBeginning . $pageLinkEncoded;
    implementSingleShareButton("Del på Twitter", $buttonLink, "twitterShareButton");
}

function implementLinkedinShareButton() {
    $buttonLinkBeginning = "https://www.linkedin.com/sharing/share-offsite/?url=";
    $pageLinkEncoded = urlencode(home_url(add_query_arg(NULL,NULL )));
    $buttonLink = $buttonLinkBeginning . $pageLinkEncoded;
    implementSingleShareButton("Del på Linkedin", $buttonLink, "linkedinShareButton");
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