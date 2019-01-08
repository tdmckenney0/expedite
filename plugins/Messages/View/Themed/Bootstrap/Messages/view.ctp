<h1><?php echo h($this->request->data['Message']['subject']); ?></h1>
<div class="tabs">
	<ul>
		<li><a href="#details">Details</a></li>	
		<li><a href="#recipients">Recipients</a></li>
		<li><a href="#copies">Carbon Copy</a></li>
		<li><a href="#blindcopies">Blind Carbon Copy</a></li>
		<li><a href="#attachments">Attachments</a></li>		
	</ul>
	
	<div id="details">
		<?php echo $this->Form->create('Message', array('url' => array($this->request->data['Message']['id'], 'ext' => 'json'))); ?>
			<fieldset>
				<legend>Properties</legend>
				<?php echo $this->Form->input('user_id', array('label' => 'Sender', 'empty' => ' - None - ', 'options' => $this->requestAction(array('plugin' => 'users', 'controller' => 'users', 'action' => 'getAllUsers')) )); ?>
				<?php echo $this->Form->input('subject'); ?>
				<?php echo $this->Form->input('sent', array('label' => 'Sent?', 'type' => 'boolean')); ?>
			</fieldset>
			<?php echo $this->Form->input('body', array('div' => false, 'label' => false)); ?>
		<?php echo $this->Form->end(); ?>
	</div>
	
	<div id="recipients">
		<table class="data">
			<thead>
				<tr>
					<th>Email</th>
					<th>Actions</th>		
				</tr>	
			</thead>
			<tbody>
				<?php foreach($this->request->data['MessageRecipient'] as $recipient): ?>
					<tr>
						<td><?php echo h($recipient['email']); ?></td>
						<td class="actions" style="text-align: right;">
							<a target="_blank" href="<?php echo $this->Html->url(array('plugin' => 'messages', 'controller' => 'message_recipients', 'action' => 'delete', $recipient['id'], 'ext' => 'json')); ?>" class="delete button">
								<span class="ui-icon ui-icon-trash"></span>
							</a>
						</td>
					</tr>	
				<?php endforeach; ?>
			</tbody>		
		</table>
	</div>
	
	<div id="copies">	
		<table class="data">
			<thead>
				<tr>
					<th>Email</th>
					<th>Actions</th>		
				</tr>	
			</thead>
			<tbody>
				<?php foreach($this->request->data['MessageCopy'] as $recipient): ?>
					<tr>
						<td><?php echo h($recipient['email']); ?></td>
						<td class="actions" style="text-align: right;">
							<a target="_blank" href="<?php echo $this->Html->url(array('plugin' => 'messages', 'controller' => 'message_copies', 'action' => 'delete', $recipient['id'], 'ext' => 'json')); ?>" class="delete button">
								<span class="ui-icon ui-icon-trash"></span>
							</a>
						</td>
					</tr>	
				<?php endforeach; ?>
			</tbody>		
		</table>
	</div>
	
	<div id="blindcopies">
		<table class="data">
			<thead>
				<tr>
					<th>Email</th>
					<th>Actions</th>		
				</tr>	
			</thead>
			<tbody>
				<?php foreach($this->request->data['MessageBlindCopy'] as $recipient): ?>
					<tr>
						<td><?php echo h($recipient['email']); ?></td>
						<td class="actions" style="text-align: right;">
							<a target="_blank" href="<?php echo $this->Html->url(array('plugin' => 'messages', 'controller' => 'message_blind_copies', 'action' => 'delete', $recipient['id'], 'ext' => 'json')); ?>" class="delete button">
								<span class="ui-icon ui-icon-trash"></span>
							</a>
						</td>
					</tr>	
				<?php endforeach; ?>
			</tbody>		
		</table>
	</div>
	
	<div id="attachments">
		<table class="data">
			<thead>
				<tr>
					<th>Email</th>
					<th>Actions</th>		
				</tr>	
			</thead>
			<tbody>
				<?php foreach($this->request->data['MessageAttachment'] as $attachment): ?>
					<tr>	
						<td><?php echo h($attachment['filename']); ?></td>
						<td class="actions" style="text-align: right;">
							<?php echo $this->Html->link('View', array('plugin' => 'documents', 'controller' => 'documents', 'action' => 'view', $attachment['filename']), array('class' => 'button')); ?>
							<a target="_blank" href="<?php echo $this->Html->url(array('plugin' => 'messages', 'controller' => 'message_attachments', 'action' => 'delete', $attachment['id'], 'ext' => 'json')); ?>" class="delete button">
								<span class="ui-icon ui-icon-trash"></span>
							</a>
						</td>
					</tr>	
				<?php endforeach; ?>
			</tbody>		
		</table>
	</div>
</div>