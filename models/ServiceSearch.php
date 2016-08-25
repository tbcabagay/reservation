<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Service;

/**
 * ServiceSearch represents the model behind the search form of `app\models\Service`.
 */
class ServiceSearch extends Service
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'transaction_id', 'spa_id', 'quantity', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount', 'total'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Service::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'spa_id' => $this->spa_id,
            'quantity' => $this->quantity,
            'amount' => $this->amount,
            'total' => $this->total,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
