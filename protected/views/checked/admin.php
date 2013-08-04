<?php
/* @var $this CheckedController */
/* @var $model Program */

$this->breadcrumbs = array(
	'Programs' => array('index'),
	'Manage',
);

$this->menu = array(
	array('label' => 'List Program', 'url' => array('index')),
	array('label' => 'Create Program', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript(
	'search',
	<<<'js'
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$('#program-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
js
);
?>
<?php $this->widget(
	'zii.widgets.grid.CGridView',
	array(
		'id' => 'program-grid',
		'dataProvider' => $model->checkedSearch(),
		//	'filter' => $model,
		'columns' => array(
			//		'id',
			array('name' => 'title', 'value' => '$data->title->title'),
			array('name' => 'channel', 'value' => '$data->channel->name'),
			/*
			'subTitle',
			'flag',
			'deleted',
			'warn',
			'revision',
			'allDay',
			*/
			array(
				'class' => 'CButtonColumn',
				'template' => '{delete}',
				'deleteButtonImageUrl' => Yii::app()->request->baseUrl.'/images/cancel-circle.png',
			),
		),
		'pager' => 'application.widgets.LinkPager',
		'pagerCssClass' => 'pure-paginator',
		'summaryText' => '',
		'htmlOptions' => array('class' => 'pure-table pure-table-horizontal'),
	)
); ?>
