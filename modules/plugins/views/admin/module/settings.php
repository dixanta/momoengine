<div region="center" border="false">
<div style="padding:20px">
<form id="settings_form" method="post" action="<?php echo site_url('plugins/admin/module/settings/'.$module_name);?>">
	<div id="gc_tabs">
		<ul>
			<li><a href="#gc_settings"><?php echo lang('setting_title');?></a></li>
		</ul>
		
		<div id="gc_settings">
<?php
echo $form;
?>
		</div>
	</div>
	<div class="button_set">
		<input type="submit" value="<?php echo lang('general_save');?>"/>
        <a href="<?php echo site_url('plugins/admin/module')?>">Back</a>
	</div>
</form>
</div>
</div>