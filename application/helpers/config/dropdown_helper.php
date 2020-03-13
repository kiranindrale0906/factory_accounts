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

function get_daily_drawer_receipt_type(){
  return array(
               array('id'=>'Hook','name'=>'Hook'),
               array('id'=>'KDM','name'=>'KDM'),
               array('id'=>'Lobster','name'=>'Lobster'),
               array('id'=>'Ball','name'=>'Ball'),
               array('id'=>'Solid Pipe','name'=>'Solid Pipe'),
               array('id'=>'Hollow Pipe','name'=>'Hollow Pipe'),
               array('id'=>'Solid Wire','name'=>'Solid Wire'),
               array('id'=>'Cutting Wire','name'=>'Cutting Wire'),
               array('id'=>'Hard Wire','name'=>'Hard Wire'),
               array('id'=>'Cutting Pipe','name'=>'Cutting Pipe'),
               array('id'=>'Para','name'=>'Para'),
               array('id'=>'I/O Pic','name'=>'I/O Pic'),
               array('id'=>'Pipe','name'=>'Pipe'),
               array('id'=>'Anc Chain','name'=>'Anc Chain'),
               array('id'=>'Stone','name'=>'Stone'),
               array('id'=>'Sisma Pic','name'=>'Sisma Pic'),
               array('id'=>'1.8 pipe','name'=>'1.8 pipe'),
               array('id'=>'1.8mm kajol','name'=>'1.8mm kajol'),
               array('id'=>'1.8mm clipping','name'=>'1.8mm clipping'),
               array('id'=>'3mm clipping','name'=>'3mm clipping'),
               array('id'=>'2mm ball chain','name'=>'2mm ball chain'),
               array('id'=>'30 anchor','name'=>'30 anchor'),
               array('id'=>'30 pipe','name'=>'30 pipe'),
               array('id'=>'4gm fancy box','name'=>'4gm fancy box'),
               array('id'=>'Box pipe clipping','name'=>'Box pipe clipping'),
               array('id'=>'Cutting wire 0.5','name'=>'Cutting wire 0.5'),
               array('id'=>'Cutting wire 0.8','name'=>'Cutting wire 0.8'),
               array('id'=>'Cutting wire 1.1','name'=>'Cutting wire 1.1'),
               array('id'=>'Para 2mm','name'=>'Para 2mm'),
               array('id'=>'Para 3mm','name'=>'Para 3mm'),
               array('id'=>'Para 4mm','name'=>'Para 4mm'),
               array('id'=>'Plain Wire 0.4','name'=>'Plain Wire 0.4'),
               array('id'=>'Plain Wire 0.8','name'=>'Plain Wire 0.8'),
               array('id'=>'Tibki','name'=>'Tibki'),
               array('id'=>'Shook','name'=>'S'),
               array('id'=>'ARF KDM','name'=>'ARF KDM'),
               array('id'=>'Cap','name'=>'Cap'),
               array('id'=>'GPC Powder','name'=>'GPC Powder'),
              );
}

function get_melting_purity(){
  return array(
           array('id'=>'70.00','name'=>'70.00'),
           array('id'=>'75.15','name'=>'75.15'),
           array('id'=>'83.50','name'=>'83.50'),
           array('id'=>'83.65','name'=>'83.65'),
           array('id'=>'87.65','name'=>'87.65'),
           array('id'=>'92.00','name'=>'92.00'));
}

function get_account_name_for_metal_issue(){
  return array(
            array('id' => '', 'name' => ''),
            array('id' => 'ARC', 'name' => 'ARC'),
            array('id' => 'ARF', 'name' => 'ARF')
          );

}

