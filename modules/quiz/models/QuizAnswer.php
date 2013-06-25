<?php

/**
 * @property integer $id_quiz_answer
 * @property integer $id_quiz_question
 * @property string $answer
 * @property integer $is_right
 * @property integer $sequence
 */
class QuizAnswer extends CActiveRecord {
	const STATUS_IS_RIGHT = 1;
	const STATUS_NOT_RIGHT = 0;

	/**
	 * @return QuizAnswer
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'pr_quiz_answer';
	}

	public function rules() {
		return array(
			array('answer', 'required'),
			array('answer', 'length', 'max' => 255, 'encoding' => 'UTF-8'),
			array('is_right', 'in', 'range' => array_keys(self::statusesList()), 'allowEmpty' => false),
			array('sequence', 'numerical', 'integerOnly' => true, 'allowEmpty' => false),
		);
	}

	public function relations() {
		return array(
//			'question' => array(self::BELONGS_TO, 'QuizQuestion', 'id_quiz_question'),
		);
	}

	public function attributeLabels() {
		return array(
			'id_quiz_answer'   => 'ID',
			'id_quiz_question' => 'ID вопроса',
			'answer'           => 'Текст ответа',
			'is_right'            => 'Правильность',
			'sequence'         => 'Порядок сортировки',
		);
	}

	public static function statusesList() {
		return array(
			self::STATUS_NOT_RIGHT => 'Не правильный',
			self::STATUS_IS_RIGHT  => 'Правильный',
		);
	}

}