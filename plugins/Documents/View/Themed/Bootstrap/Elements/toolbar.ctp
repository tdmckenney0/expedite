<?php $this->extend('/Widgets/toolbar'); ?>

<?php $this->start('plugin-button'); ?>
	<?php echo $this->Html->link('Documents', array('plugin' => 'documents', 'controller' => 'documents', 'action' => 'index', ''), array('class' => 'button plugin-button')); ?>
<?php $this->end(); ?>

<?php $this->start('menu'); ?>
	<div class="breadcrumb">
		<?php echo $this->Html->link('New Document', array('plugin' => 'documents', 'controller' => 'documents', 'action' => 'add'), array('style' => 'font-style: italic;', 'class' => 'button ajax_dialog add_new')); ?>
	</div>
<?php $this->end(); ?>

<?php $this->assign('search-plugin', 'documents'); ?>
<?php $this->assign('search-model', 'Document'); ?>
<?php $this->assign('search-controller', 'documents'); ?>