<?php 
echo head(array(
    'title' => 'Show Tagroup',
    'bodyclass' => 'page tagroup',
    'bodyid' => 'tagroup_admin_page',
)); 

?>

<ul id="section-nav" class="navigation">
	<li><a href="<?php echo html_escape(url('tagroups/tagroups/browse')); ?>">Browse Tagroups</a></li>
	<li><a href="<?php echo html_escape(url('tagroups/tagroups/add')); ?>">Add Tagroups</a></li>
	<li><a href="<?php echo html_escape(url('tagroups/tagroups/assign')); ?>">Assign Tagroups</a></li>
</ul>

<?php

echo('<h2>'.$tagroup->name.'</h2>');

?>





<?php echo foot(); ?>
