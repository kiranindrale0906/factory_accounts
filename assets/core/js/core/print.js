function print_page(){
	// if (this.event.keyCode==13 && value!='')
  if(typeof printid != 'undefined') {
    $('#'+printid).print();
  }
  $('.print_section').print();
}

// $(document).on('keydown', function(e) {
// 	if (e.keyCode==80 && value!=''){
// 		$('.print_section').print();		
// 	}	
// })
