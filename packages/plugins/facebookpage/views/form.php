<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<table width="100%" border="0" cellpadding="5">


  <tr>
    <td><div align="right"><?php echo lang('facebookpage') ?></div></td>
    <td>

    <input type="text" name="fanpage_id" value="<?php echo @$settings["fanpage_id"] ?>"/></td>
  </tr>
  
</table>
<table id="module" width="100%" >
          <thead>
            <tr>
              <td class="left">Width x Height:</td>
              <td class="left">Layout:</td>
              <td class="left">Position:</td>
              <td class="left">Status:</td>
              <td class="right">Sort Order:</td>
              <td></td>
            </tr>
          </thead>
		<?php $module_row = 0; ?>          
          <?php foreach ($modules as $module) { ?>
          <tbody id="module-row<?php echo $module_row; ?>">
            <tr>
              <td class="left"><input type="text" name="facebookpage_module[<?php echo $module_row; ?>][width]" value="<?php echo $module['width']; ?>" size="3" />
                <input type="text" name="facebookpage_module[<?php echo $module_row; ?>][height]" value="<?php echo $module['height']; ?>" size="3" />
                <?php if (isset($error_image[$module_row])) { ?>
                <span class="error"><?php echo $error_image[$module_row]; ?></span>
                <?php } ?></td>
              <td class="left"><select name="facebookpage_module[<?php echo $module_row; ?>][layout_id]">
                  <?php foreach ($this->layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>              
              <td class="left"><select name="facebookpage_module[<?php echo $module_row; ?>][position]">
                  <?php if ($module['position'] == 'content_top') { ?>
                  <option value="content_top" selected="selected">Content Top</option>
                  <?php } else { ?>
                  <option value="content_top">Content Top</option>
                  <?php } ?>
                  <?php if ($module['position'] == 'content_bottom') { ?>
                  <option value="content_bottom" selected="selected">Content Bottom</option>
                  <?php } else { ?>
                  <option value="content_bottom">Content Bottom</option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_left') { ?>
                  <option value="column_left" selected="selected">Column Left</option>
                  <?php } else { ?>
                  <option value="column_left">Column Left</option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_right') { ?>
                  <option value="column_right" selected="selected">Column Right</option>
                  <?php } else { ?>
                  <option value="column_right">Column Right</option>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="facebookpage_module[<?php echo $module_row; ?>][status]">
                  <?php if ($module['status']) { ?>
                  <option value="1" selected="selected">Enabled</option>
                  <option value="0">Disabled</option>
                  <?php } else { ?>
                  <option value="1">Enabled</option>
                  <option value="0" selected="selected">Disabled</option>
                  <?php } ?>
                </select></td>
              <td class="right"><input type="text" name="facebookpage_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="easyui-linkbutton" iconCls="icon-cancel">Remove</a></td>
            </tr>
          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
         <tfoot>
            <tr>
              <td colspan="6"></td>
              <td class="left"><a  onclick="addModule();" class="easyui-linkbutton" iconCls="icon-add">Add Module</a></td>
            </tr>
          </tfoot>
        </table>
<script type="text/javascript"><!--

var module_row = <?php echo $module_row?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><input type="text" name="facebookpage_module[' + module_row + '][width]" value="80" size="3" /> <input type="text" name="facebookpage_module[' + module_row + '][height]" value="80" size="3" /></td>';	
	html += '    <td class="left"><select name="facebookpage_module[' + module_row + '][layout_id]">';
	<?php foreach ($this->layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	
	html += '    <td class="left"><select name="facebookpage_module[' + module_row + '][position]">';
	html += '      <option value="content_top">Content Top</option>';
	html += '      <option value="content_bottom">Content Bottom</option>';
	html += '      <option value="column_left">Column Left</option>';
	html += '      <option value="column_right">Column Right</option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="facebookpage_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected">Enabled</option>';
    html += '      <option value="0">Disabled</option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="facebookpage_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a href="javascript:void(0)" onclick="$(\'#module-row' + module_row + '\').remove();"><span class="l-btn-left"><span class="l-btn-text icon-add" style="padding-left: 20px;">Remove</span></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
	
}
//--></script>         
