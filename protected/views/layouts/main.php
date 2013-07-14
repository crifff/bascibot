<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.2.0/pure-min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bascibot.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sprites.css"/>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="pure-g-r" id="layout">
	<div class="pure-u-1" id="main">

		<div class="header pure-u-1">
			<h1><?php echo CHtml::encode(Yii::app()->name); ?></h1>
		</div>

		<div class="pure-menu pure-menu-open pure-menu-horizontal">
			<?php $this->widget('zii.widgets.CMenu', array(
				'items' => array(
					array('label' => "<span class=\"icon icon-menu\"></span>ばんぐみ", 'url' => array('/program/index')),
					array('label' => "<span class=\"icon icon-heart\"></span>りすと", 'url' => array('/checked/index')),
				),'encodeLabel'=>false
			)); ?>
		</div>

		<?php echo $content; ?>

		<div class="footer">
			<?php echo Yii::powered(); ?>
		</div>


	</div>
</div>
</body>
</html>
