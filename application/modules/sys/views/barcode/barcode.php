<div class="row">
	<div class="col-12">
		<button id="btn" type="button" class="btn btn-sm btn_blue float-right mb-3"><i class="fa fa-print"></i></button>
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<div class="form-group"> 
			<div class="">
        <div class="w-100">
				  <input type="text" placeholder="Width in px" class="frame_input width form-control">
				</div>
      </div>	    
	  </div>
	</div>
	<div class="col-sm-4">
		<div class="form-group"> 
			<div class="">
        <div class="w-100">
				  <input type="text" placeholder="Height in px" class="frame_input height form-control">
				</div>
      </div>	    
	  </div>
	</div>

	<div class="col-sm-4">
		<div class="form-group"> 
			<div class="">
        <div class="w-100">
				  <input type="text" placeholder="Font size" class="frame_input font form-control">
				</div>
      </div>	    
	  </div>
	</div>
</div>



<div class="print_div barcode-font">
	<table class="main_div" style="width: 300px;">
		<?php foreach($bar_code_data as $bar_code_key => $bar_code_value){ 
			?>
			<tr style="">
				<td width="100%" class="barcode-text" style="padding: 5px 10px;">
					<?php echo $this->load->view($_GET['module'].'/'.$_GET['controller'].'/barcode_side_text');?>
				</td>
				<td width="100%" style="padding: 5px 10px;" class="devided_div">
					<?php
						$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
						$string = $generator->getBarcode($bar_code_value[$field], $generator::TYPE_CODE_128);
						echo '<img style="width: 150px; height: 50px;" class="barcode_image devided_div" src="data:image/png;base64,' . base64_encode($string) . '">';
					?>
					<?php echo $this->load->view($_GET['module'].'/'.$_GET['controller'].'/barcode_bottom_text');?>
				</td>
			</tr>
		<?php } ?>	
	</table>
</div>



