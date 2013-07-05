<div region="center" border="false">
<div style="padding:20px">
<div id="search-panel" class="easyui-panel" title="<?=lang('user_search')?>" style="padding:5px" collapsible="true" iconCls="icon-search">
<form action="" method="post" id="user-search-form">
<table width="100%" border="1" cellspacing="1" cellpadding="1">
<tr><td><label><?=lang('username')?></label>:</td>
<td><input type="text" name="search[username]" id="search_username"  class="easyui-validatebox"/></td>
<td><label><?=lang('email')?></label>:</td>
<td><input type="text" name="search[email]" id="search_email"  class="easyui-validatebox"/></td>
</tr>
<tr>
<td><label><?=lang('group')?></label>:</td>
<td><input type="text" name="search[group]" id="search_group"  class="easyui-numberbox"/></td>
<td><label><?=lang('active')?></label>:</td>
<td><input type="radio" name="search[active]" id="search_active1" value="1"/><?=lang('general_yes')?>
								<input type="radio" name="search[active]" id="search_active0"  value="0"/><?=lang('general_no')?></td>
</tr>
  <tr>
    <td colspan="4">
    <a href="javascript:void(0)" class="easyui-linkbutton" id="search" iconCls="icon-search"><?=lang('search')?></a>  
    <a href="javascript:void(0)" class="easyui-linkbutton" id="clear" iconCls="icon-clear"><?=lang('clear')?></a>
    </td>
    </tr>
</table>

</form>
</div>
<br/>

<table id="user-table" data-options="pagination:true,title:'<?=lang('user')?>',pageSize:'20',rownumbers:true,toolbar:'#toolbar',
									 collapsible:true,fitColumns:true,striped:true">
    <thead>
    <th field="checkbox" checkbox="true"></th>
    <th field="id" sortable="true" width="30"><?=lang('id')?></th>
<th field="username" sortable="true" width="70"><?=lang('username')?></th>
<th field="email" sortable="true" width="80"><?=lang('email')?></th>
<th field="group" sortable="true" width="50"><?=lang('group')?></th>
<th field="last_visit" sortable="true" width="80"><?=lang('last_visit')?></th>
<th field="created" sortable="true" width="80"><?=lang('created')?></th>
<th field="modified" sortable="true" width="80"><?=lang('modified')?></th>
<th field="active" sortable="true" width="30" align="center" formatter="formatStatus"><?=lang('active')?></th>
    <th field="action" width="60" formatter="getActions"><?=lang('action')?></th>
    </thead>
</table>

<div id="toolbar" style="padding:5px;height:auto">
    <p>
    <a href="<?php echo site_url('auth/admin/members/form')?>" class="easyui-linkbutton" iconCls="icon-add" plain="false"  title="<?=lang('create_user')?>"><?=lang('create')?></a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="false" onclick="removeSelected()"  title="<?=lang('delete_user')?>"><?=lang('remove_selected')?></a>
    </p>

</div> 

<!--for create and edit email_template form-->
<div id="contact-dialog" class="easyui-dialog" style="width:500px;height:auto;padding:10px 20px"
        data-options="closed:true,collapsible:true,modal:true,buttons:'#dlg-buttons'">
    <form id="contact-form" method="post" >
    <table>
		<tr>
		              <td width="34%" ><label><?=lang('email')?>:</label></td>
					  <td width="66%"><input name="email" id="contact_email" class="easyui-validatebox" required="true" readonly="readonly"/></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('subject')?>:</label></td>
					  <td width="66%"><input name="subject" id="subject" class="easyui-validatebox" required="true"/></td>
		       </tr><tr>
		              <td width="34%" ><label><?=lang('body')?>:</label></td>
					  <td width="66%"><textarea name="body" id="body" class="easyui-validatebox" required="true" style="width:300px;height:100px"></textarea></td>
		       </tr>
    </table>

    </form>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="sendMessage()"><?= lang('send_message')?></a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#contact-dialog').window('close')"><?= lang('cancel')?></a>
	</div>    
</div>
<!--div ends-->   
</div>
</div>
<script language="javascript" type="text/javascript">
	$(function(){
		$('#clear').click(function(){
			$('#user-search-form').form('clear');
			$('#user-table').datagrid({
				queryParams:null
				});

		});

		$('#search').click(function(){
			$('#user-table').datagrid({
				queryParams:{data:$('#user-search-form').serialize()}
				});
		});		
		$('#user-table').datagrid({
			url:'<?=site_url('auth/admin/members/json')?>',
			height:'auto',
			width:'auto',
		});
	});
	
	function getActions(value,row,index)
	{
		var c = '<a href="javascript:void(0)" class="easyui-linkbutton l-btn" iconcls="icon-contact"  title="<?=lang('contact_user')?>" onclick="contact('+index+')"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-contact"></span></span></a>';

		var e = '<a href="<?php echo site_url('auth/admin/members/form')?>/'+row.id+'" class="easyui-linkbutton l-btn" iconcls="icon-edit"  title="<?=lang('edit_user')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-edit"></span></span></a><br/>';
		var d='';
		if(row.id!='1')
		{
			d = '<a href="javascript:void(0)" onclick="remove('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-remove"  title="<?=lang('delete_user')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-cancel"></span></span></a>';
		}
		return c+e+d;		
	}
	
	function edit(index)
	{
		var row = $('#user-table').datagrid('getRows')[index];
		if (row){
			$('#form-user').form('load',row);
			$('#password').val('');
			$('#password').validatebox({required:false});
			
			$('#dlg').window('open').window('setTitle','<?=lang('edit_user')?>');
		}
		else
		{
			$.messager.alert('Error','<?=lang('edit_selection_error')?>');				
		}		
	}
	
	function contact(index)
	{
		$('#contact-form').form('clear');
		var row = $('#user-table').datagrid('getRows')[index];
		if (row){
			$('#contact_email').val(row.email);
			$('#contact-dialog').window('open').window('setTitle','<?=lang('contact_user')?> ' + row.username );
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
				var row = $('#user-table').datagrid('getRows')[index];
				$.post('<?=site_url('auth/admin/members/delete_json')?>', {id:[row.id]}, function(){
					$('#user-table').datagrid('deleteRow', index);
					$('#user-table').datagrid('reload');
				});

			}
		});
	}
	
	function removeSelected()
	{
		var rows=$('#user-table').datagrid('getSelections');
		if(rows.length>0)
		{
			selected=[];
			for(i=0;i<rows.length;i++)
			{
				selected.push(rows[i].id);
			}
			
			$.messager.confirm('Confirm','<?=lang('delete_confirm')?>',function(r){
				if(r){				
					$.post('<?=site_url('auth/admin/members/delete_json')?>',{id:selected},function(data){
						$('#user-table').datagrid('reload');
					});
				}
				
			});
			
		}
		else
		{
			$.messager.alert('Error','<?=lang('edit_selection_error')?>');	
		}
		
	}
	
	function sendMessage()
	{
		$('#contact-form').form('submit',{
			url: '<?=site_url('auth/admin/members/send_message_json')?>',
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success)
				{
					$('#contact-form').form('clear');
					$('#contact-dialog').window('close');		// close the dialog
					$.messager.show({title: '<?=lang('success')?>',msg: result.msg});
				} 
				else 
				{
					$.messager.show({title: '<?=lang('error')?>',msg: result.msg});
				} //if close
			}//success close
		
		});		
		
	}	

	
	
</script>