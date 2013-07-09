<div class="page-header">
		<h1>Contact Us</h1>
</div>
 <div id="message" style="display:none"></div>
<form action="<?php echo site_url('contact')?>" method="post" id="contact">
    <label>Name</label>
    <input name="name" type="text" class="span6" id="name" value="<?php echo set_value('name')?>"/>
    <?php echo form_error('name')?>
    <label>Email</label>
     <input name="email" type="text" class="span6"  value="<?php echo set_value('email')?>"/>
    <?php echo form_error('email')?>
    <label>Message</label> 
    <textarea name="message" class="span6" rows="8" cols="50"><?php echo set_value('message')?></textarea>
     <?php echo form_error('message')?>
    <label for="recaptcha_response_field">Captcha:</label>
    <span id="display-captcha" style="line-height:6px"><?php print $captcha?></span>
   <?php echo form_error('recaptcha_response_field')?>
  <input name="submit" type="submit" id="submit" value="Send" class="btn btn-primary"/>
</form>
                   
