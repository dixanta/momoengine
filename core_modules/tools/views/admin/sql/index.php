<div region="center" border="false">
<div style="padding:20px">
<h2>SQL Execute</h2>
<form id="sql-form" method="post">
<textarea name="sql" style="width:100%;height:100px" class="easyui-validatebox" required="true"></textarea>
<br/>
<a href="javascript:void(0)" class="easyui-linkbutton" onclick="executeQuery()">Execute Query</a>
</form>
<div id="result"></div>
</div>
</div>

<script>

	function executeQuery()
	{
		$('#sql-form').form('submit',{
			url: '<?php echo site_url('tools/admin/sql/execute')?>',
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				$('#result').html(result);
			}//success close
		
		});		
		
	}
</script>