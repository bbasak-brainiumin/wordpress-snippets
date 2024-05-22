<?php 
    class Ninja_form_helper {

        private $field_names = array();
        private $field_alises = array();
        public function __construct() {
        }
        public function set_field_names($value) {
            $this->field_names = $value;
        }

        public function set_field_alises($value) {
            $this->field_alises = $value;
        }

        public function get_filter_form_data($form_data) {
            $result = array();
                foreach ($form_data['fields'] as $field) {
                    foreach($this->field_names as $key => $item){
                        if ($field['key'] === $item) {
                            if(!count($this->field_alises)){
                                $result[$item] = $field['value'];
                            }else {
                                $result[$this->field_alises[$key]] = $field['value'];
                            }
                            
                        }
                    }
                }
            return $result;
        }
        
    }
?>