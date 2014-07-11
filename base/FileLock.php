<?php
class File_Lock {
	private $name;
	private $handle;
	private $mode;
	function __construct($filename, $mode = 'a+') {
		global $php_errormsg;
		$this -> name = $filename;
		$path = dirname($this -> name);
		if ($path == '.' || !is_dir($path)) {
			global $config_file_lock_path;
			$this -> name = str_replace(array("/", "\\"), array("_", "_"), $this -> name);
			if ($config_file_lock_path == null) {
				$this -> name = dirname(__FILE__) . "/lock/" . $this -> name;
			} else {
				$this -> name = $config_file_lock_path . "/" . $this -> name;
			}
		}
		$this -> mode = $mode;
		$this -> handle = @fopen($this -> name, $mode);
		if ($this -> handle == false) {
			throw new Exception($php_errormsg);
		}
	}

	public function close() {
		if ($this -> handle !== null) {
			@fclose($this -> handle);
			$this -> handle = null;
		}
	}

	public function __destruct() {
		$this -> close();
	}

	public function writeLock($wait = 0.1) {
		$canWrite = false;
		do {
			$canWrite = flock($this -> handle, LOCK_EX);
			if (!$canWrite) {
				usleep(rand(10, 1000));
			}
		} while ((!$canWrite));
	}

	public function unlock() {
		if ($this -> handle !== null) {
			return flock($this -> handle, LOCK_UN);
		} else {
			return true;
		}
	}
}
?>