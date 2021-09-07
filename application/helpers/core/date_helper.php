<?php
  defined('BASEPATH') OR exit('No direct script access allowed.');

  function get_no_of_period_from_datetime($datetimefrom,$datetimeto,$period_type) {
    $date_diff=0;
    $datetime_from=date_create($datetimefrom);    
    $datetime_to=(!empty($datetimeto))?date_create($datetimeto):date_create(date('Y-m-d H:i:s'));
    $difference = date_diff($datetime_from, $datetime_to);

    switch ($period_type) {
      case 'y':
        $date_diff=$difference->y;  
      break;
      case 'm':
        $date_diff=$difference->m;  
      break;
      case 'd':
        $date_diff=$difference->d;  
      break;
      case 'h':
        $date_diff=$difference->h;  
      break;
      case 'i':
        $date_diff=$difference->i;  
      break;  
      default:
        $date_diff=$difference->s;  
      break;
    }

    return $date_diff;
  }
