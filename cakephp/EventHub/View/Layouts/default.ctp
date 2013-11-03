<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title><?php echo $title_for_layout; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
    echo $this->fetch('meta');
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('bootstrap-theme.min');
    echo $this->Html->css('style');
    echo $this->fetch('css');
?>
</head>
<body>
<div id="container" class="container">
    <header>
        <h1><?php echo $this->Html->link('Event Map', array('action' => 'index')) ?></h1>
    </header>
    <div id="content">
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
    </div>

</div>
<?php
    echo $this->Html->script('jquery.min.js');
    echo $this->Html->script('bootstrap.min');
    echo $this->fetch('script');
?>
<footer>
<?php echo $this->element('sql_dump'); ?>
</footer>>
</body>
</html>
