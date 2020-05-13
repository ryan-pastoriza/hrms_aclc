<?php
/**
 * @Author: khrey
 * @Date:   2015-10-16 16:34:06
 * @Last Modified by:   khrey
 * @Last Modified time: 2015-10-20 16:11:51
 */
?>
<script type="text/javascript">
	$(function(){
    var options = {
            success: function(r){
              $('#notifications').html(r.view);
            },
            dataType: "json"
        };

		var editableOptions = {
			mode: 'inline'
		}
    $('#changePassForm').ajaxForm(options);
    $('#changeUnameForm').ajaxForm(options);
		$('.editable').editable(editableOptions);
	})
  $(document).on('keyup','#changePassForm [name=oldPass]',function(e){
    setTimeout(function(){
      verify_password();
    },500)
    })
  $(document).on('keyup','[name=newPass1], [name=newPass2]',function(e){
    verify_match();
    })
  function verify_match(){
    var nPass1 = $('[name=newPass1]');
    var nPass2 = $('[name=newPass2]');
    if (nPass1.val() != nPass2.val() || nPass1.val() == "") {
      nPass1.parent().addClass('has-error');
      nPass2.parent().addClass('has-error');
    }
    else{
      nPass1.parent().removeClass('has-error');
      nPass2.parent().removeClass('has-error');
      nPass1.parent().addClass('has-success');
      nPass2.parent().addClass('has-success');
    }
    enable_change_btn();
  }
  function verify_password(){
    var oldPass = $('#changePassForm [name=oldPass]').val();
    $('#passNotif').html("Verifying Password. . .");
    $.ajax({
      url:"<?= base_url('index.php/admin/account_settings/verify_password') ?>",
      data:{password:oldPass},
      type:'post',
      success:function(r){
        if (!r) {
          $('#passNotif').addClass("text-red");
          $('#passNotif').removeClass("text-info");
          $('#changePassForm [name=oldPass]').parent().addClass('has-error');
          $('#passNotif').html("Invalid Password");
          return false;
        }
        else{
          $('#passNotif').addClass("text-success");
          $('#passNotif').addClass("fa fa-check");
          $('#passNotif').removeClass("text-red");
          $('#passNotif').removeClass("text-info");
          $('#changePassForm [name=oldPass]').parent().removeClass('has-error');
          $('#changePassForm [name=oldPass]').parent().addClass('has-success');
          $('#passNotif').html("Password Verified!");
        }
      },
    });
    enable_change_btn();
  }
  function enable_change_btn(){
    if ( $('#changePassForm .form-group.has-error').length < 1 && $('[name=newPass1]').val() != "" ) {
      $('#changePassBTN').removeClass('disabled');
    }else{
      $('#changePassBTN').addClass('disabled');
    }
  }
</script>
<div class="content">
	<div class="col-md-7 col-sm-12 col-md-offset-2">
		<div class="box box-info">
			<div class="box-header with-border">
				<h1 class="box-title">User Account</h1>
			</div>
              <div class="box-body">
                <div class="box-group" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel ">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
                            Username
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <?php echo form_open(base_url('index.php/admin/account_settings/change_username'), array('id'=>'changeUnameForm')); ?>
                        <div class="box-body row">
  	                        <div class="col-md-6 col-md-offset-3">
  		                        <label>Username:</label>
  		                        <input type="text" name="username" id="" value="<?= $userInfo->username ?>" required class="form-control">
  	                        </div>
                        </div>
                        <div class="box-footer ">
                        <input type="submit" value="Save Changes" class='btn btn-info'>
	                        <!-- <a class="btn btn-info" id="changeUnameBTN" href='#'>Save Changes</a> -->
                        </div>
                        </form>
                      </div>
                    </div>
                    <div class="panel">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
                            Password 
                          </a>
                        </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                          <?php echo form_open(base_url('index.php/admin/account_settings/change_password'), array('id'=>'changePassForm')); ?>
                            <div class="box-body">
                              <div class="form-group">
                                <label>Current Password <small class='text-info' id='passNotif'></small></label>
                                <input type="password" name="oldPass" class="form-control" placeholder="Type Current Password" required>
                              </div>
                              <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="newPass1" class="form-control"  placeholder="Type New Password" required>
                              </div>
                              <div class="form-group">
                                <input type="password" name="newPass2" class="form-control" placeholder="Re-enter New Password" >
                              </div>
                            </div>
                            <div class="box-footer">
                            <input type="submit" id='changePassBTN' value="Save Changes" class='btn btn-info disabled'>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
              </div><!-- /.box-body -->
		</div>
	</div>
</div>