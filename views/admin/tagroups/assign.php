<?php 

queue_css_string('div.field-group{padding-top: 1em;margin-bottom:1em;border-top: 1px solid #cccccc;clear:both;overflow: auto;}');

echo head(array(
    'title' => 'Tagroups | Configuration',
    'bodyclass' => 'page tagroups',
    'bodyid' => 'tagroups_page',
)); 

?>

<ul id="section-nav" class="navigation">
	<li><a href="<?php echo html_escape(url('tagroups/tagroups/browse')); ?>">Browse Tagroups</a></li>
	<li><a href="<?php echo html_escape(url('tagroups/tagroups/add')); ?>">Add Tagroups</a></li>
	<li class="current"><a href="<?php echo html_escape(url('tagroups/tagroups/assign')); ?>">Assign Tagroups</a></li>
</ul>


<?php echo flash(); ?>

<?php


function even_or_odd() {
  static $value = 1;
  if ($value == 1) {
    $value = 2;
    return 'odd';
  } else {
    $value = 1;
    return 'even';
  }
}

function tagroup_select($tagroup,$tagroup_id,$id) {
  $tagroup_select = '<select name="tagroups-tagroup_id-'.$id.'">';
  if (is_array($tagroup)) {
    foreach ($tagroup as $key => $group) {
      $tagroup_select .= '<option value="'.$key.'"';
      if ($key == $tagroup_id) {
        $tagroup_select .= ' selected';
      }
      $tagroup_select .= '>'.$group.'</option>';
    }
  }
  $tagroup_select .= '</select>';
  return $tagroup_select;
}

?>
<div id="primary">
	<form id="tagroups-fields-form" method="post" class="tagroups-form">
	<section class="seven columns alpha">
<?php
if (is_array($records)) {
  $tagroup_name = '';
  


  foreach ($records as $tagroup_tags) {
    if ($tagroup_name != $tagroup_tags['tagroup_name']) {
      if ($tagroup_name != '') {
        echo('</div>'); 
      }  
      $tagroup_name = $tagroup_tags['tagroup_name'];
      echo('<div class="tagroup_area"><h3>'.$tagroup_tags['tagroup_name'].'</h3>'); 
    }

    echo('<div class="field-group '.even_or_odd().'">');
    echo('<input type="hidden" name="ids[]" value="'.$tagroup_tags['id'].'">');
    echo('<div class="field">');
    echo('<input type="hidden" name="tagroups-tagroup_id-original-value-'.$tagroup_tags['id'].'" value="'.$tagroup_tags['tagroup_id'].'">');
    echo('<input type="hidden" name="tagroups-tag_id-'.$tagroup_tags['id'].'" value="'.$tagroup_tags['tag_id'].'">');
    echo('<div class="two columns alpha">'.$tagroup_tags['name'].'</div>');
    echo('<div class="inputs five columns omega">'.tagroup_select($tagroups,$tagroup_tags['tagroup_id'],$tagroup_tags['id']).'</div></div>');
    echo('</div>');
  }
  echo('</div>'); 
}

?>

	</section>
	<section class="three columns omega">
        <div id="save" class="panel">
			<input type="submit" name="save_tagroups" id="save_tagroups" value="Save Changes" class="submit big green button">
		</div>
	</section>
	
	
	</form>

</div>

<?php echo foot(); ?>
