<?php
/**
 * Share Icons Widget
 * @package sharethis
 */
class ShareIconsWidget extends Widget {
	
	static $db = array(
		'EnabledIcons' => 'Varchar(255)'
	);
	static $has_one = array();
	
	static $title = "Share This!";
	static $cmsTitle = "ShareThis Widget";
	static $description = "Show icons for sharing the page on a variety of social bookmarking sites.";
	
	function getCMSFields() {
		return new FieldSet(
			new TextField("EnabledIcons", "Enabled Icons"),
			new LiteralField('EnabledIconsHelp','<p>A comma seperated list of social bookmarking sites to use</p>')
		);
	}
	
	function Content() {
		// Backup old EnabledIcons
		$oldsites = ShareIcons::$EnabledIcons; $oldtitle = ShareIcons::$disable_sharethis_title;

		// Get ShareThis html
		ShareIcons::$EnabledIcons = preg_split( '/\s*,\s*/', $this->EnabledIcons ); ShareIcons::$disable_sharethis_title = true;
		$res = Director::currentPage()->ShareThis(true);
		
		// Restore old EnabledIcons
		ShareIcons::$EnabledIcons = $oldsites; ShareIcons::$disable_sharethis_title = $oldtitle;
		return $res;
	}
	
	function PostLink() {
		$container = BlogTree::current();
		if ($container) return $container->Link('post');
	}
}

?>
