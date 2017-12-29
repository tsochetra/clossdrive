<?php

class Upload {

	private $_db,
			$_name,
			$_tmp,
			$_type,
			$_size,
			$_user_uid;

	public function __construct($name, $tmp, $type, $size) {
		if (!empty($name) && !empty($tmp) && !empty($type) && !empty($size)) {
			$this->_db = DB::connect();
			$this->_name = $name;
			$this->_tmp = $tmp;
			$this->_type = $type;
			$this->_size = $size;
			$this->_user_uid = Session::GetHash()->user_uid;
		} else {
			header("HTTP/1.1 404 Upload Error");
		}
	}

	public function start() {
		if (file_exists($this->_tmp)) {
			$key = Generate::make(15);
			$encryptedname = Generate::make(10);
			
			if ($this->chunk($encryptedname, $key)) {
				$file_uid = Generate::make(12);
				
				if($this->_db->upload($file_uid, $this->_name, $encryptedname, $this->_size, $key, $this->_user_uid, $this->_type)) {
					return true;
				} else {
					unlink(Config::get("BASE/STORAGE") . "/" . $encryptedname);
				}
			}
		}

		return false;
	}

	public function chunk($encryptedname, $key) {

		if(is_dir(Config::get("BASE/STORAGE"))) {			
			$open = fopen($this->_tmp,"rb");
			$write = fopen(Config::get("BASE/STORAGE") . "/" . $encryptedname, "wb");
			$encryptcase = AES::EncryptCase($this->_size);
			$loop = (int)($this->_size / $encryptcase);
			
			for ($i=0;$i<=$loop;$i++) {
				
				$sub = $i*$encryptcase;
				fseek($open, $sub);
				$encrypt = fread($open,$encryptcase);
				$encrypted = AES::Encrypt($encrypt, $key);
				fwrite($write,$encrypted);

				if($i=== $loop) {
					return true;
				}
			}
		}

		return false;
	}

}

?>