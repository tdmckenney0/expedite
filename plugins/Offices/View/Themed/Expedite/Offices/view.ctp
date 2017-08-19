<h1><?php echo h($this->request->data['Office']['city']); ?></h1>
<div class="tabs">
	<ul>
		<li><a href="#overview">Overview</a></li>
		<li><a href="#notes">Notes</a></li>
	</ul>
	
	<div id="overview">
		<?php echo $this->Form->create('Office', array('url' => array('controller' => 'offices', 'action' => 'view', 'ext' => 'json'))); ?>
			<?php echo $this->Form->input('address'); ?>
			<?php echo $this->Form->input('address_2'); ?>
			<?php echo $this->Form->input('city'); ?>
			<?php echo $this->Form->input('state', array('type' => 'state')); ?>
			<?php echo $this->Form->input('zip'); ?>
			<?php echo $this->Form->input('phone', array('type' => 'phone')); ?>
			<?php echo $this->Form->input('fax', array('type' => 'phone')); ?>
		<?php echo $this->Form->end(); ?>
	</div>
	
	<div id="notes">
		<?php echo $this->Form->create('Office', array('url' => array('controller' => 'offices', 'action' => 'view', 'ext' => 'json'))); ?>
			<?php echo $this->Form->input('notes', array('div' => false, 'label' => false)); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>