
<?php 
// generate dynamix short code .......................
function new_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => "warning"
    ), $atts));
    return '<div class="alert alert-'.$type.'">'.$content.'</div>';
}
add_shortcode("warning_box", "new_shortcode");

?>
[warning_box]Warning message[/warning_box]



<!-- ............................ -->

<?php

// add custom field to admin dashboard products by woocommerce 
<!-- //////////////////////////////////////// CUSTOM ADMIN PRODUCT DATA-TABS WOOCOMMERCE //////////////////////////////////////// -->

// First Register the Tab by hooking into the 'woocommerce_product_data_tabs' filter
add_filter( 'woocommerce_product_data_tabs', 'woocom_custom_product_data_tab' );
/** CSS To Add Custom tab Icon */
function wcpp_custom_style() {
?>
<style>
#woocommerce-product-data ul.wc-tabs li.my-custom-tab_options a:before { font-family: WooCommerce; content: '\e006'; }
</style>
<?php 
}
add_action( 'admin_head', 'wcpp_custom_style' );

// functions you can call to output text boxes, select boxes, etc.
add_action('woocommerce_product_data_panels', 'woocom_custom_product_data_fields');
function woocom_custom_product_data_fields() {
    global $post;
    // Note the 'id' attribute needs to match the 'target' parameter set above
    ?> 
    <div id = 'my_custom_product_data' class = 'panel woocommerce_options_panel' > 
    	 <div class = 'options_group' >
		 	<?php
	              // Text Field
			  woocommerce_wp_text_input(
			    array(
			      'id' => '_text_field',
			      'label' => __( 'Custom Text Field', 'woocommerce' ),
			      'wrapper_class' => 'show_if_simple', //show_if_simple or show_if_variable
			      'placeholder' => 'Custom text field',
			      'desc_tip' => 'true',
			      'description' => __( 'Enter the custom value here.', 'woocommerce' )
			    )
			  );
			  // Number Field
			  woocommerce_wp_text_input(
			    array(
			      'id' => '_number_field',
			      'label' => __( 'Custom Number Field', 'woocommerce' ),
			      'placeholder' => '',
			      'description' => __( 'Enter the custom value here.', 'woocommerce' ),
			      'type' => 'number',
			      'custom_attributes' => array(
			         'step' => 'any',
			         'min' => '15'
			      )
			    )
			  );
			  // Checkbox
			  woocommerce_wp_checkbox(
			    array(
			      'id' => '_checkbox',
			      'label' => __('Custom Checkbox Field', 'woocommerce' ),
			      'description' => __( 'Check me!', 'woocommerce' )
			    )
			  );
			  // Select
			  woocommerce_wp_select(
			    array(
			      'id' => '_select',
			      'label' => __( 'Custom Select Field', 'woocommerce' ),
			      'options' => array(
			         'one' => __( 'Custom Option 1', 'woocommerce' ),
			         'two' => __( 'Custom Option 2', 'woocommerce' ),
			        'three' => __( 'Custom Option 3', 'woocommerce' )
			      )
			    )
			  );
			  // Textarea
			  woocommerce_wp_textarea_input(
			     array(
			       'id' => '_textarea',
			       'label' => __( 'Custom Textarea', 'woocommerce' ),
			       'placeholder' => '',
			       'description' => __( 'Enter the value here.', 'woocommerce' )
			     )
			 );
	        ?>
    	</div>
    </div>
    <?php
}
/** Hook callback function to save custom fields information */
function woocom_save_proddata_custom_fields($post_id) {
    // Save Text Field
    $text_field = $_POST['_text_field'];
    if (!empty($text_field)) {
        update_post_meta($post_id, '_text_field', esc_attr($text_field));
    }
    // Save Number Field
    $number_field = $_POST['_number_field'];
    if (!empty($number_field)) {
        update_post_meta($post_id, '_number_field', esc_attr($number_field));
    }
    // Save Textarea
    $textarea = $_POST['_textarea'];
    if (!empty($textarea)) {
        update_post_meta($post_id, '_textarea', esc_html($textarea));
    }
    // Save Select
    $select = $_POST['_select'];
    if (!empty($select)) {
        update_post_meta($post_id, '_select', esc_attr($select));
    }
    // Save Checkbox
    $checkbox = isset($_POST['_checkbox']) ? 'yes' : 'no';
    update_post_meta($post_id, '_checkbox', $checkbox);
    // Save Hidden field
    $hidden = $_POST['_hidden_field'];
    if (!empty($hidden)) {
        update_post_meta($post_id, '_hidden_field', esc_attr($hidden));
    }
}
add_action( 'woocommerce_process_product_meta_simple', 'woocom_save_proddata_custom_fields'  );
// You can uncomment the following line if you wish to use those fields for "Variable Product Type"
//add_action( 'woocommerce_process_product_meta_variable', 'woocom_save_proddata_custom_fields'  );

