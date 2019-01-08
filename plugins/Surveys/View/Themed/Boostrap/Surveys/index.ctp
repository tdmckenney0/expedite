<?php $this->extend('/Widgets/index'); ?>

<?php $this->assign('title', 'Surveys')?>
<?php $this->assign('status_true_label', 'Active')?>
<?php $this->assign('status_false_label', 'Not Active')?>

<?php $this->start('thead'); ?>

	<th><?php echo $this->Paginator->sort('name', 'Name', array('class' => "button")); ?></th>
	<th>&nbsp;</th>
	
<?php $this->end(); ?>

<?php $this->start('tbody'); ?>
	<?php foreach($this->request->data as $survey): ?>
		<tr>
			<td><?php echo $this->Html->link('Open', array('plugin' => 'surveys', 'action' => 'view', $survey['Survey']['id'], false), array('class' => 'button')); ?></td>
			<td><?php echo h($survey['Survey']['name']); ?></td>
			
			<td class="actions" style="text-align: right;">
				<a target="_blank" href="<?php echo $this->Html->url(array('plugin' => 'surveys', 'controller' => 'surveys', 'action' => 'delete', $survey['Survey']['id'], 'ext' => 'json')); ?>" class="delete button">
					<span class="ui-icon ui-icon-trash"></span>
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
<?php $this->end(); ?>