<!doctype HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="assets/css/reset.css" />
    
    <!--[if IE 6]>
    <link rel="stylesheet" type="text/css" href="assets/css/reset[ie_6].css" />
    <![endif]-->
    
    <!--[if gte IE 6]>
    <link rel="stylesheet" type="text/css" href="assets/css/reset[gte_ie_6].css" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="assets/css/typography.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/bep_front_layout.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/forms.css" />
	<script src="assets/js/jquery.js" language="javascript"></script>
    <script src="assets/js/jquery.validate.js" language="javascript"></script>    
    <title>Installation</title>

</head>

<body>

<div id="wrapper">

    <div id="header">
        <h1>BackendPro Installation Process</h1>
    </div>

    <div id="content">
    	<a name="top"></a>
    	<?php
    		include_once("common/CommonFunctions.php");
    		
    		// Check the install folder is realy writable
    		if(!is_really_writable($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']))):
   		?>
   		<p>Before you can install BackendPro please make sure the following folder is writable, then re-run this 
   		install:</p>
   		<p><b><?php print $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']) ?></b></p>
   		<?php else:?>        
        <p>Lets get started, all we are going to do here is setup some basic details to get
        your system up and running.</p>

        <form id="installer-form" action="install_status.php" method="POST" class="horizontal">
            
            
<div class="box _100">
<div class="box-header">CodeIgniter File System</div>
<div class="box-content">
<p>First lets get some information about your CodeIgniter setup.
            Please make sure all the following paths are relative to the Base Path.
            <b>Please note this will not change the files in CI and is only used
            during the install process.</b></p>
            <p>Make sure all folders are relative to <b><?php print $_SERVER['DOCUMENT_ROOT'] . dirname(dirname($_SERVER['SCRIPT_NAME']))?>/</b></p>
            <fieldset>
                <ol>
                    <li>
                        <label for="ci_system">System Folder</label>
                        <input type="text" name="ci_system" class="text" value="system" />
                    </li>
                    <li>
                        <label for="ci_application">Application Folder</label>
                        <input type="text" name="ci_application" class="text" value="application" />
                    </li>
                    <li>
                        <label for="ci_modules">Modules Folder</label>
                        <input type="text" name="ci_modules" class="text" value="core_modules" />
                    </li>
                    <li>
                        <label for="ci_logs">Log Folder</label>
                        <input type="text" name="ci_logs" class="text" value="application/logs" />
                    </li>
                    <li>
                        <label for="ci_cache">Cache Folder</label>
                        <input type="text" name="ci_cache" class="text" value="application/cache" />
                    </li>
                </ol>
            </fieldset>
</div></div>
       <div class="box _100">
<div class="box-header">Database</div>
<div class="box-content">
            
            <p>Now lets get some information about your database you are going to use.
            Please make sure the user you specify has the ability to create new tables,
            and insert data.</p>

            <fieldset>
                <ol>
                    <li>
                        <label for="database_host">Database Host<span class="required">*</span></label>
                        <input type="text" name="database_host" class="text required" value="localhost"/>
                    </li>
                    <li>
                        <label for="database_name">Database Name<span class="required">*</span></label>
                        <input type="text" name="database_name" class="text required" />
                    </li>
                    <li>
                        <label for="database_user">Database User<span class="required">*</span></label>
                        <input type="text" name="database_user" class="text required" value="root"/>
                    </li>
                    <li>
                        <label for="database_password">Database Password</label>
                        <input type="text" name="database_password" class="text" />
                    </li>
                </ol>
            </fieldset>
</div></div>
            <div class="box _100">
<div class="box-header">User Account</div>
<div class="box-content">
            
            <p>Now lets get you setup with some login details, please remember your email address is
            used when logging in to the system.</p>
            <fieldset>
                <ol>
                    <li>
                        <label for="username">Username<span class="required">*</span></label>
                        <input type="text" name="username" class="text required" value="admin"/>
                    </li>
                    <li>
                        <label for="email">Email<span class="required">*</span></label>
                        <input type="text" name="email" class="text required" />
                    </li>
                    <li>
                        <label for="password">Password<span class="required">*</span></label>
                        <input type="text" name="password" class="text required" />
                    </li>
                </ol>
            </fieldset>
</div></div>
                    <div class="box _100">
<div class="box-header">Encryption Key</div>
<div class="box-content">   
            
            <p>Throughout the BackendPro system, encryption is used to protect sensitive data.
            For this we need an encryption key, please specify one below. If you do not
            provide one, a random key will be generated for you. When picking a key please
            ensure it is at least 32 characters long and as random as possible. <b>If this key
            is lost for any reason any data encrypted using it will also be lost.</b></p>
            <fieldset>
                <ol>
                    <li>
                        <label for="username">Key<span class="required">*</span></label>
                        <input type="text" name="encryption_key" class="text required" value="" />
                    </li>
                </ol>
            </fieldset>
</div></div>
                            <div class="box _100">
<div class="box-header">ReCAPTCHA</div>
<div class="box-content"> 
            
            <p>Now BackendPro can use ReCAPTCHA to verify someone isn't a bot, but for this we need both
            your public and private keys. If you don't have a public/private key please go <a href="http://google.com/recaptcha/admin/create" target="_blank">here</a>
            to get one. <b>This is an optional field, not entering a key will only mean ReCAPTCHA isn't
            available to you</b></p>
            <fieldset>
                <ol>
                    <li>
                        <label for="public_key">Public Key</label>
                        <input type="text" name="public_key" class="text" />
                    </li>
                    <li>
                        <label for="private_key">Private Key</label>
                        <input type="text" name="private_key" class="text" />
                    </li>
                </ol>
            </fieldset>
</div></div>
<div class="box-content">
            <fieldset>
                        <input class="btn btn-success" type="submit" name="submit" value="INSTALL" />
                        <input type="reset" class="btn btn-error" value="CLEAR"/>

            </fieldset></div>
        </form>
        <?php endif;?>
    </div>

    
</div>
<div id="footer">
       <div class="footer-wrap">
        
        
        <p class="left">&copy; Copyright <?php echo date('Y')?> - PagodaLabs -  All rights Reserved</p><p class="right">Powered by 
        <a href="http://pagodalabs.com/" target="_blank">PagodaLabs</a></p>
        </div>
    </div>
<script>
$(document).ready(function(){
	$('#installer-form').validate();
})
</script>    
</body>
</html>
