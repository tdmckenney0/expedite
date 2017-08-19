<?php $this->extend('/Widgets/toolbar'); ?>

<?php $this->start('plugin-button'); ?>
	<?php echo $this->Html->link('Support', array('plugin' => 'support', 'controller' => 'support_requests', 'action' => 'index', ''), array('class' => 'button plugin-button')); ?>
<?php $this->end(); ?>

<?php $this->start('menu'); ?>
	<?php if(!empty($this->request->data['SupportRequest'])): ?>
		<div class="breadcrumb">
			<?php echo $this->Html->link(substr($this->request->data['SupportRequest']['name'], 0, 25), '#', array('class' => 'button expedite-menu-trigger plugin-menu')); ?>
			<ul class="expedite-menu">
				<li><a href="<?php echo $this->Html->url(array('plugin' => 'support', 'controller' => 'support_requests', 'action' => 'view', $this->request->data['SupportRequest']['id'], '#overview')); ?>"><span class="ui-icon ui-icon-lightbulb"></span>Overview</a></li>
				<li><a href="<?php echo $this->Html->url(array('plugin' => 'support', 'controller' => 'support_requests', 'action' => 'view', $this->request->data['SupportRequest']['id'], '#notes')); ?>"><span class="ui-icon ui-icon-contact"></span>Notes</a></li>
			</ul>
		</div>
	<?php else: ?>
		<div class="breadcrumb">
			<?php echo $this->Html->link('New Request', array('plugin' => 'support', 'controller' => 'support_requests', 'action' => 'add'), array('style' => 'font-style: italic;', 'class' => 'button ajax_dialog add_new')); ?>
		</div>
	<?php endif; ?>
<?php $this->end(); ?>

<?php $this->assign('search-plugin', 'support')?>
<?php $this->assign('search-model', 'SupportRequest'); ?>
<?php $this->assign('search-controller', 'support_requests'); ?>