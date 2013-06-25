<?php

class CaptchaForm extends CFormModel {

	public $verifyCode;

	public function rules() {
		return array(
			array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
		);
	}

	public function attributeLabels() {
		return array(
			'verifyCode' => 'Verification Code',
		);
	}

}