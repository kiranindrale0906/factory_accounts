function country_code(){
  $(document).ready(function(){
    $(".country_code").intlTelInput({
      preferredCountries: ['us', 'in'],
      separateDialCode: true,
      //utilsScript: "utils.js",
    });
  });
}

function formatted_phone_number(){ 
  $('.country_code').keyup(function(e){
    var phone_number = this.value.replace(/\D/g,'').substring(0,11);
    var deleteKey = (e.keyCode == 8 || e.keyCode == 46);
    var len = phone_number.length;
    if(len==0){
        phone_number=phone_number;
    }else if(len<3){
        phone_number='('+phone_number;
    }else if(len==3){
        phone_number = '('+phone_number + (deleteKey ? '' : ') ');
    }else if(len<6){
        phone_number='('+phone_number.substring(0,3)+') '+phone_number.substring(3,6);
    }else if(len==6){
        phone_number='('+phone_number.substring(0,3)+') '+phone_number.substring(3,6)+ (deleteKey ? '' : '-');
    }else{
        phone_number='('+phone_number.substring(0,3)+') '+phone_number.substring(3,6)+'-'+phone_number.substring(6,11);
    }
    this.value = phone_number;
  });
}

$(document).on("click", ".country-list", function(){
  var countryID = [];
  $(".selected-dial-code").each(function(index, element){
    countryID.push($(this).html());
     $('#countryID').val(countryID);
  }); 
});

function country_code_edit(){
  if($(".country_code").length>0){
    $(".country_code").each(function(){
     country_codes = "+"+$(this).attr("dial-code");
     $(this).intlTelInput("setNumber", country_codes+$(this).val());
    })   
  }
}

function project_form_phone(){
  var project_form_phone = $(location).attr("href");
   var pageUrl= project_form_phone.split('/')[5];
   var pageUrl_1= project_form_phone.split('/')[7];
   var pageUrl_business_invoice= project_form_phone.split('/')[4];
   if(pageUrl == 'project_assignment_form_view_edit' 
       || pageUrl_1 =='expense' || pageUrl_1 =='timesheet'
       || pageUrl_business_invoice =='business_invoice'){        
    }  
}


$(document).ajaxStop(()=>{
  country_code();  
  // formatted_phone_number();
  project_form_phone();
  setTimeout(()=>{ country_code_edit() }, 500);
}).ready(()=>{
  country_code();  
  // formatted_phone_number();
  project_form_phone();
});

function country_code_form(){
  $(".form_with_country_code").on('click', function(e){
    e.preventDefault();
    var form = $(this).closest('form');
    var formUrl = form.attr('action');
    var formData = new FormData(form[0]);
    var dial_code = '';
    $('.selected-dial-code').each(function(index, element){
      dial_code = $(this).text();
      formData.append("countryID[]",dial_code);
    });
    ajax_post_request(formUrl,formData);
  });
}

