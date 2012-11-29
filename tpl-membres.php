<?php
/*
 * Template Name: Membres
 */
?> 
<?php get_header(); ?>

<?php
$luna_members = array(
		'Kraäl' => array(
				'Absälon', 'Edmÿnd', 'Elünil', 'Erouän', 'Grumli', 'Opalÿne', 'Skymo', 'Yorgën', 'Zakkäry'
		),
		'Balnazar' => array(
				'Azshärä', 'Ballthazzar', 'Hephaistos', 'Setesh', 'Slaanek', 'Toubib'
		),
		'Jarmo' => array(
				'Janok', 'Jarx', 'Jaslo', 'Jaxy', 'Jeromax', 'Jerx', 'Jôgue', 'Jultyx', 'Juxhil', 'Monolith'
		),
		'Lucylynn' => array(
				'Adrenalynn', 'Coudemas', 'Fluxinel', 'Kucykynn', 'Kyira', 'Kyriël', 'Patatraxx', 'Taela', 'Terin'
		),
		'Mégara' => array(
				'Clelïa', 'Loüenn', 'Maëlÿnn', 'Mélusïne', 'Milï'
		),
		'Meleke' => array(
				'Lunaya', 'Melyss', 'Miskie', 'Myelle', 'Néloua', 'Nukka', 'Sandrîne', 'Skymette', 'Souana'
		),
		'Mïräjäne' => array(
				'Démonïr', 'Hëaly', 'Nïrcïs'
		),
		'Thorgadon' => array(
				'Lokën'
		),
		'Angenoïr' => array(
		),
		'Allyäna' => array(
		),
		'Arkanine' => array(
		),
		'Bestau' => array(
				'Antennefix', 'Haamshagar' 
		),
		'Doxantracyde' => array(
		),
		'Drakenhell' => array(
				'Drakenwolf', 'Söryo', 'Valgus', 'Vodkilla'
		),
		'Gabrieliana' => array(
				'Azazaélle', 'Shanglee'
		),
		'Jún' => array(
				'Farkass', 'Lycän', 'Nashaashuk', 'Valkán'
		),
		'Léonissa' => array(
				'Elky', 'Quadehar', 'Raidec'
		),
		'Magicomix' => array(
				'Sarangha'
		),
		'Methron' => array(
		),
		'Oëmerin' => array(
		),
		'Pulsifer' => array(
				'Havelock'
		),
		'Valha' => array(
				'Haarn', 'Trysmyne', 'Vhoror'
		),
		'Valumia' => array(
				'Aeldriane'
		),
		'Vulkodlak' => array(
				'Bébébike', 'Bïbi', 'Heihu', 'Minolia'
		),
		'Wulfeneir' => array(
				'Sombrah'
		),
);

$classes = array(
		1 => array('Guerrier', 'Guerrière'),
		2 => array('Paladin', 'Paladin'),
		3 => array('Chasseur', 'Chasseresse'),
		4 => array('Voleur', 'Voleuse'),
		5 => array('Prêtre', 'Prêtresse'),
		6 => array('Chevalier de la mort', 'Chevalier de la mort'),
		7 => array('Chaman', 'Chamane'),
		8 => array('Mage', 'Mage'),
		9 => array('Démoniste', 'Démoniste'),
		10 => array('Moine', 'Moniale'),
		11 => array('Druide', 'Druidesse')
);

$races = array(
		1 => array('Humain', 'Humaine'),
		3 => array('Nain', 'Naine'),
		4 => array('Elfe de la nuit', 'Elfe de la nuit'),
		7 => array('Gnome', 'Gnome'),
		11 => array('Draeneï', 'Draeneï'),
		22 => array('Worgen', 'Worgen'),
		25 => array('Pandaren', 'Pandarène')
);

function get_clazz($class, $gender) {
	global $classes;
	
	if (isset($classes[$class][$gender]))
		return $classes[$class][$gender];
	else
		return $class;
}

function get_race($race, $gender) {
	global $races;

	if (isset($races[$race][$gender]))
		return $races[$race][$gender];
	else
		return $race;
}

function character_main($character, $region) {
	global $luna_members;
	global $charactersPerName;

	$url_base = 'http://' . $region . '.battle.net/static-render/' . $region . '/';
	$avatar = $character->thumbnail;
	$card = str_replace('avatar', 'card', $avatar);
	$profile = str_replace('avatar', 'profilemain', $avatar);
	$inset = str_replace('avatar', 'inset', $avatar);
	?>
	<div class="box luna-character-main" style="background-image: url(<?php echo $url_base . $card; ?>);">
		<div class="identity">
			<div class="name"><a href="http://<?php echo $region; ?>.battle.net/wow/character/les-sentinelles/<?php echo $character->name; ?>/advanced"><?php echo $character->name; ?></a></div>
			<div class="meta"><?php echo get_clazz($character->class, $character->gender); ?> <?php echo get_race($character->race, $character->gender); ?> de niveau <?php echo $character->level; ?></div>
		</div>
		<?php unset($charactersPerName[$character->name]); ?>
		<div class="rerolls">
			<?php $rerolls = $luna_members[$character->name]; ?>
			<?php foreach($rerolls as $reroll): ?>
			<div><a href="http://<?php echo $region; ?>.battle.net/wow/character/les-sentinelles/<?php echo $reroll; ?>/advanced"><?php echo $reroll; ?></a></div>
			<?php unset($charactersPerName[$reroll]); ?>
			<?php endforeach; ?>
		</div>
	</div>
<?php
}

$name = 'Luna Argenti';
$realm = 'Les Sentinelles';
$region = 'eu';
$locale = 'fr_FR';
$refresh_data = false;

$base_url = 'http://' . $region . '.battle.net/api/wow';

$two_days_ago = new DateTime('14 days ago');
$luna_guild_last_check = new DateTime(get_option('luna_guild_last_check', date_format($two_days_ago, 'Y-m-d H:i:s')));
$deadline = new DateTime();
date_modify($deadline, '-1 day');
if (($luna_guild_last_check < $deadline) || ($refresh_data == true)) {
	add_option('luna_guild_last_check', '', '', 'no');
	add_option('luna_guild_general_info', '', '', 'no');
	add_option('luna_guild_members', '', '', 'no');
	$guild_url = $base_url . '/guild/' . str_replace(' ', '-', $realm) . '/' . str_replace(' ', '%20', $name) . '?locale=' . $locale;
	$json = file_get_contents($guild_url, true);
	update_option('luna_guild_general_info', $json);
	$guild_url .= '&fields=members';
	$json = file_get_contents($guild_url, true);
	update_option('luna_guild_members', $json);
}

$json = get_option('luna_guild_general_info');
$general_info = json_decode($json);
$json = get_option('luna_guild_members');
$members = json_decode($json);
$members = $members->members;
$charactersPerRank = array();
$charactersPerName = array();
foreach ($members as $member) {
	$charactersPerRank[$member->rank][] = $member->character;
	$charactersPerName[$member->character->name] = $member->character;
}
?>
	<?php character_main($charactersPerName["Kraäl"], $region); ?>
	<?php unset($luna_members["Kraäl"]); ?>
	<?php foreach ($luna_members as $name => $rerolls):?>
		<?php character_main($charactersPerName[$name], $region); ?>
	<?php endforeach; ?>
<?php 
update_option('luna_guild_last_check', date_format(new DateTime('now'), 'Y-m-d H:i:s'));

?>
<?php get_footer(); ?>
