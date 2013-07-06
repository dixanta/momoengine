    <style type="text/css">
      .form-signin {
        max-width: 400px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
<?php print form_open('auth/login',array('class'=>'form-signin'))?>
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" name="login_field" id="login_field" value="<?php print $this->validation->login_field?>" class="input-block-level" placeholder="<?php print $login_field?>">
        <input type="password" id="password" name="password" class="input-block-level" placeholder="<?php print $this->lang->line('userlib_password')?>">
        <label class="checkbox">
	         <input type="checkbox" id="remember" name="remember" value="yes"/> <?php print $this->lang->line('userlib_remember_me')?>?
        </label>
            <?php
            // Only display captcha if needed
            if($this->preference->item('use_login_captcha')):?>
            
                <label for="recaptcha_response_field"><?php print $this->lang->line('userlib_captcha')?>:</label>
                <?php print $captcha?>
            
            <?php endif;?>        
        <button class="btn btn-large btn-primary" type="submit" name="submit" value="submit"><?php print $this->lang->line('userlib_login')?></button> 
            		<a href="<?php print site_url('auth/forgotten_password') ?>" class="btn btn-large btn-danger">
            			<?php print $this->bep_assets->icon('arrow_refresh') ?>
            			<?php print $this->lang->line('userlib_forgotten_password')?>
            		</a>

            		<?php if($this->preference->item('allow_user_registration')):?>
            		<?php /*?><a href="<?php print site_url('auth/register') ?>"  class="btn btn-large btn-danger">
            			<?php print $this->bep_assets->icon('user') ?>
            			<?php print $this->lang->line('userlib_register')?>
            		</a><?php */?>
            		<?php endif;?>        
<?php print form_close()?>

