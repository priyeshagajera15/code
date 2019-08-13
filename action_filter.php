<?php 

// 7) What are the types of hooks in WordPress and mention their functions?

// There are two types of hooks 1) Action hooks 2) Filter hooks

// Hooks allow a user to create WordPress theme or plugin with shortcode without changing the original files. Action hooks allow you to insert an additional code from an outside resource, whereas, Filter hooks will only allow you to add content or text at the end of the post.


// ...........exmple ...................
// put into  [function.php]
add_action( 'init', 'process_post' );

function process_post() {
     if( isset( $_POST['unique_hidden_field'] ) ) {
          // process $_POST data here
     }
}

function wpd_265903_request( $request ) {
    if( isset( $request['pagename'] ) ){
        unset( $request['pagename'] );
        $request['page_id'] = 106;
    }
    return $request;
}
add_filter( 'request', 'wpd_265903_request' );
?>
