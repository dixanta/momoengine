<div region="center" border="false">
<div style="padding:20px">
<table id="settings-grid" class="easyui-datagrid" cellspacing="0" fitcolumns="true" title="Module Settings">
<thead>
<tr>
<th width="70%" field="module">Module</th>
<th width="30%" field="action">Action</th>
</tr>
</thead>
<tbody>
	<?php foreach($widget_modules as $module=>$enabled): ?>
		<tr>
			<td><?php echo $module; ?></td>
			<td>
			<?php if($enabled): ?>
				<a href="<?php echo site_url('plugins/admin/module/uninstall/'.$module);?>" onclick="" class="easyui-linkbutton">Uninstall</a>
				<a href="<?php echo site_url('plugins/admin/module/settings/'.$module);?>"  class="easyui-linkbutton">Settings</a>
			<?php else: ?>
				<a href="<?php echo site_url('plugins/admin/module/install/'.$module);?>"  class="easyui-linkbutton">Install</a>
			<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</tbody>
</table>
</div>
</div>