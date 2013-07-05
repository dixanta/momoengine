<div region="center" border="false">
<div style="padding:20px">
<div id="search-panel" class="easyui-panel" data-options="title:'<?php  echo lang('artist_search')?>',collapsible:true,iconCls:'icon-search'" style="padding:5px">
<form action="" method="post" id="artist-search-form">
<table width="100%" border="1" cellspacing="1" cellpadding="1">
<tr><td><label><?=lang('studio_name')?></label>:</td>
<td><input type="text" name="search[studio_name]" id="search_studio_name"  class="easyui-validatebox"/></td>
<td><label><?=lang('artist_name')?></label>:</td>
<td><input type="text" name="search[artist_name]" id="search_artist_name"  class="easyui-validatebox"/></td>
</tr>
<tr>
<td><label><?=lang('link')?></label>:</td>
<td><input type="text" name="search[link]" id="search_link"  class="easyui-validatebox"/></td>
<td><label><?=lang('country')?></label>:</td>
<td><input type="text" name="search[country]" id="search_country"  class="easyui-validatebox"/></td>
</tr>
<tr>
<td><label><?=lang('status')?></label>:</td>
<td><input type="radio" name="search[status]" id="search_status1" value="1"/><?=lang('general_yes')?>
								<input type="radio" name="search[status]" id="search_status0" value="0"/><?=lang('general_no')?></td>
</tr>
  <tr>
    <td colspan="4">
    <a href="#" class="easyui-linkbutton" id="search" iconCls="icon-search"><?php  echo lang('search')?></a>  
    <a href="#" class="easyui-linkbutton" id="clear" iconCls="icon-clear"><?php  echo lang('clear')?></a>
    </td>
    </tr>
</table>

</form>
</div>
<br/>
<table id="artist-table" data-options="pagination:true,title:'<?php  echo lang('artist')?>',pagesize:'20', rownumbers:true,toolbar:'#toolbar',collapsible:true,fitColumns:true">
    <thead>
    <th field="checkbox" checkbox="true"></th>
    <th field="id" sortable="true" width="30"><?=lang('id')?></th>
<th field="studio_name" sortable="true" width="50"><?=lang('studio_name')?></th>
<th field="artist_name" sortable="true" width="50"><?=lang('artist_name')?></th>
<th field="link" sortable="true" width="50"><?=lang('link')?></th>
<th field="country" sortable="true" width="50"><?=lang('country')?></th>
<th field="image" sortable="true" width="50"><?=lang('image')?></th>
<th field="status" sortable="true" width="30" align="center" formatter="formatStatus"><?=lang('status')?></th>

    <th field="action" width="100" formatter="getActions"><?php  echo lang('action')?></th>
    </thead>
</table>

<div id="toolbar" style="padding:5px;height:auto">
    <p>
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="create()" title="<?php  echo lang('create_artist')?>"><?php  echo lang('create')?></a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="false" onclick="removeSelected()"  title="<?php  echo lang('delete_artist')?>"><?php  echo lang('remove_selected')?></a>
    </p>

</div> 

<!--for create and edit artist form-->
<div id="dlg" class="easyui-dialog" style="width:600px;height:auto;padding:10px 20px"
        data-options="closed:true,collapsible:true,buttons:'#dlg-buttons',modal:true">
    <form id="form-artist" method="post" >
    <table>
		<tr>
		              <td width="34%" ><label><?=lang('studio_name')?>:</label></td>
					  <td width="66%"><input name="studio_name" id="studio_name" class="easyui-validatebox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('artist_name')?>:</label></td>
					  <td width="66%"><input name="artist_name" id="artist_name" class="easyui-validatebox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('link')?>:</label></td>
					  <td width="66%"><input name="link" id="link" class="easyui-validatebox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('country')?>:</label></td>
					  <td width="66%"><input name="country" id="country" class="easyui-validatebox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('image')?>:</label></td>
					  <td width="66%"><label id="upload_image_name" style="display:none"></label>
                      <input name="image" id="image" type="text" style="display:none"/>
                      <input type="file" id="upload_image" name="userfile" style="display:block"/>
                      <a href="#" id="change-image" title="Delete" style="display:none"><img src="<?=base_url()?>assets/icons/delete.png" border="0"/></a></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('status')?>:</label></td>
					  <td width="66%"><input type="radio" value="1" name="status" id="status1" /><?=lang("general_yes")?> <input type="radio" value="0" name="status" id="status0" /><?=lang("general_no")?></td>
		       </tr><input type="hidden" name="id" id="id"/>
    </table>
    </form>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="save()"><?php  echo  lang('save')?></a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dlg').window('close')"><?php  echo  lang('cancel')?></a>
	</div>    
