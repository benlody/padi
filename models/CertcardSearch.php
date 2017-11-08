<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Certcard;

/**
 * CertcardSearch represents the model behind the search form about `app\models\Certcard`.
 */
class CertcardSearch extends Certcard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'small_box', 'orig_fee', 'req_fee'], 'integer'],
            [['t_send_date', 'DHL', 'tracking', 's_recv_date', 'extra_info'], 'safe'],
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
        $query = Certcard::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            't_send_date' => $this->t_send_date,
            'small_box' => $this->small_box,
            's_recv_date' => $this->s_recv_date,
            'orig_fee' => $this->orig_fee,
            'req_fee' => $this->req_fee,
        ]);

        $query->andFilterWhere(['like', 'DHL', $this->DHL])
            ->andFilterWhere(['like', 'tracking', $this->tracking])
            ->andFilterWhere(['like', 'extra_info', $this->extra_info]);

        return $dataProvider;
    }
}
