<?php

return array(
    'components' => array(
        'errorHandler' => array(
            'class' => 'webroot.vendor.bogsey.yii-airbrake.MErrorHandler',
            'APIKey' => 'apiKey',
            'options' => array(
                'host' => 'hostName',
            ),
        ),
    ),
);
