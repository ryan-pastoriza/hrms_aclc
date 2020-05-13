<ol class="carousel-indicators">
	<?php $counter = 0; foreach ($announcements as $key => $value): $counter++; ?>
		<li data-target="#carousel-example-generic" data-slide-to="<?= $counter ?>" class="<?= $key == 1 ? 'active' : '' ?>"></li>
	<?php endforeach ?>
    </ol>
<div class="carousel-inner">

<?php $counter = 0; foreach ($announcements as $key => $value): $counter++ ?>
	<div class="item <?= $counter == 1 ? 'active' : '' ?>">
		<!-- <img src="http://placehold.it/900x500/39CCCC/ffffff&amp;text=<?= $value->announcement_body ?>" alt=""> -->

		<div class="callout callout-default" style='min-height: 370px;text-align: center;'>
			<h3 class="text-orange"> <?= $value->announcement_title ?> </h3>
			<hr>
			<h3 class="text-info">
				<?= $value->announcement_body ?> 
			</h3>
		</div>
		<div class="carousel-caption">
	     	<label class="label label-primary">
	     		<?= date('F d, Y', strtotime($value->announcement_start)) ?>
     		</label>
	    </div>
	  </div>

<?php endforeach ?>
</div>
<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
  <span class="fa fa-angle-left"></span>
</a>
<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
  <span class="fa fa-angle-right"></span>
</a>