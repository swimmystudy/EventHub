<div class="row-fluid">
	<div class="span12">
		<h2><?php echo $this->Html->link('Event Map', array('action' => 'index')) ?></h2>

		<?php echo $this->Form->create('Event', array('action'=>'index', 'class' => 'form-horizontal')); ?>
		<fieldset>
			<legend>検索条件</legend>
			<div class="control-group">
				<?php echo $this->Form->label('keyword', 'キーワード', array('class' => 'control-label')); ?>
				<div class="controls">
				<?php echo $this->Form->text('keyword'); ?>
				<?php
					$options = array('and' => 'AND', 'or' => 'OR');
					$attributes = array('default' => 'and', 'class' => 'radio inline');
					echo $this->Form->radio('andor', $options, $attributes);
				?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $this->Form->label('Event.from', '対象期間', array('class' => 'control-label')); ?>
				<div class="controls">
				<?php echo $this->Form->text('from'); ?>
				<?php echo $this->Form->text('to'); ?>
				<?php echo $this->Form->error('from'); ?>
				<?php echo $this->Form->error('to'); ?>
				</div>
			</div>
			<?php echo $this->Form->input('service_provider_id', array('label' => '対象サービス', 'multiple' => 'checkbox', 'default' => array_keys($serviceProviders), 'class' => 'checkbox inline')); ?>
		</fieldset>
		<?php echo $this->Form->end('検索'); ?>

		<table class="table table-hover table-bordered">
			<tr>
				<th><?php echo $this->Paginator->sort('id', 'ID');?></th>
				<th><?php echo $this->Paginator->sort('title', 'イベント名');?></th>
				<th><?php echo $this->Paginator->sort('started_at', '開始日');?></th>
				<th><?php echo $this->Paginator->sort('ended_at', '終了日');?></th>
			</tr>
		<?php foreach ($events as $event): ?>
			<tr>
				<td><?php echo h($event['Event']['id']); ?></td>
				<td><?php echo $this->Html->link(h($event['Event']['title']), array('action' => 'view', $event['Event']['id'])); ?></td>
				<td><?php echo h($event['Event']['started_at']); ?></td>
				<td><?php echo h($event['Event']['ended_at']); ?></td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->Paginator->pagination(); ?>
	</div>
</div>


<?php
$this->Html->css('http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css', null, array('block' => 'css'));
$this->Html->script(
	array('http://code.jquery.com/ui/1.9.1/jquery-ui.js',
		'http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js'),
	array('block' => 'script')
);
?>
<?php $this->start('script'); ?>
<script>
$(function() {
	$("#EventFrom").datepicker({
		defaultDate: "+1w",
		changeMonth: false,
		numberOfMonths: 2,
		dateFormat: "yy-mm-dd",
		showOtherMonths: true,
		selectOtherMonths: true,
		onClose: function(s) {
			if (s) {
				$("#EventTo").datepicker("option", "minDate", s).focus();
			}
		}
	});
	$("#EventTo").datepicker({
		defaultDate: "+1w",
		changeMonth: false,
		numberOfMonths: 2,
		dateFormat: "yy-mm-dd",
		showOtherMonths: true,
		selectOtherMonths: true,
		onClose: function(s) {
			$("#EventFrom").datepicker("option", "maxDate", s);
		}
	});
});
</script>
<?php $this->end(); ?>
