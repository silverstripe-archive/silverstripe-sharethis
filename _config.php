<?php
  
/**
 * Add decorator to SiteTree
 */
DataObject::add_extension('SiteTree', 'ShareIcons');
//SiteTree::ExtendCMS(array('ShareIcons', 'updateCMSFields'));

/**
 * Set Stylesheets 
 * @ TO DO: stylesheet should only be included on pages that actually have the share this icons on them
 */
if(Director::fileExists(project() . "/css/ShareThis.css"))
         Requirements::css(project() . "/css/ShareThis.css");
      else
         Requirements::css("sharethis/css/ShareThis.css");

/**
 * For custom properties that you should add to your _config.php file, 
 * please see the comment at the top of the {@link ShareIcons} class.
 */
ShareIcons::$EnabledIcons = array("email", "print", "digg", "reddit", "delicious", "furl", "ma.gnolia", "newsvine", "live", "myweb", "google", "stumbleupon", "simpy", "facebook");
ShareIcons::$ShowTitle = false;

?>