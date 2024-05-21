<?php 
class WPAjaxHandler {
  public function __construct($action) {
    add_action( 'wp_ajax_nopriv_' . $action, array( $this, 'handle_request' ) );
    add_action( 'wp_ajax_' . $action, array( $this, 'handle_request' ) );
  }

  public function handle_request() {
    if ( isset( $_POST['action_type'] ) && method_exists( $this, $_POST['action_type'] ) ) {
      call_user_func( array( $this, $_POST['action_type'] ), $_POST );
    } else {
      wp_send_json_error( array( 'message' => 'Invalid action type' ) );
      wp_die();
    }
  }
  
}

