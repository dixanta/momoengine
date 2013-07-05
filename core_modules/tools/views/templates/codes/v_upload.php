function uploadReady()
	{
		uploader=$('#upload_image');
		new AjaxUpload(uploader, {
			action: '{PHP_START} echo site_url('{MODULE}/admin/{MODULE}/upload_image'){PHP_END}',
			name: 'userfile',
			responseType: "json",
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					$.messager.show({title: '{PHP_START} echo lang('error'){PHP_END}',msg: 'Only JPG, PNG or GIF files are allowed'});
					return false;
				}
				//status.text('Uploading...');
			},
			onComplete: function(file, response){
				if(response.error==null){
					var filename = response.file_name;
					$('#upload_image').hide();
					$('#{FIELD}').val(filename);
					$('#upload_image_name').html(filename);
					$('#upload_image_name').show();
					$('#change-image').show();
				}
                else
                {
					$.messager.show({title: '{PHP_START} echo lang('error'){PHP_END}',msg: response.error});                
                }
			}		
		});		
	}