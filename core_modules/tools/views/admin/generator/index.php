<div region="center" border="false">
<div style="padding:20px">
<h2>Module Generator</h2>
<form id="form-generator" method="post">
<label>Table Prefix</label>
<input type="text" name="prefix" id="prefix"/><br/>

<label>Discard Fields</label>
<textarea name="discard" id="discard" style="width:100%;height:100px" class="easyui-validatebox" required="true"></textarea>
(Define Fields in Comma Seperated format)<br/>
<label>Languages</label>
<input name="language[]" type="checkbox" id="language[]" value="english" checked="checked"/>English 
<input name="language[]" type="checkbox" id="language[]" value="japanese" />Japanese<br/>
<input type="checkbox" id="check_all" value="1"/>Check/Uncheck All
<ul>
<?php
foreach($tables as $table):
?>
<li><input type="checkbox" name="tables[]" id="<?php echo $table?>" value="<?php echo $table?>"/>
<a href="javascript:void()" onclick="getFields('<?php echo $table?>')"><?php echo $table?></a></li>
<?php
endforeach;
?>
</ul>
<a href="#" class="easyui-linkbutton" onclick="generate()">Generate</a>
</form>
<div id="results"></div>
</div>
</div>
<script>
$(function(){
	$('#check_all').live('click',function(){
		var checked=false;
		if($(this).is(':checked'))
		{
			checked=true;
		}
			$("input:checkbox[name='tables[]']").each(function(){
				
					$(this).attr('checked',checked);

			});
		
	});		
});
function generate()
{
	$.ajax({url:'<?php echo site_url('tools/admin/generator/generate')?>',type:'post',data:$('#form-generator').serialize(),dataType:'html',success:function(data){
		$('#results').html(data);
	}
		
	});		
	return false;	
}
</script>