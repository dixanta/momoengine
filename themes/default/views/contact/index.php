<h2>Contact Us</h2>
<div style="padding:5px;background-color:#FFF;text-align:center">
<?php echo $this->preference->item('google_adsense_banner');?>  
</div>    
<br/>     
 <div id="message" style="display:none"></div>
<form action="<?php echo site_url('contact')?>" method="post" id="contact">
    <p>
    <label>Name</label>
    <input name="name" type="text" class="required" id="name" value="<?php echo set_value('name')?>"/>
    <?php echo form_error('name')?>
     </p>
    <p><label>Email</label>
     <input name="email" type="text" class="email required"  value="<?php echo set_value('email')?>"/></p>
    <?php echo form_error('email')?>

     <p>
    <label>Message</label> 
    <textarea name="message" class="required" rows="8" cols="50"><?php echo set_value('message')?></textarea>
     <?php echo form_error('message')?>
    </p>						
    
    <p><label for="recaptcha_response_field">Captcha:</label>
    <div style="margin-left:145px" id="display-captcha"><?php print $captcha?></div></p>
   <?php echo form_error('recaptcha_response_field')?>
  <input name="submit" type="submit" id="submit" value="Send" />

</form>
                   
