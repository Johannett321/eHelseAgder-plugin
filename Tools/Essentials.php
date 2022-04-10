<?php

include ("CookieTool.php");

add_action('wp', 'add_jquery');

function add_jquery() {
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <?php
}