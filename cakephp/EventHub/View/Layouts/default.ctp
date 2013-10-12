<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title><?php echo $title_for_layout; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		echo $this->fetch('meta');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-responsive.min');
		echo $this->fetch('css');
	?>
</head>
<body>
	<div id="container" class="container">
		<div id="header">
			<?php echo $this->Session->flash(); ?>
		</div>

		<div id="content">
			<?php echo $this->fetch('content'); ?>
		</div>

		<div id="footer">
			<?php echo $this->element('sql_dump'); ?>
		</div>
	</div>
	<?php
		echo $this->Html->script('jquery.min.js');
		echo $this->Html->script('bootstrap.min');
		echo $this->fetch('script');
	?>
</body>
</html>
