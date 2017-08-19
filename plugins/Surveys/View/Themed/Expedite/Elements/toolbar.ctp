<?php $this->extend('/Widgets/toolbar'); ?>

<?php $this->start('plugin-button'); ?>
	<?php echo $this->Html->link('Surveys', array('plugin' => 'surveys', 'controller' => 'surveys', 'action' => 'index', ''), array('class' => 'button plugin-button')); ?>
<?php $this->end(); ?>

<?php $this->assign('search-plugin', 'surveys')?>
<?php $this->assign('search-model', 'Survey'); ?>
<?php $this->assign('search-controller', 'surveys'); ?>