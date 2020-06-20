<?php
  defined('BASEPATH') OR exit('No direct script access allowed.');
  
  function startsWith($string, $startString) { 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
  } 
