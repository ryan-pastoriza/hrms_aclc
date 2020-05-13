<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-lg-12">
			<table id="table" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Employee Name</th>
						<th>Department</th>
						<th>Action To Be Taken</th>
						<th>Date Filed</th>
						<th>Action</th>
					</tr>
		        </thead>
		        <tbody></tbody>
			</table>
			<?= form_open(base_url('index.php/admin/personnel_action_form/print_paf'), array('id' => 'form_print', 'target' => '_blank')); ?>
				<input type="hidden" name="emp_paf_id">
			</form>
		</div>
	</div>
</div>

<?php $this->load->view("admin/PAF/list/jscript"); ?>