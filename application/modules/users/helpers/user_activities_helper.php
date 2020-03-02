<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
 return coreuseractivities_getTableSettings();
}

/*
  0 => column title
  1 => column name
  2 => order flag
  3 => order column
  4 => filter flag
  5 => expand text flag
  6 => select column
*/

function list_settings() {
  return coreuseractivities_list_settings();
}


/*
  | [0] => Label
  | [1] => Placeholder
  | [2] => Mandatory/Not Mandatory
  | [3] => Class
  | [4] => Autofocus
  | [5] => Readonly
  | [6] => disabled
*/

function get_field_attribute($table, $field) {
  return coreuseractivities_get_field_attribute($table, $field);
}

function get_row_actions($row, $url, $select_url, $filter) {
  return coreuseractivities_get_row_actions($row, $url, $select_url, $filter);
}