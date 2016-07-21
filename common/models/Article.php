<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property string $id
 * @property string $cid
 * @property integer $type
 * @property string $title
 * @property string $sub_title
 * @property string $sumary
 * @property string $thumb
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property integer $status
 * @property string $sort
 * @property string $author_id
 * @property string $author_name
 * @property string $flag_headline
 * @property string $flag_recommend
 * @property string $flag_slide_show,
 * @property string $flag_special_recommend,
 * @property string $flag_roll,
 * @property string $flag_bold,
 * @property string $flag_picture,
 * @property string $created_at
 * @property string $updated_at
 */
class Article extends \yii\db\ActiveRecord
{
    const ARTICLE = 0;
    const SINGLE_PAGE = 2;

    const ARTICLE_PUBLISHED = 1;
    const ARTICLE_DRAFT = 0;

    public $content;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'type', 'status', 'sort', 'author_id','can_comment', 'visibility'], 'integer'],
            ['cid', 'compare', 'compareValue' => 0, 'operator' => '>', 'message'=>yii::t('app', 'Must choose a category')],
            [['title'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'sub_title', 'summary', 'thumb', 'seo_title', 'seo_keywords', 'seo_description', 'author_name', 'tag'], 'string', 'max' => 255],
            [['flag_headline', 'flag_recommend', 'flag_slide_show', 'flag_special_recommend', 'flag_roll', 'flag_bold', 'flag_picture'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cid' => Yii::t('app', 'Category Id'),
            'type' => Yii::t('app', 'Type'),
            'title' => Yii::t('app', 'Title'),
            'sub_title' => Yii::t('app', 'Sub Title'),
            'sumary' => Yii::t('app', 'Summary'),
            'content' => Yii::t('app', 'Content'),
            'thumb' => Yii::t('app', 'Thumb'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_keywords' => Yii::t('app', 'Seo Keyword'),
            'seo_description' => Yii::t('app', 'Seo Description'),
            'status' => Yii::t('app','Status'),
            'can_comment' => Yii::t('app','Can Comment'),
            'visibility' => Yii::t('app','Visibility'),
            'sort' => Yii::t('app', 'Sort'),
            'tag' => Yii::t('app', 'Tag'),
            'author_id' => Yii::t('app', 'Author Id'),
            'author_name' => Yii::t('app', 'Author'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'flag_headline' => Yii::t('app', 'Is Headline'),
            'flag_recommend' => Yii::t('app', 'Is Recommend'),
            'flag_special_recommend' => Yii::t('app', 'Is Special Recommend'),
            'flag_slide_show' => Yii::t('app', 'Is Slide Show'),
            'flag_roll' => Yii::t('app', 'Is Roll'),
            'flag_bold' => Yii::t('app', 'Is Bold'),
            'flag_picture' => Yii::t('app', 'Is Picture'),
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'cid']);
    }

    public static function getArticleById($id)
    {
        return self::findOne(['id'=>$id]);
    }

    public function afterFind()
    {
        if( $this->thumb ) $this->thumb = str_replace(yii::$app->params['site']['sign'], yii::$app->params['site']['url'], $this->thumb);
    }


}