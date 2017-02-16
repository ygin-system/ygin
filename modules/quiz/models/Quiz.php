<?php

/**
 * @property integer $id_quiz
 * @property string $name
 * @property string $description
 * @property integer $active
 *
 * @property QuizQuestion[] $questions
 */
class Quiz extends CActiveRecord {

	const STATUS_ACTIVE = 1;
	const STATUS_NOT_ACTIVE = 0;

	const SCENARIO_ON_FORM_VALIDATE = 'validateUserInput';

	public $user_answer;

	/**
	 * @return Quiz
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'pr_quiz';
	}

	public function rules() {
		return array(
			array('name, description', 'required', 'on' => 'insert'),
			array('name', 'length', 'max' => 255, 'encoding' => 'UTF-8', 'on' => 'insert'),
			array('active', 'in', 'range' => array_keys(self::statusesList()), 'allowEmpty' => false, 'on' => 'insert'),

			// валидатор проверяющий ответы на вопросы
			//array('user_answer', 'quiz.validators.UserAnswersValidator', 'on' => self::SCENARIO_ON_FORM_VALIDATE),
			array('user_answer', 'safe', 'on' => self::SCENARIO_ON_FORM_VALIDATE),
		);
	}

	public function relations() {
		return array(
			'questions' => array(self::HAS_MANY, 'QuizQuestion', 'id_quiz', 'order' => 'questions.sequence DESC'),
			//'user_answers' => array(self::HAS_MANY, 'QuizAnswerUser', 'id_quiz'),
		);
	}

	public function attributeLabels() {
		return array(
			'id_quiz' => 'ID',
			'name' => 'Название',
			'description' => 'Описание',
			'active' => 'Активность',
		);
	}

	protected function beforeSave() {
		// На всякий случай
		return $this->getScenario() === self::SCENARIO_ON_FORM_VALIDATE
				? false
				: parent::beforeSave();
	}

	public static function statusesList() {
		return array(
			self::STATUS_NOT_ACTIVE => 'Не активен',
			self::STATUS_ACTIVE     => 'Активен',
		);
	}

}