<?php
  if (!function_exists('str_contains')) {
      function str_contains(string $haystack, string $needle): bool
      {
          return '' === $needle || false !== strpos($haystack, $needle);
      }
  }

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
    $data= array( array('id' => 'Metal',                          'name' => 'Metal'),
                  array('id' => 'Daily Drawer',                   'name' => 'Daily Drawer'),
                  // array('id' => 'AR Gold Refresh',                'name' => 'AR Gold Refresh'),
                  // array('id' => 'ARC Refresh',                    'name' => 'ARC Refresh'),
                  // array('id' => 'ARF Refresh',                    'name' => 'ARF Refresh'),
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
                  array('id' => 'Export Internal',                    'name' => 'Export Internal'),
                  array('id' => 'Domestic Internal',                    'name' => 'Domestic Internal'),
                  array('id' => 'AR Gold RND',                    'name' => 'AR Gold RND'),
                  array('id' => 'ARF RND',                        'name' => 'ARF RND'),
                  array('id' => 'ARC RND',                        'name' => 'ARC RND'),
                  array('id' => 'Internal',                       'name' => 'Internal'),
                  array('id' => 'Vadotar',                        'name' => 'Vadotar'),
                  array('id' => 'Rhodium',                        'name' => 'Rhodium'),
                  array('id' => 'Stone',                        'name' => 'Stone'),
                );
    if(!empty($_GET['refresh_id']) && $_GET['refresh_id']!=''){
      // $data[]=array('id' => 'AR Gold Refresh','name' => 'AR Gold Refresh');
      // $data[]=array('id' => 'ARC Refresh','name' => 'ARC Refresh');
      // $data[]=array('id' => 'ARF Refresh','name' => 'ARF Refresh');
      $data[]=array('id' => 'Refresh','name' => 'Refresh');
    }
    return $data;
  }
  function get_issue_type() {
    return array( array('id' => 'Metal',                       'name' => 'Metal'),
                  array('id' => 'AR Gold Finished Goods',      'name' => 'AR Gold Finished Goods'),
                  array('id' => 'ARC Finished Goods',          'name' => 'ARC Finished Goods'),
                  array('id' => 'ARF Finished Goods',          'name' => 'ARF Finished Goods'),
                  array('id' => 'ARF Software Finished Goods', 'name' => 'ARF Software Finished Goods'),
                  array('id' => 'Internal',                    'name' => 'Internal'),
                  array('id' => 'Rhodium',                    'name' => 'Rhodium'),
                );
  }

  function get_transaction_type() {
    return array( array('id' => 'Cash', 'name' => 'Cash'),
                  array('id' => 'Bill', 'name' => 'Bill'));
  }

  function get_sale_types() {
    return array( array('id' => 'Sale', 'name' => 'Sale'),
                  array('id' => 'Sale Return', 'name' => 'Sale Return'),
                  array('id' => 'Sales Good Return', 'name' => 'Sales Good Return'),
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
                 array('id'=>'Kala Mani','name'=>'Kala Mani'),
                 array('id'=>'GPC Powder','name'=>'GPC Powder'));
  }

  function get_melting_purity(){
    return array(
             array('id'=>92.00,'name'=>'92.00'),
             array('id'=>91.90,'name'=>'91.90'),
             array('id'=>91.85,'name'=>'91.85'),
             array('id'=>83.75,'name'=>'83.75'),
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

  function get_api_url_from_site_name($site_name) {
    if     ($site_name=='AR Gold (May 2022)') return API_MAY2022_ARG_PATH;
    elseif ($site_name=='ARF (May 2022)')     return API_MAY2022_ARF_PATH;
    elseif ($site_name=='ARC (May 2022)')     return API_MAY2022_ARC_PATH;
    elseif ($site_name=='AR Gold (Aug 2022)') return API_AUG2022_ARG_PATH;
    elseif ($site_name=='ARF (Aug 2022)')     return API_AUG2022_ARF_PATH;
    elseif ($site_name=='ARC (Aug 2022)')     return API_AUG2022_ARC_PATH;
    elseif ($site_name=='AR Gold (Feb 2023)') return API_FEB2023_ARG_PATH;
    elseif ($site_name=='ARF (Feb 2023)')     return API_FEB2023_ARF_PATH;
    elseif ($site_name=='ARC (Feb 2023)')     return API_FEB2023_ARC_PATH;
    elseif ($site_name=='AR Gold (Apr 2023)') return API_APR2023_ARG_PATH;
    elseif ($site_name=='ARF (Apr 2023)')     return API_APR2023_ARF_PATH;
    elseif ($site_name=='ARC (Apr 2023)')     return API_APR2023_ARC_PATH;
    elseif ($site_name=='AR Gold (Sep 2023)') return API_SEP2023_ARG_PATH;
    elseif ($site_name=='ARF (Sep 2023)')     return API_SEP2023_ARF_PATH;
    elseif ($site_name=='ARC (Sep 2023)')     return API_SEP2023_ARC_PATH;
    elseif ($site_name=='AR Gold (Apr 2024)') return API_APR2024_ARG_PATH;
    elseif ($site_name=='ARF (Apr 2024)')     return API_APR2024_ARF_PATH;
    elseif ($site_name=='ARC (Apr 2024)')     return API_APR2024_ARC_PATH;
    elseif ($site_name=='Export Apr 2024')     return API_EXPORT_INTERNAL_PATH;
    elseif ($site_name=='Domestic')     return API_DOMESTIC_INTERNAL_PATH;
    elseif ($site_name=='Domesticstaging')     return API_DOMESTIC_INTERNAL_PATH;
  }

  function get_api_path($site_name, $hostversion) {
    if     ($site_name.' '.$hostversion=='AR Gold May 2022') return API_MAY2022_ARG_PATH;
    elseif ($site_name.' '.$hostversion=='ARF May 2022')     return API_MAY2022_ARF_PATH;
    elseif ($site_name.' '.$hostversion=='ARC May 2022')     return API_MAY2022_ARC_PATH;
    elseif ($site_name.' '.$hostversion=='AR Gold Aug 2022') return API_AUG2022_ARG_PATH;
    elseif ($site_name.' '.$hostversion=='ARF Aug 2022')     return API_AUG2022_ARF_PATH;
    elseif ($site_name.' '.$hostversion=='ARC Aug 2022')     return API_AUG2022_ARC_PATH;
    elseif ($site_name.' '.$hostversion=='AR Gold Feb 2023') return API_FEB2023_ARG_PATH;
    elseif ($site_name.' '.$hostversion=='ARF Feb 2023')     return API_FEB2023_ARF_PATH;
    elseif ($site_name.' '.$hostversion=='ARC Feb 2023')     return API_FEB2023_ARC_PATH;
    elseif ($site_name.' '.$hostversion=='AR Gold Apr 2023') return API_APR2023_ARG_PATH;
    elseif ($site_name.' '.$hostversion=='ARF Apr 2023')     return API_APR2023_ARF_PATH;
    elseif ($site_name.' '.$hostversion=='ARC Apr 2023')     return API_APR2023_ARC_PATH;
    elseif ($site_name.' '.$hostversion=='AR Gold Sep 2023') return API_SEP2023_ARG_PATH;
    elseif ($site_name.' '.$hostversion=='ARF Sep 2023')     return API_SEP2023_ARF_PATH;
    elseif ($site_name.' '.$hostversion=='ARC Sep 2023')     return API_SEP2023_ARC_PATH;
    elseif ($site_name.' '.$hostversion=='AR Gold Apr 2024') return API_APR2024_ARG_PATH;
    elseif ($site_name.' '.$hostversion=='ARF Apr 2024')     return API_APR2024_ARF_PATH;
    elseif ($site_name.' '.$hostversion=='ARC Apr 2024')     return API_APR2024_ARC_PATH;
  }

  function get_site_names($export=1) {
    $site_names = array(
      array('id' => '', 'name' => ''),
      // array('id' => 'AR Gold (May 2022)', 'name' => 'AR Gold (May 2022)'),
      // array('id' => 'ARF (May 2022)',     'name' => 'ARF (May 2022)'),
      // array('id' => 'ARC (May 2022)',     'name' => 'ARC (May 2022)'),
      // array('id' => 'AR Gold (Aug 2022)', 'name' => 'AR Gold (Aug 2022)'),
      // array('id' => 'ARF (Aug 2022)',     'name' => 'ARF (Aug 2022)'),
      // array('id' => 'ARC (Aug 2022)',     'name' => 'ARC (Aug 2022)'),
      // array('id' => 'AR Gold (Feb 2023)', 'name' => 'AR Gold (Feb 2023)'),
      // array('id' => 'ARF (Feb 2023)',     'name' => 'ARF (Feb 2023)'),
      // array('id' => 'ARC (Feb 2023)',     'name' => 'ARC (Feb 2023)'),
      //array('id' => 'AR Gold (Apr 2023)', 'name' => 'AR Gold (Apr 2023)'),
      //array('id' => 'ARF (Apr 2023)',     'name' => 'ARF (Apr 2023)'),
      //array('id' => 'ARC (Apr 2023)',     'name' => 'ARC (Apr 2023)'),
      //array('id' => 'AR Gold (Sep 2023)', 'name' => 'AR Gold (Sep 2023)'),
      //array('id' => 'ARF (Sep 2023)',     'name' => 'ARF (Sep 2023)'),
      //array('id' => 'ARC (Sep 2023)',     'name' => 'ARC (Sep 2023)'),
      array('id' => 'AR Gold (Apr 2024)', 'name' => 'AR Gold (Apr 2024)'),
      array('id' => 'ARF (Apr 2024)',     'name' => 'ARF (Apr 2024)'),
      array('id' => 'ARC (Apr 2024)',     'name' => 'ARC (Apr 2024)'),
    array('id' => 'AR Gold ERP', 'name' => 'AR Gold ERP'),
    array('id' => 'ARF ERP', 'name' => 'ARF ERP'),
    array('id' => 'ARC ERP', 'name' => 'ARC ERP'),
    array('id' => 'ARNA BANGLE ERP', 'name' => 'ARNA BANGLE ERP')
    );
    if ($export==1) $site_names[] = array('id' => 'Export Apr 2024', 'name' => 'Export Apr 2024');
    if ($export==2) {
      $site_names[] = array('id' => 'Domestic', 'name' => 'Domestic');
      // $site_names[] = array('id' => 'Domesticstaging', 'name' => 'Domesticstaging');
    }
    return $site_names;
  }

  function get_account_names($export=1) {
    $site_names = array(
      array('id' => '', 'name' => ''),
      /*array('id' => 'AR Gold Software (May 2022)', 'name' => 'AR Gold Software (May 2022)'),
      array('id' => 'ARF Software (May 2022)',     'name' => 'ARF Software (May 2022)'),
      array('id' => 'ARC Software (May 2022)',     'name' => 'ARC Software (May 2022)'),
      array('id' => 'AR Gold Software (Aug 2022)', 'name' => 'AR Gold Software (Aug 2022)'),
      array('id' => 'ARF Software (Aug 2022)',     'name' => 'ARF Software (Aug 2022)'),
      array('id' => 'ARC Software (Aug 2022)',     'name' => 'ARC Software (Aug 2022)'),
      array('id' => 'AR Gold Software (Feb 2023)', 'name' => 'AR Gold Software (Feb 2023)'),
      array('id' => 'ARF Software (Feb 2023)',     'name' => 'ARF Software (Feb 2023)'),
      array('id' => 'ARC Software (Feb 2023)',     'name' => 'ARC Software (Feb 2023)'),*/
      /*array('id' => 'AR Gold Software (Apr 2023)', 'name' => 'AR Gold Software (Apr 2023)'),
      array('id' => 'ARF Software (Apr 2023)',     'name' => 'ARF Software (Apr 2023)'),
      array('id' => 'ARC Software (Apr 2023)',     'name' => 'ARC Software (Apr 2023)'),
      array('id' => 'AR Gold Software (Sep 2023)', 'name' => 'AR Gold Software (Sep 2023)'),
      array('id' => 'ARF Software (Sep 2023)',     'name' => 'ARF Software (Sep 2023)'),
      array('id' => 'ARC Software (Sep 2023)',     'name' => 'ARC Software (Sep 2023)'),
     */ array('id' => 'AR Gold Software (Apr 2024)', 'name' => 'AR Gold Software (Apr 2024)'),
      array('id' => 'ARF Software (Apr 2024)',     'name' => 'ARF Software (Apr 2024)'),
      array('id' => 'ARC Software (Apr 2024)',     'name' => 'ARC Software (Apr 2024)'),
      array('id' => 'AR Gold ERP Software',     'name' => 'AR Gold ERP Software'),
      array('id' => 'ARG ERP Software',     'name' => 'ARG ERP Software'),
      array('id' => 'ARF ERP Software',     'name' => 'ARF ERP Software'),
      array('id' => 'ARC ERP Software',     'name' => 'ARC ERP Software'),
      array('id' => 'Arc Erp Software',     'name' => 'Arc Erp Software'),
      array('id' => 'ARNA BANGLE',     'name' => 'ARNA BANGLE'),
    );
    if ($export==1) $site_names[] = array('id' => 'Export', 'name' => 'Export');
    if ($export==2) $site_names[] = array('id' => 'Domestic', 'name' => 'Domestic');
    return $site_names;
  }

  function get_site_name_from_account_name($account_name) {

    if (str_contains($account_name, 'AR Gold')) {

      if (str_contains($account_name, 'Apr 2023')){
        return 'AR Gold (Apr 2023)';
      }elseif (str_contains($account_name, 'Sep 2023')){
        return 'AR Gold (Sep 2023)';
      }elseif (str_contains($account_name, 'Apr 2024')){
        return 'AR Gold (Apr 2024)';
      }else{
        if (str_contains($account_name, 'AR Gold ERP')){
          return 'AR Gold ERP';
        }elseif (str_contains($account_name, 'ARG')){
          return 'AR Gold ERP';
        }else{
          return 'AR Gold';
        }
      } 
    } elseif (str_contains($account_name, 'ARF')) {
      if (str_contains($account_name, 'Apr 2023')){
        return 'ARF (Apr 2023)';
      }elseif (str_contains($account_name, 'Sep 2023')){
        return 'ARF (Sep 2023)';
      }elseif (str_contains($account_name, 'Apr 2024')){
        return 'ARF (Apr 2024)';
      }else{
        if (str_contains($account_name, 'ARF ERP')){
          return 'ARF ERP';
        }else{
          return 'ARF';
        }
      }
    } elseif (str_contains($account_name, 'ARC')) {
      if (str_contains($account_name, 'Apr 2023')){
        return 'ARC (Apr 2023)';
      }elseif (str_contains($account_name, 'Sep 2023')){
        return 'ARC (Sep 2023)';
      }elseif (str_contains($account_name, 'Apr 2024')){
        return 'ARC (Apr 2024)';
      }else{
        if (str_contains($account_name, 'ARC ERP') || str_contains($account_name, 'Arc Erp')){
          return 'ARC ERP';
        }else{
          return 'ARC';
        }
      }
    }elseif (str_contains($account_name, 'ARF ERP')) {
       return 'ARF ERP';
    }

    /*if (str_contains($account_name, 'AR Gold')) {
      if (str_contains($account_name, 'May 2022')) return 'AR Gold (May 2022)';
      elseif (str_contains($account_name, 'Aug 2022')) return 'AR Gold (Aug 2022)';
      elseif (str_contains($account_name, 'Feb 2023')) return 'AR Gold (Feb 2023)';
    } elseif (str_contains($account_name, 'ARF')) {
      if (str_contains($account_name, 'May 2022')) return 'ARF (May 2022)';
      elseif (str_contains($account_name, 'Aug 2022')) return 'ARF (Aug 2022)';
      elseif (str_contains($account_name, 'Feb 2023')) return 'ARF (Feb 2023)';
    } elseif (str_contains($account_name, 'ARC')) {
      if (str_contains($account_name, 'May 2022')) return 'ARC (May 2022)';
      elseif (str_contains($account_name, 'Aug 2022')) return 'ARC (Aug 2022)';
      elseif (str_contains($account_name, 'Feb 2023')) return 'ARC (Feb 2023)';
    }*/ 
    if ($account_name=='ARNA BANGLE')
      return 'ARNA BANGLE ERP';
    if ($account_name=='Domestic Internal ERP Software')
      return 'Domestic Internal ERP';
     
    if ($account_name=='VADOTAR')
      return 'AR Gold';
      // return 'AR Gold (Aug 2022)';
    
       $site_name = array('AR Gold Software (May 2022)' => 'AR Gold (May 2022)',
                       'ARF Software (May 2022)'     => 'ARF (May 2022)',
                       'ARC Software (May 2022)'     => 'ARC (May 2022)',
                       'AR Gold Software (Aug 2022)' => 'AR Gold (Aug 2022)',
                       'ARF Software (Aug 2022)'     => 'ARF (Aug 2022)',
                       'ARC Software (Aug 2022)'     => 'ARC (Aug 2022)',
                       'AR Gold Software (Feb 2023)' => 'AR Gold (Feb 2023)',
                       'ARF Software (Feb 2023)'     => 'ARF (Feb 2023)',
                       'ARC Software (Feb 2023)'     => 'ARC (Feb 2023)',
                       'AR Gold Software (Apr 2023)' => 'AR Gold (Apr 2023)',
                       'ARF Software (Apr 2023)'     => 'ARF (Apr 2023)',
                       'ARC Software (Apr 2023)'     => 'ARC (Apr 2023)',
                       'AR Gold Software (Sep 2023)' => 'AR Gold (Sep 2023)',
                       'ARF Software (Sep 2023)'     => 'ARF (Sep 2023)',
                       'ARC Software (Sep 2023)'     => 'ARC (Sep 2023)',
                       'AR Gold Software (Apr 2024)' => 'AR Gold (Apr 2024)',
                       'ARF Software (Apr 2024)'     => 'ARF (Apr 2024)',
                       'ARC Software (Apr 2024)'     => 'ARC (Apr 2024)',
                       'ARG ERP Software'            => 'AR Gold ERP',
                       'Export Internal Software'    => 'Export',
                       'Domestic Internal Software'    => 'Domestic');
    if (!empty($site_name[$account_name])) return $site_name[$account_name];
  }

  function get_account_name_from_site_name($site_name) {
    $account_name = array('AR Gold (May 2022)' => 'AR Gold Software (May 2022)',
                          'ARF (May 2022)'     => 'ARF Software (May 2022)',
                          'ARC (May 2022)'     => 'ARC Software (May 2022)',
                          'AR Gold (Aug 2022)' => 'AR Gold Software (Aug 2022)',
                          'ARF (Aug 2022)'     => 'ARF Software (Aug 2022)',
                          'ARC (Aug 2022)'     => 'ARC Software (Aug 2022)',
                          'AR Gold (Feb 2023)' => 'AR Gold Software (Feb 2023)',
                          'ARF (Feb 2023)'     => 'ARF Software (Feb 2023)',
                          'ARC (Feb 2023)'     => 'ARC Software (Feb 2023)',
                          'AR Gold (Apr 2023)' => 'AR Gold Software (Apr 2023)',
                          'ARF (Apr 2023)'     => 'ARF Software (Apr 2023)',
                          'ARC (Apr 2023)'     => 'ARC Software (Apr 2023)',
                          'AR Gold (Sep 2023)' => 'AR Gold Software (Sep 2023)',
                          'ARF (Sep 2023)'     => 'ARF Software (Sep 2023)',
                          'ARC (Sep 2023)'     => 'ARC Software (Sep 2023)',
                          //'AR Gold (Apr 2024)' => 'AR Gold Software (Apr 2024)',
                          'ARF (Apr 2024)'     => 'ARF Software (Apr 2024)',
                          'ARC (Apr 2024)'     => 'ARC Software (Apr 2024)',
                          'AR Gold ERP'     => 'ARG ERP Software',
                          'Export'           => 'Export Internal Software',
                          'Domestic'           => 'Domestic Internal Software');
    return $account_name[$site_name] ?? '';
  }
  
  function get_api_path_from_account_name($account_name) {
    $api_path = array(/*'AR Gold Software (May 2022)' => API_MAY2022_ARG_PATH,
                      'ARF Software (May 2022)'     => API_MAY2022_ARF_PATH,
                      'ARC Software (May 2022)'     => API_MAY2022_ARC_PATH,
                      'AR Gold Software (Aug 2022)' => API_AUG2022_ARG_PATH,
                      'ARF Software (Aug 2022)'     => API_AUG2022_ARF_PATH,
                      'ARC Software (Aug 2022)'     => API_AUG2022_ARC_PATH,
                      'AR Gold Software (Feb 2023)' => API_FEB2023_ARG_PATH,
                      'ARF Software (Feb 2023)'     => API_FEB2023_ARF_PATH,
                      'ARC Software (Feb 2023)'     => API_FEB2023_ARC_PATH,
                      'AR Gold Software (Apr 2023)' => API_APR2023_ARG_PATH,
                      'ARF Software (Apr 2023)'     => API_APR2023_ARF_PATH,
                      'ARC Software (Apr 2023)'     => API_APR2023_ARC_PATH,
                      */
                      'AR Gold Software (Sep 2023)' => API_SEP2023_ARG_PATH,
                      'ARF Software (Sep 2023)'     => API_SEP2023_ARF_PATH,
                      'ARC Software (Sep 2023)'     => API_SEP2023_ARC_PATH,
                      //'AR Gold Software (Apr 2024)' => API_APR2024_ARG_PATH,
                      'ARF Software (Apr 2024)'     => API_APR2024_ARF_PATH,
                      'ARC Software (Apr 2024)'     => API_APR2024_ARC_PATH,
                      'AR Gold Software Staging' => API_AUG2022_ARG_PATH,
                      'ARF Software Staging'     => API_AUG2022_ARF_PATH,
                      'ARC Software Staging'     => API_AUG2022_ARC_PATH,
                      'Export Internal Software'    => API_EXPORT_INTERNAL_PATH,
                      'Domestic Internal Software'    => API_DOMESTIC_INTERNAL_PATH,
                      );
    
return $api_path[$account_name];
  }

  function get_loss_account_name_from_site_name($site_name) {
    $loss_account_name = array('ARC (May 2022)' => 'ARC Loss Account (May 2022)',
                          'ARF (May 2022)' => 'ARF Loss Account (May 2022)',
                          'AR Gold (May 2022)' => 'AR Gold Loss Account (May 2022)',
                          'AR Gold (Aug 2022)' => 'AR Gold Loss Account (Aug 2022)',
                          'ARC (Aug 2022)' => 'ARC Loss Account (Aug 2022)',
                          'ARF (Aug 2022)' => 'ARF Loss Account (Aug 2022)',
                          'AR Gold (Feb 2023)' => 'AR Gold Loss Account (Feb 2023)',
                          'ARC (Feb 2023)' => 'ARC Loss Account (Feb 2023)',
                          'ARF (Feb 2023)' => 'ARF Loss Account (Feb 2023)',
                          'AR Gold (Apr 2023)' => 'AR Gold Loss Account (Apr 2023)',
                          'ARC (Apr 2023)' => 'ARC Loss Account (Apr 2023)',
                          'ARF (Apr 2023)' => 'ARF Loss Account (Apr 2023)',
                          'AR Gold ERP' => 'ARG ERP Loss Account',
                          'AR Gold (Sep 2023)' => 'AR Gold Loss Account (Sep 2023)',
                          'ARC (Sep 2023)' => 'ARC Loss Account (Sep 2023)',
                          'ARF (Sep 2023)' => 'ARF Loss Account (Sep 2023)',
                          'AR Gold (Apr 2024)' => 'AR Gold Loss Account (Apr 2024)',
                          'ARC (Apr 2024)' => 'ARC Loss Account (Apr 2024)',
                          'ARF (Apr 2024)' => 'ARF Loss Account (Apr 2024)');
    return $loss_account_name[$site_name]; 
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
