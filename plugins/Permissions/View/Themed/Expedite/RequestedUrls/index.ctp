<?php $this->extend('/Widgets/index'); ?>

<?php $this->assign('title', 'Permissions')?>

<?php $this->start('thead'); ?>

	<th><?php echo $this->Paginator->sort('user_group_id', 'Group Name', array('class' => "button")); ?></th>
	<th><?php echo $this->Paginator->sort('controller', 'Controller', array('class' => "button")); ?></th>
	<th><?php echo $this->Paginator->sort('action', 'Action', array('class' => "button")); ?></th>
	<th>&nbsp;</th>
	
<?php $this->end(); ?>

<?php $this->start('tbody'); ?>
	<?php foreach($this->request->data as $requestedurl): ?>
		<tr>
			<td><?php echo $this->Html->link('Edit', array('plugin' => 'permissions', 'controller' => 'requested_urls', 'action' => 'edit', $requestedurl['RequestedUrl']['id']), array('class' => 'ajax_dialog button')); ?></td>
			
			<?php if(!empty($requestedurl['RequestedUrl']['user_group_id'])): ?>
				<td><?php echo h($requestedurl['UserGroup']['name']); ?></td>
			<?php else: ?>
				<td>General</td>
			<?php endif; ?>
			
			<td><?php echo h('/' . $requestedurl['RequestedUrl']['controller']); ?></td>
			<td><?php echo h('/' . $requestedurl['RequestedUrl']['action']); ?></td>
			
			<td class="actions" style="text-align: right;">
				<a target="_blank" href="<?php echo $this->Html->url(array('plugin' => 'permissions', 'controller' => 'requested_urls', 'action' => 'delete', $requestedurl['RequestedUrl']['id'], 'ext' => 'json')); ?>" class="delete button">
					<span class="ui-icon ui-icon-trash"></span>
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
<?php $this->end(); ?>