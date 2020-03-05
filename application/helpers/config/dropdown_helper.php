<?php
function get_approval_status(){
  return array(array('id' => '0',
                     'name' => 'Pending'),
              array('id' => '1',
                     'name' => 'Approved'),
              array('id' => '2',
                     'name' => 'Rejected'));
}

function get_login_status(){
  return array(array('id' => '1',
                     'name' => 'Enabled'),
              array('id' => '0',
                     'name' => 'Disabled'));
}

function get_expires_in_list(){
  return array(
              array('id' => 'now',
                     'name' => 'Now'),
              array('id' => '1 Hours',
                     'name' => '1 Hour'),
              array('id' => '2 Hours',
                     'name' => '2 Hours'),
              array('id' => '4 Hours',
                     'name' => '4 Hours'),
              array('id' => '8 Hours',
                     'name' => '8 Hours'),
              array('id' => '12 Hours',
                     'name' => '12 Hours'),
              array('id' => '1 Days',
                     'name' => '1 Day'),
              array('id' => '7 Days',
                     'name' => '7 Day'),
              array('id' => '30 Days',
                     'name' => '30 Days'),
              array('id' => 'lifetime',
                     'name' => 'Lifetime'));
}

function get_user_type_list(){
  return array(
              array('id' => '2',
                    'name' => 'Normal'),
              array('id' => '3',
                    'name' => 'Marketing'));
}

function get_transition_triggers(){
  return array(
    array('name'=>'USER',
        'id'=>'USER'),
    array('name'=>'AUTO',
        'id'=>'AUTO'),
    array('name'=>'MSG',
        'id'=>'MSG'),
    array('name'=>'TIME',
        'id'=>'TIME'),
  );
}

function get_directions(){
  return array(
    array('name'=>'IN',
        'id'=>'IN'),
    array('name'=>'OUT',
        'id'=>'OUT'),
  );
}

function get_order_status(){
  return array(
            array('name' => 'Pending order', 'id'  => '0'),
            array('name' => 'Confirmed order', 'id' => '1'),
            array('name' => 'Ready order', 'id' => '5'),
            array('name' => 'Dispatch Order', 'id' => '4'),
            array('name' => 'Cancel order', 'id' => '3'));  
}


function get_priority_type() {
  return array(
            array('name' => 'High', 'id'  => 'High'),
            array('name' => 'Medium', 'id' => 'Medium'),
            array('name' => 'Low', 'id' => 'Low'));   
}

function get_client_target_type() {
  return array(
            array('name' => 'Not Contacted', 'id'  => '0'),
            array('name' => 'Attempted to Contact', 'id' => '1'),
            array('name' => 'Contact in Future', 'id' => '2'),
            array('name' => 'Contacted', 'id' => '3'),
            array('name' => 'Junk Lead', 'id' => '4'),
            array('name' => 'Lost Lead', 'id' => '5'),
            array('name' => 'Lead', 'id' => '6'));   
}

function get_visit_type() {
  return array(
          array('name' => 'Office Visit', 'id'  => '1'),
          array('name' => 'Marketing Visit', 'id' => '2'));   
}

function get_call_type() {
  return array(
          array('name' => 'Call Done', 'id'  => '1'));   
}

function get_company_list(){
  $ci=&get_instance();
  $ci->load->model('masters/company_model');
  $result = $ci->company_model->get('id,name');
  return $result;
}

function get_receipt_type(){
  return array(
              array('id' => 'Metal',
                     'name' => 'Metal'),
              array('id' => 'Refresh',
                     'name' => 'Refresh'),
              array('id' => 'Daily Drawer',
                     'name' => 'Daily Drawer'));
}