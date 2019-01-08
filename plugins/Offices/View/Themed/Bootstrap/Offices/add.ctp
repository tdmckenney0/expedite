<div style="width: 20em;">
	<?php echo $this->Form->create('Office', array('class' => 'reload', 'url' => array('controller' => 'offices', 'action' => 'add', 'ext' => 'json'))); ?>
		<?php echo $this->Form->input('address'); ?>
		<?php echo $this->Form->input('address_2'); ?>
		<?php echo $this->Form->input('city'); ?>
		<?php echo $this->Form->input('state', array('type' => 'state')); ?>
		<?php echo $this->Form->input('zip'); ?>
		<?php echo $this->Form->input('phone'); ?>
		<?php echo $this->Form->input('fax'); ?>
		<div class="buttons">
			<?php echo $this->Form->submit(__('   OK   ')); ?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>