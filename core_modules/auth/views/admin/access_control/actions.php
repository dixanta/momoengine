<div region="center" border="false">
<div style="padding:20px">
<h2><?php print $header?></h2>
<a href="javascript:void(0)" class="easyui-linkbutton" id="create" iconCls="icon-add">
		<?php print $this->lang->line('access_create_action')?>
</a><br/><br/>

<?php print form_open('auth/admin/acl_actions/delete')?> 
<table cellspacing="0" class="easyui-datagrid" id="action-datagrid" style="width:500px;height:auto;padding:20px" fitcolumns="true" title="Actions" collapsible="true">
<thead>
    <tr>
		<th checkbox="true"><?php //print form_checkbox('all','select',FALSE)?> <?php //print $this->lang->line('general_delete')?></th>        
        <th width="5" field="id"><?php print $this->lang->line('general_id')?></th>
        <th width="100" field="name"><?php print $this->lang->line('access_actions')?></th>
        
    </tr>
</thead>
<tbody>
    <?php 
    $query = $this->access_control_model->fetch('axos');
    foreach($query->result() as $result): ?>
    <tr>
    	<td></td>
        <td><?php print $result->id?></td>
        <td><?php print $result->name?></td>
        <td><?php //print form_checkbox('select[]',$result->name,FALSE)?></td>
    </tr>    
    <?php endforeach;?>
</tbody>

</table>
<?php print form_close()?>

<div class="buttons">
	<a href="<?php print site_url('auth/admin/access_control') ?>">
		<?php print $this->bep_assets->icon('arrow_left') ?>
		<?php print $this->lang->line('general_back')?>
	</a>
</div><br/><br/>


<div id="action-window" class="easyui-window" iconCls="icon-add" title="<?php print $this->lang->line('access_create_action')?>" closed="true" maximizable="false" minimizable="false">
<p>
<?php print form_open('auth/admin/acl_actions/create',array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <?php print form_label($this->lang->line('access_name'),'name')?>
                <?php print form_input('name','','class="text"')?>
            </li>
            <li class="submit">
            	<div class="buttons">
            		<button type="submit" class="positive" name="submit" value="submit">
            			<?php print $this->bep_assets->icon('disk') ?>
            			<?php print $this->lang->line('general_save') ?>
            		</button>
            	</div>
            </li>
        </ol>
    </fieldset>
<?php print form_close()?>
</p>
</div>
</div>
</div>
<script>
//var actions=<?php //echo json_encode($this->access_control_model->fetch('axos')->result_array());?>;

$(function(){
	$('#create').click(function(){
		$('#action-window').window('open');
	});
	//$('#action-datagrid').datagrid();
	//$('#action-datagrid').datagrid('loadData',actions);
});
</script>