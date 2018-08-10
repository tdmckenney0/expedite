<h1><?php echo __('Support Requests'); ?></h1>
<div class="ui-widget ui-corner-all ui-widget-content">
	<div class="ui-widget ui-widget-header ui-corner-all" style="padding: 1em;">
		<div style="display: inline;">
			<span>Show: </span>
			<?php $counts = array(10, 25, 50, 100); ?>
			<?php foreach($counts as $count): ?>
				<?php echo $this->Html->link($count, array($status, $count, $search), array('class' => 'button', 'style' => (($show == $count) ? 'font-style: italic;' : ''))); ?>
			<?php endforeach; ?>
		</div>
		<div style="padding-left: 2em; display: inline;">
			<span>Status: </span>
			<?php foreach($supportRequestStatuses as $id => $name): ?>
				<?php echo $this->Html->link($name, array($id, $show, $search), array('class' => 'button', 'style' => (($status == $id) ? 'font-style: italic;' : ''))); ?>
			<?php endforeach; ?>
		</div>

		<?php if(!empty($search) || !empty($status)): ?>
			<div style="padding-left: 2em; display: inline;">
				<?php echo $this->Html->link('Clear Search', array(0, $show, ''), array('class' => 'button')); ?>
			</div>
		<?php endif; ?>
	</div>
	<table class="no-stripe">
		<thead class="ui-widget ui-widget-header ui-corner-all">
			<tr>
				<th style="text-align: center;">Sort By:</th>
				<th style="width: 18em !important;"><?php echo $this->Paginator->sort('title', 'Name', array('class' => "button")); ?></th>
				<th><?php echo $this->Paginator->sort('support_request_type_id', 'Type', array('class' => "button")); ?></th>
				<th><?php echo $this->Paginator->sort('support_request_status_id', 'Status', array('class' => "button")); ?></th>
				<th><?php echo $this->Paginator->sort('requested_user_id', 'Created By', array('class' => "button")); ?></th>
				<th><?php echo $this->Paginator->sort('type_of_action', 'Action Needed', array('class' => "button")); ?></th>
				<th><?php echo $this->Paginator->sort('created', 'Created', array('class' => "button")); ?></th>
				<?php if($this->Permissions->has('support_requests', 'delete')): ?>
					<th>&nbsp;</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody class="ui-widget-content ui-corner-bottom">
			<?php foreach ($data as $ticket): ?>
				<tr class="<?php echo h($ticket['SupportRequestStatus']['css_class']); ?>">
					<td class="actions"><?php echo $this->Html->link(__('Open'), array('action' => 'view', $ticket['SupportRequest']['id'])); ?></td>
					<td><?php echo h($ticket['SupportRequest']['title']); ?></td>
					<td><?php echo h($ticket['SupportRequestType']['name']); ?>&nbsp;</td>
					<td><?php echo h($ticket['SupportRequestStatus']['name']); ?>&nbsp;</td>
					<td><?php echo $this->Html->link($ticket['User']['name'], array(' plugin ' => 'users', 'controller' => 'users', 'action' => 'view', $ticket['User']['id']), array('class' => 'button', 'target' => '_blank')); ?>&nbsp;</td>
					<td><?php echo h($ticket['SupportRequest']['type_of_action']); ?>&nbsp;</td>
					<td><?php echo h($ticket['SupportRequest']['created']); ?>&nbsp;</td>
					<td class="actions" style="text-align: right;">
						<?php if($this->Permissions->has('support_requests', 'delete')): ?>
							<a href="<?php echo $this->Html->url(array('plugin' => 'support', 'controller' => 'support_requests', 'action' => 'delete', $ticket['SupportRequest']['id'], 'ext' => 'json')); ?>" class="delete button">
								<span class="ui-icon ui-icon-trash"></span>
							</a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="buttons">
		<?php echo $this->Paginator->first('<< First', array('class' => "button")); ?>
		<?php echo $this->Paginator->prev('< Previous', array('class' => "button"), null, array('class' => "button", 'disabledTag' => 'a')); ?>
		<?php echo $this->Paginator->numbers(array('currentTag' => "a", 'separator' => '   ', 'class' => "button")); ?>
		<?php echo $this->Paginator->next('Next >', array('class' => "button"), null, array('class' => "button", 'disabledTag' => 'a')); ?>
		<?php echo $this->Paginator->last('Last >>', array('class' => "button")); ?>
	</div>
	<div class="buttons">
		<?php echo $this->Paginator->counter(array('format' => 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')); ?>
	</div>
</div>
