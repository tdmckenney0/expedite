<div class="ui-widget-content ui-widget-corner span-24" style="padding: 1em;">
	<div class="span-24">
		<h1 style="text-align: center; display: block; ">Welcome to Expedite</h1>
		<h2 style="text-align: center; display: block; ">Data Management System</h2>
	</div>
	<div class="prepend-6 span-12 append-6 last">
		<fieldset>
			<legend>Login Information</legend>
			<?php echo $this->Form->create('User', array('class' => 'no_ajax', 'show' => true, 'override_permissions' => true)); ?>
				<?php //echo $this->Form->input('username', array('options' => $users)); ?>
				<?php echo $this->Form->input('username'); ?>
				<?php echo $this->Form->input('password', array('style' => 'width: 10em;')); ?>
				<div class="buttons">
					<?php echo $this->Form->submit(__('Login')); ?>
				</div>
			<?php echo $this->Form->end(); ?>
		</fieldset>
	</div>
</div>