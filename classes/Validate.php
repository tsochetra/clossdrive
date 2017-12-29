<?php

class Validate {

	private $_success = false,
			$_db = null,
			$_errors = array();
	
	public function __construct() {
		$this->_db = DB::connect();
	}
	
	public function check($source, $items = array()) {
		foreach($items as $item => $rules) {
			foreach($rules as $rule => $rule_value) {
					
				$value = $source[$item];
				$item = $item;

				if ($rule === 'required' && empty($value)) {
				$this->addError("<script>$(document).ready(function () {
					$('#{$item}').attr('class', 'error');
					
				});
				</script>");
				} else if (!empty($value)){
					switch($rule) {
						case 'email':
							if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
								$this->addError("<script>$(document).ready(function () {
							$('#{$item}').attr('class', 'error');
							});
							</script>");
							}
						break;
						case 'min':
							if (strlen($value) < $rule_value) {
								$this->addError("<script>$(document).ready(function () {
							$('#{$item}').attr('class', 'error');
							});
							</script>");
							}
						break;
						case 'max':
							if (strlen($value) > $rule_value) {
								$this->addError("<script>$(document).ready(function () {
							$('#{$item}').attr('class', 'error');
							});
							</script>");
							}
						break;
						case 'matches':
							if ($value != $source[$rule_value]) {
								$this->addError("<script>$(document).ready(function () {
							$('#{$item}').attr('class', 'error');
							});
							</script>");
							}
						break;
						case 'unique':
							$check = $this->_db->select($rule_value, $rule_value, array($rule_value, '=', AES::Encrypt(lower($value))));
							if ($check->num_rows === 1) {
								$this->addError("<script>$(document).ready(function () {
							$('#{$item}').attr('class', 'error');
							});
							</script>");
							}
						break;
						case 'escape':
							if (escape_string($value) != $value) {
								$this->addError("<script>$(document).ready(function () {
							$('#{$item}').attr('class', 'error');
							});
							</script>");
							}
						break;
					}
				}
			}
		}
		if (empty($this->errors())) {
			$this->_success = true;
		}
		
		return $this;
	}
	public function errors() {
		return $this->_errors;
	}
	public function addError($error) {
		$this->_errors[] = $error;
	}
	public function passed() {
		return $this->_success;
	}
}

?>