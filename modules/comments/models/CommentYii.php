<?php

/**
 * Comment class file.
 *
 * @author Dmitry Zasjadko <segoddnja@gmail.com>
 * @link https://github.com/segoddnja/ECommentable
 */

/**
 *
 * The followings are the available columns in table 'pr_comment':
 *
 * @property integer $id_comment
 * @property integer $id_object
 * @property integer $id_instance
 * @property string $comment_name
 * @property integer $id_user
 * @property integer $comment_date
 * @property string $comment_theme
 * @property string $comment_text
 * @property integer $moderation
 * @property string $ip
 * @property integer $id_parent
 * @property string $token
 */
class CommentYii extends DaActiveRecord {

  const ID_OBJECT = 250;
  protected $idObject = self::ID_OBJECT;

  /*
   * Comment statuses
   */
  const STATUS_APPROVED = 1; //Утвержден
  const STATUS_PENDING = 2; //Ожидает модерации
  const STATUS_DELETED = 3; // Удален

  /*
   * @var captcha code handler
   */
  public $verifyCode;

  /*
   * @var captcha action
   */
//    public $captchaAction;

  /*
   * flag  of don't watch comment
  */
  public $isUnWatchComment = false;

  /*
   * Holds current model config
   */
  private $_config;

  /*
   * Holds comments owner model
   */
  private $_ownerModel = false;

  public function init() {
    parent::init();
    if ($this->isNewRecord) {
      $this->ip = HU::getUserIp();
    }
  }

  /**
   * Returns the static model of the specified AR class.
   * @return CommentYii
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'pr_comment';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    $rules = array(
      array('comment_text, id_object, id_instance', 'required'),
      array('comment_date, id_instance, moderation, id_user', 'numerical', 'integerOnly' => true),
      array('id_object, comment_name', 'length', 'max' => 125),
      array('id_comment, id_parent, comment_theme', 'safe'),
    );
    $config = Yii::app()->getModule('comments')->getModelConfig();
    if ($config['useCaptcha']) {
      $rules[] = array('verifyCode', 'captcha', 'caseSensitive' => true);
    }
    if (Yii::app()->user->isGuest) {
      array_push($rules, array('comment_name', 'required'));
    }
    return $rules;
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    $relations = array(
      'parent' => array(self::BELONGS_TO, 'CommentYii', 'id_parent'),
      'childs' => array(self::HAS_MANY, 'CommentYii', 'id_parent'),
      'user' => array(self::BELONGS_TO, 'User', 'id_user'),
    );
    return $relations;
  }

  public function behaviors() {
    return array(
      'ImagePreview' => array(
        'class' => 'ImagePreviewBehavior',
        'imageProperty' => 'avatarPhoto',
        'formats' => array(),
      ),
    );
  }

  public function scopes() {
    return array(
      'csOwnerComments' => array(
        'condition' => 'id_object = :OBJECT && id_instance = :INSTANCE',
        'params' => array(':OBJECT' => $this->id_object, ':INSTANCE' => $this->id_instance),
      ),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'comment_name' => 'Имя',
      'comment_theme' => 'Тема',
      'comment_text' => 'Сообщение',
      'verifyCode' => 'Проверочный код',
    );
  }

  /*
   * Return id_object
  * @return integer
  */
  public function getIdObjectOwner() {
    return $this->id_object;
  }

  /*
   * Return id_instance
  * @return integer
  */
  public function getIdInstanceOwner() {
    return $this->id_instance;
  }

  /*
   * Return count comments by instance
   * @return integer
   */
  public function getCountComments($idObject, $idInstance) {
    $criteria = new CDbCriteria();
    $criteria->compare('id_object', $this->id_object);
    $criteria->compare('id_instance', $this->id_instance);
    $criteria->compare('t.moderation', self::STATUS_APPROVED);
    return self::model()->count($criteria);
  }

  /*
   * Return array with prepared comments for given modelName and id
   * @return Comment array array with comments
   */
  public function getCommentsTree() {
    $criteria = new CDbCriteria;
    $criteria->compare('id_object', $this->id_object);
    $criteria->compare('id_instance', $this->id_instance);
    $criteria->compare('t.moderation', self::STATUS_APPROVED);
    $criteria->order = 't.id_parent, t.comment_date ';
    if ($this->config['orderComments'] === 'ASC' || $this->config['orderComments'] === 'DESC') {
      $criteria->order .= $this->config['orderComments'];
    }

    $relations = $this->relations();
    //if User model has been configured
    if (isset($relations['user'])) {
      $criteria->with = 'user';
    }
    $comments = self::model()->findAll($criteria);
    return $this->buildTree($comments);
  }

  public function beforeValidate() {
    if ($this->id_user === null && Yii::app()->user->isGuest === false && Yii::app()->isFrontend) {
      $this->id_user = Yii::app()->user->id;
    }
    return parent::beforeValidate();
  }

  /*
   * recursively build the comment tree for given root node
   * @param array $data array with comments data
   * @int $rootID root node id
   * @return Comment array
   */

