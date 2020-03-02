var autocomplete = [];

function set_autocomplete_variable(variable_name, values) {
  autocomplete[variable_name] = values.data;
  autocomplete_input();
}

function autocomplete_input(){
  $(".autocomplete").each(function(){
     var getUrl   = $(this).attr('url');
    if(getUrl !='' && getUrl != 'null'){
      $(this).keyup(function (){
        var value = $(this).val();
        var split_array = value.split(',');
        var length_array = split_array.length;
        formdata = new FormData();
        formdata.append('query',$.trim(split_array[length_array -1]));
        formdata.append('variable', $(this).attr('name'));
        ajax_post_request(getUrl, formdata);
      });
    }
    var jsondata = autocomplete[$(this).attr('name')];
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
    $(this).autocomplete({
      // source: 
      minLength: 0,
      source: function( request, response ) {
        response( $.ui.autocomplete.filter(jsondata, extractLast( request.term ) ) );
      },
      focus: function() {
        return false;
      },
      select: function( event, ui ) {
        var terms = split( this.value );
        // remove the current input
        terms.pop();
        // add the selected item
        terms.push( ui.item.value );
        // add placeholder to get the comma-and-space at the end
        terms.push( "" );
        this.value = terms.join( ", " );
        return false;
      }
    });
  });
}

function autocomplete_listing(){
  $(".autocomplete").autocomplete({
    source: function (request, response) {
      var getTable = $('.autocomplete').attr('data-table');
      var getColumn = $('.autocomplete').attr('data-column');
      jQuery.get(base_url+'sys/search/getAutoCompleteDropDownData', {
        query: request.term+'&&'+getTable+'&&'+getColumn
      }, function (data) {
        response(JSON.parse(data));
      });
    },
    minLength: 1
  });
}




