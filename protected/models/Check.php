<?php

/**
 * This is the model class for table "check".
 *
 * The followings are the available columns in table 'check':
 * @property integer $id
 * @property integer $channelId
 * @property integer $titleId
 * @property integer $botId
 *
 * The followings are the available model relations:
 * @property Channel $channel
 * @property Title $title
 * @property Bot   $bot
 */
class Check extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Check the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'check';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('channelId, titleId, botId', 'required'),
            array('channelId, titleId, botId', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, channelId, titleId,botId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'channel' => array(self::BELONGS_TO, 'Channel', 'channelId'),
            'title' => array(self::BELONGS_TO, 'Title', 'titleId'),
            'bot' => array(self::BELONGS_TO, 'Bot', 'BotId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'channelId' => 'Channel',
            'titleId' => 'Title',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('channelId', $this->channelId);
        $criteria->compare('titleId', $this->titleId);
        $criteria->compare('botId', $this->botId);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}