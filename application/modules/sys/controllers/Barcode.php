<?php 
	class Barcode extends BaseController {
		protected $load_helper = false;
		public function __construct() {
	  	parent::__construct();
		}

		public function view($data=''){
			$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
			$barcode['string'] = $generator->getBarcode($data, $generator::TYPE_CODE_128);
			$barcode['layout'] = 'application';
			$this->load->render('sys/barcode/barcode',$barcode);
		}
	}
?>