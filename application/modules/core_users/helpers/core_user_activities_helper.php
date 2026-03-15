<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function coreuseractivities_getTableSettings() {
  return array(
    'page_title'          => 'User Activities List',
    'primary_table'       => 'user_activities',
    'default_column'      => 'id',
    'table'               => 'user_activities',
    'join_conditions'     => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'user_activities.id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'user_activities',
    'add_title'           => 'Add User activities',
    'export_title'        => 'Export',
    'edit'                => '',
    'select_column'       => true,
  );
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

function coreuseractivities_list_settings() {
  return array(
    array("Category", "category", TRUE, "category", TRUE, TRUE, 'user_activities.category', 'user_activities', FALSE,'autocomplete',array('user_activities','category')),
    array("Acrivity action ", "activity_action", TRUE, "action", TRUE, TRUE, 'user_activities.action as activity_action', 'user_activities', FALSE,'autocomplete',array('user_activities','action')),
    array("Label", "label", TRUE, "label", TRUE, TRUE, 'label', 'user_activities', FALSE,'autocomplete',array('user_activities','label')),
    array("Value", "value", TRUE, "value", TRUE, TRUE, 'value', 'user_activities', FALSE,'autocomplete',array('user_activities','value')),
    //array("Action", "action", FALSE, "action", FALSE, FALSE),
  );
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

function coreuseractivities_get_field_attribute($table, $field) {
  $attributes = array();

  $attributes['user_activities'] = array(
    'id'       => array('', '', TRUE, '', TRUE),
    'category' => array('Enter Category', '', TRUE, '', TRUE),
    'action'   => array('Enter Action', '', TRUE, '', TRUE),
    'label'    => array('Enter Label', '', FALSE, '', TRUE),
    'value'    => array('Enter Value', '', FALSE, '', TRUE),
  );
  return $attributes[$table][$field];
}

function coreuseractivities_get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'core_user_activities';
  $actions["View"] = array('request' => "http", 
                           'url' => base_url().$controller.'/view/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'green');
  return $actions;
}