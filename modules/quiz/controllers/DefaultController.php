<?php

class DefaultController extends Controller {

  protected $urlAlias = "news";  
  
  protected function loadModel($id) {
    /**
     * TODO или сделать в один запрос?
     */

    $criteria = new CDbCriteria();
    $criteria->compare('t.active', Quiz::STATUS_ACTIVE);

    /** @var $quiz Quiz */
    $quiz = Quiz::model()->findByPk($id, $criteria);
    if ($quiz === null) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }

    $criteria = new CDbCriteria(array(
      'with' => 'answers',
      'order' => 't.sequence ASC, answers.sequence ASC',
    ));
    $criteria->compare('t.id_quiz', $id);
    $questions = QuizQuestion::model()->findAll($criteria);
    if (empty($questions)) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }

    $quiz->addRelatedRecord('questions', $questions, false);

    return $quiz;
  }

  public function actionView($id) {
    $quiz = $this->loadModel($id);
    $quiz->setScenario(Quiz::SCENARIO_ON_FORM_VALIDATE);

    $answer = BaseActiveRecord::newModel('QuizAnswerUser');
    $captcha = new CaptchaForm();

    // валидация по AJAX
    $this->performAjaxValidation(array($quiz, $answer, $captcha));

    if (isset($_POST[get_class($quiz)], $_POST[get_class($answer)], $_POST[get_class($captcha)])) {
      $quiz->setAttributes($_POST[get_class($quiz)]);
      $answer->setAttributes($_POST[get_class($answer)]);
      $captcha->setAttributes($_POST[get_class($captcha)]);

      // проверяем
      $valid = $quiz->validate();
      $valid = $answer->validate() && $valid;
      //$valid = $captcha->validate() && $valid;

      if ($valid) {
        //$answer->answer  = QuizAnswerUser::prepareAnswerData($quiz);
        $answer->answer  = $this->renderPartial('/user_answer', array(
          'quiz' => $quiz,
        ), true);
        $answer->id_quiz = $quiz->getPrimaryKey();

        if ($answer->save()) {
          $this->afterDataSave($answer);
        }
      }
    }

    $this->render('view', array(
      'quiz' => $quiz,
      'answer' => $answer,
      'captcha' => $captcha,
    ));
  }

  protected function performAjaxValidation($models) {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'victorinaForm') {
      echo CActiveForm::validate($models);
      Yii::app()->end();
    }
  }

  /**
   * @param QuizAnswerUser $model
   */
  protected function afterDataSave($model) {
    $this->redirect('success');
  }

  public function actionSuccess() {
    $this->render('success');
  }

}