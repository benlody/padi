<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transfer;

/**
 * TransferSearch represents the model behind the search form about `app\models\Transfer`.
 */
class TransferSearch extends Transfer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'chinese_addr', 'english_addr', 'contact', 'tel', 'content', 'send_date', 'recv_date', 'src_warehouse', 'dst_warehouse', 'ship_type', 'shipping_info', 'extra_info'], 'safe'],
            [['status'], 'integer'],
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
        $query = Transfer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'send_date' => $this->send_date,
            'recv_date' => $this->recv_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'chinese_addr', $this->chinese_addr])
            ->andFilterWhere(['like', 'english_addr', $this->english_addr])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'src_warehouse', $this->src_warehouse])
            ->andFilterWhere(['like', 'dst_warehouse', $this->dst_warehouse])
            ->andFilterWhere(['like', 'ship_type', $this->ship_type])
            ->andFilterWhere(['like', 'shipping_info', $this->shipping_info])
            ->andFilterWhere(['like', 'extra_info', $this->extra_info]);

        return $dataProvider;
    }
}
