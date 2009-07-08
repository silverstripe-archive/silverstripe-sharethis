<?php
/**
 * Add a field to each SiteTree object and it's subclasses to enable Share icons.
 * 
 * You can (and should) customise this class by adding the following options 
 * to your _config.php file:
 * - {@link ShareIcons::$EnabledIcons}: An array of the enabled icons
 * - {@link ShareIcons::$IconTransparent}: Use transparent icons (or not)
 * - {@link ShareIcons::$ShowTitle}: Show the title next to the icon (or not)
 */
class ShareIcons extends DataObjectDecorator {
	
	
	/**
	 * Boolean that determines whether icons are transparent or not.
	 * @var boolean
	 */
	static $IconTransparent = false;
	
	/**
	 * Boolean that determines whether to show the title of the site next to 
	 * the icon.
	 * @var boolean
	 */
	static $ShowTitle = true;
	
	/**
	 * Sets the enabled icons list. May contain any of the following:
	 * - email
	 * - print
	 * - digg
	 * - reddit
	 * - delicious
	 * - furl
	 * - ma.gnolia
	 * - newsvine
	 * - live
	 * - myweb
	 * - google
	 * - stumbleupon
	 * - simpy
	 * 
	 * Example: ShareIcons::$EnabledIcons = array('digg', 'delicious');
	 * @var array
	 */
	static $EnabledIcons = array();
	
	/**
	 * Allows you to specify alternate images for each of the icons. Will be 
	 * used only if specified, otherwise the default will be used. If this is 
	 * used, it won't try to get transparent/non-transparent images.
	 * @var array
	 */
	static $alternate_icons = array();
	
	/**
	 * Allows you to specify icons to appear on dataobjects rather then pages
	 * eg Forum Posts
	 */
	static $dataobject_sharing = false;
	
	/**
	 * Default Controller if needed for dataobject sharing. Eg forum/
	 */
	static $dataobject_controller = "";
	
	/**
	 * Appends a string to the end of the title which is submitted
	 * to the providers
	 */
	static $custom_title = "";
	
	/**
	 * Disable the title ('Share This!') by setting this static to true.
	 * @var boolean
	 */
	static $disable_sharethis_title = false;
		 
	function extraStatics(){
	return array(
		'db' => array(
			'ShareIcons' => 'Boolean'
		)
	);
	}
	
	/**
	 * Add a share icons field to cms 
	 * This method doesn't seemed to get automatically called. had to add a static method to config.
	*/
	
	function updateCMSFields(FieldSet &$fields) {
		$fields->addFieldToTab("Root.Behaviour", new CheckboxField("ShareIcons",_t('ShareIcons.SHOWSHAREICONS','Show Share Icons in this page ?')));
		return $fields;
	}
	
	/**
	 * At the moment this method does nothing.
	 */
	
	function augmentSQL(SQLQuery &$query) {}


	/**
	 * At the moment this method does nothing.
	 */
	function augmentDatabase() {}
	
