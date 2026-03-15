function filter_listing(modalId) {
  // alert("#"+modalId+"")
  $("#"+modalId+"").modal();
}

function updateQueryStringParam(param, value, extraparam="") {
    if (typeof value === "undefined") {value ="";}
    var urls =window.location.href.split('?')[0];
    var urlQueryString = document.location.search;
    if(value ==''){
      var newParam='';
    }else{
      var newParam = '?' + param + '=' + value;
    }
    params =  newParam;
    // If the "search" string exists, then build params from it
    if (urlQueryString) {
        keyRegex = new RegExp('([\?&])' + param + '[^&]*');
        // If param exists already, update it
        if (urlQueryString.match(keyRegex) !== null) {
          params = urlQueryString.replace(keyRegex, "$1" + newParam);
        } else { // Otherwise, add it to end of query string
          params = urlQueryString + '&' + newParam;
        }
    }
    if(extraparam){
        if (urlQueryString) {
            urlQueryString = params;
            var newParam1 = extraparam + '=' + value,
        keyRegex = new RegExp('([\?&])' + extraparam + '[^&]*');
            // If param exists already, update it
            if (urlQueryString.match(keyRegex) !== null) {
              params = urlQueryString.replace(keyRegex, "$1" + newParam1);
            } else { // Otherwise, add it to end of query string
              params = urlQueryString + '&' + newParam1;
            }
        }
    }
    if(params=='?'){
      params ='';
    }
    window.location = urls+params;
}


function filterTableData(urls,show_class,set_get,is_ajax,intial_param){
  var url = window.location.href;
  var selected_columns = getParameterByName('selected_column',url);
  var ordered_columns = getParameterByName('ordered_columns',url);
  var remove_id = getParameterByName('remove_id',url);
  var order_column = getParameterByName('order_column',url);
  var order_by = getParameterByName('order_by',url);
  var per_page_records =$('#per_page_record').val();
  var order_status =  getParameterByName('order_status',url);
  var my_dashboard =  getParameterByName('dashboard_id',url);
  // Form Elements
  var new_url = $('form#searchFrom').serialize();

  new_url = new_url.replace(/[^=&]+=(&|$)/g,"").replace(/&$/,"");

  if(order_status!="")
    new_url=new_url+"&order_status="+order_status;
  if(order_column!="")
    new_url=new_url+"&order_column="+order_column+"&order_by="+order_by;
  if(remove_id!="")
    new_url=new_url+"&order_column="+order_column+"&remove_id="+remove_id;
  /*if(selected_columns==1 && ordered_columns==0){
    new_url=new_url+"&selected_column=1&ordered_columns=0&search=true";
  }*/
  if(selected_columns==1 && ordered_columns==1){
    new_url=new_url+"&selected_column=1&ordered_columns=1";
  }
  if(my_dashboard!=""){
    new_url=new_url+"&dashboard_id="+my_dashboard;
  }
  if(per_page_records){
    new_url=new_url+"&per_page_records="+per_page_records;
  }
  if(is_ajax == 1){
    $.ajax({
      'url':urls+"?"+intial_param+new_url+'&'+set_get,
      'type':'GET',
      'dataType':'json',
      success:function(res){
        $('.show_'+show_class).html(res.html);
        $('#searchModal').modal('hide');
      } 
    });
  }else{
    window.location.href=urls+"?"+intial_param+new_url;
  }
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return '';
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

$(".location_auto").autocomplete({
  source: function (request, response) {
      var getModuleController = $('.location_auto').attr('data-module');
      jQuery.get(base_url+'filters/index', {
        query: request.term+'&&'+getModuleController+'&&location'
      }, function (data) {
        response(JSON.parse(data));
      });
  },
  minLength: 2
});

$(document).on('click','.removeInput', function(){
  $(this).closest('.divInput').remove();
  $(".submit_filter_form").trigger("click");
});


function searchpopup(urls,key,function_name,search_url,current_url,current_module,search_param,query_string,dashboard_id,is_ajax){
  var urlParams = new URLSearchParams(window.location.search);
  if($("#searchModal").text()==""){

      var getData = {key:key,function_name:function_name,search_url:search_url,current_url:current_url,module:current_module,
        search_param:search_param,query_string:encodeURIComponent(query_string),dashboard_id:dashboard_id,is_ajax:is_ajax};
  }
 else{
    var getData = $('form#searchFrom').serialize()+"&key="+key+"&function_name="+function_name+"&search_url="+search_url+
    "&current_url="+current_url+"&module="+current_module+"&search_param="+search_param+"&query_string="+encodeURIComponent(query_string)
    +"&dashboard_id="+dashboard_id+"&is_ajax="+is_ajax;  
    $("#searchModal").remove();
  }
  var url = urls+"sys/search";
  ajax_get_request(url,'Filter',getData);
 }
