<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AssembleOrder;

/**
 * AssembleOrderSearch represents the model behind the search form about `app\models\AssembleOrder`.
 */
class AssembleOrderSearch extends AssembleOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'assemble', 'date', 'done_date', 'warehouse', 'extra_info'], 'safe'],
            [['status', 'qty'], 'integer'],
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
        $query = AssembleOrder::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'date' => $this->date,
            'done_date' => $this->done_date,
            'status' => $this->status,
            'qty' => $this->qty,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'assemble', $this->assemble])
            ->andFilterWhere(['like', 'warehouse', $this->warehouse])
            ->andFilterWhere(['like', 'extra_info', $this->extra_info]);

        return $dataProvider;
    }
}
