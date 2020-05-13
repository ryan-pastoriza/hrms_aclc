<?php
/**
 * @Author: khrey
 * @Date:   2015-10-20 08:49:41
 * @Last Modified by:   khrey
 * @Last Modified time: 2015-10-27 15:37:09
 */
?>
<script type="text/javascript">
	var options = {
	        beforeSubmit:  function(){
	        	$('#saveARBTN').attr('disabled','disabled');
	        },
	        success: function(r){
	        	$('#saveARBTN').removeAttr('disabled');
	        	$('#notifications').append(r.view);
	        },
	        dataType: "json"
	    };
	
	    $('#attendanceRuleForm').ajaxForm(options);
</script>
<div class="content">
	<div class="col-md-7 col-sm-12 col-md-offset-2">
		<div class="box box-info collapsed-box">
			<div class="box-header">
				<h3 class="box-title">Attendance</h3>
				<div class="box-tools pull-right">
	                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
	            </div>
			</div>
			<div class="box-body">
			<?php echo form_open(base_url('index.php/admin/account_settings/save_attendance_rules'), array('id'=>'attendanceRuleForm')); ?>
	                <div class="box-body">
	                  <div class="form-group row">
		                <div class="col-md-12">
		                    <label>Employee is considered absent when late is greater than or equal to</label>
	                    </div>
	                    <div class="col-md-2">
		                    <input type="number" class="form-control" name="late_hr_max" placeholder="HH" min="0" max="24" required value="<?= $att_rule->late_hr_max ?>"> hours 
	                    </div>
	                    <div class="col-md-2">
	                    	<input type="number" name="late_min_max" id="" class="form-control" placeholder="MM" min="0" max="59" value="<?= $att_rule->late_min_max ?>" required> minutes
	                    </div>
	                  </div>
	                  <div class="form-group row">
	                  	<div class="col-md-12">
		                    <label>Employee is considered absent when timed out earlier than or equal to</label>
	                  	</div>
	                  	<div class="col-md-2">
		                    <input type="number" class="form-control" name="ut_hr_max"  placeholder="HH" min="0" max="24" value="<?= $att_rule->ut_hr_max ?>" required> hours
	                  	</div>
	                  	<div class="col-md-2">
	                  		<input type="number" name="ut_min_max" id="" class="form-control" placeholder="MM" min="0" max="59" required value="<?= $att_rule->ut_min_max ?>"> minutes
	                  	</div>
	                  </div>
	                  <!-- <div class="form-group row">
		                <div class="col-md-12">
		                    <label>Employee is considered absent when worked for under or</label>
	                    </div>
	                    <div class="col-md-2">
		                    <input type="number" class="form-control" name="uw_hr_max" placeholder="HH" min="0" max="24" required value="<?= $att_rule->uw_hr_max ?>"> hours 
	                    </div>
	                    <div class="col-md-2">
	                    	<input type="number" name="uw_min_max" id="" class="form-control" placeholder="MM" min="0" max="59" value="<?= $att_rule->uw_min_max ?>" required> minutes
	                    </div>
	                  </div> -->
	                </div>
	                <div class="box-footer">
	                	<input type="submit" value="Save Attendance Rule" id="saveARBTN" class="btn btn-info">
	                </div>
	            </form>
			</div>
			<div class="box-footer">
			</div>
		</div>
	</div>
</div>