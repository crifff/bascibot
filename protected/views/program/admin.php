<?php
/* @var $this ProgramController */
/* @var $model Program */

$this->breadcrumbs = array(
	'Programs' => array('index'),
	'Manage',
);

$this->menu = array(
	array('label' => 'List Program', 'url' => array('index')),
	array('label' => 'Create Program', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').keyup(function(){
	$('#program-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Programs</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'program-grid',
	'dataProvider' => $model->search(), 'filter' => $model, 'columns' => array(
		//		array('name' => 'category', 'value' => '$data->title->category'),
		array('name' => '', 'value' => '$data->check?"✔":""', 'filter' => false),
		array('name' => 'title', 'value' => '$data->title->title'),
		array('name' => 'channel', 'value' => '$data->channel->name'),
//		'startTime',
		array
		(
			'class' => 'CButtonColumn',
			'template' => '{check}{uncheck}',
			'buttons' => array
			(
				'check' => array
				(
					'label' => '[+]',
					'url' => 'Yii::app()->controller->createUrl("check",array("titleId"=>$data->title->id,"channelId"=>$data->channel->id))',
					'click' => "function(){
    $.fn.yiiGridView.update('program-grid', {
        type:'POST',
        url:$(this).attr('href'),
        success:function(data) {
              $.fn.yiiGridView.update('program-grid');
        }
    })
    return false;
  }
",
					'visible' => '!$data->check'
				),
				'uncheck' => array
				(
					'label' => '[-]',
					'url' => 'Yii::app()->controller->createUrl("uncheck",array("titleId"=>$data->title->id,"channelId"=>$data->channel->id))',
					'click' => "function(){
    $.fn.yiiGridView.update('program-grid', {
        type:'POST',
        url:$(this).attr('href'),
        success:function(data) {
              $.fn.yiiGridView.update('program-grid');
        }
    })
    return false;
  }
",
					'visible' => '$data->check'
				),
			),
		),
	)));?>
