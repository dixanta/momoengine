<div region="center" border="false">
<div style="padding:20px">
<div id="search-panel" class="easyui-panel" title="<?=lang('page_search')?>" style="padding:5px" collapsible="true" iconCls="icon-search">
<form action="" method="post" id="page-search-form">
<table width="100%" border="1" cellspacing="1" cellpadding="1">
<tr><td><label><?=lang('page_title')?></label>:</td>
<td><input type="text" name="search[page_title]" id="search_page_title"  class="easyui-validatebox"/></td>
</tr>
  <tr>
    <td colspan="4">
      <a href="#" class="easyui-linkbutton" id="search" iconCls="icon-search"><?=lang('search')?></a>  
      <a href="#" class="easyui-linkbutton" id="clear" iconCls="icon-clear"><?=lang('clear')?></a>
      </td>
  </tr>
</table>

</form>
</div>
<br/>
<br/>
<table id="page-table" pagination="true" title="<?=lang('page')?>" pagesize="20" rownumbers="true" toolbar="#toolbar" collapsible="true" fitColumns="true">
    <thead>
    <th field="checkbox" checkbox="true"></th>
    <th field="page_title" sortable="true" width="50" formatter="formatLink"><?=lang('page_title')?></th>
    <th field="image_name" sortable="true" width="50" formatter="formatImage"><?=lang('image_name')?></th>
    <th field="status" sortable="true" width="30" align="center" formatter="formatStatus"><?=lang('status')?></th>
    <th field="action" width="100" formatter="getActions"><?=lang('action')?></th>
    </thead>
</table>

<div id="toolbar" style="padding:5px;height:auto">
    <p>
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="create()" title="<?=lang('create_page')?>"><?=lang('create')?></a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="false" onclick="removeSelected()"  title="<?=lang('delete_page')?>"><?=lang('remove_selected')?></a>
    </p>

</div> 

