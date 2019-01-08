<div class="templates form span-21">
	<?php echo $this->Form->create('Template', array('url' => array('ext' => 'json'))); ?>
		<fieldset>
			<legend>Properties</legend>
			<?php echo $this->Form->input('template_type_id'); ?>
			<?php echo $this->Form->input('name'); ?>
		</fieldset>
		<fieldset>
			<legend>Body</legend>
			<?php echo $this->Form->input('body', array('class' => 'body', 'div' => false, 'label' => false)); ?>
		</fieldset>
		<div class="buttons">
			<?php echo $this->Form->submit(__('   OK   ')); ?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>