<div region="center" border="false">
<div style="padding:20px">
<h2><?php print $header?></h2>

<div class="buttons">                
	<a href="<?php print  site_url('auth/admin/members/form')?>">
    <?php print  $this->bep_assets->icon('add');?>
    <?php print $this->lang->line('userlib_create_user')?>
    </a>
</div><br/><br/>

<?php print form_open('auth/admin/members/delete')?>
<table id="users-grid" class="easyui-datagrid" cellspacing="0" fitcolumns="true" pagination="true" title="Users">
    <thead>
        <tr>
            <th width="10" checkbox="true"><?php print form_checkbox('all','select',FALSE)?><?php print $this->lang->line('general_delete')?></th>        
            <th width="10" field="id"><?php print $this->lang->line('general_id')?></th>
            <th field="username" width="200"><?php print $this->lang->line('userlib_username')?></th>
            <th field="email" width="200"><?php print $this->lang->line('userlib_email')?></th>
            <th field="group" width="100"><?php print $this->lang->line('userlib_group')?></th>
            <th field="last_visit" width="100"><?php print $this->lang->line('userlib_last_visit')?></th>
            <th field="active" width="20" align="center"><?php print $this->lang->line('userlib_active')?></th> 
            <th width="30" field="edit" class="center"><?php print $this->lang->line('general_edit')?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan=7>&nbsp;</td>
            <td><?php print form_submit('delete',$this->lang->line('general_delete'),'onClick="return confirm(\''.$this->lang->line('userlib_delete_user_confirm').'\');"')?></td>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach($members->result_array() as $row):
            // Check if this user account belongs to the person logged in
            // if so don't allow them to delete it, also if it belongs to the main
            // admin user don't allow them to delete it
            $delete  = ($row['id'] == $this->session->userdata('id') || $row['id'] == 1) ? '&nbsp;' : form_checkbox('select[]',$row['id'],FALSE);  
			
			$active =  ($row['active']?'tick':'cross');   
        ?>
        <tr>
            <td><?php print $delete?></td>
            <td><?php print $row['id']?></td>
            <td><?php print $row['username']?></td>
            <td><?php print $row['email']?></td>
            <td><?php print $row['group']?></td>
            <td><?php print $row['last_visit']?></td>
            <td><?php print $this->bep_assets->icon($active);?></td>
            <td><a href="<?php print site_url('auth/admin/members/form/'.$row['id'])?>"><?php print $this->bep_assets->icon('pencil');?></a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php print form_close()?>
<br/>
<br/>
</div>
</div>
<script>
$(function(){
	$('#users-grid').datagrid({
		onLoadSuccess:function(data){
			console.log(data);
		}
	});
});
</script>