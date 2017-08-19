<div class="span-16">
	<?php echo $this->Form->create('User', array('class' => 'reload', 'url' => array('controller' => 'users', 'action' => 'add', 'ext' => 'json'))); ?>
        <fieldset>
            <legend>New User</legend>
            <div class="span-7">
                <?php echo $this->Form->input('first_name'); ?>
                <?php echo $this->Form->input('last_name'); ?>
                <?php echo $this->Form->input('email'); ?>
                <?php echo $this->Form->input('username'); ?>
                <?php echo $this->Form->input('password'); ?>
                <?php echo $this->Form->input('change_password', array('type' => 'hidden', 'value' => true)); ?>
            </div>
            <div class="span-7 last">
                <?php echo $this->Form->input('Office', array('style' => 'height: 20em;')); ?>
            </div>
        </fieldset>
		<div class="buttons">
			<?php echo $this->Form->submit(__('   OK   ')); ?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
