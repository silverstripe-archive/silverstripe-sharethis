<?php
  
/**
 * Add decorator to SiteTree
 */
//DataObject::add_extension('SiteTree', 'ShareIcons');
//SiteTree::ExtendCMS(array('ShareIcons', 'updateCMSFields'));

/**
 * Set Stylesheets
 */
if(Director::fileExists(project() . "/css/ShareThis.css"))
         Requirements::css(project() . "/css/ShareThis.css");
      else
         Requirements::css("sharethis/css/ShareThis.css");

/**
 * For custom properties that you should add to your _config.php file, 
 * please see the comment at the top of the {@link ShareIcons} class.
 */
?>