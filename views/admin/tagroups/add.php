<?php
    $title = __('Add Tagroup');
    echo head(array('title' => html_escape($title), 'bodyclass' => 'tagroup'));
?>
<ul id="section-nav" class="navigation">
	<li><a href="<?php echo html_escape(url('tagroups/tagroups/browse')); ?>">Browse Tagroups</a></li>
	<li class="current"><a href="<?php echo html_escape(url('tagroups/tagroups/add')); ?>">Add Tagroups</a></li>
	<li><a href="<?php echo html_escape(url('tagroups/tagroups/assign')); ?>">Assign Tagroups</a></li>
</ul>

<?php echo flash(); ?>

<?php
$formArgs = array('tagroup' => $tagroup, 'theme' => null);
?>

<form id="tagroup-metadata-form" method="post" class="tagroup-builder">
    <section class="seven columns alpha">
    <fieldset>
        <legend><?php echo __('Tagroup Name'); ?></legend>
        <div class="field">
            <div class="two columns alpha">
                <?php echo $this->formLabel('name', __('Name')); ?>
            </div>
            <div class="five columns omega inputs">
                <?php echo $this->formText('name', $tagroup->name); ?>
            </div>
        </div>
    </fieldset>
    </section>

    <section class="three columns omega">
        <div id="save" class="panel">
            <?php echo $this->formSubmit('save_tagroup', __('Save Changes'), array('class'=>'submit big green button')); ?>
        </div>
    </section>
</form>

<?php echo foot(); ?>
