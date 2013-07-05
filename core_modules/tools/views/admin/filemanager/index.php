<div region="center" border="false">
<div style="padding:20px">
<h2>File Manager</h2>
<div id="finder"></div>
</div>
</div>

<script language="javascript">
$(function(){
	var f = $('#finder').elfinder({
	places:'',
	url : '<?=site_url('connector')?>',
	lang : 'jp',
	docked : true,
	 dialog : {
		title : 'File Manager',
		height : 500
	 },	
	});

});
</script>
