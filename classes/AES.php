<?php

class AES {
		
	public function Encrypt($string, $key = null) {
		$key = isset($key) ? $key : Config::get("AES/PASSWORD");
		return openssl_encrypt($string, Config::get('AES/MTD'), $key, false, Config::get('AES/IV'));
	}
	
	public function Decrypt($string, $key = null) {
		$key = isset($key) ? $key : Config::get("AES/PASSWORD");
		return openssl_decrypt($string, Config::get('AES/MTD'), $key, false, Config::get('AES/IV'));
	}

	public function EncryptCase($size) {
		if ($size >= 8589934592) {
			$case_encrypt = 8388608; // for 8Gb encrypt
		} else if ($size >= 4294967296) {
			$case_encrypt = 4194304; // for 4Gb encrypt
		} else if ($size >= 2147483648) {
			$case_encrypt = 2097152; // for 2Gb encrypt
		} else if ($size >= 1073741824) {
			$case_encrypt = 1048576; // for 1Gb encrypt
		} else if ($size >= 536870912) {
			$case_encrypt = 524288; // for 512mb encrypt
		} else if ($size >= 268435456) {
			$case_encrypt = 262144; // for 256mb encrypt
		} else if ($size >= 134217728) {
			$case_encrypt = 131072; // for 128mb encrypt
		} else if ($size >= 67108864) {
			$case_encrypt = 65536; // for 64mb encrypt
		} else if ($size >= 33554432) {
			$case_encrypt = 32768; // for 32mb encrypt
		} else if ($size >= 16777216) {
			$case_encrypt = 16384; // for 16mb encrypt
		} else {
			$case_encrypt = 8192; // for under 8mb encrypt
		}
		
		return $case_encrypt;
	}

	public function DecryptCase($case) {
		switch ($case) {
		case "8192": $case_decrypt = 10944;
		break;
		case "16384": $case_decrypt = 21868;
		break;
		case "32768": $case_decrypt = 43712;
		break;
		case "65536": $case_decrypt = 87404;
		break;
		case "131072": $case_decrypt = 174784;
		break;
		case "262144": $case_decrypt = 349548;
		break;
		case "524288": $case_decrypt = 699072;
		break;
		case "1048576": $case_decrypt = 1398124;
		break;
		case "2097152": $case_decrypt = 2796224;
		break;
		case "4194304": $case_decrypt = 5592428;
		break;
		case "8388608": $case_decrypt = 11184832;
		break;
		}

		return $case_decrypt;
	}
}

?>