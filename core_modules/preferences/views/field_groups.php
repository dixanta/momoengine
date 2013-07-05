<div region="center" border="false">
<div style="padding:20px">
<h2><?php print $header?></h2>

<ul id="preference_list">
<?php
    foreach($group as $key=>$value)
    {
        print "<li>" . anchor($form_link . '/' . $key,$value['name'],'class="icon_cog"') . "</li>";
    }
?>
</ul>
</div>
</div>