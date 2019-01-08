<div class="toasts ui-widget ui-widget-content ui-corner-all">
	<?php if(StackMessagesComponent::exists()): ?>
		<?php $msgs = StackMessagesComponent::flush(); ?>
		<?php foreach($msgs as $msg): ?>
			<div class="<?php echo $msg['type']; ?>">
				<?php echo $msg['message']; ?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>