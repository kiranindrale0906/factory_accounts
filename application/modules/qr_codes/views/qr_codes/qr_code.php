<body style="margin: 0px">
	<div class="container" style="display: flex; height: 'auto'; align-items: center; justify-content: center;">
	      <div style="width: 'auto'">
	        <?php 
						$string=$qr_code_detail['id'];	  	
						$qr_code = generate_qrcode($string,'48');
						echo $qr_code;
					?>
	      </div>
	      <div style="font-size: 7px; font-weight: bold; font-family: Helvetica">
	    		<?php echo 'Chitti No - '.$qr_code_detail['id']; ?>
	      </div>
	      
	    </div>
</body>


	

