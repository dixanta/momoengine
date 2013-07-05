<div region="center" border="false">
<div style="padding:20px">
<h2>Database Backup</h2>
	<table id="backup-table" title="<?=lang('page_title')?>" style="width:1024px;;height:auto"
			url="<?=site_url('tools/admin/dbbackup/json')?>"
			toolbar="#toolbar"
			 fitColumns="true" singleSelect="false" pagination="true" rownumbers="true">
		<thead>
			<tr>
				<th field="checkbox" checkbox="true"></th>
                <th field="backup_id" width="20" sortable="true" ><?=lang('backup_id')?></th>
				<th field="file" width="100" sortable="true" formatter="formatFile"><?=lang('file')?></th>
				<th field="backup_date" width="30" sortable="true"><?=lang('backup_date')?></th>
				<th field="action" width="30" formatter="formatAction"><?=lang('delete')?></th>                
			</tr>
		</thead>
	</table>
	<div id="toolbar" style="padding:5px;height:auto">
		<p>
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="false" onClick="createBackup()"><?=lang('new_backup')?></a><a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="false" onClick="removeSelected()"><?=lang('delete_selected')?></a>
      </p>
	</div>
</div>
</div>

<script type="text/javascript">

	$(function(){
		$('#backup-table').datagrid({width:'100%',height:'auto'});
	});
	function createBackup(){
		$.ajax({url:'<?=site_url('tools/admin/dbbackup/create')?>',
			success: function(result){
				var result = eval('('+result+')');
				if (result.success){
					$('#backup-table').datagrid('reload');	// reload the user data
				} else {
					$.messager.show({
						title: 'Error',
						msg: result.msg
					});
				}
			}
		});
	}

	function removeSelected()
	{
		var rows=$('#backup-table').datagrid('getSelections');
		if(rows.length>0)
		{
			selected=[];
			for(i=0;i<rows.length;i++)
			{
				selected.push(rows[i].backup_id);
			}
			
			$.messager.confirm('Confirm','<?=lang('delete_confirm')?>',function(r){
				if(r){				
					$.post('<?=site_url('tools/admin/dbbackup/delete_json')?>',{id:selected},function(data){
						$('#backup-table').datagrid('reload');
					});
				}
				
			});
			
		}
		else
		{
			$.messager.alert('Error','<?=lang('edit_selection_error')?>');	
		}
		
	}

	function remove(index)
	{
		$.messager.confirm('Confirm','<?=lang('delete_confirm')?>',function(r){
			if (r){
				var row = $('#backup-table').datagrid('getRows')[index];
				$.post('<?=site_url('tools/admin/dbbackup/delete_json')?>', {id:[row.backup_id]}, function(){
					$('#backup-table').datagrid('reload');
				});

			}
		});
	}
		
	function formatAction(value,row,index)
	{
		return '<a href="#" onclick="remove('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-cancel"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-cancel"></span></span></a>';			
	}

	function formatFile(val,row){
		return '<a href="<?=site_url('tools/admin/dbbackup/download')?>?file='+val+'">'+val+'</a>';
	}

	</script>   