<?php
$ok = true;
$errors = array();
if (!empty($_POST)) {
	if (empty($_POST['display_name'])) {
		$ok = false;
		$errors['display_name'] = true;
	}
	if (empty($_POST['user_email'])) {
		$ok = false;
		$errors['user_email'] = true;
	}
	if (!empty($_POST['user_pass'])) {
		if ($_POST['user_pass'] != $_POST['user_pass_2']) {
			$errors['user_pass'] = true;
		}
	}
	$userdata = array('ID' => $_POST['user_id'], 'display_name' => $_POST['display_name'], 'user_login' => $_POST['user_login'], 'user_email' => $_POST['user_email']);
	if (!empty($_POST['user_pass'])) {
		$userdata['user_pass'] = wp_hash_password($_POST['user_pass']);
	}
	
	if (empty($errors)) {
		$id = wp_insert_user($userdata);
		if (is_wp_error($id)) {
			echo $id->get_error_message();
			die();
		}
		else {
			header('location: ' . site_url('/'));
		}
	}
} 
?>
<?php get_header(); ?>
	<div class="box">
		<div class="title">Profil</div>
		<?php $user = wp_get_current_user(); ?>
		<?php $id = $user->ID; ?>
		<form method="post">
			<p>Votre pseudo et votre adresse mail sont obligatoires.</p>
			<p>
				<label for="display_name">Pseudo : </label>
				<input type="text" name="display_name" id="display_name" value="<?php echo $user->display_name; ?>"/>
				<label for="display_name">eMail : </label>
				<input type="text" name="user_email" id="user_email" value="<?php echo $user->user_email; ?>"/>
			</p>
			<p>Si vous souhaitez changer votre mot de passe, veuillez le saisir deux fois ci-dessous. Après validation, vous serez déconnecté automatiquement. Vous devrez alors vous reconnecter avec votre nouveau mot de passe.</p>
			<p>
				<label for="user_pass">Mot de passe : </label>
				<input type="password" name="user_pass" id="user_pass" value=""/>
				<label for="user_pass_2">Vérifier le mot de passe : </label>
				<input type="password" name="user_pass_2" id="user_pass_2" value=""/>
			</p>
			<p>
				<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Mettre à jour"/>
				<input type="hidden" name="user_id" id="user_id" value="<?php echo $user->ID; ?>"/>
				<input type="hidden" name="user_login" id="user_login" value="<?php echo $user->user_login; ?>"/>
			</p>
		</form>
	</div>
<?php get_footer(); ?>
