<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\filtrosUsuario;

/**
 * filtrosUsuarioSearch represents the model behind the search form about `app\models\filtrosUsuario`.
 */
class filtrosUsuarioSearch extends filtrosUsuario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idUsuario'], 'integer'],
            [['DOC_TYPE', 'CREATED_BY', 'PUR_GROUP', 'PLANT'], 'safe'],
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
        $query = filtrosUsuario::find();

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
            'idUsuario' => $this->idUsuario,
        ]);

        $query->andFilterWhere(['like', 'DOC_TYPE', $this->DOC_TYPE])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY])
            ->andFilterWhere(['like', 'PUR_GROUP', $this->PUR_GROUP])
            ->andFilterWhere(['like', 'PLANT', $this->PLANT]);

        return $dataProvider;
    }
}
