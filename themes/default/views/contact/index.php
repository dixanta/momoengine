<div class="page-header">
		<h1>Contact Us</h1>
</div>
 <div id="message" style="display:none"></div>
<form action="<?php echo site_url('contact')?>" method="post" id="contact">
    <label>Name</label>
    <input name="name" type="text" class="span6" id="name" value="<?php echo set_value('name')?>"/>
    <span class="text-error"><?php echo form_error('name')?></span>
    <label>Email</label>
     <input name="email" type="text" class="span6"  value="<?php echo set_value('email')?>"/>
    <span class="text-error"><?php echo form_error('email')?></span>
    <label>Message</label> 
    <textarea name="message" class="span6" rows="8" cols="50"><?php echo set_value('message')?></textarea>
     <span class="text-error"><?php echo form_error('message')?></span>
    <label for="recaptcha_response_field">Captcha:</label>
    <span id="display-captcha" style="line-height:6px"><?php print $captcha?></span>
   <span class="text-error"><?php echo form_error('recaptcha_response_field')?></span>
  <input name="submit" type="submit" id="submit" value="Send" class="btn btn-primary"/>
</form>
                   
