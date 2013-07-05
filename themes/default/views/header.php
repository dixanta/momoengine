<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php print $this->bep_site->get_metatags(); ?>
	<title><?php print $header.' | '.$this->preference->item('site_name')?></title>
	<?php print $this->bep_site->get_variables()?>
	<?php print $this->bep_assets->get_header_assets();?>
	<?php print $this->bep_site->get_js_blocks()?>
</head>

<body>

<!--header_wrap goes here-->
<div id="header_wrap">
	<!--header goes here-->
 
<div id="header">

        <li class="active"><a href="<?php echo site_url()?>">Home </a>|</li>
        <li><a href="<?php echo site_url('contact')?>">Contact us </a>|</li>
        <li><a href="<?php echo site_url('auth/register')?>">Sign up </a></li>
        <li><a href="<?php echo site_url('auth/login')?>">Login </a></li>        
  </div>