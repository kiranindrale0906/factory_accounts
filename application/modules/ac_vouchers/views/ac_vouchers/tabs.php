<?php 
	$class_issue= "";
	$class_receipt= "";
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
<?php 
 	if(stripos($this->router->class,"issue")==TRUE  || stripos($this->router->class,"receipt")==TRUE) :
?>
	<div class="col-lg-6 col-md-12">
		<div class="form-group row">
			<h4 class="blue"><?php echo strtoupper(str_replace("_"," ",$this->router->class)); ?></h4>
		</div>
	  <div class="form-group row">
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

	     <?php 
	     if(!empty(strrpos($this->router->class, "issue") == TRUE)) {
	     load_buttons('anchor',array('name'=>'create alloy record',
                                  'layout' => 'application',
                                  'class'=>'btn-xs bold blue float-left',
                                  'href'=>base_url().'transactions/metal_issue_vouchers?alloy_gpc_records=1'));
        }
        ?> <?php 
	     if(!empty(strrpos($this->router->class, "issue") == TRUE)) {
	     load_buttons('anchor',array('name'=>'create gpc record',
                                  'layout' => 'application',
                                  'class'=>'btn-xs bold blue float-left',
                                  'href'=>base_url().'transactions/metal_issue_vouchers?alloy_gpc_records=2'));
        }
        ?><br>
	  </div>
	
	</div>


<?php endif; ?>

<?php 
	if($this->router->class =="journal_vouchers" 
		 || $this->router->class=="contra_vouchers") {

		if(!empty($this->router->class == "journal_vouchers")) {
			$class_issue="btn-secondary";
			$class_receipt="btn-success";
		} else {
			$class_issue="btn-danger";
			$class_receipt="btn-secondary";	
		}
		?> 

		<div class="col-lg-6 col-md-12">
		  <div class="form-group row">
		    <div class="btn-group" role="group" aria-label="Basic example">
		      <a href="<?= base_url('transactions/journal_vouchers') ?>" class="btn btn-sm text-uppercase <?= $class_receipt; ?> skewright">
		      	<span class="skewleft">Journal voucher</span></a>
		      <a href="<?= base_url('transactions/contra_vouchers'); ?>" class="btn btn-sm text-uppercase <?= $class_issue; ?> skewright"><span class="skewleft">Contra Voucher</span></a>
		    </div>
		  </div>
		</div>
	<?php } 
?>

<?php 
	if($this->router->class =="opening_stock_vouchers") {
		$class_issue="btn-secondary";
		$class_receipt="btn-success";
		?> 

		<div class="col-lg-6 col-md-12">
		  <div class="form-group row">
		    <div class="btn-group" role="group" aria-label="Basic example">
		      <a href="<?= base_url('transactions/opening_stock_vouchers') ?>" class="btn btn-sm text-uppercase <?= $class_receipt; ?> skewright">
		      	<span class="skewleft">Opening Stock voucher</span>
	      	</a>
		    </div>
		  </div>
		</div>
	<?php } 
?>
