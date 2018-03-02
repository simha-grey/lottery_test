<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lottery".
 *
 * @property string $id
 * @property int $entry_price
 * @property string $start_date
 * @property string $end_date
 */
class Lottery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */


    public static function tableName()
    {
        return 'lottery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'entry_price', 'start_date', 'end_date'], 'required'],
            [['entry_price'], 'integer'],
            [['start_date', 'end_date','currency','coef'], 'safe'],
            [['id'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entry_price' => 'Entry Price',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ];
    }

     public function findParticipants($id, $uid = false)
    {
        $user_str = empty($uid) ? '' : ' AND (lottery_deposit.player_uuid = :uid)';
        $sql = "SELECT  
            @rn:=@rn+1 AS position,
            `x`.`playerUUID`,
            `x`.`username`,
            `x`.`sumAmount`,
            `x`.`ticketCount`
            FROM (
                SELECT
                    lottery.*, 
                    lottery_ticket_price.currency,
                    lottery_ticket_price.coefficient,
                    lottery_deposit.player_uuid as playerUUID, 
                    SUM(lottery_deposit.amount) AS sumAmount, 
                    FLOOR(SUM(lottery_deposit.amount)/lottery_ticket_price.coefficient) AS ticketCount,
                    lottery_profile.username as username
                FROM lottery
                JOIN lottery_ticket_price   ON  
                    (lottery.id = lottery_ticket_price.lottery_id)AND
                    (lottery.id = :id)
                JOIN lottery_deposit    ON  
                    (processed_at BETWEEN lottery.start_date AND lottery.end_date)AND
                    (lottery_deposit.currency = lottery_ticket_price.currency)
                    {$user_str}
                JOIN lottery_profile ON 
                    (lottery_profile.player_uuid = lottery_deposit.player_uuid)AND
                    (lottery_profile.currency = lottery_deposit.currency)

                GROUP BY lottery.id, lottery_ticket_price.currency, lottery_deposit.player_uuid
                HAVING (lottery.entry_price*lottery_ticket_price.coefficient<=SUM(lottery_deposit.amount))
                ORDER BY ticketCount DESC
            ) x, 
            (SELECT @rn:=0) t2";

        if(!empty($uid)){
            return $this->findBySql( $sql, [
                ':id' => $id,
                ':uid' => $uid,
                ] )->asArray()->one();
            
        }else{
            $result = $this->findBySql( $sql, [
                ':id' => $id,
                ] )->asArray()->all();
            return ['content'=> $result, 'length' => count($result)];
        }
    }
}
