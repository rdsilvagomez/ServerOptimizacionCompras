<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SolicitudCotizacionSapDet;

/**
 * SolicitudCotizacionSapDetSearch represents the model behind the search form about `app\models\SolicitudCotizacionSapDet`.
 */
class SolicitudCotizacionSapDetSearch extends SolicitudCotizacionSapDet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idSolicitudSapCap'], 'integer'],
            [['NUMERO_SOLPED', 'PREQ_ITEM'], 'safe'],
            [['CANTIDAD', 'PRECIOUNITARIO'], 'number'],
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
        $query = SolicitudCotizacionSapDet::find();

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
            'idSolicitudSapCap' => $this->idSolicitudSapCap,
            'CANTIDAD' => $this->CANTIDAD,
            'PRECIOUNITARIO' => $this->PRECIOUNITARIO,
        ]);

        $query->andFilterWhere(['like', 'NUMERO_SOLPED', $this->NUMERO_SOLPED])
            ->andFilterWhere(['like', 'PREQ_ITEM', $this->PREQ_ITEM]);

        return $dataProvider;
    }
}
