<script type="text/javascript">
	$(function() {



	    var start = moment().subtract(29, 'days');
	    var end = moment();

	    function cb(start, end) {
	        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

	        startdate = start.format('YYYY-MM-DD');
	        enddate   = end.format('YYYY-MM-DD');
	        if (typeof biometric_rejects !== "undefined") {
		        biometric_rejects.ajax.reload();
	        }

	    }

	    $('#reportrange').daterangepicker({
	        startDate: start,
	        endDate: end,
	        ranges: {
	           'Today': [moment(), moment()],
	           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	           'This Month': [moment().startOf('month'), moment().endOf('month')],
	           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	        }
	    }, cb);

	    cb(start, end);

	    // datatable
			biometric_rejects = $('#biometric-rejects').DataTable({
				'ajax' : {'url' : "<?= base_url('index.php/admin/biometric_rejects/bio_data_json') ?>",
						data: function(d){
							d.startDate = startdate;
							d.endDate = enddate;
						}
					},
				processing : true,
				serverSide : true
			})
		// datatable end

	    
	});
</script>