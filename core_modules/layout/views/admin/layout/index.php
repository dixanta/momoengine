<div region="center" border="false">
<div style="padding:20px">
<div id="search-panel" class="easyui-panel" title="<?=lang('layout_search')?>" style="padding:5px" collapsible="true" iconCls="icon-search">
<form action="" method="post" id="layout-search-form">
<table width="100%" border="1" cellspacing="1" cellpadding="1">
<tr><td><label><?=lang('name')?></label>:</td>
<td><input type="text" name="search[name]" id="search_name"  class="easyui-validatebox"/></td>
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
<table id="layout-table" pagination="true" title="<?=lang('layout')?>" pagesize="20" rownumbers="true" toolbar="#toolbar" collapsible="true"
			 fitColumns="true">
    <thead>
    <th field="checkbox" checkbox="true"></th>
    <th field="layout_id" sortable="true" width="30"><?=lang('layout_id')?></th>
<th field="name" sortable="true" width="50"><?=lang('name')?></th>

    <th field="action" width="100" formatter="getActions"><?=lang('action')?></th>
    </thead>
</table>

<div id="toolbar" style="padding:5px;height:auto">
    <p>
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="create()" title="<?=lang('create_layout')?>"><?=lang('create')?></a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="false" onclick="removeSelected()"  title="<?=lang('delete_layout')?>"><?=lang('remove_selected')?></a>
    </p>

</div> 

<!--for create and edit layout form-->
<div id="dlg" class="easyui-window" style="width:auto;height:auto;padding:10px 20px"
        closed="true" collapsible="true" buttons="#dlg-buttons">
    <form id="form-layout" method="post" >
    <table>
		<tr>
		              <td width="34%" ><label><?=lang('name')?>:</label></td>
					  <td width="66%"><input name="name" id="name" class="easyui-validatebox" required="true"></td>
		       </tr><input type="hidden" name="layout_id"/>
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
			$('#layout-search-form').form('clear');
			$('#layout-table').datagrid({
				queryParams:null
				});

		});

		$('#search').click(function(){
			$('#layout-table').datagrid({
				queryParams:{data:$('#layout-search-form').serialize()}
				});
		});		
		$('#layout-table').datagrid({
			url:'<?=site_url('layout/admin/layout/json')?>',
			height:'auto',
			width:'auto',
			onDblClickRow:function(index,row)
			{
			$('#form-layout').form('load',row);
			$('#dlg').window('open').window('setTitle','<?=lang('edit_layout')?>');
			}
		});
	});
	
	function getActions(value,row,index)
	{
		var e = '<a href="#" onclick="edit('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-edit"  title="<?=lang('edit_layout')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-edit"></span></span></a>';
		var d = '<a href="#" onclick="remove('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-remove"  title="<?=lang('delete_layout')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-cancel"></span></span></a>';
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
		$('#dlg').window('open').window('setTitle','<?=lang('create_layout')?>');
		$('#form-layout').form('clear');
	}	

	function edit(index)
	{
		var row = $('#layout-table').datagrid('getRows')[index];
		if (row){
			$('#form-layout').form('load',row);
			$('#dlg').window('open').window('setTitle','<?=lang('edit_layout')?>');
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
				var row = $('#layout-table').datagrid('getRows')[index];
				$.post('<?=site_url('layout/admin/layout/delete_json')?>', {id:[row.layout_id]}, function(){
					$('#layout-table').datagrid('deleteRow', index);
					$('#layout-table').datagrid('reload');
				});

			}
		});
	}
	
	function removeSelected()
	{
		var rows=$('#layout-table').datagrid('getSelections');
		if(rows.length>0)
		{
			selected=[];
			for(i=0;i<rows.length;i++)
			{
				selected.push(rows[i].layout_id);
			}
			
			$.messager.confirm('Confirm','<?=lang('delete_confirm')?>',function(r){
				if(r){				
					$.post('<?=site_url('layout/admin/layout/delete_json')?>',{id:selected},function(data){
						$('#layout-table').datagrid('reload');
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
		$('#form-layout').form('submit',{
			url: '<?=site_url('layout/admin/layout/form_json')?>',
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success)
				{
					$('#form-layout').form('clear');
					$('#dlg').window('close');		// close the dialog
					$.messager.show({title: '<?=lang('success')?>',msg: result.msg});
					$('#layout-table').datagrid('reload');	// reload the user data
				} 
				else 
				{
					$.messager.show({title: '<?=lang('error')?>',msg: result.msg});
				} //if close
			}//success close
		
		});		
		
	}
	
	
</script>