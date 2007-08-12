<?php
  
/**
 *add decorator to SiteTree
*/
DataObject::add_extension('SiteTree', 'ShareIcons');
SiteTree::ExtendCMS(array('ShareIcons', 'updateCMSFields'));

/**
 * Set Stylesheets
*/
if(Director::fileExists(project() . "/css/ShareThis.css"))
         Requirements::css(project() . "/css/ShareThis.css");
      else
         Requirements::css("sharethis/css/ShareThis.css");

/**
 *Custom Properties
*/

ShareIcons::$IconTransparent = true; //sets the transparency of the icons
ShareIcons::$ShowTitle = false; //shows title of the icon in text, next to the icon

/**
 *Enabled icons
 *We recommend not to have more than 5 icons, to avoid the visual noise.
*/
ShareIcons::$EnabledIcons = array('digg', 'reddit', 'delicious', 'simpy', 'google', 'ma.gnolia');


?>