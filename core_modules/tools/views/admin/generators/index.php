<div region="center" border="false">
<div style="padding:20px">
<h2>Module Generator</h2>
<form id="form-generator" method="post">
<label>Table Prefix</label>
<input type="text" name="prefix" id="prefix"/><br/>

<label>Discard Fields (Define Fields in Comma Seperated format)</label>
<input name="discard_search" type="checkbox" value="search" checked="checked"/>Search Bar
<input name="discard_grid" type="checkbox" value="grid" checked="checked"/>Grid 
<input name="discard_form" type="checkbox" value="form" checked="checked"/>Form 
<input name="discard_post" type="checkbox" value="post" checked="checked"/>Post Back 
<textarea name="discard" id="discard" style="width:100%;height:100px" class="easyui-validatebox"></textarea>
<br/>
<label>Languages</label>
<input name="language[]" type="checkbox"  value="english" checked="checked"/>English 
<input name="language[]" type="checkbox" value="japanese" />Japanese
<input name="language[]" type="checkbox" value="spanish" />Spanish
<input name="language[]" type="checkbox" value="french" />French
<input name="other_language" type="text" value=""/>(Other Language Use Comma if you want to generate multiple language Files)
<br/>

<input type="checkbox" id="check_all" value="1"/>Check/Uncheck All
<ul>
<?php
foreach($tables as $table):
?>
<li><input type="checkbox" name="tables[]" id="<?php echo $table?>" value="<?php echo $table?>" class="tables"/>
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
	$('#check_all').on('click',function(){
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
	var checked=false;
	$.each($('.tables'),function(i,o){
		if($(this).is(':checked')){
			checked=true;
		}
	});
	if(!checked){
		$.messager.alert('Error','Please Select any table');
		return false;
	}
	$.ajax({url:'<?php echo site_url('tools/admin/generators/generate')?>',type:'post',data:$('#form-generator').serialize(),dataType:'html',success:function(data){
		$('#results').html(data);
	}
		
	});		
	return false;	
}
</script>