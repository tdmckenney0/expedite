<?php $this->extend('/Widgets/toolbar'); ?>

<?php $this->start('plugin-button'); ?>
	<?php echo $this->Html->link('Users', array('plugin' => 'users', 'controller' => 'users', 'action' => 'index', ''), array('class' => 'button plugin-button')); ?>
<?php $this->end(); ?>

<?php $this->start('menu'); ?>
	<?php if(!empty($this->request->data['User'])): ?>
		<div class="breadcrumb">
			<?php echo $this->Html->link(substr($this->request->data['User']['fullname'], 0, 25), '#', array('class' => 'button expedite-menu-trigger plugin-menu')); ?>
			<ul class="expedite-menu">
				<li><a href="<?php echo $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $this->request->data['User']['id'], '#overview')); ?>"><span class="ui-icon ui-icon-lightbulb"></span>Overview</a></li>
				<li><a href="<?php echo $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $this->request->data['User']['id'], '#groups')); ?>"><span class="ui-icon ui-icon-contact"></span>Groups</a></li>
			</ul>
		</div>
	<?php else: ?>
		<div class="breadcrumb">
			<?php echo $this->Html->link('New User', array('plugin' => 'users', 'controller' => 'users', 'action' => 'add'), array('style' => 'font-style: italic;', 'class' => 'button ajax_dialog add_new')); ?>
		</div>
	<?php endif; ?>
<?php $this->end(); ?>

<?php $this->assign('search-plugin', 'users')?>
<?php $this->assign('search-model', 'User'); ?>
<?php $this->assign('search-controller', 'users'); ?>