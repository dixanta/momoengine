<div class="page-header">
		<h1>Change Password</h1>
</div>
 
<form method="post" id="login" action="<?php echo site_url('account/change_password')?>">

<label for="password"><?=lang('password')?>: </label>
<input type="password" name="password" id="password" class="span4" />
<span class="text-error"><?php echo form_error('password'); ?></span>

<label for="new_password"><?=lang('new_password')?>: </label>
<input type="password" name="new_password" id="new_password" class="span4"/>
<span class="text-error"><?php echo form_error('new_password'); ?></span>

<label for="conf_password"><?=lang('conf_password')?>: </label>
<input type="password" name="conf_password" id="conf_password" class="span4"/>
<span class="text-error"><?php echo form_error('conf_password'); ?></span>

<br/>
<input class="btn btn-primary" type="submit" id="contactbtn" name="confirm" value="Change Password" />
</form>

 

