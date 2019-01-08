<?php $this->extend('/Widgets/toolbar'); ?>

<?php $this->start('plugin-button'); ?>
	<?php echo $this->Html->link('Templates', array('plugin' => 'templates', 'controller' => 'templates', 'action' => 'index', ''), array('class' => 'button plugin-button')); ?>
<?php $this->end(); ?>

<?php $this->start('menu'); ?>
	<?php if(!empty($this->request->data['Template'])): ?>
		<div class="breadcrumb">
			<?php echo $this->Html->link(substr($this->request->data['Template']['name'], 0, 25), '#', array('class' => 'button plugin-button')); ?>
		</div>
	<?php else: ?>
		<div class="breadcrumb">
			<?php echo $this->Html->link('New Template', array('plugin' => 'templates', 'controller' => 'templates', 'action' => 'add'), array('style' => 'font-style: italic;', 'class' => 'button ajax_dialog add_new')); ?>
		</div>
	<?php endif; ?>
<?php $this->end(); ?>

<?php $this->assign('search-plugin', 'templates')?>
<?php $this->assign('search-model', 'Template'); ?>
<?php $this->assign('search-controller', 'templates'); ?>