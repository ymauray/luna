<?php
add_action('init', 'register_main_menus');
add_action('init', 'register_last_visit');

function register_last_visit() {
	global $_SESSION;
	
	$user = wp_get_current_user();
	if ($user->ID != 0) {
		session_start();
 		if (!isset($_SESSION['last_visit'])) {
			$last_visit = get_user_meta($user->ID, 'last_visit', true);
			if ($last_visit == null) {
				$last_visit = date_format(new DateTime('14 days ago'), 'Y-m-d H:i:s');
			}
			$_SESSION['last_visit'] = $last_visit;
 		}
		$now = current_time('mysql');
 		update_user_meta($user->ID, 'last_visit', $now);
	}
}

$sidebar = array(
		'before_widget' => '<div class="box widget">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title">',
		'after_title' => '</div>'
);

register_sidebar($sidebar);

function register_main_menus() {
	register_nav_menus(array(
			'primary-menu' => 'Menu principal'
	));
}

if (!function_exists('luna_posted_on')):
function luna_posted_on() {
	printf('<span class="sep">Publié le </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a> à %2$s <span class="by-author"> <span class="sep"> par </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>',
			esc_url(get_permalink()),
			esc_attr(get_the_time()),
			esc_attr(get_the_date('c')),
			esc_html(get_the_date()),
			esc_url(get_author_posts_url(get_the_author_meta('ID'))),
			esc_attr(sprintf(__( 'View all posts by %s', 'twentyeleven'), get_the_author())),
			get_the_author()
	);
}
endif;

class Luna_Login_Widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
				'luna_login_widget', // Base ID
				'Luna::Connexion', // Name
				array('description' => 'Le Widget de connexion de Luna Argenti') // Args
		);
	}
	
	public function widget($args, $instance) {
		extract($args);
		
		echo $before_widget;
		
		$user = wp_get_current_user();
		if ($user->ID == 0) {
?>
<div class="title">Connexion</div>
<form  method="post" id="connectionform" action="<?php echo site_url('/login'); ?>">
<div>
	<p><label for="user_login">Identifiant : <input type="text" name="user_login" id="user_login" class="input" value=""></label></p>
	<p><label for="user_password">Mot de passe : <input type="password" name="user_password" id="user_password" class="input" value=""></label></p>
	<p class="forgetmenot"><label for="remember"><input type="checkbox" name="remember" id="remember" value="forever">Se souvenir de moi</label></p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Se connecter">
		<input type="hidden" name="luna-action" value="login">
	</p>
	<p>Pas encore de compte ? <a href="<?php echo site_url('/register'); ?>">S'enregistrer</a></p>
</div>
</form>
<?php 
		} else {
?>
<div class="title">Profil</div>
<form method="post" id="connectionform" action="<?php echo site_url('/login'); ?>">
<div>
	<p>Bonjour, <a href="<?php echo site_url('/profil'); ?>"><?php echo $user->display_name ?></a>.</p>
	<p>Envie de <a href="<?php echo site_url('/contribute'); ?>">dire quelque chose</a> ?</p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Se déconnecter">
		<input type="hidden" name="luna-action" value="logout">
	</p>
</div>
</form>
<?php 
		}
		echo $after_widget;
	}
};

add_action('widgets_init', 'luna_register_widgets');

function luna_register_widgets() {
	register_widget('luna_login_widget');
}

add_action('send_headers', 'luna_site_router');
add_action('wp_enqueue_scripts', 'luna_enqueue_scripts');

function luna_enqueue_scripts() {
}

function luna_site_router() {
	$root = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
	$url = str_replace($root, '', $_SERVER['REQUEST_URI']);
	$url = explode('/', $url);
	if ((count($url) == 1) && ($url[0] == 'login')) {
		require('luna-login.php');
		die();
	}
	elseif ((count($url) == 1) && ($url[0] == 'profil')) {
		require('luna-profil.php');
		die();
	}
	elseif ((count($url) == 1) && ($url[0] == 'register')) {
		require('luna-register.php');
		die();
	}
	elseif ((count($url) == 1) && ($url[0] == 'contribute')) {
		require('luna-contribute.php');
		die();
	}
}
?>
