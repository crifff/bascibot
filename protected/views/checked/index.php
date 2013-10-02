<?php
/* @var $this CheckedController */
/* @var $model Program */

$this->breadcrumbs = array(
    'Programs' => array('index'),
    'Manage',
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
        'dataProvider' => $model->checkedSearch($this->bot->id),
        'columns' => array(
            array('name' => 'title', 'value' => '$data->title->title'),
            array('name' => 'channel', 'value' => '$data->channel->name'),
            array(
                'class' => 'CButtonColumn',
                'template' => '{uncheck}',
                'buttons' => array
                (
                    'uncheck' => array
                    (
                        'label' =>'<img src="'.Yii::app()->request->baseUrl . '/images/cancel-circle.png" style="width:15px"/>',
                        'url' => function ($data) use ($server, $channel) {
                            return Yii::app()->controller->createUrl(
                                "program/uncheck",
                                array(
                                    "server" => $server,
                                    "channel" => $channel,
                                    "titleId" => $data->title->id,
                                    "channelId" => $data->channel->id
                                )
                            );
                        },
                        'click' => <<<'js'
function postCheckProgram(){
    $.fn.yiiGridView.update('program-grid', {
        type:'POST',
        url:$(this).attr('href'),
        success:function() {
              $.fn.yiiGridView.update('program-grid');
        }
    });
    return false;
  }
js
                    ,
                    ),
                )
            ),
        ),
        'pager' => 'application.widgets.LinkPager',
        'pagerCssClass' => 'pure-paginator',
        'summaryText' => '',
        'htmlOptions' => array('class' => 'pure-table pure-table-horizontal'),
    )
); ?>
