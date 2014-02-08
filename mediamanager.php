<?php

/**
 * DokuWiki Media Manager Popup
 *
 * NOTE: Based on the mediamanager.php out of the "starter" template by
 *       Anika Henke.
 *
 *
 * LICENSE: This file is open source software (OSS) and may be copied under
 *          certain conditions. See COPYING file for details or try to contact
 *          the author(s) of this file in doubt.
 *
 * @license GPLv2 (http://www.gnu.org/licenses/gpl2.html)
 * @author ARSAVA <dokuwiki@dev.arsava.com>
 * @link https://www.dokuwiki.org/template:monobook
 * @link https://www.dokuwiki.org/devel:templates
 */

//check if we are running within the DokuWiki environment
if (!defined("DOKU_INC")){
    die();
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo hsc($conf["lang"]); ?>" lang="<?php echo hsc($conf["lang"]); ?>" dir="<?php echo hsc($lang["direction"]); ?>" class="popup">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo hsc($lang["mediaselect"]); echo " - ".hsc($conf["title"]); ?></title>
<?php
//show meta-tags
tpl_metaheaders();
echo "<meta name=\"viewport\" content=\"width=device-width,initial-scale=1\" />";

//manually load needed CSS? this is a workaround for PHP Bug #49642. In some
//version/os combinations PHP is not able to parse INI-file entries if there
//are slashes "/" used for the keynames (see bugreport for more information:
//<http://bugs.php.net/bug.php?id=49692>). to trigger this workaround, simply
//delete/rename monobook's style.ini.
if (!file_exists(DOKU_TPLINC."style.ini")){
    echo  "<link rel=\"stylesheet\" media=\"all\" type=\"text/css\" href=\"".DOKU_TPL."bug49642.php".((!empty($lang["direction"]) && $lang["direction"] === "rtl") ? "?langdir=rtl" : "")."\" />\n"; //var comes from DokuWiki core
}

//include default or userdefined favicon
//
//note: since 2011-04-22 "Rincewind RC1", there is a core function named
//      "tpl_getFavicon()". But its functionality is not really fitting the
//      behaviour of this template, therefore I don't use it here.
if (file_exists(DOKU_TPLINC."user/favicon.ico")){
    //user defined - you might find http://tools.dynamicdrive.com/favicon/
    //useful to generate one
    echo "\n<link rel=\"shortcut icon\" href=\"".DOKU_TPL."user/favicon.ico\" />\n";
}elseif (file_exists(DOKU_TPLINC."user/favicon.png")){
    //note: I do NOT recommend PNG for favicons (cause it is not supported by
    //all browsers), but some users requested this feature.
    echo "\n<link rel=\"shortcut icon\" href=\"".DOKU_TPL."user/favicon.png\" />\n";
}else{
    //default
    echo "\n<link rel=\"shortcut icon\" href=\"".DOKU_TPL."static/3rd/dokuwiki/favicon.ico\" />\n";
}

//include default or userdefined Apple Touch Icon (see <http://j.mp/sx3NMT> for
//details)
if (file_exists(DOKU_TPLINC."user/apple-touch-icon.png")){
    echo "<link rel=\"apple-touch-icon\" href=\"".DOKU_TPL."user/apple-touch-icon.png\" />\n";
}else{
    //default
    echo "<link rel=\"apple-touch-icon\" href=\"".DOKU_TPL."static/3rd/dokuwiki/apple-touch-icon.png\" />\n";
}

//load userdefined js?
if (tpl_getConf("monobook_loaduserjs")){
    echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".DOKU_TPL."user/user.js\"></script>\n";
}

//load language specific css hacks?
if (file_exists(DOKU_TPLINC."lang/".$conf["lang"]."/style.css")){
  $interim = trim(file_get_contents(DOKU_TPLINC."lang/".$conf["lang"]."/style.css"));
  if (!empty($interim)){
      echo "<style type=\"text/css\" media=\"all\">\n".hsc($interim)."\n</style>\n";
  }
}
?>
<!--[if lte IE 8]><link rel="stylesheet" media="all" type="text/css" href="<?php echo DOKU_TPL; ?>static/css/screen_iehacks.css" /><![endif]-->
<!--[if lt IE 5.5000]><link rel="stylesheet" media="all" type="text/css" href="<?php echo DOKU_TPL; ?>static/3rd/monobook/IE50Fixes.css" /><![endif]-->
<!--[if IE 5.5000]><link rel="stylesheet" media="all" type="text/css" href="<?php echo DOKU_TPL; ?>static/3rd/monobook/IE55Fixes.css" /><![endif]-->
<!--[if IE 6]><link rel="stylesheet" media="all" type="text/css" href="<?php echo DOKU_TPL; ?>static/3rd/monobook/IE60Fixes.css" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" media="all" type="text/css" href="<?php echo DOKU_TPL; ?>static/3rd/monobook/IE70Fixes.css" /><![endif]-->
<!--[if lt IE 7]><script type="text/javascript" charset="utf-8" src="<?php echo DOKU_TPL; ?>static/3rd/wikipedia/IEFixes.js"></script><meta http-equiv="imagetoolbar" content="no" /><![endif]-->
</head>

<body>
    <div id="media__manager" class="dokuwiki">
        <?php html_msgarea() ?>
        <div id="mediamgr__aside"><div class="pad">
            <h1><?php echo hsc($lang['mediaselect'])?></h1>

            <?php /* keep the id! additional elements are inserted via JS here */?>
            <div id="media__opts"></div>

            <?php tpl_mediaTree() ?>
        </div></div>

        <div id="mediamgr__content"><div class="pad">
            <?php tpl_mediaContent() ?>
        </div></div>
    </div>
</body>
</html>
