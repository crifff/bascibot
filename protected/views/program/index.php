<?php
/* @var $this ProgramController */
/* @var $model Program */

Yii::app()->clientScript->registerScript(
    'search',
    <<<'js'
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
js
);
?>
<?php $this->widget(
    'zii.widgets.grid.CGridView',
    array(
        'id' => 'program-grid',
        'dataProvider' => $model->search($this->bot->id),
        'filter' => $model,
        'columns' => array(
            //		array('name' => 'category', 'value' => '$data->title->category'),
            //		array('name' => '', 'value' => '$data->check?"✔":""', 'filter' => false, 'htmlOptions' => array('class' => 'item-checked')),
            array('name' => 'title', 'value' => '$data->title->title', 'htmlOptions' => array('class' => 'item-title')),
            array(
                'name' => 'channel',
                'value' => '$data->channel->name',
                'htmlOptions' => array('class' => 'item-channel')
            ),
            //		'startTime',
            array
            (
                'class' => 'CButtonColumn',
                'template' => '{check}{uncheck}',
                'buttons' => array
                (
                    'check' => array
                    (
                        'label' => '<span class="icon-checkbox-unchecked"></span>',
                        'url' => function ($data) use ($server, $channel) {
                            return Yii::app()->controller->createUrl(
                                "check",
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
                        'visible' => function ($key, Program $data) use ($botId) {
                            return !Check::model()->findByAttributes(
                                array('botId' => $botId, 'titleId' => $data->titleId, 'channelId' => $data->channelId)
                            );
                        }
                    ),
                    'uncheck' => array
                    (
                        'label' => '<span class="icon-checkbox-checked"></span>',
                        'url' => function ($data) use ($server, $channel) {
                            return Yii::app()->controller->createUrl(
                                "uncheck",
                                array(
                                    "server" => $server,
                                    "channel" => $channel,
                                    "titleId" => $data->title->id,
                                    "channelId" => $data->channel->id
                                )
                            );
                        },
                        'click' => <<<'js'
function postUnCheckProgram(){
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
                        'visible' => function ($key, Program $data) use ($botId) {
                            return Check::model()->findByAttributes(
                                array('botId' => $botId, 'titleId' => $data->titleId, 'channelId' => $data->channelId)
                            );
                        }
                    ),
                ),
            ),
        ),
        'pager' => 'application.widgets.LinkPager',
        'pagerCssClass' => 'pure-paginator',
        'summaryText' => '',
        'htmlOptions' => array('class' => 'pure-table pure-table-horizontal'),
    )
);?>
