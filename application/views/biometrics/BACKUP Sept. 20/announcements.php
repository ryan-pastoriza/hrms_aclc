	<ol class="carousel-indicators">
	<?php $counter = 0; foreach ($announcements as $key => $value): $counter++; ?>
		<li data-target="#carousel-example-generic" data-slide-to="<?= $counter ?>" class="<?= $key == 1 ? 'active' : '' ?>"></li>
	<?php endforeach ?>
    </ol>
<div class="carousel-inner">

<?php foreach ($announcements as $key => $value): ?>
	<div class="item <?= $key == 1 ? 'active' : '' ?>">
		<!-- <img src="http://placehold.it/900x500/39CCCC/ffffff&amp;text=<?= $value->announcement_body ?>" alt=""> -->

		<div class="callout callout-default" style='min-height: 370px;text-align: center;'>
			<h3 class="text-orange"><?= $value->announcement_title ?></h3>
			<hr>
			<h5 class="text-info">
			<?= $value->announcement_body ?>
			</h5>
		</div>
		<div class="carousel-caption">
	     	<label class="label label-primary">
	     		<?= date('F d, Y', strtotime($value->announcement_start)) ?>
     		</label>
	    </div>
	  </div>

<?php endforeach ?>
</div>