<!--for create and edit page form-->
<div id="dlg" class="easyui-window" style="width:auto;height:auto;padding:10px 20px"
        closed="true" collapsible="true" buttons="#dlg-buttons" modal="true">
    <form id="form-page" method="post">
                 <!-- to create tab format within the form--> 
                <div id="page-tab" class="easyui-tabs" style="width:700px;height:auto">  
                         <!-- 1st tab for blog details--> 
                    <div title="Page Details" style="padding:20px"> 
    <table>
		<tr>
		              <td width="34%" ><label><?=lang('page_title')?>:</label></td>
					  <td width="66%"><input name="page_title" id="page_title" class="easyui-validatebox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('image_name')?>:</label></td>
					  <td width="66%"><label id="upload_image_name" style="display:none"></label>
                      <input name="image_name" id="image_name" type="text" style="display:none"/>
                      <input type="file" id="upload_image" name="userfile" style="display:block"/>
                      <a href="#" id="change-image" title="Delete" style="display:none"><img src="<?=base_url()?>assets/icons/delete.png" border="0"/></a></td>
		       </tr>
               <tr>
		              <td width="34%" ><label><?=lang('description')?>:</label></td>
					  <td width="66%"><textarea name="description" id="description" class="easyui-validatebox" required="true" style="width:300px;height:100px"></textarea></td>
		       </tr>
               <tr>
		              <td width="34%" ><label><?=lang('status')?>:</label></td>
					  <td width="66%"><input type="radio" name="status" id="status1" value="1"/><?=lang("general_yes")?> <input type="radio" name="status" id="status0" value="0"/><?=lang("general_no")?></td>
		       </tr><input type="hidden" name="page_id"/><input type="hidden" name="slug_id"/>
    </table>
     </div>  <!-- 2nd tab end--> 
                   
                    <div title="Meta Tags" style="overflow:auto;padding:20px;"> 
                        <label>Meta Keywords:</label><textarea name="meta_keywords" style="width:650px"></textarea><br/>
                        <label>Meta Description:</label><textarea name="meta_description"  style="width:650px"></textarea>
                    </div>
                </div>  <!-- to create tab format within the form-->      
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
			$('#page-search-form').form('clear');
			$('#page-table').datagrid({
				queryParams:null
				});

		});

		$('#search').click(function(){
			$('#page-table').datagrid({
				queryParams:{data:$('#page-search-form').serialize()}
				});
		});		
		$('#page-table').datagrid({
			url:'<?=site_url('page/admin/page/json')?>',
			height:'auto',
			width:'auto',
			onDblClickRow:function(index,row)
			{
			$('#form-page').form('load',row);
			$('#dlg').window('open').window('setTitle','<?=lang('edit_page')?>');
			}
		});
		
		$('#change-image').click(function(){
			var filename = $('#image_name').val();
			$.messager.confirm('Confirm','Are you sure?',function(r){
				if(r) {
					$.post('<?php echo site_url('page/admin/page/upload_delete')?>',{ filename: filename },function(){
			
					 $('#image_name').val('');
					 $('#upload_image_name').html('');
					 $('#upload_image_name').hide();
					 $('#change-image').hide();
					 $('#upload_image').show();
					});
				}
			});
		});
		
		<?php
			tinymce('description');
		?>
	});

	
	function getActions(value,row,index)
	{
		var e = '<a href="#" onclick="edit('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-edit"  title="<?=lang('edit_page')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-edit"></span></span></a>';
		var d = '<a href="#" onclick="remove('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-remove"  title="<?=lang('delete_page')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-cancel"></span></span></a>';
		return e+d;		
	}
	
	function formatImage(value)
	{
		var i='<img src="<?=base_url()?>uploads/page/thumb/'+value+'" border="0" height="100" width="100"/>';
		
		return i;
	}
	
	function formatLink(value,row)
	{
		return '<a href="<?php echo base_url()?>page/index/'+row.page_id+'" target="_blank">'+value+'</a>';
	}
	
	function create(){
		//Create code here
		tinymce.get('description').setContent('');
		$('#form-page').form('clear');
		$('#status1').attr('checked',true);
		uploadReady();
		$('#upload_image').show();
		$('#image_name').val('');
		$('#upload_image_name').html('');
		$('#upload_image_name').hide();
		$('#change-image').hide();
		$('#page-tab').tabs('select',0);
		$('#dlg').window('open').window('setTitle','<?=lang('create_page')?>');
	}	

	function edit(index)
	{
		var row = $('#page-table').datagrid('getRows')[index];
		if (row){
			$('#form-page').form('load',row);
			
			if(row.image_name!='')
			{
				$('#upload_image').hide();
				$('#image_name').val(row.image_name);
				$('#upload_image_name').html(row.image_name);
				$('#upload_image_name').show();
				$('#change-image').show();				
			}
			$('#page-tab').tabs('select',0);
			uploadReady();
			
			$('#dlg').window('open').window('setTitle','<?=lang('edit_page')?>');
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
				var row = $('#page-table').datagrid('getRows')[index];
				$.post('<?=site_url('page/admin/page/delete_json')?>', {id:[row.page_id]}, function(){
					$('#page-table').datagrid('deleteRow', index);
					$('#page-table').datagrid('reload');
				});

			}
		});
	}
	
	function removeSelected()
	{
		var rows=$('#page-table').datagrid('getSelections');
		if(rows.length>0)
		{
			selected=[];
			for(i=0;i<rows.length;i++)
			{
				selected.push(rows[i].page_id);
			}
			
			$.messager.confirm('Confirm','<?=lang('delete_confirm')?>',function(r){
				if(r){				
					$.post('<?=site_url('page/admin/page/delete_json')?>',{id:selected},function(data){
						$('#page-table').datagrid('reload');
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
		$('#form-page').form('submit',{
			url: '<?=site_url('page/admin/page/form_json')?>',
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success)
				{
					$('#form-page').form('clear');
					$('#dlg').window('close');		// close the dialog
					$.messager.show({title: '<?=lang('success')?>',msg: result.msg});
					$('#page-table').datagrid('reload');	// reload the user data
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
			action: '<?=site_url('page/admin/page/upload_image')?>',
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
					$('#image_name').val(filename);
					$('#upload_image_name').html(filename);
					$('#upload_image_name').show();
					$('#change-image').show();
				}
			}		
		});		
	}
</script>