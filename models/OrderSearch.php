<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form about `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'customer_name', 'chinese_addr', 'english_addr', 'region', 'contact', 'tel', 'content', 'date', 'done_date', 'warehouse', 'shipping_info', 'extra_info'], 'safe'],
            [['ship_type', 'status'], 'integer'],
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
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ship_type' => $this->ship_type,
            'date' => $this->date,
            'done_date' => $this->done_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'customer_id', $this->customer_id])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'chinese_addr', $this->chinese_addr])
            ->andFilterWhere(['like', 'english_addr', $this->english_addr])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'warehouse', $this->warehouse])
            ->andFilterWhere(['like', 'shipping_info', $this->shipping_info])
            ->andFilterWhere(['like', 'extra_info', $this->extra_info]);

        return $dataProvider;
    }

    public function mysearch($params)
    {
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 300,
            ],
        ]);

        $contents = explode(',',$params['content']);

        $query->andFilterWhere(['like', 'id', $params['id']])
            ->andFilterWhere(['like', 'customer_id', $params['customer_id']])
            ->andFilterWhere(['like', 'customer_name', $params['customer_name']])
            ->andFilterWhere(['or', ['like', 'chinese_addr', $params['addr']], ['like', 'english_addr', $params['addr']]]);

        foreach ($contents as $content) {
            $query->andFilterWhere(['like', 'content', $content]);
        }

        $query->addOrderBy('date DESC');

        return $dataProvider;
    }

}
