<?php 
    $this->load->view('reports/ledgers/report_header', array('header' => 'Domestic Export Ledger'));
    $this->load->view('reports/domestic_export_ledgers/search'); 
    $this->load->view('reports/domestic_export_ledgers/date_wise_ledger', array('report' => 'domestic export ledger')); 

?>