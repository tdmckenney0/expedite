<div class="span-12">
	<fieldset>
		<legend>Permission</legend>
		<?php echo $this->Form->create('RequestedUrl'); ?>
			<?php echo $this->Form->input('user_group_id', array('empty' => 'General', 'options' => $this->requestAction(array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'getUserGroups')))); ?>
			<?php echo $this->Form->input('controller'); ?>
			<?php echo $this->Form->input('action'); ?>
			<div class="buttons">
				<?php echo $this->Form->submit(__('   OK   ')); ?>
			</div>
		<?php echo $this->Form->end(); ?>
	</fieldset>
</div>