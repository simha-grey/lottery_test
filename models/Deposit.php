<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lottery_deposit".
 *
 * @property string $payment_uuid
 * @property string $player_uuid
 * @property string $processed_at
 * @property string $amount
 * @property string $currency
 */
class Deposit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lottery_deposit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_uuid', 'player_uuid', 'processed_at', 'amount', 'currency'], 'required'],
            [['processed_at'], 'safe'],
            [['amount'], 'number'],
            [['payment_uuid', 'player_uuid'], 'string', 'max' => 64],
            [['currency'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payment_uuid' => 'Payment Uuid',
            'player_uuid' => 'Player Uuid',
            'processed_at' => 'Processed At',
            'amount' => 'Amount',
            'currency' => 'Currency',
        ];
    }
}
