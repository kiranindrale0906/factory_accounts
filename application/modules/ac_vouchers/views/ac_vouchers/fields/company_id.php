<?php
  load_field('hidden',array('field' => 'company_id',
                            'value' => ($this->session->userdata('company_id')?$this->session->userdata('company_id'):1))); ?>
?>