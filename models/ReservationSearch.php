<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reservation;

/**
 * ReservationSearch represents the model behind the search form about `app\models\Reservation`.
 */
class ReservationSearch extends Reservation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'package_item_id', 'status', 'quantity_of_guest', 'created_at', 'updated_at'], 'integer'],
            [['firstname', 'lastname', 'contact', 'email', 'check_in', 'remark', 'address'], 'safe'],
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
        $query = Reservation::find();

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
            'package_item_id' => $this->package_item_id,
            'status' => $this->status,
            'check_in' => $this->check_in,
            'quantity_of_guest' => $this->quantity_of_guest,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
