<?php
add_shortcode("sc_login_knapp", "sc_login_knapp");

function sc_login_knapp() {
    //TODO få login knappen til å fungere, og vise logg ut når man skal logge ut igjen.
    ?>
    <a href = "<?php echo get_site_url() ?>/logg-inn">
        <div class=button>
            <?php if (userIsLoggedIn()){echo "Logg ut";}else{echo "Logg inn";}?>
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