<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Packing;

/**
 * PackingSearch represents the model behind the search form about `app\models\Packing`.
 */
class PackingSearch extends Packing
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'net_weight', 'measurement'], 'safe'],
            [['qty'], 'integer'],
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
        $query = Packing::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'qty' => $this->qty,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'net_weight', $this->net_weight])
            ->andFilterWhere(['like', 'measurement', $this->measurement]);

        return $dataProvider;
    }
}
