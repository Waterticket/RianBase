<?php
class Shell {
    public static $_last_exec_out;
    public static $_last_exec_retcode;

    public static function executeShell($cmd) {
		$args = func_get_args();
		$arg_count = func_num_args();
		if($arg_count != substr_count($cmd, '?') + 1) {
            throw new \RianBase\Message\Exception(EXCEPTION_LEVEL_WARNING, 'Placeholder count not matching argument list.');
			return false;
		}
		if($arg_count > 1) {
			array_shift($args);

			$pos = 0;
			$a = 0;
			foreach($args as $value) {
				$a++;

				$pos = strpos($cmd, '?', $pos);
				if($pos === false) {
					break;
				}
				$value = escapeshellarg($value);
				$cmd = substr_replace($cmd, $value, $pos, 1);
				$pos += strlen($value);
			}
		}

		self::$_last_exec_out = null;
		self::$_last_exec_retcode = null;
		$ret = exec($cmd, self::$_last_exec_out, self::$_last_exec_retcode);

		return $ret;
	}
}