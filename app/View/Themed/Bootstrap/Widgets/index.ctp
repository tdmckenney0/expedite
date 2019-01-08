<h1><?php echo __($this->fetch('title')); ?></h1>
<?php echo $this->fetch('message'); ?>
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
			<?php ($this->fetch('status_true_label') ? $status_true_label = $this->fetch('status_true_label') : $status_true_label = 'Active');  ?>
			<?php ($this->fetch('status_false_label') ? $status_false_label = $this->fetch('status_false_label') : $status_false_label = 'Inactive');  ?>
			
			<?php echo $this->Html->link($status_true_label, array(1, $show, $search), array('class' => 'button', 'style' => (($status == 1) ? 'font-style: italic;' : '') )); ?>
			<?php echo $this->Html->link($status_false_label, array(0, $show, $search), array('class' => 'button', 'style' => (($status == 0) ? 'font-style: italic;' : ''))); ?>
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
				<?php echo $this->fetch('thead'); ?>
			</tr>
		</thead>
		<tbody class="ui-widget-content ui-corner-bottom">
			<?php echo $this->fetch('tbody'); ?>
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