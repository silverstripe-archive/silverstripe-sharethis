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
		 
	function extraDBFields(){
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
		$fields->addFieldToTab("Root.Behaviour", new CheckboxField("ShareIcons","Show Share Icons on this page ?"));
		return $fields;
	}
	
	/**
	 * At the moment this method does nothing.
	 */
	
	function augmentSQL(SQLQuery &$query) {
	}


	/**
	 * At the moment this method does nothing.
	 */
	function augmentDatabase() {
	}
	
	function ShareThis(){
	
	$snippet = "";
	$page_url = Director::absoluteBaseURL().Director::currentURLSegment();
	$obj = $this->owner;
	$page_title = $obj->Title;	
	
	$bookmarks = array(
	"email" => array(
				"url" => "mailto:?body=$page_url",
				"title" => "Email"),
	"print" => array(
				"url" => "javascript:window.print()",
				"title" => "Print"),	
	"digg" => array(
				"url" => "http://digg.com/submit?".htmlentities("phase=2&url=$page_url&title=$page_title"),
				"title" => "Digg this!"),
	"reddit" => array(
				"url" => "http://reddit.com/submit?".htmlentities("url=$page_url&title=$page_title"),
				"title" => "Reddit!"),
	"delicious" => array(
				"url" => "http://del.icio.us/post?".htmlentities("v=4&noui&jump=close&url=$page_url&title=$page_title"),
				"title" => "Add to del.icio.us"),
	"furl" => array(
				"url" => "http://www.furl.net/storeIt.jsp?".htmlentities("t=$page_title&u=$page_url"),
				"title" => "Furl this!"),
	"ma.gnolia" => array(
				"url" => "http://ma.gnolia.com/bookmarklet/add?".htmlentities("url=$page_url&title=$page_title"),
				"title" => "Add to ma.gnolia"),
	"newsvine" => array(
				"url" => "http://www.newsvine.com/_tools/seed".htmlentities("&save?u=$page_url&h=$page_title"), 
				"title" => "Save to Newsvine!"),
	"live" => array(
				"url" => "https://favorites.live.com/quickadd.aspx?".htmlentities("marklet=1&mkt=en-us&url=$page_url&title=$page_title&top=1"),
				"title" => "Add to Windows Live"),
	"myweb" => array(
				"url" =>  "http://myweb.yahoo.com/myresults/bookmarklet?".htmlentities("t=$page_title&u=$page_url&ei=UTF"),
				"title" => "Add to Yahoo MyWeb"),
	"google" => array(
				"url" =>  "http://www.google.com/bookmarks/mark?".htmlentities("op=edit&output=popup&bkmk=$page_url&title=$page_title"),
				"title" => "Googlize this post!"),
	"stumbleupon" => array(
				"url" => "http://www.stumbleupon.com/submit?".htmlentities("url=$page_url&title=$page_title"),
				"title" => "Stumble It!"),
	"simpy" => array(
				"url" => "http://simpy.com/simpy/LinkAdd.do?".htmlentities("title=$page_title&href=$page_url"),
				"title" => "Add to Simpy")
	); 
	
	if($obj->ShareIcons){
	$format = self::$IconTransparent ? "_trans" : "";
	$snippet = '<h3>Share This !</h3>'; //Title
	$snippet .= '<ul class="share-list">';
	
		foreach(self::$EnabledIcons as $enabled){
		$title = self::$ShowTitle ? $bookmarks[$enabled]['title'] : "";
		$snippet .= '<li><a href="'.$bookmarks[$enabled]['url'].'"><img src="sharethis/images/icons/'.$enabled.$format.'.gif" title="'. $bookmarks[$enabled]['title'].'"/>'.$title.'</a></li>';
		}
		
	$snippet .= '</ul>';
	}
	
		return $snippet ;
	}
	
}
?>