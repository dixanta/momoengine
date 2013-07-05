<div style="background-color:#EFEFEF; padding:5px;width:auto;"  class="menubar">
<a href="<?=site_url('admin')?>" id="menu-dashboard-button" class="easyui-linkbutton" plain="true" iconCls="icon-dashboard"><?=lang('dashboard_menu')?></a>

<?php if(check('System',NULL,FALSE)):?>
		<a href="javascript:void(0)" id="menu-system-button" class="easyui-menubutton" menu="#system-menu" iconCls="icon-system"><?=lang('system_menu')?></a>
<?php endif;?>
        <a href="javascript:void(0)" id="menu-system-button" class="easyui-menubutton" menu="#content-menu" iconCls="icon-content">Content</a>
        <a href="javascript:void(0)" id="menu-design-button" class="easyui-menubutton" menu="#design-menu" iconCls="icon-content">Design</a>        
        <a href="javascript:void(0)" id="menu-tools-button" class="easyui-menubutton" menu="#plugins-menu" iconCls="icon-extension"><?=lang('plugin_menu')?></a>        
        <a href="javascript:void(0)" id="menu-tools-button" class="easyui-menubutton" menu="#tools-menu" iconCls="icon-tools"><?=lang('tools_menu')?></a>
        <a href="javascript:void(0)" id="logout-button" class="easyui-linkbutton" plain="true" iconCls="icon-logout"  onclick="logout()"><?=lang('logout_menu')?></a>

        
	</div>


<!-- Sub Menu of  System Menu-->
<div id="system-menu" style="width:150px">
<?php if(check('Members',NULL,FALSE)):?><div iconCls="icon-member" href="<?=site_url('auth/admin/members')?>" ><?= lang('members_menu')?></div>
<?php endif;?>
<?php if(check('Access Control',NULL,FALSE)):?><div iconCls="icon-accesscontrol" href="<?php print site_url('auth/admin/access_control')?>"><?= lang('access_control_menu')?></div><?php endif;?>
<?php if(check('Settings',NULL,FALSE)):?><div href="<?=site_url('admin/settings')?>"  plain="false" iconCls="icon-tools"><?=lang('settings_menu')?></div><?php endif;?>
</div>

<div id="content-menu" style="width:150px">
<div iconCls="icon-page" href="<?=site_url('page/admin/page')?>">Pages</div>
</div>

<div id="design-menu" style="width:150px">
<div iconCls="icon-page" href="<?=site_url('email_template/admin/email_template')?>">Email Templates</div>
</div>

<div id="plugins-menu" style="width:150px">
<div iconCls="icon-module" href="<?=site_url('plugins/admin/module')?>"><?=lang('module_menu')?></div>
</div>
<div id="tools-menu" style="width:150px">
<div iconCls="icon-backup" href="<?=site_url('tools/admin/dbbackup')?>"><?=lang('dbbackup_menu')?></div>
<div iconCls="icon-file-editor" href="<?=site_url('tools/admin/feditor')?>"><?=lang('feditor_menu')?></div>
<div iconCls="icon-filemanager" href="<?=site_url('tools/admin/filemanager')?>"><?=lang('filemanager_menu')?></div>
<div iconCls="icon-layout" href="<?=site_url('layout/admin/layout')?>"><?=lang('layout_menu')?></div>
<div iconCls="icon-shortcut" href="<?=site_url('tools/admin/generator')?>"><?=lang('generator_menu')?></div>
<div iconCls="icon-shortcut" href="<?=site_url('tools/admin/shortcut')?>"><?=lang('shortcut_menu')?></div>
<div iconCls="icon-shortcut" href="<?=site_url('tools/admin/sql')?>"><?=lang('sql_menu')?></div>
</div>



<script language="javascript">
  function logout(){
    $.messager.defaults={ok:"OK",cancel:"<?=lang('general_cancel')?>"};
    $.messager.confirm('<?=lang('confirm')?>', '<?=lang('logout_confirm')?>', function(r){
    if (r){
     location.href = '<?=site_url('auth/logout')?>';
    }
   });
  }
 </script>