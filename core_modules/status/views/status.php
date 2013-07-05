<div class="status_box <?php print $type; ?>">
    <h6><?php print $this->lang->line('status_type_' . $type);?></h6>
    <?php print ul($messages); ?>
</div>
<script>
$(document).ready(function()
{
	$(".status_box").animate({opacity: 1.0}, 5000).fadeOut('slow');
	$('.status_box').click(function()
	{
		$(this).hide();
	});
});
</script>
