<?php
/* @var $this CheckedController */
/* @var $model Program */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'program-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'channelId'); ?>
		<?php echo $form->textField($model,'channelId'); ?>
		<?php echo $form->error($model,'channelId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'titleId'); ?>
		<?php echo $form->textField($model,'titleId'); ?>
		<?php echo $form->error($model,'titleId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startTime'); ?>
		<?php echo $form->textField($model,'startTime'); ?>
		<?php echo $form->error($model,'startTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'endTime'); ?>
		<?php echo $form->textField($model,'endTime'); ?>
		<?php echo $form->error($model,'endTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastUpdate'); ?>
		<?php echo $form->textField($model,'lastUpdate'); ?>
		<?php echo $form->error($model,'lastUpdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subTitle'); ?>
		<?php echo $form->textArea($model,'subTitle',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'subTitle'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'flag'); ?>
		<?php echo $form->textField($model,'flag'); ?>
		<?php echo $form->error($model,'flag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deleted'); ?>
		<?php echo $form->textField($model,'deleted'); ?>
		<?php echo $form->error($model,'deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'warn'); ?>
		<?php echo $form->textField($model,'warn'); ?>
		<?php echo $form->error($model,'warn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'revision'); ?>
		<?php echo $form->textField($model,'revision'); ?>
		<?php echo $form->error($model,'revision'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'allDay'); ?>
		<?php echo $form->textField($model,'allDay'); ?>
		<?php echo $form->error($model,'allDay'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->