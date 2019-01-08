<?php $this->extend('/Widgets/toolbar'); ?>

<?php $this->start('plugin-button'); ?>
	<?php echo $this->Html->link('Offices', array('plugin' => 'offices', 'controller' => 'offices', 'action' => 'index', ''), array('class' => 'button plugin-button')); ?>
<?php $this->end(); ?>

<?php $this->start('menu'); ?>
	<?php if(!empty($this->request->data['Office'])): ?>
		<div class="breadcrumb">
			<?php echo $this->Html->link(substr($this->request->data['Office']['name'], 0, 25), '#', array('class' => 'button expedite-menu-trigger plugin-menu')); ?>
			<ul class="expedite-menu">
				<li><a href="<?php echo $this->Html->url(array('plugin' => 'offices', 'controller' => 'offices', 'action' => 'view', $this->request->data['Office']['id'], '#overview')); ?>"><span class="ui-icon ui-icon-lightbulb"></span>Overview</a></li>
				<li><a href="<?php echo $this->Html->url(array('plugin' => 'offices', 'controller' => 'offices', 'action' => 'view', $this->request->data['Office']['id'], '#notes')); ?>"><span class="ui-icon ui-icon-contact"></span>Notes</a></li>
			</ul>
		</div>
	<?php else: ?>
		<div class="breadcrumb">
			<?php echo $this->Html->link('New Office', array('plugin' => 'offices', 'controller' => 'offices', 'action' => 'add'), array('style' => 'font-style: italic;', 'class' => 'button ajax_dialog add_new')); ?>
		</div>
	<?php endif; ?>
<?php $this->end(); ?>

<?php $this->assign('search-plugin', 'offices')?>
<?php $this->assign('search-model', 'Office'); ?>
<?php $this->assign('search-controller', 'offices'); ?>