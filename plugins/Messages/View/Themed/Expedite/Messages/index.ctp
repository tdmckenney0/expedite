<?php $this->extend('/Widgets/index'); ?>

<?php $this->assign('title', 'Messages')?>
<?php $this->assign('status_true_label', 'Sent')?>
<?php $this->assign('status_false_label', 'Not Sent')?>

<?php $this->start('thead'); ?>

	<th><?php echo $this->Paginator->sort('subject', 'Subject', array('class' => "button")); ?></th>
	<th><?php echo $this->Paginator->sort('user_id', 'Sender', array('class' => "button")); ?></th>
	<th><?php echo $this->Paginator->sort('modified', 'Modified', array('class' => "button")); ?></th>
	<th>&nbsp;</th>
	
<?php $this->end(); ?>

<?php $this->start('tbody'); ?>
	<?php foreach($this->request->data as $message): ?>
		<tr>
			<td><?php echo $this->Html->link('View', array('plugin' => 'messages', 'action' => 'view', $message['Message']['id'], false), array('class' => 'button')); ?></td>
			<td><?php echo h($message['Message']['subject']); ?></td>
			
			<?php if(!empty($message['User']['id'])): ?>
				<td><?php echo $this->Html->link($message['User']['fullname'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $message['User']['id']), array('class' => 'button')); ?></td>
			<?php else: ?>
				<td>Expedite</td>
			<?php endif; ?>
			
			<td><?php echo $message['Message']['modified']; ?></td>
			
			<td class="actions" style="text-align: right;">
				<a target="_blank" href="<?php echo $this->Html->url(array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'delete', $message['Message']['id'], 'ext' => 'json')); ?>" class="delete button">
					<span class="ui-icon ui-icon-trash"></span>
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
<?php $this->end(); ?>