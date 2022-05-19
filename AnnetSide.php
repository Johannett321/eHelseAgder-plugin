<?php
add_shortcode('sc_annet_list', 'sc_annet_list');

function sc_annet_list() {
    global $post;
    $pages =  get_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0');
    foreach ($pages as $page) {
        ?>
        <a href = "<?php echo get_permalink($page)?>"><button class = "annetsideklasse"><?php echo get_the_title($page)?></button></a>
        <br/>
        <?php
    }
}