<?php /*if($this->router->class =="cash_receipt_vouchers" || $this->router->class=="cash_issue_vouchers" || $this->router->class =="metal_receipt_vouchers" || $this->router->class=="metal_issue_vouchers") : */
	$class_issue= "";
	$class_receipt= "";
	//if(!empty($this->router->class == "cash_receipt_vouchers")) {
	if(!empty(strrpos($this->router->class, "receipt") == false)) {
		$class_receipt="btn-success";
	}
	else
	{
		$class_issue="btn-danger";
	}

	$label_issue=str_replace("receipt","issue", $this->router->class);
	$label_receipt=str_replace("issue","receipt", $this->router->class);
?> 

<div class="col-lg-6 col-md-12">
	<div class="form-group row">
		<h4 class="blue"><?php echo strtoupper(str_replace("_"," ",$this->router->class)); ?></h4>
	</div>
  <!-- <div class="form-group row">
    <div class="btn-group" role="group" aria-label="Basic example">
      <a href="<?= base_url('transactions/'.str_replace('receipt','issue', $this->router->class)) ?>" class="btn btn-sm btn-secondary text-uppercase <?= $class_receipt; ?> skewright">
      	<span class="skewleft">
      		<?= str_replace("_", " ", $label_issue); ?>
      	</span>
      </a>
      <a href="<?= base_url('transactions/'.str_replace('issue','receipt', $this->router->class)); ?>" class="btn btn-sm btn-secondary text-uppercase <?= $class_issue; ?> skewright">
      	<span class="skewleft"><?= str_replace("_", " ", $label_receipt); ?>
      	</span>
      </a>
    </div>
  </div> -->
</div>

<?php //endif; ?>

<?php if($this->router->class =="metal_receipt_vouchers" || $this->router->class=="metal_issue_vouchers") : 

	// if(!empty($this->router->class == "metal_receipt_vouchers")) {
	// 	$class_issue="btn-secondary";
	// 	$class_receipt="btn-success";
	// }
	// else
	// {
	// 	$class_issue="btn-danger";
	// 	$class_receipt="btn-secondary";	
	// }
?> 
<!-- 
<div class="col-lg-6 col-md-12">
  <div class="form-group row">
    <div class="btn-group" role="group" aria-label="Basic example">
      <a href="<?= base_url('transactions/metal_receipt_vouchers') ?>" class="btn btn-sm text-uppercase <?= $class_receipt; ?> skewright"><span class="skewleft">Metal Receipt</span></a>
      <a href="<?= base_url('transactions/metal_issue_vouchers'); ?>" class="btn btn-sm text-uppercase <?= $class_issue; ?> skewright"><span class="skewleft">Metal Issue</span></a>
    </div>
  </div>
</div> -->

<?php endif; ?>