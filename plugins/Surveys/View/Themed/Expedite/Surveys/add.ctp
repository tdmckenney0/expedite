<div style="width: 20em;">
	<?php echo $this->Form->create('Survey', array('class' => 'reload', 'url' => array('plugin' => 'surveys', 'controller' => 'surveys', 'action' => 'add', 'ext' => 'json'))); ?>
        <fieldset>
            <legend>Add Survey</legend>
		    <?php echo $this->Form->input('name'); ?>
        </fieldset>
		<div class="buttons">
			<?php echo $this->Form->submit(__('   OK   ')); ?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>