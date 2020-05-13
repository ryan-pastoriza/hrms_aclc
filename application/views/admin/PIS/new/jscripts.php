<script>
$(function(){
  // $.ajaxSetup({
  //     data: {
  //         csrf_test_name: $.cookie('csrf_cookie_name')
  //     }
  // });
  $('#employeeCheckBox').attr("checked",true)
  $('#employeeCheckBox').trigger("change")
  $(document).on('click','#employeeCheckBox',function(){
    if($('#employeeCheckBox').is(':checked')) { 

      $(".department select").attr("required",true)
      $(".rate").removeAttr("readonly")
      $(".job_titles").removeAttr("readonly");
      $(".employment_types").attr("required",true)
      $(".employment_types").removeAttr("readonly")

    }

    

  });

  $(document).on('click','#studentCheckBox',function(){
    if($('#studentCheckBox').is(':checked')) { 

      $(".department select").removeAttr("required")
      $(".rate").attr("readonly",true)
      $(".job_titles").attr("readonly",true)
      $(".job_titles").val("Student Assistant")
      $(".employment_types").removeAttr("required")
      $(".employment_types").attr("readonly",true)

    }

  });
  var newFormData;
  var options = { 
        // target: '#notifications',   // target element(s) to be updated with server response 
        beforeSubmit: function(formData){
                                  $('#submit').attr('disabled','disabled');
                                  $('#submit').html('Submitting');
                              },  // pre-submit callback 
        success: function(e){
                $('#notifications').append(e.view);
                if (e.success == true) {
                  $('#addNewForm input').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
                };  
                                $('.img-prev').attr('src','<?=base_url()?>images/no-image.fw.png');
                                $('#submit').removeAttr('disabled');
                                $('#submit').html('Submit');
                              },
        dataType:  'json',
        // 'xml', 'script', or 'json' (expected server response type) 
        // data: {csrf_test_name: $.cookie('csrf_cookie_name')}
    };
  $('#addNewForm').ajaxForm(options);
});


  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onloadend = function () { // set image data as background of div
          $('.img-prev').attr('src', this.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
  
  $(document).on('change','#fileupload',function(){
    readURL(this);
  });

</script>
  <style type="text/css">
    .form-inline .form-group{
    margin-left: 0 !important;
    margin-right: 0 !important;
    }
  </style>