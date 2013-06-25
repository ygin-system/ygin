<?php
/**
 * @var $this DefaultController
 * @var $quiz Quiz
 * @var $answer QuizAnswerUser
 * @var $captcha CaptchaForm
 * @var $form CActiveForm
 */
?>
<?
$form = $this->beginWidget('CActiveForm', array(
  'id' => 'victorinaForm',
  'htmlOptions' => array(
    'name' => 'victorinaForm',
    'class' => 'b-quiz',
  ),
  'enableAjaxValidation' => true,
  'enableClientValidation' => true,
  'clientOptions' => array(
    'validateOnSubmit' => true,
  ),
)); ?>

<form class="b-quiz" id="victorinaForm" name="victorinaForm" method="post" action="">
  <h2><?= CHtml::encode($quiz->name); ?></h2>
  <!--  Описание викторины -->
  <div class="desc">
    <?= $quiz->description; ?>
  </div>
  <!--  Описание викторины -->

  <!--  Вопросы викторины -->
  <div class="ask-list">
    <? $i = 0; ?>
    <? foreach ($quiz->getRelated('questions') as $question) : /** @var $question QuizQuestion */?>
    <div class="item">
      <p>Вопрос №<?= ++$i; ?></p>
      <div class="ask">
        <?= $question->question; ?>
      </div>
      <?
        $pk = $question->getPrimaryKey();

        if ($question->type == QuizQuestion::TYPE_INDEPENDENT) {
          echo $form->textArea($quiz, 'user_answer[' . $pk .']');
        } elseif (in_array($question->type, array(QuizQuestion::TYPE_SINGLE, QuizQuestion::TYPE_MULTIPLE))) {

          $listType = $question->type == QuizQuestion::TYPE_SINGLE ? 'radioButtonList' : 'checkBoxList';
          echo $form->$listType($quiz, 'user_answer[' . $pk .']',
            CHtml::listData($question->getRelated('answers'), 'id_quiz_answer', 'answer'),
            array(
              'container' => 'ul',
              'template' => '<li>{input} {label}</li>',
              'separator' => "\n",
            )
          );
        }
        ?>

        <?= $form->error($quiz, 'user_answer[' . $pk .']'); ?>
    </div>
    <? endforeach; ?>
  </div>
<!--  Вопросы викторины -->

<!--  Данные участника -->
  <table class="formTable">
    <tbody>
      <tr>
        <th><?= $form->labelEx($answer, 'name'); ?>:</th>
        <td>
          <?= $form->textField($answer, 'name', array(
            'autocomplete' => 'off',
            'class' => 'text',
//            'id' => 'acpro_inp1',
          )); ?>
          <?= $form->error($answer, 'name'); ?>
        </td>
      </tr>
      <!-- +not-encode-mail -->
      <tr>
        <th><?= $form->labelEx($answer, 'mail'); ?>:</th>
        <td>
          <?= $form->textField($answer, 'mail', array(
            'autocomplete' => 'off',
            'type' => 'email', // не работает
            'class' => 'text',
          )); ?>
          <?= $form->error($answer, 'mail'); ?>
        </td>
      </tr>
      <!-- -not-encode-mail -->
      <tr>
        <th><?= $form->labelEx($answer, 'library_card'); ?>:</th>
        <td>
          <?= $form->textArea($answer, 'library_card', array(
            'autocomplete' => 'off',
            'cols' => '40',
            'rows' => '8',
          )); ?>
          <?= $form->error($answer, 'library_card'); ?>
        </td>
      </tr>
      <tr>
        <th><?= $form->labelEx($answer, 'contact'); ?>:</th>
        <td>
          <?= $form->textField($answer, 'contact', array(
            'autocomplete' => 'off',
            'type' => 'tel', // не работает
          )); ?>
          <?= $form->error($answer, 'contact'); ?>
        </td>
      </tr>

<? if (CCaptcha::checkRequirements()) : ?>
      <tr>
        <th><?= $form->labelEx($captcha, 'verifyCode'); ?>:</th>
        <td>
          <? $this->widget('CCaptcha'); ?>
          <?= $form->textField($captcha,'verifyCode'); ?>
          <?= $form->error($captcha,'verifyCode'); ?>
        </td>
      </tr>
<? endif; ?>
      <tr>
        <th>&nbsp;</th>
        <td><?= CHtml::submitButton('Отправить', array(
          'class' => 'submit',
          'name' => 'submit',
        )); ?></td>
      </tr>
    </tbody>
  </table>
</form>
<? $this->endWidget(); ?>