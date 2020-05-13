<style type="text/css">
  #paymentTable td {
    padding: 1px;
    text-indent: 5%;
  }
  #paymentTable {
    width: 100%;
  }
</style>
<div id="payment" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Payment</h4>
      </div>
      <div class="modal-body">
        <?= form_open(base_url('index.php/admin/loan/add_payment'), 'id=payment_form'); ?>
        	<table id="paymentTable">
            <tr>
              <td><p><b>Date Filed:</b></p></td>
              <td><p id="date"></p><input type="hidden" name="loan_id"></td>
            </tr>
        		<tr>
        			<td><p><b>Employee Name:</b></p></td>
        			<td><p id="emp_name"></p></td>
        		</tr>
        		<tr>
        			<td><p><b>Loan Type:</b></p></td>
        			<td><p id="type"></p></td>
        		</tr>
        		<tr>
        			<td><p><b>Amount Loaned:</b></p></td>
        			<td><p id="amt"></p></td>
        		</tr>
            <tr>
              <td><p><b>Terms:</b></p></td>
              <td><p id="terms"></p></td>
            </tr>
            <tr>
              <td><p><b>Deduction:</b></p></td>
              <td><p id="deduct"></p></td>
            </tr>
        		<tr>
        			<td><p><b>Balance:</b></p></td>
        			<td><p id="balance"></p></td>
        		</tr>
        	</table>

        	<hr>

        	<div class="form-group">
        		<label>Date Paid</label>
        		<input type="date" class="form-control" name="date_paid" required>
        	</div>
        	<div class="form-group" id="divAmount">
        		<label>Amount Paid</label>
        		<input type="number" class="form-control" min="0" name="amount_paid" step="any" required>
            <span id="msg" class="label alert-danger"></span>
        	</div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
        <button type="submit" class="btn btn-success" id="payment_btn_add"><span class="fa fa-save"></span> Save</button>
         </form>
      </div>

    </div>

  </div>
</div>