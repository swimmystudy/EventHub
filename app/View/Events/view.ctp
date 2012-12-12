<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Event');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($event['Event']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Event'); ?></dt>
			<dd>
				<?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'view', $event['Event']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Service Provider'); ?></dt>
			<dd>
				<?php echo h($event['Event']['service_provider']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Title'); ?></dt>
			<dd>
				<?php echo h($event['Event']['title']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Description'); ?></dt>
			<dd>
				<?php echo h($event['Event']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Event Url'); ?></dt>
			<dd>
				<?php echo h($event['Event']['event_url']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Started At'); ?></dt>
			<dd>
				<?php echo h($event['Event']['started_at']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Ended At'); ?></dt>
			<dd>
				<?php echo h($event['Event']['ended_at']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Place'); ?></dt>
			<dd>
				<?php echo h($event['Event']['place']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Created'); ?></dt>
			<dd>
				<?php echo h($event['Event']['created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modified'); ?></dt>
			<dd>
				<?php echo h($event['Event']['modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Event')), array('action' => 'edit', $event['Event']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Event')), array('action' => 'delete', $event['Event']['id']), null, __('Are you sure you want to delete # %s?', $event['Event']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Events')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Event')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Events')), array('controller' => 'events', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Event')), array('controller' => 'events', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Events')); ?></h3>
	<?php if (!empty($event['Event'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Event Id'); ?></th>
				<th><?php echo __('Service Provider'); ?></th>
				<th><?php echo __('Title'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th><?php echo __('Event Url'); ?></th>
				<th><?php echo __('Started At'); ?></th>
				<th><?php echo __('Ended At'); ?></th>
				<th><?php echo __('Place'); ?></th>
				<th><?php echo __('Created'); ?></th>
				<th><?php echo __('Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($event['Event'] as $event): ?>
			<tr>
				<td><?php echo $event['id'];?></td>
				<td><?php echo $event['event_id'];?></td>
				<td><?php echo $event['service_provider'];?></td>
				<td><?php echo $event['title'];?></td>
				<td><?php echo $event['description'];?></td>
				<td><?php echo $event['event_url'];?></td>
				<td><?php echo $event['started_at'];?></td>
				<td><?php echo $event['ended_at'];?></td>
				<td><?php echo $event['place'];?></td>
				<td><?php echo $event['created'];?></td>
				<td><?php echo $event['modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'events', 'action' => 'view', $event['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'events', 'action' => 'edit', $event['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'events', 'action' => 'delete', $event['id']), null, __('Are you sure you want to delete # %s?', $event['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Event')), array('controller' => 'events', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
