<?php
/**
 * Truglass skin
 *
 * @file
 * @ingroup Skins
 * @author Elliott Franklin Cable
 * @author Jack Phoenix <jack@countervandalism.net>
 * @copyright Copyright © Elliott Franklin Cable
 * @copyright Copyright © 2009-2014 Jack Phoenix
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @date 27 July 2014
 *
 * To install place the Truglass folder (the folder containing this file!) into
 * skins/ and add this line to your wiki's LocalSettings.php:
 * require_once("$IP/skins/Truglass/Truglass.php");
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not a valid entry point.' );
}

// Skin credits that will show up on Special:Version
$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Truglass',
	'version' => '3.1',
	'author' => array( 'Elliott Franklin Cable', 'Jack Phoenix' ),
	'description' => 'A sleek, stylish, simplified skin',
	'url' => 'https://www.mediawiki.org/wiki/Skin:Truglass',
);

// The first instance must be strtolower()ed so that useskin=truglass works and
// so that it does *not* force an initial capital (i.e. we do NOT want
// useskin=Truglass) and the second instance is used to determine the name of
// *this* file.
$wgValidSkinNames['truglass'] = 'Truglass';

// Autoload the skin class, make it a valid skin, set up i18n, set up CSS
// (via ResourceLoader)
$wgAutoloadClasses['SkinTruglass'] = __DIR__ . '/Truglass.skin.php';
$wgMessagesDirs['SkinTruglass'] = __DIR__ . '/i18n';
$wgResourceModules['skins.truglass'] = array(
	'styles' => array(
		'skins/Truglass/truglass/main.css' => array( 'media' => 'screen' ),
		'skins/Truglass/truglass/handheld.css' => array( 'media' => 'handheld' ),
	),
	'position' => 'top'
);

$wgTruglassSidebarLinks = array();