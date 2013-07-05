<div region="center" border="false">
<div style="padding:20px">
<table id="shortcut-table" pagination="true" title="<?=lang('shortcut')?>" pagesize="20" rownumbers="true" toolbar="#toolbar" collapsible="true"
			 fitColumns="true">
    <thead>
    <th field="checkbox" checkbox="true"></th>
    <th field="shortcut_id" sortable="true" width="30"><?=lang('shortcut_id')?></th>
<th field="name" sortable="true" width="50"><?=lang('name')?></th>
<th field="image" sortable="true" width="50"><?=lang('image')?></th>
<th field="new_window" sortable="true" width="50"><?=lang('new_window')?></th>
<th field="added_date" sortable="true" width="50"><?=lang('added_date')?></th>
<th field="status" sortable="true" width="30" align="center" formatter="formatStatus"><?=lang('status')?></th>

    <th field="action" width="100" formatter="getActions"><?=lang('action')?></th>
    </thead>
</table>

<div id="toolbar" style="padding:5px;height:auto">
    <p>
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="create()" title="<?=lang('create_shortcut')?>"><?=lang('create')?></a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="false" onclick="removeSelected()"  title="<?=lang('delete_shortcut')?>"><?=lang('remove_selected')?></a>
    </p>

</div> 

<!--for create and edit shortcut form-->
<div id="dlg" class="easyui-window" style="width:auto;height:auto;padding:10px 20px"
        closed="true" collapsible="true" buttons="#dlg-buttons">
    <form id="form-shortcut" method="post" >
    <table>
		<tr>
		              <td width="34%" ><label><?=lang('name')?>:</label></td>
					  <td width="66%"><input name="name" id="name" class="easyui-validatebox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('image')?>:</label></td>
					  <td width="66%"><label id="upload_image_name" style="display:none"></label>
                      <input name="image" id="image" type="text" style="display:none"/>
                      <input type="file" id="upload_image" name="userfile" style="display:block"/>
                      <a href="#" id="change-image" title="Delete" style="display:none"><img src="<?=base_url()?>assets/icons/delete.png" border="0"/></a></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('link')?>:</label></td>
					  <td width="66%"><textarea name="link" id="link" class="easyui-validatebox" validType="url" required="true" style="width:300px;height:100px"></textarea></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('new_window')?>:</label></td>
					  <td width="66%"><input type="radio" name="new_window" id="new_window1" value="1"/><?=lang("general_yes")?> <input type="radio" name="new_window" id="new_window0" value="0"/><?=lang("general_no")?></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('status')?>:</label></td>
					  <td width="66%"><input type="radio" name="status" id="status1" value="1"/><?=lang("general_yes")?> <input type="radio" name="status" id="status0" value="0"/><?=lang("general_no")?></td>
		       </tr><input type="hidden" name="shortcut_id"/>
    </table>
    </form>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="save()"><?= lang('save')?></a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dlg').window('close')"><?= lang('cancel')?></a>
	</div>    
</div>
<!--div ends-->
   
</div>
</div>
<script language="javascript" type="text/javascript">
	$(function(){
		$('#clear').click(function(){
			$('#shortcut-search-form').form('clear');
			$('#shortcut-table').datagrid({
				queryParams:null
				});

		});

		$('#search').click(function(){
			$('#shortcut-table').datagrid({
				queryParams:{data:$('#shortcut-search-form').serialize()}
				});
		});		
		$('#shortcut-table').datagrid({
			url:'<?=site_url('tools/admin/shortcut/json')?>',
			height:'auto',
			width:'auto',
			onDblClickRow:function(index,row)
			{
			$('#form-shortcut').form('load',row);
			$('#dlg').window('open').window('setTitle','<?=lang('edit_shortcut')?>');
			}
		});
	});
	
	function getActions(value,row,index)
	{
		var e = '<a href="#" onclick="edit('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-edit"  title="<?=lang('edit_shortcut')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-edit"></span></span></a>';
		var d = '<a href="#" onclick="remove('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-remove"  title="<?=lang('delete_shortcut')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-cancel"></span></span></a>';
		return e+d;		
	}
	
	function formatStatus(value)
	{
		if(value==1)
		{
			return 'Yes';
		}
		return 'No';
	}

	function create(){
		//Create code here
		$('#dlg').window('open').window('setTitle','<?=lang('create_shortcut')?>');
		$('#form-shortcut').form('clear');
		$('#new_window0').attr('checked',true);
		$('#status1').attr('checked',true);
		
	}	

	function edit(index)
	{
		var row = $('#shortcut-table').datagrid('getRows')[index];
		if (row){
			$('#form-shortcut').form('load',row);
			$('#dlg').window('open').window('setTitle','<?=lang('edit_shortcut')?>');
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
				var row = $('#shortcut-table').datagrid('getRows')[index];
				$.post('<?=site_url('tools/admin/shortcut/delete_json')?>', {id:[row.shortcut_id]}, function(){
					$('#shortcut-table').datagrid('deleteRow', index);
					$('#shortcut-table').datagrid('reload');
				});

			}
		});
	}
	
	function removeSelected()
	{
		var rows=$('#shortcut-table').datagrid('getSelections');
		if(rows.length>0)
		{
			selected=[];
			for(i=0;i<rows.length;i++)
			{
				selected.push(rows[i].shortcut_id);
			}
			
			$.messager.confirm('Confirm','<?=lang('delete_confirm')?>',function(r){
				if(r){				
					$.post('<?=site_url('tools/admin/shortcut/delete_json')?>',{id:selected},function(data){
						$('#shortcut-table').datagrid('reload');
					});
				}
				
			});
			
		}
		else
		{
			$.messager.alert('Error','<?=lang('edit_selection_error')?>');	
		}
		
	}
	
	function save()
	{
		$('#form-shortcut').form('submit',{
			url: '<?=site_url('tools/admin/shortcut/form_json')?>',
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success)
				{
					$('#form-shortcut').form('clear');
					$('#dlg').window('close');		// close the dialog
					$.messager.show({title: '<?=lang('success')?>',msg: result.msg});
					$('#shortcut-table').datagrid('reload');	// reload the user data
				} 
				else 
				{
					$.messager.show({title: '<?=lang('error')?>',msg: result.msg});
				} //if close
			}//success close
		
		});		
		
	}
	
	function uploadReady()
	{
		uploader=$('#upload_image');
		new AjaxUpload(uploader, {
			action: '<?=site_url('tools/admin/shortcut/upload_image')?>',
			name: 'userfile',
			responseType: "json",
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				//status.text('Uploading...');
			},
			onComplete: function(file, response){
				if(response.error==null){
					var filename = response.file_name;
					$('#upload_image').hide();
					$('#image').val(filename);
					$('#upload_image_name').html(filename);
					$('#upload_image_name').show();
					$('#change-image').show();
				}
			}		
		});		
	}
</script>