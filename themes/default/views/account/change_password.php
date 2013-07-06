
 <h2>Change Password</h2>
 <div>
 
<form method="post" id="login" action="<?php echo site_url('account/change_password')?>">
<ul>
<li><label for="password" style="width:140px"><?=lang('password')?>: </label>
<input type="password" name="password" id="password" class="required" />
<?php echo form_error('password'); ?>
</li>
<li><label for="new_password" style="width:140px"><?=lang('new_password')?>: </label>
<input type="password" name="new_password" id="new_password" class="required"/>
<?php echo form_error('new_password'); ?>
</li>
<li><label for="conf_password" style="width:140px"><?=lang('conf_password')?>: </label>
<input type="password" name="conf_password" id="conf_password" class="required"/>
<?php echo form_error('conf_password'); ?>
</li>

<li><input class="btn btn-info" type="submit" id="contactbtn" name="confirm" value="Change Password" />
</li>
</ul>

</form>

   </div>
 

