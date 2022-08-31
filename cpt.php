<?php 
/* please use init hook for post type */
class create_cpt(){
  public $post_type;
  public $args = array(
    'public'    => true,
    'menu_icon' => 'dashicons-book',
    'has_archive' => true,
  );
  function __construct($pt, $arg) {
      $this->post_type = $pt;
      if(is_array($arg)){
        $this->args = $arg;
      }else{
        $this->args['label']  => __( 'Books');
      }
   }
   
   function init(){
       register_post_type( $this->post_type, $this->args );
   }
}
?>
