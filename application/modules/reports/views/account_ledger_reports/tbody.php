<tbody>
  <?php 
    $this->load->view('issue_and_receipts/issue_and_receipts/balance', array('label' => 'Opening',
                                                                             'created_date' => $previous_date,
                                                                             'type' => $type));

    foreach ($created_date_records as $index => $record) 
      $this->load->view('issue_and_receipts/issue_and_receipts/tr', array('record' => $record));
  
    $this->load->view('issue_and_receipts/issue_and_receipts/total', array('label' => 'Total',
                                                                           'weight' => $total[$created_date][$type]['weight'], 
                                                                           'fine' => $total[$created_date][$type]['fine']));
    $this->load->view('issue_and_receipts/issue_and_receipts/balance', array('label' => 'Balance',
                                                                             'created_date' => $created_date,
                                                                             'type' => $type));


  ?>
</tbody>