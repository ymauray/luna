<?php
if (!empty($_POST)) {
	if (isset($_POST['luna-action'])) {
		$action = $_POST['luna-action'];
		if ($action == 'login') {
			$user = wp_signon($_POST);
			header('location: ' . site_url('/'));
			die();
		} else if ($action == 'logout') {
			remove_action( 'wp_logout', 'remote_logout_loader', 9999 );
			wp_logout();
			header('location: ' . site_url('/'));
			die();
		}
	}
}
?>