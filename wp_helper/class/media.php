<?php 
class mediaHelper {

    public function __construct(){
        add_action( 'wp_head', array( $this, 'ajaxurl_head' ), 99 );
        add_shortcode( 'bn_upload_helper', array( $this, 'file_uploader_render' ));
    }

    public function file_uploader($name='upload-files'){
        echo '
            <form action="" enctype="multipart/form-data" method="post">
                <input id="'.$name.'" name="'.$name.'" type="file"> 
                <input name="submit" type="submit" value="Upload File">
            </form>
        ';
    }

    public function file_uploader_render(){
        ob_start();  
            $this->file_uploader();
        return ob_get_clean();
    }

    public function upload($name){
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        if (isset($_FILES[$name])) {     
           // wp_upload_bits($_FILES[$name]['name'], null, file_get_contents($_FILES[$name]['tmp_name'])); 
           $upload = wp_handle_upload( 
            $_FILES[ $name ], 
            array( 'test_form' => false ) 
           );

           if( ! empty( $upload[ 'error' ] ) ) {
            wp_die( $upload[ 'error' ] );
            }

            $attachment_id = wp_insert_attachment(
                array(
                    'guid'           => $upload[ 'url' ],
                    'post_mime_type' => $upload[ 'type' ],
                    'post_title'     => basename( $upload[ 'file' ] ),
                    'post_content'   => '',
                    'post_status'    => 'inherit',
                ),
                $upload[ 'file' ]
            );
            
            if( is_wp_error( $attachment_id ) || ! $attachment_id ) {
                wp_die( 'Upload error.' );
            }
            
            wp_update_attachment_metadata(
                $attachment_id,
                wp_generate_attachment_metadata( $attachment_id, $upload[ 'file' ] )
            );
        
        }
    }
    public function ajaxurl_head() {
        echo '<script type="text/javascript">var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
    }
    public function media_footer_script() {
        echo '<script>
        jQuery(document).ready(function($) {
            var myForm = $("#myform");
             
            $(myForm).submit(function(e) {
                //Prevent normal form submission
                e.preventDefault();
                 
                //Get the form data and store in a variable
                var myformData = new FormData(myForm[0]);
                 
                //Add our own action to the data
                //action is where we will be hooking our php function
                myformData.append('action', 'pn_wp_frontend_ajax_upload');
                 
                //Prepare and send the call
                $.ajax({
                    type: "POST",
                    data: myformData,
                    dataType: "json",
                    url: ajaxurl,
                    cache: false,
                    processData: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    success: function(data, textStatus, jqXHR) {
                        //Success codes goes here
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        //if fails     
                        console.log(jqXHR);
                    }
                });
            });
        }); </script>';
    }

}