</div>
<!--div ends-->
   
</div>
</div>
<script language="javascript" type="text/javascript">
	$(function(){
		$('#clear').click(function(){
			$('#artist-search-form').form('clear');
			$('#artist-table').datagrid({
				queryParams:null
				});

		});

		$('#search').click(function(){
			$('#artist-table').datagrid({
				queryParams:{data:$('#artist-search-form').serialize()}
				});
		});		
		$('#artist-table').datagrid({
			url:'<?php  echo site_url('artist/admin/artist/json')?>',
			height:'auto',
			width:'auto',
			onDblClickRow:function(index,row)
			{
			$('#form-artist').form('load',row);
			$('#dlg').window('open').window('setTitle','<?php  echo lang('edit_artist')?>');
			}
		});
	});
	
	function getActions(value,row,index)
	{
		var e = '<a href="#" onclick="edit('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-edit"  title="<?php  echo lang('edit_artist')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-edit"></span></span></a>';
		var d = '<a href="#" onclick="removeartist('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-remove"  title="<?php  echo lang('delete_artist')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-cancel"></span></span></a>';
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
		$('#form-artist').form('clear');
		$('#dlg').window('open').window('setTitle','<?php  echo lang('create_artist')?>');
		//uploadReady(); //Uncomment This function if ajax uploading
	}	

	function edit(index)
	{
		var row = $('#artist-table').datagrid('getRows')[index];
		if (row){
			$('#form-artist').form('load',row);
			//uploadReady(); //Uncomment This function if ajax uploading
			$('#dlg').window('open').window('setTitle','<?php  echo lang('edit_artist')?>');
		}
		else
		{
			$.messager.alert('Error','<?php  echo lang('edit_selection_error')?>');				
		}		
	}
	
		
	function removeartist(index)
	{
		$.messager.confirm('Confirm','<?php  echo lang('delete_confirm')?>',function(r){
			if (r){
				var row = $('#artist-table').datagrid('getRows')[index];
				$.post('<?php  echo site_url('artist/admin/artist/delete_json')?>', {id:[row.id]}, function(){
					$('#artist-table').datagrid('deleteRow', index);
					$('#artist-table').datagrid('reload');
				});

			}
		});
	}
	
	function removeSelected()
	{
		var rows=$('#artist-table').datagrid('getSelections');
		if(rows.length>0)
		{
			selected=[];
			for(i=0;i<rows.length;i++)
			{
				selected.push(rows[i].id);
			}
			
			$.messager.confirm('Confirm','<?php  echo lang('delete_confirm')?>',function(r){
				if(r){				
					$.post('<?php  echo site_url('artist/admin/artist/delete_json')?>',{id:selected},function(data){
						$('#artist-table').datagrid('reload');
					});
				}
				
			});
			
		}
		else
		{
			$.messager.alert('Error','<?php  echo lang('edit_selection_error')?>');	
		}
		
	}
	
	function save()
	{
		$('#form-artist').form('submit',{
			url: '<?php  echo site_url('artist/admin/artist/save')?>',
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success)
				{
					$('#form-artist').form('clear');
					$('#dlg').window('close');		// close the dialog
					$.messager.show({title: '<?php  echo lang('success')?>',msg: result.msg});
					$('#artist-table').datagrid('reload');	// reload the user data
				} 
				else 
				{
					$.messager.show({title: '<?php  echo lang('error')?>',msg: result.msg});
				} //if close
			}//success close
		
		});		
		
	}
	
	function uploadReady()
	{
		uploader=$('#upload_image');
		new AjaxUpload(uploader, {
			action: '<?php  echo site_url('artist/admin/artist/upload_image')?>',
			name: 'userfile',
			responseType: "json",
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					$.messager.show({title: '<?php  echo lang('error')?>',msg: 'Only JPG, PNG or GIF files are allowed'});
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
                else
                {
					$.messager.show({title: '<?php  echo lang('error')?>',msg: response.error});                
                }
			}		
		});		
	}
</script>