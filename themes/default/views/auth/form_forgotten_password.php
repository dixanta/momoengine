
<?php print form_open('auth/forgotten_password',array('class'=>'vertical'))?>
    <fieldset>
        <ol>
            <li>
                <label style="float:left;" for="email"><?php print $this->lang->line('userlib_email')?>:</label>
                <input type="text" name="email" id="email" class="text" />
            </li>
            <li class="submit">
            	<div class="buttons" style="margin-left:103px;">
            		<button type="submit" class="positive" name="submit" value="submit">
            			<?php print $this->bep_assets->icon('arrow_refresh') ?>
            			<?php print $this->lang->line('userlib_reset_password')?>
            		</button>
            		
            		<a style="padding:6px;" href="<?php print site_url('auth/login') ?>" class="negative">
            			<?php print $this->bep_assets->icon('cross') ?>
            			<?php print $this->lang->line('general_cancel')?>
            		</a>
            	</div>
            </li>
        </ol>
    </fieldset>
<?php print form_close()?>
