<?php

// search for some bad things
class Required implements themecheck {
	protected $error = array();

	function check( $php_files, $css_files, $other_files) {

		// combine all the php files into one string to make it easier to search
	//	$php = implode(' ', $php_files);

		$ret = true;

		// things to check for
		$checks = array(
		'/[\s|]get_option\((\s|)("|\')home("|\')(\s|)\)/m' => 'home_url()',
		'/[\s|]get_option\((\s|)("|\')site_url("|\')(\s|)\)/m' => 'site_url()',
			);

		foreach ($php_files as $php_key => $phpfile) {
		foreach ($checks as $key => $check) {
		checkcount();
			if ( preg_match( $key, $phpfile, $matches ) ) {
			    $filename = basename($php_key);
				$error = esc_html( rtrim($matches[0],'(') );
$grep = tc_grep( rtrim($matches[0],'('), $php_key);
				$this->error[] = "REQUIRED<strong>{$error}</strong> was found in the file <strong>{$filename}</strong>. Use <strong>{$check}</strong> instead.{$grep}";
				$ret = false;
			}


		}

}
		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new Required;
