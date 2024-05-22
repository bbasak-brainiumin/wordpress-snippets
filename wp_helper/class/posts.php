<?php 
    class BnPostHelper {

        private $status = 'publish';
        private $author = 1;

        public function __construct() {
            if(is_user_logged_in()){
                $this->author = get_current_user_id();
            }
        }
    
        public function status($value) {
            $this->status = $value;
        }

        public function author($value) {
            $this->author = $value;
        }


        public function add ($title, $content) {
            $args = array(
                'post_title'    => $title,
                'post_content'  => $content,
                'post_status'   => $this->status,
                'post_author'   => $this->author,
            );
            //create post
            wp_insert_post( $args );
        }

        public function pr(){
            var_dump($this->status);
            var_dump($this->author);
        }
    
    
    }