//////////////////////////////////////// CUSTOM ADMIN PRODUCT DATA-TABS WOOCOMMERCE ////////////////////////////////////////







// ..........................adding media image to custom texonomy ........................................
/**
 * Plugin class
 **/
if ( ! class_exists( 'CT_TAX_META' ) ) {

class CT_TAX_META {

  public function __construct() {
    //
  }
 
 /*
  * Initialize the class and start calling our hooks and filters
  * @since 1.0.0
 */
 public function init() {
   add_action( 'State_add_form_fields', array ( $this, 'add_State_image' ), 10, 2 );
   add_action( 'created_State', array ( $this, 'save_State_image' ), 10, 2 );
   add_action( 'State_edit_form_fields', array ( $this, 'update_State_image' ), 10, 2 );
   add_action( 'edited_State', array ( $this, 'updated_State_image' ), 10, 2 );
   add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
   add_action( 'admin_footer', array ( $this, 'add_script' ) );
 }

public function load_media() {
 wp_enqueue_media();
}
 
 /*
  * Add a form field in the new State page
  * @since 1.0.0
 */
 public function add_State_image ( $taxonomy ) { ?>
   <div class="form-field term-group">
     <label for="State-image-id"><?php _e('State Image', 'techhive'); ?></label>
     <input type="hidden" id="State-image-id" name="State-image-id" class="custom_media_url" value="">
     <div id="State-image-wrapper"></div>
     <p>
       <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'techhive' ); ?>" />
       <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'techhive' ); ?>" />
    </p>
   </div>
 <?php
 }
 
 /*
  * Save the form field
  * @since 1.0.0
 */
 public function save_State_image ( $term_id, $tt_id ) {
   if( isset( $_POST['State-image-id'] ) && '' !== $_POST['State-image-id'] ){
     $image = $_POST['State-image-id'];
     add_term_meta( $term_id, 'State-image-id', $image, true );
   }
 }
 
 /*
  * Edit the form field
  * @since 1.0.0
 */
 public function update_State_image ( $term, $taxonomy ) { ?>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="State-image-id"><?php _e( 'Image', 'techhive' ); ?></label>
     </th>
     <td>
       <?php $image_id = get_term_meta ( $term -> term_id, 'State-image-id', true ); ?>
       <input type="hidden" id="State-image-id" name="State-image-id" value="<?php echo $image_id; ?>">
       <div id="State-image-wrapper">
         <?php if ( $image_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'techhive' ); ?>" />
         <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'techhive' ); ?>" />
       </p>
     </td>
   </tr>
 <?php
 }

/*
 * Update the form field value
 * @since 1.0.0
 */
 public function updated_State_image ( $term_id, $tt_id ) {
   if( isset( $_POST['State-image-id'] ) && '' !== $_POST['State-image-id'] ){
     $image = $_POST['State-image-id'];
     update_term_meta ( $term_id, 'State-image-id', $image );
   } else {
     update_term_meta ( $term_id, 'State-image-id', '' );
   }
 }

/*
 * Add script
 * @since 1.0.0
 */
 public function add_script() { ?>
   <script>
     jQuery(document).ready( function($) {
       function ct_media_upload(button_class) {
         var _custom_media = true,
         _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if ( _custom_media ) {
               $('#State-image-id').val(attachment.id);
               $('#State-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#State-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
            }
         wp.media.editor.open(button);
         return false;
       });
     }
     ct_media_upload('.ct_tax_media_button.button'); 
     $('body').on('click','.ct_tax_media_remove',function(){
       $('#State-image-id').val('');
       $('#State-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });
     // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-State-ajax-response
     $(document).ajaxComplete(function(event, xhr, settings) {
       var queryStringArr = settings.data.split('&');
       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
         var xml = xhr.responseXML;
         $response = $(xml).find('term_id').text();
         if($response!=""){
           // Clear the thumb image
           $('#State-image-wrapper').html('');
         }
       }
     });
   });
 </script>
 <?php }

  }
 
$CT_TAX_META = new CT_TAX_META();
$CT_TAX_META -> init();
 
}

function mytheme_post_thumbnails() {
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'mytheme_post_thumbnails' );
