<?php
add_shortcode("sc_login_knapp", "sc_login_knapp");

function sc_login_knapp() {
    if (areElementorBufferingObjects()) return;
    $loginButtonHref = get_site_url();
    if (userIsLoggedIn()) {
        //$loginButtonHref .= "/wp-json/ehelseagderplugin/api/logg_ut";
        $loginButtonHref .= "/min-side";
    }else {
        $loginButtonHref .= "/logg-inn";
    }
    ?>
    <a href = "<?php echo $loginButtonHref ?>">
        <div class="button" style="font-size: 13px;">
            <?php if (userIsLoggedIn()){echo "<span class=\"material-icons\" style=\"margin-bottom: 6px\">person</span> Min side";}else{echo "<span class=\"material-icons\" style=\"margin-bottom: 6px\">lock</span> Logg inn";}?>
        </div>
    </a>
    <style>
        .button {
            background: white;
            color: black;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            border-style: solid;
            border-width: 1px 1px 0px 1px;
            border-color: #84c58e;
            width: 130px;
            font-family: 'Lato' sans-serif;
            font-weight: 400;
            font-size: 14px;
            text-transform: uppercase;
            padding-top: 1.3em;
            text-align: center;
        }
        .button:hover {
            background:#7cc48c;
            font-weight: 700;
            color: #fff;
    </style>
    <?php
}