<h1><?php echo h($this->request->data['SupportRequest']['title']); ?></h1>

<div class="tabs">
	<ul>
		<li><a href="#overview">Overview</a></li>
		<li><a href="#notes">Notes</a></li>
	</ul>

	<div id="overview">
		<?php if(!empty($this->request->data['SupportRequestStatus']['id'])): ?>
			<div class="<?php echo h($this->request->data['SupportRequestStatus']['css_class']); ?>">
				<em>This request is <?php echo h($this->request->data['SupportRequestStatus']['name']); ?></em>
			</div>
		<?php endif; ?>
		<fieldset>
			<legend>Actions</legend>
			<div class="buttons">
				<?php if(!empty($this->request->data['SupportRequest']['file'])): ?>
					<?php echo $this->Html->link('Download Attachment', array('plugin' => 'support', 'controller' => 'support_requests', 'action' => 'download_attachment', $this->request->data['SupportRequest']['id'] ), array('class' => 'button')); ?>
				<?php endif; ?>
			</div>
		</fieldset>
		<?php echo $this->Form->create('SupportRequest', array('readonly' => !empty($this->request->data['SupportRequest']['is_closed']), 'url' => array('ext' => 'json'))); ?>
			<fieldset>
				<legend>Description</legend>
				<?php echo $this->Form->input('description', array('div' => false, 'label' => false)); ?>
			</fieldset>

			<fieldset>
				<legend>Details</legend>
				<?php echo $this->Form->input('type_of_action'); ?>
				<?php echo $this->Form->input('support_request_type_id'); ?>
				<?php echo $this->Form->input('support_request_status_id'); ?>
				<?php echo $this->Form->input('requested_user_id', array('options' => $users)); ?>
				<?php echo $this->Form->input('title'); ?>
			</fieldset>
		<?php echo $this->Form->end(); ?>
	</div>

	<div id="notes">
		<?php echo $this->Form->create('SupportRequest', array('url' => array('ext' => 'json'))); ?>
			<?php echo $this->Form->input('notes', array('div' => false, 'label' => false)); ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
