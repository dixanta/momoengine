<?php
	foreach($shortcuts as $row):
?>
<a class="border" href="<?php echo $row['link']?>" target="<?php echo ($row['new_window'])?'_blank':'' ?>"><span class="dash_blog"><?php echo $row['name']?></span></a>
<?php
	endforeach;
?>