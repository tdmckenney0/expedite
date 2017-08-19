<div class="span-10">
	<?php echo $this->Form->create('MessageRecipient'); ?>
		<fieldset>
			<legend>Properties</legend>
			<?php echo $this->Form->input('email'); ?>
		</fieldset>
		<div class="buttons">
			<?php echo $this->Form->submit(__('   OK   ')); ?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>