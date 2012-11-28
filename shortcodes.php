<?php

$luna_members = array(
		"Kraäl" => array(
				"Absälon", "Erouän", "Grumli", "Elünil", "Opalÿne", "Yorgën", "Edmÿnd", "Skymo", "Zakkäry"
		), 
		"Balnazar" => array(
				"Ballthazzar", "Slaanek", "Azshärä", "Hephaistos", "Toubib", "Setesh"
		),
		"Jarmo" => array(
				"Jarx", "Jeromax", "Monolith", "Jaslo", "Jerx", "Jôgue", "Jaxy", "Jultyx", "Juxhil", "Janok"
		),
		"Lucylynn" => array(
				"Kyriël", "Fluxinel", "Adrenalynn", "Taela", "Terin", "Patatraxx", "Kyira", "Coudemas"
		),
		"Mïräjäne" => array(
				"Démonïr", "Nïrcïs", "Hëaly"
		),
		"Mégara" => array(
				"Clelïa", "Maëlÿnn", "Milï", "Mélusïne"
		),
		"Drakenhell" => array(
				"Söryo", "Drakenwolf", "Valgus", "Vodkilla"
		),
		"Thorgadon" => array(
				"Lokën"
		),
		"Gabrieliana" => array(
				"Azazaélle", "Shanglee"
		),
		"Meleke" => array(
				"Néloua", "Sandrîne", "Myelle", "Souana", "Lunaya", "Nukka", "Melyss", "Skymette", "Miskie"
		),
		"Vulkodlak" => array(
				"Heihu", "Bébébike", "Bïbi", "Minolia"
		),
		"Pulsifer" => array(
				"Havelock"
		),
		"Magicomix" => array(
				"Sarangha"
		),
		"Bestau" => array(
				"Haamshagar", "Antennefix"
		),
		"Valha" => array(
				"Trysmyne", "Haarn", "Vhoror"
		),
		"Oëmerin" => array(
				""
		),
		"Wulfeneir" => array(
				"Sombrah"
		),
		"Léonissa" => array(
				"Quadehar", "Elky", "Raidec"
		),
		"Arkanine" => array(
				""
		),
		"Allyäna" => array(
				""
		),
		"Valumia" => array(
				"Aeldriane"
		),
		"Jún" => array(
				"Lycän", "Farkass", "Nashaashuk", "Valkán"
		),
		"Methron" => array(
				""
		),
		"Kucykynn" => array(
				""
		),
		"Doxantracyde" => array(
				""
		),
		"Angenoïr" => array(
				""
		),
		"Loüenn" => array(
				""
		)
);

//[foobar]
function luna_guild($atts){
	global $wpdb;
	global $luna_members;
	global $charactersPerName;

	extract(shortcode_atts(array(
			'name' => '',
			'realm' => '',
			'region' => 'eu',
			'locale' => 'fr_FR',
			'refresh_data' => true
	), $atts));
	
	$base_url = 'http://' . $region . '.battle.net/api/wow';
	
	$two_days_ago = new DateTime('14 days ago');
	$luna_guild_last_check = new DateTime(get_option('luna_guild_last_check', date_format($two_days_ago, 'Y-m-d H:i:s')));
	$deadline = new DateTime();
	date_modify($deadline, '-1 day');
	if (($luna_guild_last_check < $deadline) || ($refresh_date == true)) {
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
	
	if ($refresh_data == true) {
		add_option('luna_guild_races', '', '', 'no');
		$data_url = $base_url . '/data/character/races?locale=' . $locale;
		$json = file_get_contents($data_url, true);
		update_option('luna_guild_races', $json);
	}
	
	$data = json_decode(get_option('luna_guild_races'));
	$races = array();
	foreach ($data->races as $race) {
		$races[$race->id] = $race;
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
	ob_start();
?>
	<p><?php echo $general_info->name ?>, guilde niveau <?php echo $general_info->level ?></p>
	<div>
		<p>Maitre de guilde :</p>
		<?php character_main($charactersPerName["Kraäl"]); ?>
		<?php unset($luna_members["Kraäl"]); ?>
	</div>
	<div>
		<p>Membres :</p>
		<?php foreach ($luna_members as $name => $rerolls):?>
			<?php character_main($charactersPerName[$name]); ?>
		<?php endforeach; ?>
	</div>
<?php 
	update_option('luna_guild_last_check', date_format(new DateTime('now'), 'Y-m-d H:i:s'));
	
	$html = ob_get_contents();
	
	ob_end_clean();
	
	return $html;
}
add_shortcode('luna-guild', 'luna_guild');

function character_main($character) {
	global $luna_members;
	global $charactersPerName;
?>
	<div class="luna-character-main">
		<?php echo $character->name; ?>
		<img src="<?php echo get_template_directory_uri() . '/wow/race-' . $character->race . '-' . $character->gender . '.png'; ?>"/>
		<img src="<?php echo get_template_directory_uri() . '/wow/class-' . $character->class . '.png'; ?>"/>
		<?php echo $character->level; ?>
		<?php unset($charactersPerName[$character->name]); ?>
	</div>
	<div class="luna-character-rerolls">
		<span>Rerolls :	</span>
		<ul>
			<?php $rerolls = $luna_members[$character->name]; ?>
			<?php foreach($rerolls as $reroll): ?>
			<li><?php echo $reroll; ?></li>
			<?php unset($charactersPerName[$reroll]); ?>
			<?php endforeach; ?>
		</ul>
	</div>
<?php		
}
?>
