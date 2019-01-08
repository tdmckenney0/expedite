<div class="span-10">
	<fieldset>
		<legend>Upload Attachment</legend>
		<?php echo $this->Form->create('MessageAttachment', array('type' => 'file')); ?>
			<?php echo $this->Form->input('filename', array('type' => 'file')); ?>
			<div class="buttons">
				<?php echo $this->Form->submit(__('   OK   ')); ?>
			</div>
		<?php echo $this->Form->end(); ?>
	</fieldset>
</div>