<h1>Welcome to Expedite</h1>

<div class="info">
	<em>Please choose a module below to get started.</em>
</div>

<fieldset>
	<legend>Actions</legend>
	<div class="buttons">
		<?php foreach($_plugins as $plugin): ?>
			<?php echo $this->Html->link($plugin, array('plugin' => strtolower($plugin), 'controller' => Inflector::tableize($plugin)), array('class' => 'button')); ?>
		<?php endforeach; ?>
	</div>
</fieldset>	