<?php

/**
 * @property integer $id_quiz_answer_user
 * @property integer $id_quiz
 * @property string $name
 * @property string $mail
 * @property string $library_card
 * @property string $contact
 * @property string $answer
 * @property string $create_date
 * @property string $ip
 */
class QuizAnswerUser extends CActiveRecord {

	/**
	 * @return QuizAnswerUser
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'pr_quiz_answer_user';
	}

	public function rules() {
		return array(
			array('name, mail', 'required'),
			array('name, mail, library_card, contact', 'length', 'max' => 255, 'encoding' => 'UTF-8'),
			array('mail', 'email'),
		);
	}

	public function relations() {
		return array(
//			'quiz' => array(self::BELONGS_TO, 'Quiz', 'id_quiz'),
		);
	}

	public function attributeLabels() {
		return array(
			'id_quiz_answer_user' => 'ID',
			'id_quiz'             => 'ID викторины',
			'name'                => 'ФИО',
			'mail'                => 'e-mail',
			'library_card'        => 'Читательский билет',
			'contact'             => 'Контактная информация',
			'answer'              => 'Ответ',
			'create_date'         => 'Дата создания',
			'ip'                  => 'IP пользователя',
		);
	}


	protected function beforeSave() {
		$this->ip          = Yii::app()->getRequest()->getUserHostAddress();
		$this->create_date = time();

		return parent::beforeSave();
	}

	/**
	 * @param $quiz Quiz
	 */
	public static function prepareAnswerData($quiz) {
//		// если вдруг понадобится хранить ответы в базе в каком-то структурированном виде
//		$output = $quiz->getAttributes();
//		foreach ($quiz->getRelated('questions') as $question) { /** @var $question QuizQuestion */
//			$question_data = $question->getAttributes();
//
//			foreach ($question->getRelated('answers') as $answer) { /** @var $answer QuizAnswer */
//				$question_data['_answers'][$answer->getPrimaryKey()] = $answer->getAttributes();
//			}
//
//			$question_data['_user_answer'] = $quiz->user_answer;
//
//			$output['_questions'][] = $question_data;
//		}
//
//		return CJSON::encode($output);
	}

}