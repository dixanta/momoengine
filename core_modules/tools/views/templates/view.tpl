<div region="center" border="false">
<div style="padding:20px">
<div id="search-panel" class="easyui-panel" data-options="title:'{PHP_START} echo lang('{TABLE_NAME}_search'){PHP_END}',collapsible:true,iconCls:'icon-search'" style="padding:5px">
<form action="" method="post" id="{VIEWTABLE}-search-form">
<table width="100%" border="1" cellspacing="1" cellpadding="1">
{SEARCH_FIELDS}
  <tr>
    <td colspan="4">
    <a href="#" class="easyui-linkbutton" id="search" iconCls="icon-search">{PHP_START} echo lang('search'){PHP_END}</a>  
    <a href="#" class="easyui-linkbutton" id="clear" iconCls="icon-clear">{PHP_START} echo lang('clear'){PHP_END}</a>
    </td>
    </tr>
</table>

</form>
</div>
<br/>
<table id="{VIEWTABLE}-table" data-options="pagination:true,title:'{PHP_START} echo lang('{TABLE_NAME}'){PHP_END}',pagesize:'20', rownumbers:true,toolbar:'#toolbar',collapsible:true,fitColumns:true">
    <thead>
    <th field="checkbox" checkbox="true"></th>
    {TABLE_FIELDS}
    <th field="action" width="100" formatter="getActions">{PHP_START} echo lang('action'){PHP_END}</th>
    </thead>
</table>

<div id="toolbar" style="padding:5px;height:auto">
    <p>
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="create()" title="{PHP_START} echo lang('create_{TABLE_NAME}'){PHP_END}">{PHP_START} echo lang('create'){PHP_END}</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="false" onclick="removeSelected()"  title="{PHP_START} echo lang('delete_{TABLE_NAME}'){PHP_END}">{PHP_START} echo lang('remove_selected'){PHP_END}</a>
    </p>

</div> 

<!--for create and edit {VIEWTABLE} form-->
<div id="dlg" class="easyui-dialog" style="width:600px;height:auto;padding:10px 20px"
        data-options="closed:true,collapsible:true,buttons:'#dlg-buttons',modal:true">
    <form id="form-{VIEWTABLE}" method="post" >
    <table>
		{FORMFIELDS}
    </table>
    </form>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="save()">{PHP_START} echo  lang('general_save'){PHP_END}</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dlg').window('close')">{PHP_START} echo  lang('general_cancel'){PHP_END}</a>
	</div>    
</div>
<!--div ends-->
   
</div>
</div>
<script language="javascript" type="text/javascript">
	$(function(){
		$('#clear').click(function(){
			$('#{VIEWTABLE}-search-form').form('clear');
			$('#{VIEWTABLE}-table').datagrid({
				queryParams:null
				});

		});

		$('#search').click(function(){
			$('#{VIEWTABLE}-table').datagrid({
				queryParams:{data:$('#{VIEWTABLE}-search-form').serialize()}
				});
		});		
		$('#{VIEWTABLE}-table').datagrid({
			url:'{PHP_START} echo site_url('{VIEWTABLE}/admin/{VIEWTABLE}/json'){PHP_END}',
			height:'auto',
			width:'auto',
			onDblClickRow:function(index,row)
			{
				edit(index);
			}
		});
	});
	
	function getActions(value,row,index)
	{
		var e = '<a href="#" onclick="edit('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-edit"  title="{PHP_START} echo lang('edit_{TABLE_NAME}'){PHP_END}"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-edit"></span></span></a>';
		var d = '<a href="#" onclick="remove{VIEWTABLE}('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-remove"  title="{PHP_START} echo lang('delete_{TABLE_NAME}'){PHP_END}"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-cancel"></span></span></a>';
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
		$('#form-{VIEWTABLE}').form('clear');
		$('#dlg').window('open').window('setTitle','{PHP_START} echo lang('create_{VIEWTABLE}'){PHP_END}');
		//uploadReady(); //Uncomment This function if ajax uploading
	}	

	function edit(index)
	{
		var row = $('#{VIEWTABLE}-table').datagrid('getRows')[index];
		if (row){
			$('#form-{VIEWTABLE}').form('load',row);
			//uploadReady(); //Uncomment This function if ajax uploading
			$('#dlg').window('open').window('setTitle','{PHP_START} echo lang('edit_{VIEWTABLE}'){PHP_END}');
		}
		else
		{
			$.messager.alert('Error','{PHP_START} echo lang('edit_selection_error'){PHP_END}');				
		}		
	}
	
		
	function remove{VIEWTABLE}(index)
	{
		$.messager.confirm('Confirm','{PHP_START} echo lang('delete_confirm'){PHP_END}',function(r){
			if (r){
				var row = $('#{VIEWTABLE}-table').datagrid('getRows')[index];
				$.post('{PHP_START} echo site_url('{VIEWTABLE}/admin/{VIEWTABLE}/delete_json'){PHP_END}', {id:[row.{PRIMARY_KEY}]}, function(){
					$('#{VIEWTABLE}-table').datagrid('deleteRow', index);
					$('#{VIEWTABLE}-table').datagrid('reload');
				});

			}
		});
	}
	
	function removeSelected()
	{
		var rows=$('#{VIEWTABLE}-table').datagrid('getSelections');
		if(rows.length>0)
		{
			selected=[];
			for(i=0;i<rows.length;i++)
			{
				selected.push(rows[i].{PRIMARY_KEY});
			}
			
			$.messager.confirm('Confirm','{PHP_START} echo lang('delete_confirm'){PHP_END}',function(r){
				if(r){				
					$.post('{PHP_START} echo site_url('{VIEWTABLE}/admin/{VIEWTABLE}/delete_json'){PHP_END}',{id:selected},function(data){
						$('#{VIEWTABLE}-table').datagrid('reload');
					});
				}
				
			});
			
		}
		else
		{
			$.messager.alert('Error','{PHP_START} echo lang('edit_selection_error'){PHP_END}');	
		}
		
	}
	
	function save()
	{
		$('#form-{VIEWTABLE}').form('submit',{
			url: '{PHP_START} echo site_url('{VIEWTABLE}/admin/{VIEWTABLE}/save'){PHP_END}',
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success)
				{
					$('#form-{VIEWTABLE}').form('clear');
					$('#dlg').window('close');		// close the dialog
					$.messager.show({title: '{PHP_START} echo lang('success'){PHP_END}',msg: result.msg});
					$('#{VIEWTABLE}-table').datagrid('reload');	// reload the user data
				} 
				else 
				{
					$.messager.show({title: '{PHP_START} echo lang('error'){PHP_END}',msg: result.msg});
				} //if close
			}//success close
		
		});		
		
	}
	
	{UPLOAD_VIEW_FUNCTION}
</script>