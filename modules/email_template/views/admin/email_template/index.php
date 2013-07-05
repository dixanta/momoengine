<div region="center" border="false">
<div style="padding:20px">
<div id="search-panel" class="easyui-panel" title="<?=lang('email_template_search')?>" style="padding:5px" collapsible="true" iconCls="icon-search">
<form action="" method="post" id="email_template-search-form">
<table width="100%" border="1" cellspacing="1" cellpadding="1">
<tr><td><label><?=lang('name')?></label>:</td>
<td><input type="text" name="search[name]" id="search_name"  class="easyui-validatebox"/></td>
<td><label><?=lang('slug_name')?></label>:</td>
<td><input type="text" name="search[slug_name]" id="search_slug_name"  class="easyui-validatebox"/></td>
</tr>
<tr>
<td><label><?=lang('subject')?></label>:</td>
<td><input type="text" name="search[subject]" id="search_subject"  class="easyui-validatebox"/></td>
<td><label><?=lang('created_date')?></label>:</td>
<td><input type="text" name="date[created_date][from]" id="search_created_date_from"  class="easyui-datebox"/> ~ <input type="text" name="date[created_date][to]" id="search_created_date_to"  class="easyui-datebox"/></td>
</tr>
<tr>
<td><label><?=lang('modified_date')?></label>:</td>
<td  colspan="3"><input type="text" name="date[modified_date][from]" id="search_modified_date_from"  class="easyui-datebox"/> ~ <input type="text" name="date[modified_date][to]" id="search_modified_date_to"  class="easyui-datebox"/></td>
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
<table id="email_template-table" pagination="true" title="<?=lang('email_template')?>" pagesize="20" rownumbers="true" toolbar="#toolbar" collapsible="true"
			 fitColumns="true">
    <thead>
    <th field="checkbox" checkbox="true"></th>
    <th field="email_template_id" sortable="true" width="30"><?=lang('email_template_id')?></th>
<th field="name" sortable="true" width="50"><?=lang('name')?></th>
<th field="slug_name" sortable="true" width="50"><?=lang('slug_name')?></th>
<th field="subject" sortable="true" width="50"><?=lang('subject')?></th>
<th field="created_date" sortable="true" width="50"><?=lang('created_date')?></th>
<th field="modified_date" sortable="true" width="50"><?=lang('modified_date')?></th>

    <th field="action" width="100" formatter="getActions"><?=lang('action')?></th>
    </thead>
</table>

<div id="toolbar" style="padding:5px;height:auto">
    <p>
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="create()" title="<?=lang('create_email_template')?>"><?=lang('create')?></a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="false" onclick="removeSelected()"  title="<?=lang('delete_email_template')?>"><?=lang('remove_selected')?></a>
    </p>

</div> 

<!--for create and edit email_template form-->
<div id="dlg" class="easyui-window" style="width:auto;height:auto;padding:10px 20px"
        closed="true" collapsible="true" buttons="#dlg-buttons">
    <form id="form-email_template" method="post" >
    <table>
		<tr>
		              <td width="34%" ><label><?=lang('name')?>:</label></td>
					  <td width="66%"><input name="name" id="name" class="easyui-validatebox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('slug_name')?>:</label></td>
					  <td width="66%"><input name="slug_name" id="slug_name" class="easyui-validatebox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('subject')?>:</label></td>
					  <td width="66%"><input name="subject" id="subject" class="easyui-validatebox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('body')?>:</label></td>
					  <td width="66%"><textarea name="body" id="body" class="easyui-validatebox" required="true" style="width:300px;height:100px"></textarea></td>
		       </tr>
    </table>
    <input type="hidden" name="email_template_id"/>
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
			$('#email_template-search-form').form('clear');
			$('#email_template-table').datagrid({
				queryParams:null
				});

		});

		$('#search').click(function(){
			$('#email_template-table').datagrid({
				queryParams:{data:$('#email_template-search-form').serialize()}
				});
		});		
		$('#email_template-table').datagrid({
			url:'<?=site_url('email_template/admin/email_template/json')?>',
			height:'auto',
			width:'auto',
			onDblClickRow:function(index,row)
			{
			$('#form-email_template').form('load',row);
			$('#dlg').window('open').window('setTitle','<?=lang('edit_email_template')?>');
			}
		});
	});
	
	function getActions(value,row,index)
	{
		var e = '<a href="#" onclick="edit('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-edit"  title="<?=lang('edit_email_template')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-edit"></span></span></a>';
		var d = '<a href="#" onclick="remove('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-remove"  title="<?=lang('delete_email_template')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-cancel"></span></span></a>';
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
		$('#dlg').window('open').window('setTitle','<?=lang('create_email_template')?>');
		$('#form-email_template').form('clear');
	}	

	function edit(index)
	{
		var row = $('#email_template-table').datagrid('getRows')[index];
		if (row){
			$('#form-email_template').form('load',row);
			$('#dlg').window('open').window('setTitle','<?=lang('edit_email_template')?>');
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
				var row = $('#email_template-table').datagrid('getRows')[index];
				$.post('<?=site_url('email_template/admin/email_template/delete_json')?>', {id:[row.email_template_id]}, function(){
					$('#email_template-table').datagrid('deleteRow', index);
					$('#email_template-table').datagrid('reload');
				});

			}
		});
	}
	
	function removeSelected()
	{
		var rows=$('#email_template-table').datagrid('getSelections');
		if(rows.length>0)
		{
			selected=[];
			for(i=0;i<rows.length;i++)
			{
				selected.push(rows[i].email_template_id);
			}
			
			$.messager.confirm('Confirm','<?=lang('delete_confirm')?>',function(r){
				if(r){				
					$.post('<?=site_url('email_template/admin/email_template/delete_json')?>',{id:selected},function(data){
						$('#email_template-table').datagrid('reload');
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
		$('#form-email_template').form('submit',{
			url: '<?=site_url('email_template/admin/email_template/form_json')?>',
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success)
				{
					$('#form-email_template').form('clear');
					$('#dlg').window('close');		// close the dialog
					$.messager.show({title: '<?=lang('success')?>',msg: result.msg});
					$('#email_template-table').datagrid('reload');	// reload the user data
				} 
				else 
				{
					$.messager.show({title: '<?=lang('error')?>',msg: result.msg});
				} //if close
			}//success close
		
		});		
		
	}
	
	
</script>