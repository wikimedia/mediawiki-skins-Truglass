<?php
/**
 * Truglass skin for MediaWiki
 *
 * Source: http://meta.enterwiki.net/page/MediaWiki:CODE/skins/Truglass.php
 *
 * @file
 * @author Elliott Franklin Cable <me@ell.io>
 * @author Jack Phoenix
 * @copyright Copyright © Elliott Franklin Cable
 * @copyright Copyright © 2009-2025 Jack Phoenix
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

use MediaWiki\Html\Html;
use MediaWiki\Linker\Linker;
use MediaWiki\MediaWikiServices;

class TruglassTemplate extends BaseTemplate {

	/**
	 * Template filter callback for Truglass skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 */
	public function execute() {
		$skin = $this->getSkin();
		$this->data['pageLanguage'] = $skin->getTitle()->getPageLanguage()->getHtmlCode();

?><div id="main">
	<table class="fullwidth container" cellpadding="0">
		<tr>
			<td colspan="2">
				<div id="header">
					<div class="headerback">
						<div id="ptools" class="noprint">
							<ul>
							<?php
							foreach ( $this->getPersonalTools() as $key => $item ) {
								echo $this->makeListItem( $key, $item );
							}
							?>
							</ul>
						</div>
						<?php $this->searchBox(); ?>
						<h1 id="title" lang="<?php $this->text( 'pageLanguage' ) ?>"><?php $this->html( 'title' ) ?></h1>
						<?php $this->cactions(); ?>
					</div>
				</div>
				<div class="toplineone"><div>&zwnj;</div></div>
			</td>
		</tr>
		<tr>
			<td class="contentshell" data-mw-ve-target-container>
				<table class="cbar noprint">
					<tbody>
						<tr>
							<td>
							<?php foreach ( $this->data['content_actions'] as $key => $tab ) { ?>
								<?php if ( !preg_match( "/^(article|talk|nstab-main|nstab-user|nstab-wp|nstab-image|nstab-mediawiki|nstab-template|nstab-help|nstab-category)$/", $key ) ) { ?>
									<span id="ca-<?php echo htmlspecialchars( $key ) ?>"><a href="<?php echo htmlspecialchars( $tab['href'] ) ?>"<?php if ( isset( $tab['class'] ) && $tab['class'] ) { ?> class="<?php echo htmlspecialchars( $tab['class'] ) ?>"<?php } ?> title="<?php echo htmlspecialchars( Linker::titleAttrib( $tab['id'], 'withaccess' ), ENT_QUOTES ) ?>" accesskey="<?php echo htmlspecialchars( Linker::accesskey( $tab['id'] ), ENT_QUOTES ) ?>"><?php echo htmlspecialchars( $tab['text'] ) ?></a></span>
								<?php } ?>
							<?php } ?>
							</td>
						</tr>
					</tbody>
				</table>
				<div id="content">
					<?php /* Hook point for ShoutWiki Ads extension */ MediaWikiServices::getInstance()->getHookContainer()->run( 'TruglassInContent' ); ?>
					<table class="fullwidth" id="bC">
						<tr>
							<td id="realcontent">
								<?php if ( $this->data['sitenotice'] ) { ?>
								<div id="siteNotice">
									<?php $this->html( 'sitenotice' ) ?>
								</div>
							<?php } elseif ( $skin->getTitle()->getNamespace() != NS_SPECIAL ) { ?>
								<div id="siteNotice">
									<span class="sntext">
										<?php echo $skin->msg( 'truglass-welcome' )->parse(); ?>
									</span>
								</div>
							<?php } ?>
								<a id="top"></a>
								<h3 id="siteSub"><?php $this->msg( 'tagline' ) ?></h3>
								<?php echo $this->getIndicators(); ?>
								<div id="contentSub2"><?php $this->html( 'subtitle' ) ?></div>
								<?php if ( $this->data['undelete'] ) { ?><div id="contentSub"><?php $this->html( 'undelete' ) ?></div><?php } ?>
								<?php if ( $this->data['newtalk'] ) { ?><div class="usermessage"><?php $this->html( 'newtalk' ) ?></div><?php } ?>
								<div id="jump-to-nav" class="mw-jump"><?php $this->msg( 'jumpto' ) ?> <a href="#column-one"><?php $this->msg( 'jumptonavigation' ) ?></a>, <a href="#searchInput"><?php $this->msg( 'jumptosearch' ) ?></a></div>
								<!-- start content -->
								<?php $this->html( 'bodytext' ) ?>
								<?php
								if ( $this->data['catlinks'] ) {
									$this->html( 'catlinks' );
								}
								?>
								<!-- end content -->
								<?php if ( $this->data['dataAfterContent'] ) { $this->html( 'dataAfterContent' ); } ?>
							</td>
						</tr>
					</table>
				</div>
			</td>
			<!-- Begin sidebar -->
			<td class="sidebar noprint">
				<div id="sidebar">
					<?php $this->renderPortals( $this->data['sidebar'] ); ?>
				</div>
			</td>
		</tr>
		<tr class="noprint">
			<td colspan="2">
				<div class="bottomline">
					<div>
					</div>
				</div>
				<div id="nN">
					<div class="networknavback">
					<?php
						$navlinks = [ 'privacy', 'about', 'disclaimer' ];
						// Add MobileFrontend toggle link if both MF and the Minerva skin are enabled
						// @todo FIXME: so hacky!
						if ( class_exists( 'MobileContext' ) && class_exists( 'SkinMinerva' ) ) {
							$navlinks[] = 'mobileview';
						}
					?>
						<sup><small><?php $this->html( $navlinks[0] ) ?></small></sup>
					<?php
						foreach ( array_slice( $navlinks, 1 ) as $nLink ) {
							if ( $this->data[$nLink] ) {
					?>		<sup><small><b>&nbsp;&bull;&nbsp;</b></small></sup><!-- separator -->
							<sup><small><?php $this->html( $nLink ) ?></small></sup>
<?php
						}
					}
				?>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>
<?php
	#$validFooterLinks = $this->getFooterLinks( 'flat' ); // Additional footer links
	// I can't figure out how to remove copyright, privacy, about and disclaimer
	// from the array that getFooterLinks() returns, so this will unfortunately
	// have to do [[for now]]
	$validFooterLinks = [
		'lastmod', 'viewcount', 'numberofwatchingusers', 'credits', /*'copyright',
		'privacy', 'about', 'disclaimer',*/ 'tagline',
	];

	$footerMessage = $skin->msg( 'truglass-footertext' );

	// Horribly inelegant, unstable and otherwise hacky.
	// I have no clue whatsoever why unset( $validFooterLinks['about'] );
	// (for example) doesn't work here...
	$hasFooterLinks = (
		isset( $this->data['lastmod'] ) && $this->data['lastmod'] ||
		isset( $this->data['viewcount'] ) && $this->data['viewcount'] ||
		isset( $this->data['numberofwatchingusers'] ) && $this->data['numberofwatchingusers'] ||
		isset( $this->data['credits'] ) && $this->data['credits'] ||
		isset( $this->data['tagline'] ) && $this->data['tagline']
	);

	// Open the #footer and #pageinfo divs if we have something that goes there
	if ( $hasFooterLinks || !$footerMessage->isBlank() || isset( $this->data['copyright'] ) && $this->data['copyright'] ):
?>
<div id="footer" class="noprint">
	<div id="pageinfo">
<?php
	if ( $hasFooterLinks ) {
?>
		<ul>
<?php foreach ( $validFooterLinks as $aLink ) {
			if ( isset( $this->data[$aLink] ) && $this->data[$aLink] ) {
?>			<li id="<?php echo $aLink ?>"><?php $this->html( $aLink ) ?></li>
<?php
			}
		}
?>
		</ul>
<?php
	} // hasFooterLinks check

	// This is so that we show #verybottomfooter *only* if it has some content
	if ( !$footerMessage->isBlank() || isset( $this->data['copyright'] ) && $this->data['copyright'] ) {
?>
		<div id="verybottomfooter">
<?php
		if ( !$footerMessage->isBlank() ) {
			echo $footerMessage->parse() . '<br />';
		}

		if ( $this->data['copyright'] ) {
			$this->html( 'copyright' );
		}
	}
?>
		</div>
	</div>
</div>
<?php endif;
	} // end of execute() method

	/*************************************************************************************************/

	/**
	 * @param $sidebar array
	 */
	protected function renderPortals( $sidebar ) {
		if ( !isset( $sidebar['SEARCH'] ) ) {
			// @phan-suppress-next-line PhanTypeMismatchDimAssignment
			$sidebar['SEARCH'] = false; // changed
		}
		if ( !isset( $sidebar['TOOLBOX'] ) ) {
			$sidebar['TOOLBOX'] = true;
		}
		if ( !isset( $sidebar['LANGUAGES'] ) ) {
			$sidebar['LANGUAGES'] = true;
		}
		if ( !isset( $sidebar['NETWORKNAVIGATION'] ) ) {
			$sidebar['NETWORKNAVIGATION'] = true; // this is a custom thingy
		}

		foreach ( $sidebar as $boxName => $content ) {
			if ( $content === false ) {
				continue;
			}

			if ( $boxName == 'NETWORKNAVIGATION' ) {
				$this->networkNavigationBox();
			} elseif ( $boxName == 'TOOLBOX' ) {
				$this->toolbox();
			} elseif ( $boxName == 'LANGUAGES' ) {
				$this->languageBox();
			} elseif ( $boxName !== 'SEARCH' ) {
				$this->customBox( $boxName, $content );
			}
		}
	}

	function searchBox() {
		// For grep: the following images are used here:
		// searchleftcap.gif, searchleftcap_rtl.gif, searchrightcap.gif,
		// searchrightcap_rtl.gif
		$skin = $this->getSkin();
		$isRTL = $skin->getLanguage()->isRTL();
		$stylepath =  $skin->getConfig()->get( 'StylePath' ) . '/Truglass/truglass';
?>
						<!-- Search form -->
						<div id="search" class="noprint">
							<form name="searchform" action="<?php $this->text( 'wgScript' ) ?>" id="searchform">
								<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
								<input type="hidden" name="fulltext" class="searchButton" value="<?php $this->msg( 'search' ) ?>" />
								<img src="<?php echo $stylepath ?>/searchleftcap<?php if ( $isRTL ) echo '_rtl'; ?>.gif" alt="" width="17" height="19" border="0" id="s1" class="srchimgs" />
								<input type="text" name="search" class="sbox" id="searchInput" <?php if( $this->haveMsg( 'accesskey-search' ) ) { ?>accesskey="<?php $this->msg( 'accesskey-search' ) ?>"<?php } if( isset( $this->data['search'] ) ) { ?> value="<?php $this->text( 'search' ) ?>"<?php } ?> />
								<img src="<?php echo $stylepath ?>/searchrightcap<?php if ( $isRTL ) echo '_rtl'; ?>.gif" alt="" width="9" height="19" border="0" id="s2" class="srchimgs" />
							</form>
						</div>
						<!-- //Search form -->
<?php
	}

	/**
	 * Prints the content actions bar.
	 */
	function cactions() {
?>
						<div id="cactions" class="noprint">
							<?php foreach ( $this->data['content_actions'] as $key => $tab ) { ?>
								<?php if ( preg_match( "/^(nstab-main|nstab-user|nstab-project|nstab-image|nstab-mediawiki|nstab-template|nstab-help|nstab-category)$/", $key ) ) { ?>
									<div id="contentpages"><span id="ca-<?php echo htmlspecialchars( $key ) ?>">[ <a href="<?php echo htmlspecialchars( $tab['href'] ) ?>"<?php if( $tab['class'] ) { ?> class="<?php echo htmlspecialchars( $tab['class'] ) ?>"<?php } ?>><?php echo htmlspecialchars( $tab['text'] ) ?></a></span>
								<?php } elseif( preg_match( "/^(talk)$/", $key ) ) { ?>
									<span id="ca-<?php echo htmlspecialchars( $key ) ?>"><a href="<?php echo htmlspecialchars( $tab['href'] ) ?>"<?php if( $tab['class'] ) { ?> class="<?php echo htmlspecialchars( $tab['class'] ) ?>"<?php } ?>><?php echo htmlspecialchars( $tab['text'] ) ?></a> ]</span></div>
								<?php } elseif( preg_match( "/^(article|nstab-special)$/", $key ) ) { ?>
									<div id="contentpages"><span id="ca-<?php echo htmlspecialchars( $key ) ?>">[ <a href="<?php echo htmlspecialchars( $tab['href'] ) ?>"<?php if( $tab['class'] ) { ?> class="<?php echo htmlspecialchars( $tab['class'] ) ?>"<?php } ?>><?php echo htmlspecialchars( $tab['text'] ) ?></a> ]</span></div><br />
								<?php } ?>
							<?php } ?>
						</div>
<?php
	}

	/*************************************************************************************************/
	function toolbox() {
?>
			<div class="sbmodule" id="sbm-toolbox">
				<h4 class="sbmoduletitle displayer"><?php $this->msg( 'toolbox' ) ?></h4>
				<div class="sbmodulebody">
					<div class="stretcher">
						<ul>
<?php
		foreach ( $this->data['sidebar']['TOOLBOX'] as $key => $tbitem ) {
			echo $this->makeListItem( $key, $tbitem );
		}

		// Avoid PHP 7.1 warning of passing $this by reference
		$template = $this;
		MediaWikiServices::getInstance()->getHookContainer()->run( 'SkinTemplateToolboxEnd', [ &$template, true ] );
?>
						</ul>
					</div>
				</div>
			</div>
<?php
	}

	/*************************************************************************************************/
	function languageBox() {
		if ( $this->data['language_urls'] ) {
?>
					<div class="sbmodule" id="sbm-lang">
						<h4 class="sbmoduletitle displayer"<?php $this->html( 'userlangattributes' ) ?>><?php $this->msg( 'otherlanguages' ) ?></h4>
						<div class="sbmodulebody">
							<div class="stretcher">
								<ul>
<?php							foreach ( $this->data['language_urls'] as $key => $langlink ) {
									echo $this->makeListItem( $key, $langlink );
								}
								?>
								</ul>
							</div>
						</div>
					</div>
<?php
		}
	}

	/**
	 * Renders the "Network Navigation" box, which is nothing but an elaborate
	 * box of "sponsored" links, if $wgTruglassSidebarLinks is not empty and is
	 * an array.
	 */
	function networkNavigationBox() {
		$sidebarLinks = $this->config->get( 'TruglassSidebarLinks' );

		if ( is_array( $sidebarLinks ) && $sidebarLinks ) {
?>
					<div class="sbmodule" id="sbm-networknav">
						<h4 class="sbmoduletitle displayer"><?php echo $this->getSkin()->msg( 'truglass-links' )->parse() ?></h4>
						<div class="sbmodulebody">
							<div class="stretcher">
								<ul>
									<?php
									foreach ( $sidebarLinks as $link => $title ) {
										echo '<li><a href="http://' . $link . '/">' . $title . '</a></li>';
									}
									?>
								</ul>
							</div>
						</div>
					</div>
<?php }
	}

	/*************************************************************************************************/
	/**
	 * @param $bar string
	 * @param $cont array|string
	 */
	function customBox( $bar, $cont ) {
		$portletAttribs = [
			'class' => 'sbmodule',
			'id' => Sanitizer::escapeIdForAttribute( "sbm-$bar" )
		];
		$tooltip = Linker::titleAttrib( "p-$bar" );
		if ( $tooltip !== false ) {
			$portletAttribs['title'] = $tooltip;
		}
		$skin = $this->getSkin();
		$msg = $skin->msg( $bar );
		echo '	' . Html::openElement( 'div', $portletAttribs );
?>

		<h4 class="sbmoduletitle displayer"><?php echo htmlspecialchars( $msg->exists() ? $msg->text() : $bar ); ?></h4>
		<div class="sbmodulebody">
			<div class="stretcher">
<?php	if ( is_array( $cont ) ) { ?>
			<ul>
<?php		foreach ( $cont as $key => $val ) {
				// prefix the IDs with smb-
				$val['id'] = 'smb-' . $val['id'];
				echo $this->makeListItem( $key, $val );
			}
?>
			</ul>
<?php	} else {
			# allow raw HTML block to be defined by extensions
			echo $cont;
		}

		// Need this nonsense to support NewsBox in MW 1.39+ using the new hooks (urgh)
		$content = $skin->getAfterPortlet( $bar );
		if ( $content !== '' ) {
			echo Html::rawElement(
				'div',
				[ 'class' => [ 'after-portlet', 'after-portlet-' . $bar ] ],
				$content
			);
		}
?>
			</div>
		</div>
	</div>
<?php
	}

} // end of class
