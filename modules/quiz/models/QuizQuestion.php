<?php

/**
 * @property integer $id_quiz_question
 * @property integer $id_quiz
 * @property string $question
 * @property integer $type
 * @property integer $sequence
 *
 * @property QuizAnswer[] $answers
 */
class QuizQuestion extends CActiveRecord {
	const TYPE_SINGLE = 1;
	const TYPE_MULTIPLE = 2;
	const TYPE_INDEPENDENT = 3;

	/**
	 * @return QuizQuestion
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'pr_quiz_question';
	}

	public function rules() {
		return array(
			array('question', 'required'),
			array('question', 'length', 'max' => 255, 'encoding' => 'UTF-8'),
			array('type', 'in', 'range' => array_keys(self::typesList()), 'allowEmpty' => false),
			array('sequence', 'numerical', 'integerOnly' => true, 'allowEmpty' => false),
		);
	}

	public function relations() {
		return array(
//			'quiz' => array(self::BELONGS_TO, 'Quiz', 'id_quiz'),
			'answers' => array(self::HAS_MANY, 'QuizAnswer', 'id_quiz_question'),
		);
	}

	public function attributeLabels() {
		return array(
			'id_quiz_question' => 'ID',
			'id_quiz'          => 'ID викторины',
			'question'         => 'Текст вопроса',
			'type'             => 'Тип',
			'sequence'         => 'Порядок сортировки',
		);
	}

	public static function typesList() {
		return array(
			self::TYPE_SINGLE      => 'Один вариант',
			self::TYPE_MULTIPLE    => 'Несколько вариантов',
			self::TYPE_INDEPENDENT => 'Свой ответ',
		);
	}

}