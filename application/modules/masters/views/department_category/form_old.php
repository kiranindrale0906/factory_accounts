<?php if ($action != 'edit'): ?>
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="form-group row">
                <label class="control-label text-right col-md-3 col-form-label vertical-middle"></label>
                <div class="btn-group btn-group-sm m-b-5 m-l-20">
                    <!-- <a href="<?= base_url('cash_issue_voucher'); ?>" class="skewright btn <?= ($controller != 'cash_issue_voucher') ? 'thm-btn-default' : 'btn-danger' ?>"><span class="skewleft">Cash Issue</span></a> -->
                    <a href="<?= base_url('cash_receipt_voucher') ?>" class="skewright btn <?= ($controller != 'cash_receipt_voucher') ? 'thm-btn-default' : 'btn-success' ?>"><span class="skewleft">Cash Receipt</span></a>
                    <a href="<?= base_url('cash_issue_voucher'); ?>" class="skewright btn <?= ($controller != 'cash_issue_voucher') ? 'thm-btn-default' : 'btn-danger' ?>"><span class="skewleft">Cash Issue</span></a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<form method="post" class="form-horizontal" action="<?= get_form_action($controller, $action, $record) ?>">
    <div class="row">
        <?php
        $display_extra_field = 'block'; 
        if ($action == 'edit'):
            echo '<input type="hidden" name="id" value="' . $record['id'] . '">';
            $display_extra_field = 'block';
        endif;

        if (isset($sales_voucher_id) && $sales_voucher_id != ''):
            echo '<input type="hidden" name="sales_voucher_number" value="' . $sales_voucher_id . '">';
        endif;

        $cash_bill_type = array(
            array('label' => 'On Account', 'name' => 'account', 'checked' => true),
            array('label' => 'Against', 'name' => 'against', 'checked' => false),
        );
        ?>
        <div class="col-lg-6 col-md-12">
            <?php
            $this->load->view('forms/fields/date', array('field' => 'date'));
            $this->load->view('forms/fields/select', array('field' => 'account_name', 'option' => $account, 'has_id_field' => true));
//            $this->load->view('forms/fields/select', array('field' => 'group_code', 'option' => $groups, 'has_id_field' => false));
            $this->load->view('forms/fields/number', array('field' => 'credit_amount', 'step' => '0.01', 'pattern' => '[0-9]*', 'display' => $display_extra_field));
            $this->load->view('forms/fields/text', array('field' => 'narration', 'display' => $display_extra_field));
//            $this->load->view('forms/fields/select', array('field' => 'transaction_type', 'option' => $cash_bill_type, 'option_label' => 'label', 'display' => $display_extra_field, 'has_id_field' => false));
            ?>
        </div>
        <div class="col-md-12 sales-voucher-mapping"><?php $this->load->view('voucher_mapping/edit'); ?></div>
    </div>
    <?php $this->load->view('forms/fields/submit', array('controller' => $controller)) ?>
</form>