  private function buildTree(&$data, $rootID = null) {
    $tree = array();
    foreach ($data as $id => $node) {
      $node->id_parent = $node->id_parent == 0 ? null : $node->id_parent;
      if ($node->id_parent == $rootID) {
        unset($data[$id]);
        $node->childs = $this->buildTree($data, $node->id_comment);
        $tree[] = $node;
      }
    }
    return $tree;
  }

  /*
   * returns the string, which represents comment's creator
   * @return string
   */
  public function getUserName() {
    $userName = '';
    if (isset($this->user)) {
      $userName = $this->user->full_name;
    } else {
      $userName = $this->comment_name;
    }
    return $userName;
  }

  /*
   * @return array
   */
  public function getConfig() {
    if ($this->_config === null) {
      //get comments module
      $commentsModule = Yii::app()->getModule('comments');
      //get model config for comments module
      $this->_config = $commentsModule->getModelConfig();
    }
    return $this->_config;
  }

  /*
   * Returns comments owner model
   * @return CActiveRecord $model
   */
  public function getOwnerModel() {
    if ($this->_ownerModel === false) {
      if ($this->id_object != null && $this->id_instance != null) {
        $commentsModule = Yii::app()->getModule('comments');
        if (!isset($commentsModule->modelClassMap[$this->id_object])) return $this->_ownerModel;
        $this->_ownerModel = BaseActiveRecord::model($commentsModule->modelClassMap[$this->id_object])->findByPk($this->id_instance);
      } else
        $this->_ownerModel = null;
    }
    return $this->_ownerModel;
  }

  /*
   * Set comment and all his childs as deleted
   * @return boolean
   */
  public function setDeleted() {
    /*todo add deleting for childs*/
    $this->moderation = self::STATUS_DELETED;
    return $this->update();
  }

  /*
   * Sets comment as approved
   * @return boolean
   */
  public function setApproved() {
    $this->moderation = self::STATUS_APPROVED;
    return $this->update();
  }

  /*
   * Sets comment as moderated
   * @return boolean
   */
  public function setModerated() {
    $this->moderation = self::STATUS_PENDING;
    return $this->update();
  }

  public function getStatus() {
    return $this->moderation;
  }

  protected function beforeSave() {
    if ($this->getIsNewRecord()) {
      $this->token = md5(time() + rand());
    }
    return parent::beforeSave();
  }

  public function processTextFromFoul($text) {
    $arr = array("гомосек", "хуй", "хуила", "пизда", "пиздеть", "пиздуй", "пиздец", "еблан", "ебанат", "ебать", "хуярить", "пидрила", "пидар", "пидор", "пидорас", "пидарас", "пидараст", "жопа", "жополиз", "гондон", "гандон", "говно", "гавно", "говнецо", "бляд", "блят", "бля", "охуе", "охереть", "чмо", "срать", "срач", "мудак", "ссать", "срать", "отсос", "обосос", "отсосать", "хуесос", "хуесосить", "говнюк", "педик", "херачить", "хуячить", "блядва", "ебанько", "дебил", "какашка", "гомик", "ублюдок", "дерьмо", "сука", "сучка", "суки", "ебало", "пиздобол", "пиздабол", "ментяра", "ахуе", "ахуеть", "никуя", "писец", "заепали", "заипали");
    $c = count($arr);
    $textLower = mb_strtolower($text);
    for ($i = 0; $i < $c; $i++) {
      $mat = $arr[$i];
      $len = mb_strlen($mat);
      $pos = mb_strpos($textLower, $mat);
      while (!($pos === false)) {
        $zv = str_repeat("*", $len - 1);
        $text = mb_substr($text, 0, $pos + 1) . $zv . mb_substr($text, $pos + $len);
        $textLower = mb_substr($textLower, 0, $pos + 1) . $zv . mb_substr($textLower, $pos + $len);
        $pos = mb_strpos($textLower, $mat, $pos + 1);
      }
    }
    return $text;
  }

  public function isOwnerComment() {
    if (isset($this->id_user)) {
      return $this->id_user == Yii::app()->user->id;
    }
    return false;
  }


  public function getBackendEventHandler() {
    return array(
      'class' => 'comments.backend.CommentEventHandler'
    );
  }

  protected function afterSave() {
    parent::afterSave();
    $module = Yii::app()->getModule('comments');
    if ($this->isNewRecord) {
      $module->onNewComment($this);
    } else {
      $module->onUpdateComment($this);
    }
  }

  protected function afterDelete() {
    parent::afterDelete();
    $module = Yii::app()->getModule('comments');
    $module->onDeleteComment($this);
  }

  public function isProcessDeleteChild () {
    return true;
  }

  protected function beforeDelete () {
    self::model ()->updateAll (array(
      'id_parent' => null,
    ),'id_parent = :ID_PARENT',array(
      ':ID_PARENT' => $this->primaryKey,
    ));
    return parent::beforeDelete ();
  }
}
