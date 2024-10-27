<?php

/*
Plugin Name: Amazon Book Picture from ASIN
Plugin URI: http://narcanti.keyboardsamurais.de/amazon-book-picture.html
Plugin Version: 1.0
Description: Allows to include images of books by asin or isbn from amazon through a simple tag: [abp:SIZE:ASIN:w:IMG-WIDTH:h:IMG-HEIGHT:i:IMG-ID:c:IMG-CLASS]. SIZE: S for small, M for medium or L for large. if not given, defaults to medium. ASIN: plain asin number without - symbols. SIZE, IMG-WIDTH, IMG-HEIGHT, IMG-ID and IMG-CLASS are optional. Examples: [abp:l:3492246885:w:123:h:123:i:1:c:book] [abp:S:3492246885] [abp:3492246885]
Author: M. Serhat Cinar
Author URI: http://narcanti.keyboardsamurais.de
License: GPL
*/

if( !function_exists( 'abp_tag_handler' ) ){
  function abp_tag_handler($asin, $size="M", $width="", $height="", $id="", $class=""){
    $base_url = '<img src="http://images.amazon.com/images/P/'.$asin.'.03.';
    if (strcasecmp($size, 'S') == 0){
      $base_url = $base_url.'THUMBZZZ';
    }
    else if (strcasecmp($size, 'L') == 0){
      $base_url = $base_url.'LZZZZZZZ';
    }
    else{
      $base_url = $base_url.'MZZZZZZZ';
    }
    $base_url = $base_url.'.jpg"';
    if (strlen($width)>0){
      $base_url = $base_url.' width="'.$width.'"';
    }
    if (strlen($height)>0){
      $base_url = $base_url.' height="'.$height.'"';
    }
    if (strlen($id)>0){
      $base_url = $base_url.' id="'.$id.'"';
    }
    if (strlen($class)>0){
      $base_url = $base_url.' class="'.$class.'"';
    }
    $base_url = $base_url.' />';
    return $base_url;
  }
}

if( !function_exists( 'abp_tag' ) ){
  function abp_tag($text){
  	return 
          preg_replace(
            "/(?:\[ABP:(?:\s*)(?:(S|M|L)(?:(?:\s*):)){0,1}(?:\s*)([^:\]]+)(?:\s*)(?::W(?:\s*):(?:\s*)(\d+)(?:\s*)){0,1}(?::H(?:\s*):(?:\s*)(\d+)){0,1}(?::I(?:\s*):(?:\s*)([^:]+)){0,1}(?::C(?:\s*):(?:\s*)([^:]+)){0,1}\])/ismeU",
            "abp_tag_handler('\\2', '\\1', '\\3', '\\4', '\\5', '\\6')", 
            $text
          );
  }
}

add_filter('the_content', 'abp_tag', 10);
add_filter('the_excerpt', 'abp_tag', 10);
?>