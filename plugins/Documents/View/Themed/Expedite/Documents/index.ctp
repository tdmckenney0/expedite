<?php $this->extend('/Widgets/index'); ?>

<?php $this->assign('title', 'Documents')?>

<?php $this->start('thead'); ?>

	<th><?php echo $this->Paginator->sort('description', 'Description', array('class' => "button")); ?></th>
	<th><?php echo $this->Paginator->sort('user_id', 'Created By', array('class' => "button")); ?></th>
	<th><?php echo $this->Paginator->sort('created', 'Created On', array('class' => "button")); ?></th>
	<th><?php echo $this->Paginator->sort('usage', 'Usage', array('class' => "button")); ?></th>
	<?php if($this->Permissions->has('documents', 'delete')): ?>
		<th>&nbsp;</th>
	<?php endif; ?>
<?php $this->end(); ?>

<?php $this->start('tbody'); ?>
	<?php foreach($this->request->data as $document): ?>
		<tr>
			<td><?php echo $this->Html->link('Open', array('plugin' => 'documents', 'controller' => 'documents', 'action' => 'view', $document['Document']['filename']), array('class' => 'button')); ?></td>
			<?php if(strlen($document['Document']['description']) > 30): ?>
				<?php $document['Document']['description'] = explode('.', $document['Document']['description']); ?>
				<?php $document['Document']['description'][0] = '[' . substr($document['Document']['description'][0], 0, 30) . '...]'; ?>
				<?php $document['Document']['description'] = implode('.', $document['Document']['description']); ?>
			<?php endif; ?>
			<td style="max-width: 14em;"><?php echo h($document['Document']['description']); ?></td>
            
            <?php if(!empty($document['User']['id'])): ?>
			     <td><?php echo $this->Html->link($document['User']['fullname'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $document['User']['id']), array('class' => 'button')); ?></td>
            <?php else: ?>
                <td>Expedite</td>
            <?php endif; ?>
			<td><?php echo h($document['Document']['created']); ?></td>
			<td><?php echo h($document['Document']['usage']); ?>x</td>
			<?php if($this->Permissions->has('documents', 'delete')): ?>
				<td>
					<a target="_blank" href="<?php echo $this->Html->url(array('plugin' => 'documents', 'controller' => 'documents', 'action' => 'delete', $document['Document']['id'], 'ext' => 'json')); ?>" class="delete button">
						<span class="ui-icon ui-icon-trash"></span>
					</a>
				</td>
			<?php endif; ?>
		</tr>
	<?php endforeach; ?>
<?php $this->end(); ?>