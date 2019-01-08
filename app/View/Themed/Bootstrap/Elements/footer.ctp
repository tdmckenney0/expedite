<div class="hidden expedite-engine">
	<?php echo $this->Html->script('tinymce/tinymce.min'); ?>
	<?php echo $this->Html->script(array(
		'jquery.expediteForms',
		'main'
	)); ?>

	<?php if((boolean) AuthComponent::user()): ?>
		<?php echo $this->Html->script('session.min'); ?>
	<?php endif; ?>

	<?php echo $this->fetch('additional-engine-scripts'); ?>
</div>
