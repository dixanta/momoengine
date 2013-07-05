<?php print (isset($content)) ? $content : NULL; ?>
<?php
if( isset($page)){
if( isset($module)){
		$this->load->module_view($module,$page);
	} else {
		$this->load->view($page);
	}}
?>
<br/>
