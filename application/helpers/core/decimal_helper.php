<?php

defined('BASEPATH') OR exit('No direct script access allowed.');

if ( ! function_exists('four_decimal')) {
  function four_decimal($value, $zero_value='0'){
    if ($value == 0)
      return $zero_value;
    else
      return number_format((float)$value, 3, '.', '');
  }
}
if ( ! function_exists('eight_decimal')) {
  function eight_decimal($value, $zero_value='0'){
    if ($value == 0)
      return $zero_value;
    else
      return number_format((float)$value, 8, '.', '');
  }
}

if (!function_exists('decimal_number_format')) {
  function decimal_number_format($number, $digits=4, $default = '', $abs = true) {
    if(!empty($default))
      $result = $default;
    else 
      $result = "0.0000";
    
    if ($number == '' || $number == '0.00') {
        return $result;
    }

    if($abs === true):
        $number = abs($number);
    endif;

    return number_format($number, $digits);
  }
}