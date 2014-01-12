<!DOCTYPE html>
<html lang="en">
<head>
	<?php print $this->bep_site->get_metatags();?>
	<title><?php print $header.' | '.$this->preference->item('site_name');?></title>
	<?php print $this->bep_site->get_variables();?>
	<?php print $this->bep_assets->get_header_assets();?>
	<?php print $this->bep_site->get_js_blocks();?>
<script>
$(document).ready(function()
{
	$('body').show();
});
</script>    
</head>
<body class="easyui-layout" style="display:none" fit="true">
<div region="north"  border="false">
    <?php print displayStatus();?>
<? print $this->load->view($this->config->item('template_admin') . 'menu');?>
</div>