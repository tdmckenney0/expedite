<h1><?php echo h($this->request->data['User']['fullname']); ?></h1>
<div class="tabs">
	<ul>
		<li><a href="#overview">Overview</a></li>
		<li><a href="#permissions">Permissions</a></li>
	</ul>
	
	<div id="overview">
		<?php if(empty($this->request->data['User']['is_active'])): ?>
			<div class="notice">
				"Deleted" users are marked as inactive and are unable to login. This is for historic integrity of the database.
			</div>
		<?php endif; ?>
		<div class="span-22 last">
			<fieldset>
				<legend>Actions</legend>	
				<div class="buttons">
					<?php echo $this->Html->link('Send Email', 'mailto:' . $this->request->data['User']['email'], array('class' => 'button')); ?>
					<?php echo $this->Html->link('Call User', 'tel:' . $this->request->data['User']['phone'], array('class' => 'button')); ?>
					
					<?php if($this->Permissions->has('users', 'delete')): ?>
						<?php echo $this->Html->link('Delete User', array('plugin' => 'users', 'controller' => 'users', 'action' => 'delete', $this->request->data['User']['id'], 'ext' => 'json'), array('class' => 'button delete')); ?>
					<?php endif; ?>
				</div>
			</fieldset>
		</div>
		<div class="span-12">
			<fieldset style="min-height: 22em;">
				<legend>Identity</legend>
				<?php echo $this->Form->create('User', array('url' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $this->request->data['User']['id'], 'ext' => 'json'))); ?>
					<?php echo $this->Form->input('title'); ?>
					<?php echo $this->Form->input('username'); ?>
					<?php echo $this->Form->input('first_name'); ?>
					<?php echo $this->Form->input('last_name'); ?>
					<?php echo $this->Form->input('is_active', array('type' => 'boolean')); ?>
				<?php echo $this->Form->end(); ?>
				<?php echo $this->Form->create('User', array('type' => 'file', 'url' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'upload_image', $this->request->data['User']['id']))); ?>
					<?php echo $this->Form->input('image', array('label' => 'Profile Photo', 'type' => 'file')); ?>
				<?php echo $this->Form->end(); ?>	
			</fieldset>
		</div>
		<div class="span-10 last">
			<fieldset style="min-height: 22em;">
				<legend>Profile Photo</legend>
				<?php if(!empty($this->request->data['User']['image'])): ?>
					<img src="<?php echo $this->Html->url(array('plugin' => 'documents', 'controller' => 'documents', 'action' => 'view', $this->request->data['User']['image'])); ?>" style="vertical-align: middle; display: block; margin: auto; max-width: 250px; max-height: 250px;" />
				<?php endif; ?>
			</fieldset>
		</div>
		<div class="clear"></div>
		<div class="span-12">
			<fieldset>
				<legend>Contact Information</legend>
				<?php echo $this->Form->create('User', array('url' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $this->request->data['User']['id'], 'ext' => 'json'))); ?>
					<?php echo $this->Form->input('email'); ?>
					<?php echo $this->Form->input('phone'); ?>
					<?php echo $this->Form->input('mobile', array('type' => 'phone')); ?>
					<?php echo $this->Form->input('fax'); ?>
				<?php echo $this->Form->end(); ?>
			</fieldset>
		</div>
		<div class="span-10 last">
			<fieldset>
				<legend>Password</legend>
				<?php if(AuthComponent::user('is_superuser') || AuthComponent::user('is_manager') || AuthComponent::user('id') == $this->request->data['User']['id']): ?>
					<?php echo $this->Form->create('User', array('url' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $this->request->data['User']['id'], 'ext' => 'json'))); ?>
						<?php echo $this->Form->input('password', array('value' => false)); ?>
						<?php echo $this->Form->input('change_password', array('type' => 'boolean', 'label' => "Change Password?")); ?>
					<?php echo $this->Form->end(); ?>
				<?php else: ?>
					<div class="notice">You cannot change this password.</div>
				<?php endif; ?>
			</fieldset>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	
	<div id="permissions">
		<?php echo $this->Form->create('User', array('url' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $this->request->data['User']['id'], 'ext' => 'json'))); ?>
            <div class="accordion">
                <h3>Superuser Property</h3>
                <div class="permission">
                    <div class="span-2 border">
                        <?php echo $this->Form->input('is_superuser', array('type' => 'boolean', 'div' => false, 'label' => false)); ?>
                    </div>
                    <div class="push-1 span-18">
                        <p>The <strong>superuser</strong> property overwrites all group-based permissions and grants access to the entire system.</p>
                    </div>
                </div>
                
                <h3>Manager Property</h3>
                <div class="permission">
                    <div class="span-2 border">
                        <?php echo $this->Form->input('is_manager', array('type' => 'boolean', 'div' => false, 'label' => false)); ?>
                    </div>
                    <div class="push-1 span-18">
                        <p>The <strong>manager</strong> property assigns special characteristics to a user.</p>
                    </div>
                </div>
                
                <h3>Offices</h3>
                <div>
                    <div class="span-7 border">
                        <?php echo $this->Form->input('Office', array('div' => false, 'label' => false, 'style' => 'min-height: 28em;', 'options' => $this->requestAction(array('plugin' => 'offices', 'controller' => 'offices', 'action' => 'getList')) )); ?>
                    </div>
                    <div class="push-1 span-13">
                        <h4>About Offices</h4>
                        <p>
                            Offices are assigned to users to prevent users from accessing information thats not associated with their office. 
                        </p>
                    </div>
                </div>
                
                <!-- Groups -->
                <h3>Permission Groups</h3>
                <div>
                    <div class="span-7 border">
                        <?php echo $this->Form->input('UserGroup', array('div' => false, 'label' => false, 'style' => 'height: 22em;')); ?>
                    </div>
                    <div class="push-1 span-13">
                        <h4>About Groups</h4>
                        <p>
                            By default, a user added to the system is a <strong>General</strong> user. This means a 
                            user has read-only permissions for the system and cannot access restricted
                            areas. Assigning the <strong>Superuser</strong> property to a user allows full access to
                            the system (including restricted areas) regardless of the groups to which said user belongs. 
                        </p>
                        <p>
                            By choosing the groups to the left, areas of the application are unlocked for said user to manipulate.
                            These permissions are non-degrading. Meaning: Restricted permissions in one group, do not apply if the user belongs to another group 
                            which allow access to those permissions. E.g. The <strong>Distributions</strong> group can update the distributions compartment, but <strong>Administrators</strong> are denied,
                            However, if a User belongs to <strong>Administrators</strong> and <strong>Distributions</strong>, then <strong>Distributions</strong> can be accessed. 
                        </p>
                        <p>
                            The permissions &amp; groups system can only be configured by a Systems Engineer at this time. Please contact your department supervisor for questions.
                        </p>
                    </div>
                </div>
            </div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>