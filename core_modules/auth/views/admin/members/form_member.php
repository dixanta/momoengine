<div region="center" border="false">
<div style="padding:20px">

<h2><?php print $header?></h2>
<p><?php print $this->lang->line('userlib_password_info')?></p>

<?php print form_open('auth/admin/members/form/'.$this->validation->id,array('class'=>'horizontal'))?>
    <fieldset>
<table style="width:100%">
            <tr>
            <td style="width:20%">
                <label for="username"><?php echo $this->lang->line('userlib_username')?></label>
            </td>
            <td>
                <input type="text" name="username" value="<?php echo $this->validation->username?>" id="username" style="width:300px"/>
            </td>
            </tr>
            <tr>
                <td><label for="email"><?php echo $this->lang->line('userlib_email')?></label></td>
                <td><input type="text" name="email" id="email" value="<?php echo $this->validation->email?>" style="width:300px"/></td>
            </tr>
            <tr>
                <td><label for="password"><?php echo $this->lang->line('userlib_password')?></label></td>
                <td><input type="password" name="password" id="password" value="" style="width:300px"/></td>
            </tr>
            <tr>
                <td><label for="confirm_password"><?php echo $this->lang->line('userlib_confirm_password')?></label></td>
                <td><input type="password" name="confirm_password" id="confirm_password" value="" style="width:300px"/></td>
            </tr>
            <tr>
                <td><label for="group"><?php echo $this->lang->line('userlib_group')?></label></td>
                <td><?php print form_dropdown('group',$groups,$this->validation->group,'id="group" size="10" style="width:20.3em;"')?></td>
            </tr>
            <tr>
                <td><label for="active"><?php echo $this->lang->line('userlib_active')?></label></td>
                <td><?php print $this->lang->line('general_yes')?> <?php print form_radio('active','1',$this->validation->set_radio('active','1'),'id="active"')?>
                <?php print $this->lang->line('general_no')?> <?php print form_radio('active','0',$this->validation->set_radio('active','0'))?>
                </td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td class="submit">
                <?php print form_hidden('id',$this->validation->id)?>
                <div class="buttons">
	                <button type="submit" class="positive" name="submit" value="submit">
	                	<?php print  $this->bep_assets->icon('disk');?>
	                	<?php print $this->lang->line('general_save')?>
	                </button>

	                <a href="<?php print  site_url('auth/admin/members')?>" class="negative">
	                	<?php print  $this->bep_assets->icon('cross');?>
	                	<?php print $this->lang->line('general_cancel')?>
	                </a>

	                <a href="javascript:void(0);" id="generate_password">
	                	<?php print  $this->bep_assets->icon('key');?>
	                	<?php print $this->lang->line('userlib_generate_password'); ?>
	                </a>
	            </div>
               </td>
            </tr>
        </table>
    </fieldset>
<h2><?php print $this->lang->line('userlib_user_profile')?></h2>
<?php
   /* if( ! $this->preference->item('allow_user_profiles')):
        print "<p>".$this->lang->line('userlib_profile_disabled')."</p>";
    else:
?>
    <fieldset>
        <ol>
            <li class="submit">
                <div class="buttons">
	                <button type="submit" class="positive" name="submit" value="submit">
	                	<?php print  $this->bep_assets->icon('disk');?>
	                	<?php print $this->lang->line('general_save')?>
	                </button>

	                <a href="<?php print  site_url('auth/admin/members')?>" class="negative">
	                	<?php print  $this->bep_assets->icon('cross');?>
	                	<?php print $this->lang->line('general_cancel')?>
	                </a>
	            </div>
            </li>
        </ol>
    </fieldset>
<?php endif; */?>
<?php print form_close()?>
<br/>
<br/>
</div>
</div>
<div id="generatePassword-Window" class="easyui-window" title="Generate Password" style="width:400px;height:auto" closed="true">
	<table style="width:100%;padding:20px">
		<tr>
        
        <td rowspan="3"><?php print $this->lang->line('userlib_password'); ?>:<br/>&nbsp;&nbsp;&nbsp;<b id="gpPassword">PASSWORD</b></td>
        
        <td class="right"><?php print $this->lang->line('general_uppercase'); ?> <?php print form_checkbox('uppercase','1',TRUE); ?></td></tr>
		<tr><td class="right"><?php print $this->lang->line('general_numeric'); ?> <?php print form_checkbox('numeric','1',TRUE); ?></td></tr>
		<tr><td class="right"><?php print $this->lang->line('general_symbols'); ?> <?php print form_checkbox('symbols','1',FALSE); ?></td></tr>
		<tr><td colspan="2"><span class="right"><?php print $this->lang->line('general_length'); ?>
              <input type="text" name="length" value="12" maxlength="2" size="4" />
		</span></td></tr>
		<tr>
        <td>
        <a href="javascript:void(0);" class="easyui-linkbutton" iconcls="icon_arrow_refresh" id="gpGenerateNew">
		<?php print $this->lang->line('general_generate'); ?></a>
        <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon_tick" id="gpApply">&nbsp;
		<?php print $this->lang->line('general_apply'); ?></a>
        </td>
        <td class="right">&nbsp;</td>
        </tr>
	</table>
</div>
