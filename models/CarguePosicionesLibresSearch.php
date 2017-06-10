<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CarguePosicionesLibres;

/**
 * CarguePosicionesLibresSearch represents the model behind the search form about `app\models\CarguePosicionesLibres`.
 */
class CarguePosicionesLibresSearch extends CarguePosicionesLibres
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'integer'],
            [['NUMERO_SOLPED', 'PREQ_ITEM', 'DOC_TYPE', 'CREATED_BY', 'CH_ON', 'PREQ_NAME', 'SHORT_TEXT', 'MATERIAL', 'MATERIAL_EXTERNAL'], 'safe'],
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
        $query = CarguePosicionesLibres::find();

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
            'ID' => $this->ID,
        ]);

        $query->andFilterWhere(['like', 'NUMERO_SOLPED', $this->NUMERO_SOLPED])
            ->andFilterWhere(['like', 'PREQ_ITEM', $this->PREQ_ITEM])
            ->andFilterWhere(['like', 'DOC_TYPE', $this->DOC_TYPE])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'CH_ON', $this->CH_ON])
            ->andFilterWhere(['like', 'PREQ_NAME', $this->PREQ_NAME])
            ->andFilterWhere(['like', 'SHORT_TEXT', $this->SHORT_TEXT])
            ->andFilterWhere(['like', 'MATERIAL', $this->MATERIAL])
            ->andFilterWhere(['like', 'MATERIAL_EXTERNAL', $this->MATERIAL_EXTERNAL]);

        return $dataProvider;
    }
}
