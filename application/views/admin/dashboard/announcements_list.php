<style type="text/css">
	.timeline-editor{
		display: none;
		padding: 10px !important;
	}
	.timeline-editor.opened{
		display: block !important;
	}
</style>
<div class="tab-pane active" id="timeline">
	      <ul class="timeline timeline-inverse">
 <?php foreach ($announcements as $key => $value): ?>
	      <!-- The timeline -->
	        <!-- timeline time label -->
	        <li class="time-label">
	              <span class="bg-aqua">
	                <?= $key ?>
	              </span>
	        </li>
	        <?php foreach ($value as $key2 => $value2): ?>
        	<?php 
        		$dates = date('F', strtotime($value2->announcement_start)) == date('F', strtotime($value2->announcement_end)) ? date('F d', strtotime($value2->announcement_start))." - ". date('d, Y', strtotime($value2->announcement_end)) : date('F d, Y', strtotime($value2->announcement_start))." - ". date('F d, Y', strtotime($value2->announcement_end));
        	 ?>
	        	<li>
		          <i class="fa fa-bullhorn bg-teal disabled"></i>
		          <div class="timeline-item">
		            <span class="time">
		            	<a href="#" class="btn btn-xs" open-edit="<?= $value2->announcement_id ?>"><i class="fa fa-pencil text-default"></i></a>
		            	<span class="btn-group">
		            	<a href="#" class="btn btn-xs dropdown-toggle" data-toggle='dropdown' ><i class="fa fa-close text-default"></i></a>
		            	<ul class='dropdown-menu pull-right' role='menu'>
							<li class='text-center'><span class='label alert-warning'>Remove Announcement?</span></li>
							<li class='text-center'><a href='#' onclick='remove_announcement(<?= $value2->announcement_id ?>); return false;'>Yes</a></li>
							<li class='text-center'><a href='#' onclick='return false;'>No</a></li>
						</ul>
						</span>
		            </span>

		            <h3 class="timeline-header"><a href="#"><?= $value2->announcement_title ?></a> <small><?= $dates ?></small></h3>

		            <div class="timeline-body">
		             <?= $value2->announcement_body ?>
		            </div>
		          </div>
		          <div class="timeline-item timeline-editor" editor="<?= $value2->announcement_id ?>">
			            <h3 class="timeline-header">
			            	<a href="#" class="editable" data-name='announcement_title' data-pk="<?= $value2->announcement_id ?>" ><?= $value2->announcement_title ?></a> 
			            	<br>
				            <small>From</small> <a href="#" class="editable" data-type="combodate"  data-pk="<?= $value2->announcement_id ?>" data-name='announcement_start'><?= $value2->announcement_start ?> <small>to</small> <a href="#" class="editable" data-type="combodate" data-name='announcement_end' data-pk="<?= $value2->announcement_id ?>" ><?= $value2->announcement_end ?></a></h3>
		             	<span>
			            <div class="timeline-body">
			             	<small>Body:</small></span><br>
			             	<textarea style="width: 100%" rows="5" body="<?= $value2->announcement_id ?>" ><?= $value2->announcement_body ?></textarea>
			             	<br>
			             	<div class="row">
			             		<div class="col-sm-12">
					             	<div class="pull-right">
						             	<button class="btn btn-xs btn-info" onclick="close_editor(<?= $value2->announcement_id ?>)"><i class="fa fa-close"></i> Cancel</button>
						             	<button class="btn btn-xs btn-info" onclick="save_announcement(<?= $value2->announcement_id ?>)"><i class="fa fa-check"></i> Save</button>
					             	</div>
				             	</div>
			             	</div>
		             	</div>
		          </div>
		        </li>
	        <?php endforeach ?>
	        
	       
    <?php endforeach ?>
		     <li>
	          <i class="fa fa-clock-o bg-gray"></i>
	        </li>
	      </ul>
	    </div>
