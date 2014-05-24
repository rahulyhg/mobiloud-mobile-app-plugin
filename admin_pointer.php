<?php
//admin pointer once the plugin is initialized
function ml_enqueue_pointer_script_style( $hook_suffix ) {
    $enqueue_pointer_script_style = false;
    // Get array list of dismissed pointers for current user and convert it to array
    $dismissed_pointers = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

    // Check if our pointer is not among dismissed ones

    if( !in_array( 'ml_admin_pointer', $dismissed_pointers ) ) {
        $enqueue_pointer_script_style = true;
        // Add footer scripts using callback function
        add_action( 'admin_print_footer_scripts', 'ml_pointer_print_scripts');
    }
    // Enqueue pointer CSS and JS files, if needed
    if( $enqueue_pointer_script_style ) {
        wp_enqueue_style( 'wp-pointer' );
        wp_enqueue_script( 'wp-pointer' );
    }
}
add_action('admin_enqueue_scripts','ml_enqueue_pointer_script_style');

function ml_pointer_print_scripts() {
	$pointer_content  = "<h3>Preview your mobile app now!</h3>";
  $pointer_content .= "<p>Then access the configuration pages in the menu to further customise settings and add pages and categories to your app\'s menu.</p>";
  ?>
  <script type="text/javascript">
  jQuery(document).ready( function($) {
	  $('#toplevel_page_mobiloud_menu').pointer({
    	content:'<?php echo $pointer_content; ?>',
      position: {
	      edge:   'left', // arrow direction
	      align:  'center' // vertical alignment
      },
      pointerWidth:   350,
      close:          function() {
      	$.post( ajaxurl, {
	      	pointer: 'ml_admin_pointer', // pointer ID
        	action: 'dismiss-wp-pointer'
	      });
  	  }
     }).pointer('open');
  });

  </script>
<?php 
}
?>