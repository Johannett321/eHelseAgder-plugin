<?php
add_action('init', 'javascriptMustBeEnabledInfo');

function javascriptMustBeEnabledInfo() {
    ?>
    <noscript>
        <h3>Denne siden krever javascript</h3>
        <p style="font-size: 20px">Det ser ut som javascript ikke er støttet i din nettleser. Vennligst prøv en annen nettleser eller datamaskin.</p>
        <style>div { display:none; }</style>
    </noscript>
    <?php
}