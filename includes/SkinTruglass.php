<?php

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @ingroup Skins
 */
class SkinTruglass extends SkinTemplate {
	public $skinname = 'truglass', $stylename = 'truglass',
		$template = 'TruglassTemplate', $useHeadElement = true;
	/**
	 * @var Config
	 */
	private $truglassConfig;

	public function __construct() {
		$this->truglassConfig = ConfigFactory::getDefaultInstance()->makeConfig( 'truglass' );
	}

	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

		// Add CSS
		$out->addModuleStyles( 'skins.truglass' );
	}

	/**
	 * Override to pass our Config instance to it
	 */
	public function setupTemplate( $classname, $repository = false, $cache_dir = false ) {
		return new $classname( $this->truglassConfig );
	}
}