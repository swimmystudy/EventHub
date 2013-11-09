<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title><?php echo $title_for_layout; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
    echo $this->fetch('meta');
    echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('bootstrap-theme.min');
    echo $this->Html->css('style');
    echo $this->fetch('css');
?>
<script>
if (typeof jQuery == 'undefined') {
    document.write(unescape("%3Cscript src='/js/jquery.min.js' type='text/javascript'%3E%3C/script%3E"));
}
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-45586249-1', 'gopagoda.com');
  ga('send', 'pageview');
</script>
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
    echo $this->Html->script('bootstrap.min');
    echo $this->fetch('script');
?>
<footer>
<?php echo $this->element('sql_dump'); ?>
</footer>
</body>
</html>
