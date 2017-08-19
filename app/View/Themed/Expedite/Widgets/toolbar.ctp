<div class="toolbar ui-widget-header ui-corner-all">
	<div class="left">
		<!-- Menu for Switching Compartments -->
		
		<div class="breadcrumb">
			<?php echo $this->Html->link("Expedite", '#', array('class' => 'button expedite-menu-trigger home-menu', 'title' => "Click here to change compartment.")); ?>
			<ul class="expedite-menu master_menu">
				<?php foreach($_plugins as $plugin): ?>
					<li><?php echo $this->Html->link($plugin, array('plugin' => strtolower($plugin), 'controller' => Inflector::tableize($plugin))); ?></li>
				<?php endforeach; ?>
				<li>&nbsp;</li>
				<li><?php echo $this->Html->link('Home' . $this->Html->tag('span', '', array('class' => 'ui-icon ui-icon-contact')), array('plugin' => false, 'controller' => 'pages', 'action' => 'display', 'home'), array('escape' => false)); ?></li>
				<li>&nbsp;</li>
				<li><?php echo $this->Html->link('Quit' . $this->Html->tag('span', '', array('class' => 'ui-icon ui-icon-power')), array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout'), array('escape' => false)); ?></li>
			</ul>
		</div>
		
		<div class="breadcrumb">
			<?php echo $this->fetch('plugin-button'); ?>
		</div>
		
		<?php echo $this->fetch('menu'); ?>
	</div>
	
	<div class="right">
		<a href="#" title="Save All" class="function save-button button expedite-form-save"><span class="ui-icon ui-icon-disk">&nbsp;</span></a>
		
		<?php $plugin = $this->fetch('search-plugin'); ?>
		
		<?php if(!empty($plugin)): ?>
			<div class="function search">
				<?php echo $this->Form->create($this->fetch('search-model'), array('url' => array('plugin' => (!empty($plugin) ? $plugin : false), 'controller' => $this->fetch('search-controller'), 'action' => 'index'), 'readonly' => false, 'override_permissions' => true)); ?>
					<?php echo $this->Form->input('search', array('value' => (!empty($search) ? $search : false), 'class' => 'search', 'div' => false, 'label' => false,'readonly' => false)); ?>
					<a href="#" class="button search_submit">
						<?php echo $this->Html->tag('span', '', array('class' => 'ui-icon ui-icon-search')); ?>
					</a>
				<?php echo $this->Form->end(); ?>
			</div>
		<?php endif; ?>
	</div>
</div>

<div class="expedite-dialog-container">
	<div class="container">
		<div class="expedite-dialog ui-widget ui-widget-content ui-corner-all">
			Hello!
		</div>
	</div>
</div>