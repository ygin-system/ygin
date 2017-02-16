примеры использования компонента notifier для рассылки сообщений.

class FeedbackController extends Controller {
  const EVENT_TYPE_NEW_FEEDBACK = 100;
  
  public function actionIndex() {
    $model = new Feedback();
    ...
    ...
    
    if ($model->save()) {
      ...
      ...
      
      //Отправляем сообщение в пул для отправки писем
      Yii::app()->notifier->addNewEvent(
        self::EVENT_TYPE_NEW_FEEDBACK,
        $model->text
      );
      
      //Если необходимо немедленно отправить письмо (например, при восстановлении пароля)
      Yii::app()->notifier->addNewEvent(
        self::EVENT_TYPE_NEW_FEEDBACK,
        $model->text
      )->senNowLastAdded();
    }
    
  } 
}