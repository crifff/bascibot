<?php
/* @var $this CheckedController */
/* @var $data Program */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('channelId')); ?>:</b>
	<?php echo CHtml::encode($data->channelId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('titleId')); ?>:</b>
	<?php echo CHtml::encode($data->titleId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('startTime')); ?>:</b>
	<?php echo CHtml::encode($data->startTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('endTime')); ?>:</b>
	<?php echo CHtml::encode($data->endTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastUpdate')); ?>:</b>
	<?php echo CHtml::encode($data->lastUpdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subTitle')); ?>:</b>
	<?php echo CHtml::encode($data->subTitle); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('flag')); ?>:</b>
	<?php echo CHtml::encode($data->flag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deleted')); ?>:</b>
	<?php echo CHtml::encode($data->deleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('warn')); ?>:</b>
	<?php echo CHtml::encode($data->warn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('revision')); ?>:</b>
	<?php echo CHtml::encode($data->revision); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allDay')); ?>:</b>
	<?php echo CHtml::encode($data->allDay); ?>
	<br />

	*/ ?>

</div>