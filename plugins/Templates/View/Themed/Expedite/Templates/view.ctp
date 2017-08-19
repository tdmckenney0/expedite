<h1><?php echo $this->request->data['Template']['name']; ?></h1>
<div class="tabs">
	<ul>
		<li><a href="#overview">Overview</a></li>
	</ul>
	
	<div id="overview">
		<?php echo $this->Form->create('Template', array('url' => array($this->request->data['Template']['id'], 'ext' => 'json'))); ?>
			<fieldset>
				<legend>Properties</legend>
				<?php echo $this->Form->input('name'); ?>
				<?php echo $this->Form->input('template_type_id'); ?>
			</fieldset>
			<?php echo $this->Form->input('body', array('div' => false, 'label' => false)); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>