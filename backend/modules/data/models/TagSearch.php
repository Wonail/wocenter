<?php
namespace wocenter\backend\modules\data\models;

use wocenter\backend\core\ActiveDataProvider;
use wocenter\libs\Constants;

/**
 * TagSearch represents the model behind the search form about `wocenter\backend\modules\data\models\Tag`.
 */
class TagSearch extends Tag
{

    public $status = Constants::UNLIMITED;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['parent_id', 'required'],
            [['parent_id', 'status'], 'integer'],
            [['title'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params $_POST或$_GET方式传入的参数
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tag::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('sort_order'),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->where([
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere([
            'status' => $this->status != Constants::UNLIMITED ? $this->status : null,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        parent::load($data, $formName);
        if (!$this->parent_id) {
            $this->parent_id = isset($data[$this->breadcrumbParentParam])
                ? $data[$this->breadcrumbParentParam]
                : 0;
        }

        return true;
    }

}
