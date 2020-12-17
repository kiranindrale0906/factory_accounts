<?php
  function get_dropdown_array($simple_array, $empty_value=false) {
    $dropdown_array = array();
    if ($empty_value)
      $dropdown_array[] = array('id' => '', 'name' => '');
    if (empty($simple_array)) return $dropdown_array;
    foreach($simple_array as $array_item) {
      $dropdown_array[] = array('id' => $array_item, 'name' => $array_item);
    }
    return $dropdown_array;
  }

  function get_company_list() {
    $ci=&get_instance();
    $ci->load->model('masters/company_model');
    $result = $ci->company_model->get('id,name');
    return $result;
  }

  function get_logo() {
    $ci=&get_instance();
    $ci->load->model('masters/company_model');
    $logo = $ci->company_model->find('logo',array('id'=>!empty($ci->session->userdata('company_id'))?$ci->session->userdata('company_id'):1))['logo'];
    return $logo;
  }

  function get_receipt_type() {
    return array( array('id' => 'Metal',                          'name' => 'Metal'),
                  array('id' => 'Daily Drawer',                   'name' => 'Daily Drawer'),
                  array('id' => 'AR Gold Refresh',                'name' => 'AR Gold Refresh'),
                  array('id' => 'ARC Refresh',                    'name' => 'ARC Refresh'),
                  array('id' => 'ARF Refresh',                    'name' => 'ARF Refresh'),
                  array('id' => 'AR Gold Finished Goods',         'name' => 'AR Gold Finished Goods'),
                  array('id' => 'ARC Finished Goods',             'name' => 'ARC Finished Goods'),
                  array('id' => 'ARF Finished Goods',             'name' => 'ARF Finished Goods'),
                  array('id' => 'ARF Software Finished Goods',    'name' => 'ARF Software Finished Goods'),
                  array('id' => 'AR Gold Chain Receipt',          'name' => 'AR Gold Chain Receipt'),
                  array('id' => 'ARF Chain Receipt',              'name' => 'ARF Chain Receipt'),
                  array('id' => 'ARC Chain Receipt',              'name' => 'ARC Chain Receipt'),
                  array('id' => 'AR Gold Internal Receipt',          'name' => 'AR Gold Internal Receipt'),
                  array('id' => 'ARF Internal Receipt',              'name' => 'ARF Internal Receipt'),
                  array('id' => 'ARC Internal Receipt',              'name' => 'ARC Internal Receipt'),
                  array('id' => 'AR Gold Finished Goods Receipt', 'name' => 'AR Gold Finished Goods Receipt'),
                  array('id' => 'ARF Finished Goods Receipt',     'name' => 'ARF Finished Goods Receipt'),
                  array('id' => 'ARC Finished Goods Receipt',     'name' => 'ARC Finished Goods Receipt'),
                  array('id' => 'AR Gold RND',                    'name' => 'AR Gold RND'),
                  array('id' => 'ARF RND',                        'name' => 'ARF RND'),
                  array('id' => 'ARC RND',                        'name' => 'ARC RND'),
                  array('id' => 'Internal',                       'name' => 'Internal'),
                  array('id' => 'Vadotar',                        'name' => 'Vadotar'),
                );
  }
  function get_issue_type() {
    return array( array('id' => 'Metal',                       'name' => 'Metal'),
                  array('id' => 'AR Gold Finished Goods',      'name' => 'AR Gold Finished Goods'),
                  array('id' => 'ARC Finished Goods',          'name' => 'ARC Finished Goods'),
                  array('id' => 'ARF Finished Goods',          'name' => 'ARF Finished Goods'),
                  array('id' => 'ARF Software Finished Goods', 'name' => 'ARF Software Finished Goods'),
                  array('id' => 'Internal',                    'name' => 'Internal'),
                );
  }

  function get_transaction_type() {
    return array( array('id' => 'Cash', 'name' => 'Cash'),
                  array('id' => 'Bill', 'name' => 'Bill'));
  }

  function get_sale_types() {
    return array( array('id' => 'Sale', 'name' => 'Sale'),
                  array('id' => 'Labour', 'name' => 'Labour'));
  }

  function get_gold_rate_purities() {
    return array( array('id' => '100', 'name' => '100'),
                  array('id' => '99.5', 'name' => '99.5'));
  }

  function get_daily_drawer_receipt_type(){
    return array(array('id'=>'Hook','name'=>'Hook'),
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
                 array('id'=>'GPC Powder','name'=>'GPC Powder'));
  }

  function get_melting_purity(){
    return array(
             array('id'=>92.00,'name'=>'92.00'),
             array('id'=>91.90,'name'=>'91.90'),
             array('id'=>91.85,'name'=>'91.85'),
             array('id'=>83.50,'name'=>'83.50'),
             array('id'=>75.25,'name'=>'75.25'),
             array('id'=>75.15,'name'=>'75.15'),
             array('id'=>75.00,'name'=>'75.00'),
             array('id'=>58.50,'name'=>'58.50'),
             array('id'=>41.70,'name'=>'41.70'),
             );
  }

  function get_has_hallmark(){
    return array( array('id' => 'Yes', 'name' => 'Yes'),
                  array('id' => 'No', 'name' => 'No'));

  }

  function get_site_url($site_name) {
    if ($site_name=='AR Gold') return API_ARG_BASE_PATH;
    elseif ($site_name=='ARF') return API_ARF_BASE_PATH;
    elseif ($site_name=='ARC') return API_ARC_BASE_PATH;
  }

  
function remove_duplicates_in_string($str) {
  $words  = explode(",", $str);
  $sanitized_words = array();
  foreach ($words as $word) {
    if (trim($word) == '') continue;
    if (trim($word) == '0') continue;
    $sanitized_words[] = trim($word);
  }
  $unique_words = array_unique($sanitized_words);
  return implode(', ', $unique_words);
}
