<div class="span-20">
	<?php echo $this->Form->create('Message'); ?>
		<fieldset>
			<legend>Properties</legend>
			<?php echo $this->Form->input('user_id', array('label' => 'Sender', 'empty' => ' - None - ', 'options' => $this->requestAction(array('plugin' => 'users', 'controller' => 'users', 'action' => 'getAllUsers')) )); ?>
			<?php echo $this->Form->input('subject'); ?>
		</fieldset>
		<?php echo $this->Form->input('body', array('div' => false, 'label' => false)); ?>
		<div class="buttons">
			<?php echo $this->Form->submit(__('   OK   ')); ?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>