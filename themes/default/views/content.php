<?php print displayStatus();?>

	<?php print (isset($content)) ? $content : NULL; ?>
    <?php $this->load->view($view_page);?>
