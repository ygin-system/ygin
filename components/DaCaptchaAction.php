<?php
class DaCaptchaAction extends CCaptchaAction {
	
	private $_letters = '1234567890';
	public function setLetters($string) {
		$this->_letters = $string;
	}
	/**
	 * Generates a new verification code.
	 * @return string the generated verification code
	 */
	protected function generateVerifyCode() {
		if ($this->minLength<3) $this->minLength=3;
		if ($this->maxLength>20) $this->maxLength=20;
		if ($this->minLength > $this->maxLength)
		  $this->maxLength=$this->minLength;
		
		$length = rand($this->minLength,$this->maxLength);

		// Тут указываем символы которые будут
		// выводится у нас на капче.
		$code = '';
		for($i = 0; $i < $length; $i++) {
			$code .= $this->_letters[rand(0, strlen($this->_letters)-1)];
		}
		return $code;
	}
}
