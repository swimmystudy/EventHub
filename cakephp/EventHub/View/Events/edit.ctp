<div class="row-fluid">
	<div class="span9">
		<?php echo $this->BootstrapForm->create('Event', array('class' => 'form-horizontal'));?>
			<fieldset>
				<legend><?php echo __('Edit %s', __('Event')); ?></legend>
				<?php
				echo $this->BootstrapForm->input('event_id', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('service_provider');
				echo $this->BootstrapForm->input('title');
				echo $this->BootstrapForm->input('description');
				echo $this->BootstrapForm->input('event_url');
				echo $this->BootstrapForm->input('started_at');
				echo $this->BootstrapForm->input('ended_at');
				echo $this->BootstrapForm->input('place');
				echo $this->BootstrapForm->hidden('id');
				?>
				<?php echo $this->BootstrapForm->submit(__('Submit'));?>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Event.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Event.id'))); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Events')), array('action' => 'index'));?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Events')), array('controller' => 'events', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Event')), array('controller' => 'events', 'action' => 'add')); ?></li>
		</ul>
		</div>
	</div>
</div>