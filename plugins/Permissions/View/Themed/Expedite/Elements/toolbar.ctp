<?php $this->extend('/Widgets/toolbar'); ?>

<?php $this->start('plugin-button'); ?>
	<?php echo $this->Html->link('Permissions', array('plugin' => 'permissions', 'controller' => 'requested_urls', 'action' => 'index', ''), array('class' => 'button plugin-button')); ?>
<?php $this->end(); ?>

<?php $this->start('menu'); ?>
	<div class="breadcrumb">
		<?php echo $this->Html->link('New Permission', array('plugin' => 'permissions', 'controller' => 'requested_urls', 'action' => 'add'), array('style' => 'font-style: italic;', 'class' => 'button ajax_dialog add_new')); ?>
	</div>
<?php $this->end(); ?>

<?php $this->assign('search-plugin', 'permissions')?>
<?php $this->assign('search-model', 'RequestedUrl'); ?>
<?php $this->assign('search-controller', 'requested_urls'); ?>