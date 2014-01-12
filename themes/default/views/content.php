	<?php print displayStatus();?>
	<?php
        foreach($this->column_left as $block):
            echo $block;
        endforeach;
    ?>
	<?php
        foreach($this->content_top as $block):
            echo $block;
        endforeach;
    ?>    
	<?php print (isset($content)) ? $content : NULL; ?>
    <?php $this->load->view($view_page);?>
	<?php
        foreach($this->content_bottom as $block):
            echo $block;
        endforeach;
    ?> 
	<?php
        foreach($this->column_right as $block):
            echo $block;
        endforeach;
    ?>    