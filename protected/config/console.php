<?php

return CMap::mergeArray(
  require(dirname(__FILE__) . '/database.php'),
  array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',

    'preload' => array('log'),
    'import'=>array(
      'application.models.*',
      'application.components.*',
    ),

    'components' => array(
      'log' => array(
        'class' => 'CLogRouter',
        'routes' => array(
          array(
            'class' => 'CFileLogRoute',
            'levels' => 'error, warning',
          ),
        ),
      ),
    ),
  )
);
