<div region="center" border="false">
<div style="padding:20px">
<style>
#filetree {
	width: 300px;
	height: 400px;
	border-top: solid 1px #BBB;
	border-left: solid 1px #BBB;
	border-bottom: solid 1px #FFF;
	border-right: solid 1px #FFF;
	background: #FFF;
	overflow: scroll;
	padding: 5px;
	float:left;
}
</style>
<h1><u>File Editor</u></h1>
<p style="float:right;margin-right:90px">
<a id="save-changes" class="easyui-linkbutton">Save Changes</a>
</p>  
<div style="clear:both"></div>
<div id="filetree"></div>
<div style="position:relative;float:right;margin-left:10px;width:75%">
    <form action="#" method="post" id="file-form" onSubmit="return false">
        <input type="text" id="source_file" name="source_file" readonly="readonly" style="width:90%"/>
		<textarea id="filecontent" name="filecontent" style="height:380px;width:90%"></textarea>
        <input type="hidden" id="save" name="save" value="1"/>
    </form>
</div>
</div>
</div>

<script>

$(function() {

    $('#filetree').fileTree({ root: '<?php echo $_SERVER['DOCUMENT_ROOT']?>/',script:'<?=site_url('tools/admin/feditor/filetree')?>',multiFolder: false }, 
	function(file) {
		$.get('<?php echo site_url('tools/admin/feditor/get_file')?>',{file:file},function(data){
			$('#filecontent').val(data);
		});
		$('#source_file').val(file);
		
    });

	$('#save-changes').click(function(){
		$.ajax({type:'post',url:'<?=site_url('tools/admin/feditor/save')?>',data:$('#file-form').serialize(),dataType:'json',
				success:function(data){
					if(data.success)
					{
						$.messager.alert('Success','File Editor Successfully');
					}
				}
		});

	});	
});

</script>