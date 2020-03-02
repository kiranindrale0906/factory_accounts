<?php
defined('BASEPATH') OR exit('No direct script access allowed');

trait Terminal_command_trait {

  public function execute_commands($commands) {
    $str_output='';
    foreach ($commands as $index => $command) {
      $str_output=$str_output.$command.' \n';
      exec($command, $output, $failure);
      $str_output=$str_output.implode("\n", $output).' \n \n';
      $output = '';
      if ($failure!=0)
        return $str_output.' FAILURE';
    }
    return $str_output.' SUCCESS' ;
  }
}