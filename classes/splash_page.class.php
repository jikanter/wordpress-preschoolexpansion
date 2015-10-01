<?php

/* 
 * Copyright (c) 2015 Jordan Kanter. All rights reserved. 
 */
class splash_page_type extends custom_post_type { 
  
  const CLASS_NAME = 'splash_page_type';
  const POST_NAME_SINGLE = 'Custom Splash Page';
  const POST_TYPE_NAME = 'Custom Splash Pages';
  
  
  public static function load_fields() {
    $class_name = get_called_class();
    $class_name::$fields = array( 'splash_section_subheading' => array('type' => 'html'), 
                                  'splash_page_subcontent' =>    array('type' => 'html'));
  }
  
  public function __construct() {
    parent::__construct(); 
  }

}

