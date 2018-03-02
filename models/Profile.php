<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lottery_profile".
 *
 * @property string $player_uuid
 * @property string $username
 * @property string $currency
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lottery_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['player_uuid', 'username', 'currency'], 'required'],
            [['player_uuid'], 'string', 'max' => 64],
            [['username'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'player_uuid' => 'Player Uuid',
            'username' => 'Username',
            'currency' => 'Currency',
        ];
    }
}
