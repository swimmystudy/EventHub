<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Events'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('event_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('service_provider');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('title');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('description');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('event_url');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('started_at');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('ended_at');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('place');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('created');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('modified');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($events as $event): ?>
			<tr>
				<td><?php echo h($event['Event']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'view', $event['Event']['id'])); ?>
				</td>
				<td><?php echo h($event['Event']['service_provider']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['title']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['description']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['event_url']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['started_at']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['ended_at']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['place']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['created']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['modified']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $event['Event']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $event['Event']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $event['Event']['id']), null, __('Are you sure you want to delete # %s?', $event['Event']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Event')), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Events')), array('controller' => 'events', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Event')), array('controller' => 'events', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>