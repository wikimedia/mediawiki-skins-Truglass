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
 * @date 4 December 2014
 *
 * To install place the Truglass folder (the folder containing this file!) into
 * skins/ and add this line to your wiki's LocalSettings.php:
 * require_once("$IP/skins/Truglass/Truglass.php");
 */

if ( function_exists( 'wfLoadSkin' ) ) {
	wfLoadSkin( 'Truglass' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['Truglass'] = __DIR__ . '/i18n';
	wfWarn(
		'Deprecated PHP entry point used for Truglass skin. Please use wfLoadSkin instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the Truglass skin requires MediaWiki 1.25+' );
}
