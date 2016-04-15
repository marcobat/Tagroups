<?php 
echo head(array(
    'title' => 'Tagroup | Configuration',
    'bodyclass' => 'page tagroup',
    'bodyid' => 'tagroup_admin_page',
)); 

?>
<ul id="section-nav" class="navigation">
	<li class="current"><a href="<?php echo html_escape(url('tagroups/tagroups/browse')); ?>">Browse Tagroups</a></li>
	<li><a href="<?php echo html_escape(url('tagroups/tagroups/add')); ?>">Add Tagroups</a></li>
	<li><a href="<?php echo html_escape(url('tagroups/tagroups/assign')); ?>">Assign Tagroups</a></li>
</ul>

<?php echo flash(); ?>


<?php 


if (count($results) > 0) {

  echo pagination_links(); 
  

?>
        <table id="tagroup">
            <thead>
                <tr>
					<th>Name</th><th></th>
	            </tr>
            </thead>
            <tbody>
                <?php $key = 0; ?>
                <?php foreach ($results as $tagroup) { ?>
                <tr class="tagroup<?php if(++$key%2==1) echo ' odd'; else echo ' even'; ?>">
                    <td class="name">
                    	<?php echo($tagroup['name']); ?>
	                </td>
                    <td>
						<a href="<?php echo html_escape(url('tagroups/tagroups/edit/id/'.$tagroup['id'])); ?>" class="small green edit button"><?php echo __('Edit'); ?></a></p>
	                </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

<?php 



} else { 

?>
    <h2><?php echo __('You have no Tagroups.'); ?></h2>
<?php 
} 

?>

<p><a href="<?php echo html_escape(url('tagroups/tagroups/add')); ?>" class="big green add button"><?php echo __('Add a Tagroup'); ?></a></p>


<?php echo foot(); ?>
