<div class="span-10">
	<fieldset>
		<legend>Document</legend>
		<?php echo $this->Form->create('Document', array('type' => 'file')); ?>
			<?php echo $this->Form->input('File', array('type' => 'file')); ?>
			<div class="buttons">
				<?php echo $this->Form->submit(__('   OK   ')); ?>
			</div>
		<?php echo $this->Form->end(); ?>
	</fieldset>
</div>