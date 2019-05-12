<?php

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @ingroup Skins
 */
class SkinTruglass extends SkinTemplate {
	public $skinname = 'truglass', $stylename = 'truglass',
		$template = 'TruglassTemplate';
	/**
	 * @var Config
	 */
	private $truglassConfig;

	public function __construct() {
		parent::__construct( ...func_get_args() );
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