	function ShareThis($overrideDisplay=false){
		$snippet = "";
		$page_url = Director::absoluteBaseURL() . Controller::curr()->Link();
		$obj = $this->owner;
		if(self::$dataobject_sharing) {
			$page_url = Director::absoluteBaseURL() . self::$dataobject_controller . $obj->ID;
		}
		$page_title = $obj->Title;	
		if(self::$custom_title) {
			$page_title .= ' ' . self::$custom_title;
		}
		$bookmarks = array(
			"email" => array(
						"url" => "mailto:?body=$page_url",
						"title" => _t('ShareIcons.EMAIL','Email')),
			"print" => array(
						"url" => "javascript:window.print()",
						"title" => _t('ShareIcons.PRINT','Print')),	
			"digg" => array(
						"url" => "http://digg.com/submit?".htmlentities("phase=2&url=$page_url&title=$page_title"),
						"title" => _t('ShareIcons.DIGGTHIS','Digg this!')),
			"reddit" => array(
						"url" => "http://reddit.com/submit?".htmlentities("url=$page_url&title=$page_title"),
						"title" => _t('ShareIcons.REDDIT','Reddit!')),
			"delicious" => array(
						"url" => "http://del.icio.us/post?".htmlentities("v=4&noui&jump=close&url=$page_url&title=$page_title"),
						"title" => _t('ShareIcons.DELICIOUS','Add to del.icio.us')),
			"furl" => array(
						"url" => "http://www.furl.net/storeIt.jsp?".htmlentities("t=$page_title&u=$page_url"),
						"title" => _t('ShareIcons.FURLTHIS','Furl this!')),
			"ma.gnolia" => array(
						"url" => "http://ma.gnolia.com/bookmarklet/add?".htmlentities("url=$page_url&title=$page_title"),
						"title" => _t('ShareIcons.MAGNOLIA','Add to ma.gnolia')),
			"newsvine" => array(
						"url" => "http://www.newsvine.com/_tools/seed".htmlentities("&save?u=$page_url&h=$page_title"), 
						"title" => _t('ShareIcons.NEWSVINE','Save to Newsvine!')),
			"live" => array(
						"url" => "https://favorites.live.com/quickadd.aspx?".htmlentities("marklet=1&mkt=en-us&url=$page_url&title=$page_title&top=1"),
						"title" => _t('ShareIcons.WINDOWSLIVE','Add to Windows Live')),
			"myweb" => array(
						"url" =>  "http://myweb.yahoo.com/myresults/bookmarklet?".htmlentities("t=$page_title&u=$page_url&ei=UTF"),
						"title" => _t('ShareIcons.YAHOO','Add to Yahoo MyWeb')),
			"google" => array(
						"url" =>  "http://www.google.com/bookmarks/mark?".htmlentities("op=edit&output=popup&bkmk=$page_url&title=$page_title"),
						"title" => _t('ShareIcons.GOOGLIZE','Googlize this post!')),
			"stumbleupon" => array(
						"url" => "http://www.stumbleupon.com/submit?".htmlentities("url=$page_url&title=$page_title"),
						"title" => _t('ShareIcons.STUMBLEIT','Stumble It!')),
			"facebook" => array(
					   "url" => "http://www.facebook.com/share.php?".htmlentities("u=$page_url&t=$page_title"),
					   "title" => _t('ShareIcons.FACEBOOK','Share on Facebook')),
			"simpy" => array(
						"url" => "http://simpy.com/simpy/LinkAdd.do?".htmlentities("title=$page_title&href=$page_url"),
						"title" => _t('ShareIcons.SIMPY','Add to Simpy'))
		); 
	
		if($overrideDisplay || $obj->ShareIcons || self::$dataobject_sharing) {
			$format = self::$IconTransparent ? "_trans" : "";
			if(!self::$disable_sharethis_title) $snippet = '<h3>' . _t('ShareIcons.SHARETHIS','Share This !') . '</h3>'; // Only show the title if it hasn't been disabled
			$snippet .= '<ul class="share-list">';
	
			foreach(self::$EnabledIcons as $enabled){
				$title = self::$ShowTitle ? $bookmarks[$enabled]['title'] : "";
				$snippet .= '<li><a href="'.$bookmarks[$enabled]['url'].'">';
			
				if(isset(self::$alternate_icons["$enabled"]) && Director::fileExists(self::$alternate_icons["$enabled"])) {
					$snippet .= '<img src="'.self::$alternate_icons["$enabled"].'" alt="'. $bookmarks[$enabled]['title'].'" title="'. $bookmarks[$enabled]['title'].'"/>'.$title.'</a></li>';
				} else {
					$snippet .= '<img src="sharethis/images/icons/'.$enabled.$format.'.gif" alt="'. $bookmarks[$enabled]['title'].'" title="'. $bookmarks[$enabled]['title'].'"/>'.$title.'</a></li>';
				}
			}
		}
		$snippet .= '</ul>';	
		return $snippet;
	}	
}
?>