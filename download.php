<?php
require_once "config/init.php";
if (Input::exists("get")) {
	$id = Hash::solve(Input::get("id", 'get'));
	$query = DB::connect();
	$result = $query->file_found($id);
	if ($result->num_rows === 1) {
		$result = $result->fetch_object();
		
		if (!file_exists("datacenter/" . $result->encrypted_file_name)) {
			echo "File_Not_Found";
		} else {
			$size = $result->size;
			$encrypted_size = filesize("datacenter/" . $result->encrypted_file_name);
			$encryptcase = AES::EncryptCase($size);
			$decryptcase = AES::DecryptCase($encryptcase);
			$key = $result->key_encrypted;
			

			header("Connection: close");
			header("Access-Control-Allow-Origin: *");
			header("Cache-Control: private");
			header('Content-Disposition: attachment; filename="' . basename($result->name) . '"');
			header("Content-Type: application/force-download");
			header("Pragma: private");
			header("X-Content-Type-Options: nosniff");
			header("X-XSS-Protection: 1; mode=block");
			$open = fopen("datacenter/" . $result->encrypted_file_name, "rb");	
			$loop = (int)($encrypted_size / $decryptcase);
			
			if(isset($_SERVER['HTTP_RANGE'])) {
				list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
				list($range) = explode(",",$range,2);
				list($range, $range_end) = explode("-", $range);
				$range = intval($range);
				if(!$range_end) {
					$range_end = $size-1;
				} else {
					$range_end = intval($range_end);
				}
				$new_length = $range_end-$range+1;
				header("HTTP/1.1 206 Partial Content");
				header("Content-Length: $new_length");
				header("Content-Range: bytes $range-$range_end/$size");
				$trim = (int)($range / $encryptcase);
				$for_decrypt = $decryptcase*$trim;
				fseek($open,$for_decrypt);
				$all = fread($open,$decryptcase);
				$decrypt_range = AES::Decrypt($all,$key);
				$sub = ($range - $trim*$encryptcase);
				$decrypted_range = substr($decrypt_range,$sub);
				echo $decrypted_range;
				$for = $trim + 1;
			} else {
				header("Content-Length: ".$size);
				$for = 0;
			}
			for ($i=$for;$i<=$loop;$i++) {
				$sub = $i*$decryptcase;
				fseek($open,$sub);
				$decrypt = fread($open,$decryptcase);
				$decrypted = AES::Decrypt($decrypt,$key);
				echo $decrypted;
			}
		
		fclose($open);
		}

	} else {
		header("Location: /");
	}
}
?>