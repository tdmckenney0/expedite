<?php $this->extend('/Widgets/toolbar'); ?>

<?php $this->start('plugin-button'); ?>
	<?php echo $this->Html->link('Surveys', array('plugin' => 'surveys', 'controller' => 'surveys', 'action' => 'index', ''), array('class' => 'button plugin-button')); ?>
<?php $this->end(); ?>

<?php $this->start('menu'); ?>
	<?php if(!empty($this->request->data['Survey'])): ?>
		<div class="breadcrumb">
			<?php echo $this->Html->link(substr($this->request->data['Survey']['name'], 0, 25), '#', array('class' => 'button expedite-menu-trigger plugin-menu')); ?>
			<!-- <ul class="expedite-menu">
				<li><a href="<?php echo $this->Html->url(array('plugin' => 'surveys', 'controller' => 'surveys', 'action' => 'view', $this->request->data['Survey']['id'], '#overview')); ?>"><span class="ui-icon ui-icon-lightbulb"></span>Overview</a></li>
				<li><a href="<?php echo $this->Html->url(array('plugin' => 'surveys', 'controller' => 'surveys', 'action' => 'view', $this->request->data['Survey']['id'], '#notes')); ?>"><span class="ui-icon ui-icon-contact"></span>Notes</a></li>
			</ul> -->
		</div>
	<?php else: ?>
		<div class="breadcrumb">
			<?php echo $this->Html->link('New Survey', array('plugin' => 'surveys', 'controller' => 'surveys', 'action' => 'add'), array('style' => 'font-style: italic;', 'class' => 'button ajax_dialog add_new')); ?>
		</div>
	<?php endif; ?>
<?php $this->end(); ?>

<?php $this->assign('search-plugin', 'surveys')?>
<?php $this->assign('search-model', 'Survey'); ?>
<?php $this->assign('search-controller', 'surveys'); ?>
