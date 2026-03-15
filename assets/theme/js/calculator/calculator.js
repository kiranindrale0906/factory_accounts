$(document).ready(function(){
  
$("#calculate").keyup(function(){
        var result = $("#calculate").val();
        if(result.match(/^[a-zA-Z]+$/))
        {
            alert('Alphabets Not Allowed');
                  location.reload();
        }
        var result1 = eval(result);
        if(result1==null)
        {
        $("#cal").html(" ");
        }else
        {
          var res = result1.toFixed(8);
          $("#cal").html(res);
          
        }
        
    });
});

function reload_page(data){
     location.reload();
}