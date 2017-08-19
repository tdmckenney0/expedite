<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php echo $this->element('head_tag'); ?>
	<body>
		<!-- Toolbar -->
		<?php echo $this->element('toolbar'); ?>
		
		<!-- Toaster -->
		<?php echo $this->element('toaster'); ?>
		
		<!-- Main Content -->
		<div class="container">
			<div class="span-24 last content">
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		
		<!-- Loading Screen -->
		<?php echo $this->element('loading'); ?>
		
		<!-- Footer -->
		<?php echo $this->element('footer'); ?>
	</body>
</html>
