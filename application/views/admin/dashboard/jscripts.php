<script type="text/javascript">

	$(function(){
		$.fn.combodate.defaults.maxYear = <?= date('Y') ?>;
		$('.timeline-editor .editable').editable({mode:'inline',
													url:"<?= base_url('index.php/admin/home/edit_announcement') ?>",
													success: function(){
														reload_announcement_list();
													}
													});
	})

	$(document).on('click','[open-edit]',function(){
		var toEdit = $(this).attr('open-edit');
		$('[editor='+ toEdit +']').addClass('opened');
		$('[editor='+ toEdit +']').parent().find('.timeline-item').css({'display':'none'});

		return false;
	});


	$('#post-announcement-form').ajaxForm({
		beforeSubmit: function(){
			$('#submit-announcement-icon').removeClass('fa-paper-plane-o').addClass('fa-circle-o-notch').addClass('animate-spin').attr('disabled','disabled');
		},
		success: function(){
			$('#submit-announcement-icon').removeClass('fa-circle-o-notch').removeClass('animate-spin').addClass('fa-paper-plane-o').removeAttr('disabled');
			$('#post-announcement-form [type=reset]').trigger('click');
			reload_announcement_list();
		}
	});

	var reload_announcement_list = function(){
		$('#announcements_list').css({"opacity": '0.5'});

		$.post("<?= base_url('index.php/admin/home/announcements_list') ?>","",function(r){
				$('#announcements-list').html(r);
				setTimeout(function(){
					$('#announcements_list').css({"opacity":'1'});
				},1000)
				$('.timeline-editor .editable').editable({mode:'inline',
														url:"<?= base_url('index.php/admin/home/edit_announcement') ?>",
														success: function(){
															reload_announcement_list();
														}
														});
				
				return false;
			})
	}
	var close_editor = function(ann_id){
		$('[editor='+ ann_id +']').removeClass('opened');
		$('[editor='+ ann_id +']').parent().find('.timeline-item:not(".timeline-editor")').css({'display':'block'});
	}
	var save_announcement = function(ann_id){
		var newVal = $("[body="+ann_id+"]").val();
		$.post("<?= base_url('index.php/admin/home/edit_announcement') ?>", "name=announcement_body&pk="+ann_id+"&value="+newVal, function(){
			reload_announcement_list();

		});
	}
	var remove_announcement = function(ann_id){
		$.post("<?= base_url('index.php/admin/home/remove_announcement') ?>","id="+ann_id,function(r){
				$('#announcements-list').html(r);
				reload_announcement_list();
				return false;
			})
		return false;
	}

</script>