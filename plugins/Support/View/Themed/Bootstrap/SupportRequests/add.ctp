<div style="width: 60em;">
	<?php echo $this->Form->create('SupportRequest', array('type' => 'file')); ?>
		<fieldset>
			<legend>Details</legend>
			<?php echo $this->Form->input('type_of_action'); ?>
			<?php echo $this->Form->input('support_request_type_id'); ?>
			<?php echo $this->Form->input('support_request_status_id', array('value' => 1)); ?>
			<?php echo $this->Form->input('requested_user_id', array('options' => $users, 'value' => AuthComponent::user('id'))); ?>
			<?php echo $this->Form->input('title'); ?>
		</fieldset>

		<!-- <fieldset>
			<legend>Attachments</legend>
			<?php echo $this->Form->input('file', array('type' => 'file')); ?>
		</fieldset> -->

		<?php echo $this->Form->input('description', array('type' => 'textarea', 'class' => 'description', 'div' => false, 'label' => false)); ?>

		<div class="buttons">
			<?php echo $this->Form->submit(__('   OK   ')); ?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
