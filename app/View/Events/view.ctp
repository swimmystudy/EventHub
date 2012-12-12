<div class="row-fluid">
	<div class="span12">
		<h2><?php echo $this->Html->link('Event Map', array('action' => 'index')) ?></h2>

		<dl class="dl-horizontal">
			<dt><?php echo __('Id'); ?></dt>
			<dd><?php echo h($event['Event']['id']); ?></dd>
			<dt><?php echo __('タイトル'); ?></dt>
			<dd><?php echo h($event['Event']['title']); ?></dd>
			<dt><?php echo __('内容'); ?></dt>
			<dd><?php echo h($event['Event']['description']); ?></dd>
			<dt><?php echo __('日時'); ?></dt>
			<dd><?php echo h($event['Event']['started_at']); ?>〜<?php echo h($event['Event']['ended_at']); ?></dd>
			<dt><?php echo __('場所'); ?></dt>
			<dd><?php echo h($event['Event']['place']); ?></dd>
			<dt><?php echo __('URL'); ?></dt>
			<dd><?php echo h($event['Event']['event_url']); ?></dd>
		</dl>

	</div>
</div>
