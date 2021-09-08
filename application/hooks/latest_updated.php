<?php
class Latest_updated {
  function get_latest_updated_date() {
  	$ci =& get_instance();
  	$ci->load->model('ac_vouchers/voucher_model');
  	$_SESSION['lastes_updated_at'] = $ci->voucher_model->find('MAX(updated_at)  as lastest_updated')['lastest_updated'];
  }
}