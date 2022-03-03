<?php
add_shortcode( 'add_login_field', 'loginfield');

function loginfield( $atts ) {
    ?>
    <form action = "../ProsjektRedigering" method = "post">   
        <label for="uname">Brukernavn:</label><br>
        <input type="text" id="uname" name="uname" value="johannett321"><br>
        <label for="password">Passord:</label><br>
        <input type="password" id="password" name="password" value="julebrus"><br>
        <input type = "submit">
    </form>
    <?php
}