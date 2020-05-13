<script type="text/javascript">

	$(function(){
		var loc = window.location.href;
		var hasSelect = loc.split('opt');

		if (typeof hasSelect[1] !== 'undefined') {
			$('#opt'+hasSelect[1]).removeClass('hidden');
		}
	})
	$(document).on('click','[btn]',function(){
		var href = $(this).attr('href');
		$('[ide]').addClass('hidden');
		$(href).removeClass('hidden');
	})	
</script>

<a href="#opt1" btn>OPTION 1</a>
|
<a href="#opt2" btn>OPTION 2</a>
|
<a href="#opt3" btn>OPTION 3</a>
<hr>
<div id="opt1" class="hidden" ide> option 1</div>
<div id="opt2" class="hidden" ide> option 2</div>
<div id="opt3" class="hidden" ide> option 3</div>