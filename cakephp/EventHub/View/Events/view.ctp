<div class="row-fluid">
    <div class="span12">

        <dl class="dl-horizontal">
            <dt><?php echo __('Id'); ?></dt>
            <dd><?php echo h($event['Event']['id']); ?></dd>
            <dt><?php echo __('タイトル'); ?></dt>
            <dd><?php echo h($event['Event']['title']); ?></dd>
            <dt><?php echo __('内容'); ?></dt>
            <dd><?php echo $event['Event']['description']; ?></dd>
            <dt><?php echo __('日時'); ?></dt>
            <dd><?php echo h($event['Event']['started_at']); ?>〜<?php echo h($event['Event']['ended_at']); ?></dd>
            <dt><?php echo __('場所'); ?></dt>
            <dd><?php echo h($event['Event']['place']); ?></dd>
            <dt><?php echo __('URL'); ?></dt>
            <dd></dd>
        </dl>
        <div>
            <a target="_blank" class="btn btn-primary" href="<?php echo h($event['Event']['event_url']); ?>">
            イベントサイトへ
            </a>
        </div>
    </div>
</div>
