<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lottery_ticket_price".
 *
 * @property string $id
 * @property string $lottery_id
 * @property string $currency
 * @property int $coefficient
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lottery_ticket_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lottery_id', 'currency', 'coefficient'], 'required'],
            [['coefficient'], 'integer'],
            [['id', 'lottery_id'], 'string', 'max' => 64],
            [['currency'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lottery_id' => 'Lottery ID',
            'currency' => 'Currency',
            'coefficient' => 'Coefficient',
        ];
    }
}
