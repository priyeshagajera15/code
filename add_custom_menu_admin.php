<?php

add_action('admin_menu', 'custom_menu');

function custom_menu(){
    add_menu_page('Custom Menu', 'Custom Menu', 'manage_options', 'custom-menu-slug', 'custom_menu_page_display');
}

function custom_menu_page_display(){
    echo '<h1>Hello World</h1>';
    echo '<p>This is a custom page</p>';
}
?>