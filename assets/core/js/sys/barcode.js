$(".frame_input").keyup(function(e){
	var frame_width = $(".width").val(),
			frame_height = $(".height").val();
			font = $(".font").val();
			var barcodedivwidth = frame_width/2;
			var barcodewidth = barcodedivwidth - 2;
	if(barcodedivwidth != '')
		$(".devided_div").css({'width':barcodedivwidth});
	$(".barcode-font").css({'font-size':font});
	if(frame_width != '')
		$(".main_div").css({'width':frame_width});
	if(frame_height != '')
		$(".devided_div").css({'height':frame_height});
	var width_deduct = frame_width - 10;
	///$(".barcode_image").css({'margin':barcodewidth});
});


function printData()
{
  $(".print_div").printThis();;
}

$("#btn").click(function () {
 	printData();
});

