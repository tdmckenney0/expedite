<?php $this->extend('/Widgets/toolbar'); ?>

<?php $this->start('plugin-button'); ?>
	<?php echo $this->Html->link('Messages', array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'index', ''), array('class' => 'button plugin-button')); ?>
<?php $this->end(); ?>

<?php $this->start('menu'); ?>
	<?php if(!empty($this->request->data['Message'])): ?>
		<div class="breadcrumb">
			<?php echo $this->Html->link(substr($this->request->data['Message']['subject'], 0, 25), '#', array('class' => 'button expedite-menu-trigger plugin-menu')); ?>
			<ul class="expedite-menu">
				<li>
					<a href="#"><span class="ui-icon ui-icon-circle-plus"></span>Add New</a>
					<ul class="expedite-menu">
						<li><?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'ui-icon ui-icon-document')) . 'Recipient', array('plugin' => 'messages', 'controller' => 'message_recipients', 'action' => 'add', $this->request->data['Message']['id']), array('class' => 'ajax_dialog', 'escape' => false)); ?></li>
						<li><?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'ui-icon ui-icon-document')) . 'Carbon Copy', array('plugin' => 'messages', 'controller' => 'message_copies', 'action' => 'add', $this->request->data['Message']['id']), array('class' => 'ajax_dialog', 'escape' => false)); ?></li>
						<li><?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'ui-icon ui-icon-document')) . 'Blind Carbon Copy', array('plugin' => 'messages', 'controller' => 'message_blind_copies', 'action' => 'add', $this->request->data['Message']['id']), array('class' => 'ajax_dialog', 'escape' => false)); ?></li>
						<li><?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'ui-icon ui-icon-document')) . 'Attachment', array('plugin' => 'messages', 'controller' => 'message_attachments', 'action' => 'add', $this->request->data['Message']['id']), array('class' => 'ajax_dialog', 'escape' => false)); ?></li>
					</ul>
				</li>
			</ul>
		</div>
	<?php else: ?>
		<div class="breadcrumb">
			<?php echo $this->Html->link('New Message', array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'add'), array('style' => 'font-style: italic;', 'class' => 'button ajax_dialog add_new')); ?>
		</div>
	<?php endif; ?>
	
<?php $this->end(); ?>

<?php if(empty($this->request->data['Report'])): ?>
	<?php $this->assign('search-plugin', 'messages')?>
	<?php $this->assign('search-model', 'Message'); ?>
	<?php $this->assign('search-controller', 'messages'); ?>
<?php endif; ?>