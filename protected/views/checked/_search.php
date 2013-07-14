<?php
/* @var $this CheckedController */
/* @var $model Program */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'channelId'); ?>
		<?php echo $form->textField($model,'channelId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'titleId'); ?>
		<?php echo $form->textField($model,'titleId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'startTime'); ?>
		<?php echo $form->textField($model,'startTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'endTime'); ?>
		<?php echo $form->textField($model,'endTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lastUpdate'); ?>
		<?php echo $form->textField($model,'lastUpdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subTitle'); ?>
		<?php echo $form->textArea($model,'subTitle',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'flag'); ?>
		<?php echo $form->textField($model,'flag'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deleted'); ?>
		<?php echo $form->textField($model,'deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'warn'); ?>
		<?php echo $form->textField($model,'warn'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'revision'); ?>
		<?php echo $form->textField($model,'revision'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'allDay'); ?>
		<?php echo $form->textField($model,'allDay'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->