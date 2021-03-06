<?php
class AdminMenu implements themecheck {
	protected $error = array();

	function check( $php_files, $css_files, $other_files) {

		$ret = true;


//check for levels deprecated in 2.0 in creating menus.

		$checks = array(
			'/(add_(admin|submenu|menu|dashboard|posts|media|links|pages|comments|theme|plugins|users|management|options)_page\s?\([^,]*,[^,]*,\s[\'|"]?(level_[0-9]|[0-9])[^;|\r|\r\n]*)/' => __( 'User levels were deprecated in <strong>2.0</strong>. Please see <a href="http://codex.wordpress.org/Roles_and_Capabilities">Roles_and_Capabilities</a>', 'themecheck' ),
			'/[^a-z0-9](current_user_can\s?\(\s?[\'\"]level_[0-9][\'\"]\s?\))[^\r|\r\n]*/' => __( 'User levels were deprecated in <strong>2.0</strong>. Please see <a href="http://codex.wordpress.org/Roles_and_Capabilities">Roles_and_Capabilities</a>', 'themecheck' )
			);

		foreach ( $php_files as $php_key => $phpfile ) {
			foreach ( $checks as $key => $check ) {
				checkcount();
				if ( preg_match( $key, $phpfile, $matches ) ) {
					$filename = tc_filename( $php_key );

					$grep = tc_grep( $matches[0], $php_key );
					$this->error[] = "<span class='tc-lead tc-warning'>WARNING</span>: <strong>{$filename}</strong>. {$check}{$grep}";
					$ret = false;
				}
			}
		}


//check for add_admin_page

		$checks = array(
			'/(add_(admin|submenu|menu|dashboard|posts|media|links|pages|comments|plugins|users|management|options)_page\()/' => __( 'Themes should use <strong>add_theme_page()</strong> for adding admin pages.', 'themecheck' )
			);


		foreach ( $php_files as $php_key => $phpfile ) {
			foreach ( $checks as $key => $check ) {
				checkcount();
				if ( preg_match( $key, $phpfile, $matches ) ) {
					$filename = tc_filename( $php_key );
					$error = rtrim( $matches[0], '(' );
					$grep = tc_grep( $error, $php_key );
					$this->error[] = "<span class='tc-lead tc-required'>REQUIRED</span>: <strong>{$filename}</strong>. {$check}{$grep}";
					$ret = false;
				}
			}
		}

		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new AdminMenu;