<h1><?php echo __('Offices'); ?></h1>
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
			<?php echo $this->Html->link('Active', array(1, $show, $search), array('class' => 'button', 'style' => (($status == 1) ? 'font-style: italic;' : '') )); ?>
			<?php echo $this->Html->link('Inactive', array(0, $show, $search), array('class' => 'button', 'style' => (($status == 0) ? 'font-style: italic;' : ''))); ?>
		</div>
		
		<?php if(!empty($search)): ?>
			<div style="padding-left: 2em; display: inline;">
				<?php echo $this->Html->link('Clear Search', array($status, $show, ''), array('class' => 'button')); ?>
			</div>
		<?php endif; ?>
	</div>
	<table>
		<thead class="ui-widget ui-widget-header ui-corner-all">
			<tr>
				<th style="text-align: center;">Sort By:</th>
				<th><?php echo $this->Paginator->sort('city', 'City', array('class' => "button")); ?></th>
				<th><?php echo $this->Paginator->sort('address', 'Address', array('class' => "button")); ?></th>
				<th><?php echo $this->Paginator->sort('phone', 'Phone', array('class' => "button")); ?></th>
				<?php if($this->Permissions->has('offices', 'delete')): ?>
					<th>&nbsp;</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody class="ui-widget-content ui-corner-bottom">
			<?php foreach ($data as $office): ?>
				<tr>
					<td class="actions"><?php echo $this->Html->link(__('Open'), array('action' => 'view', $office['Office']['id'])); ?></td>
					<td><?php echo h($office['Office']['city']); ?></td>
					<td><?php echo h($office['Office']['address']); ?>&nbsp;</td>
					<td><?php echo h($office['Office']['phone']); ?>&nbsp;</td>
					<td class="actions"style="text-align: right;">
						<a target="_blank" href="<?php echo $this->Html->url(array('action' => 'delete', $office['Office']['id'], 'ext' => 'json')); ?>" class="delete button">
							<span class="ui-icon ui-icon-trash"></span>
						</a>
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