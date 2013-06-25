<?php

class UserAnswersValidator extends CValidator {

	/**
	 * @param CActiveRecord $object
	 * @param string $attribute
	 */
	protected function validateAttribute($object, $attribute) {
		/**
		 * Значение аттрибута
		 */
		$value = $object->$attribute;

		foreach ($object->getRelated('questions') as $question) { /** @var $question QuizQuestion */
			$pk = $question->getPrimaryKey();
			if (!is_array($value) || !array_key_exists($pk, $value) || $this->isEmpty($value[$pk], true)) { // если не пришли данные для этого вопроса, или пришли, но пустые
				$this->addError($object, $attribute, $pk);
			} else {
				// собираем PK ответов на этот вопрос
				$answers_pk = array();
				foreach ($question->getRelated('answers') as $answer) { /** @var $answer QuizAnswer */
					$answers_pk[] = $answer->getPrimaryKey();
				}

				if ($question->type == QuizQuestion::TYPE_SINGLE // на вопрос можно дать только один ответ
					&& !in_array($value[$pk], $answers_pk) // и он не присутствует в списке возможных ответов
				) {
					unset($object->$attribute[$pk]); // стираем текущие значения
					$this->addError($object, $attribute, $pk);
				}

				if ($question->type == QuizQuestion::TYPE_MULTIPLE) { // на вопрос можно несколько ответов
					/**
					 * "Лишние" ответы, не присутсвующие в списке вопросов
					 */
					$wrong_answers = array_diff($value[$pk], $answers_pk);
					if (!empty($wrong_answers)) {
						unset($object->$attribute[$pk]); // стираем текущие значения
						$this->addError($object, $attribute, $pk);
					}
				}

				/**
				 * Дополнительной проверки произвольного ответа не производится
				 * он не пуст и нас это устраивает
				 */
			}
		}
	}

	public function addError($object, $attribute, $pk) {
		$object->addError($attribute . '[' . $pk .']', 'Вы должны дать ответ на этот вопрос');
	}

	/**
	 * @param CActiveRecord $object
	 * @param string $attribute
	 */
	public function clientValidateAttribute($object,$attribute) {
		/**
		 * TODO
		 */
	}

}