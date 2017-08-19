<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php echo $this->element('head_tag'); ?>
	<body style="background-color: #dcdcdc;">
		<div class="container">
			<div class="span-24 content">
				<noscript>
					<div class="span-24 error">
						<p>You must have scripting enabled to use Expedite.</p>
					</div>
				</noscript>
				<?php if($msg = $this->Session->flash()): ?>
					<div class="span-24">
						<div class="notice"><?php echo $msg; ?></div>
					</div>
				<?php endif; ?>
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<!-- Footer -->
		<?php echo $this->element('footer'); ?>
	</body>
</html>
