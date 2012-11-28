<?php
/*
 * Template Name: Luna Contribute
 * Description: Formulaire de publication.
 */
?>
<?php
if (!empty($_POST)) {
	$user = wp_get_current_user();
	$post = array(
			/*'post_author' => $user->ID,*/
			/*'post_type' => 'post',*/
			'post_status' => 'publish',
			'post_title' => $_POST['post_title'],
			'post_content' => $_POST['post_content']
	);
	$id = wp_insert_post($post);
	if ($id != 0) {
		wp_set_post_terms($id, array('contribution'), 'category', true);
	}
	header('Location: ' . site_url('/'));
	die(); 
}
?>
<?php get_header(); ?>
<div class="box">
	<div class="innerbox">
		<form class="luna-contribute-form" method="POST">
			<p>
				<label for="post_title">Titre du sujet : </label>
				<input type="text" name="post_title" id="post_title">
			</p>
			<p>
				<label for="post_content">Corps du message : </label>
				<textarea rows="" cols="" name="post_content" id="post_content"></textarea>
			</p>
			<p>
				<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Envoyer">
			</p>
		</form>
	</div>
</div>
<?php get_footer(); ?>