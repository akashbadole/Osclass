<?php
/*
 *      OSCLass – software for creating and publishing online classified
 *                           advertising platforms
 *
 *                        Copyright (C) 2010 OSCLASS
 *
 *       This program is free software: you can redistribute it and/or
 *     modify it under the terms of the GNU Affero General Public License
 *     as published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful, but
 *         WITHOUT ANY WARRANTY; without even the implied warranty of
 *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU Affero General Public License for more details.
 *
 *      You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

<<<<<<< HEAD
error_reporting(E_ALL);
=======
error_reporting(E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_PARSE);
>>>>>>> 527

define( 'ABS_PATH', dirname(dirname(dirname(__FILE__))) . '/' );
define( 'LIB_PATH', ABS_PATH . 'oc-includes/' ) ;
define( 'CONTENT_PATH', ABS_PATH . 'oc-content/' ) ;
define( 'TRANSLATIONS_PATH', CONTENT_PATH . 'languages/' ) ;

require_once ABS_PATH . 'oc-includes/osclass/db.php';
require_once ABS_PATH . 'oc-includes/osclass/classes/DAO.php';
require_once ABS_PATH . 'oc-includes/osclass/model/Preference.php';
require_once ABS_PATH . 'oc-includes/osclass/helpers/hPreference.php';
require_once ABS_PATH . 'oc-includes/osclass/helpers/hDatabaseInfo.php';
require_once ABS_PATH . 'oc-includes/osclass/helpers/hErrors.php';
require_once ABS_PATH . 'oc-includes/osclass/core/Session.php';
require_once ABS_PATH . 'oc-includes/osclass/helpers/hDefines.php';
require_once ABS_PATH . 'oc-includes/osclass/helpers/hSearch.php';
require_once ABS_PATH . 'oc-includes/osclass/helpers/hLocale.php';
require_once ABS_PATH . 'oc-includes/osclass/install-functions.php';
require_once ABS_PATH . 'oc-includes/osclass/core/Params.php';
require_once ABS_PATH . 'oc-includes/osclass/utils.php';

require_once ABS_PATH . 'oc-includes/osclass/Logger/Logger.php' ;
require_once ABS_PATH . 'oc-includes/osclass/Logger/LogOsclass.php' ;


$step = Params::getParam('step');
if( !is_numeric($step) ) {
    $step = '1';
}

if( is_osclass_installed( ) ) {
    $message = 'You appear to have already installed OSClass. To reinstall please clear your old database tables first.' ;
    osc_die('OSClass &raquo; Error', $message) ;
}

switch ($step) {
    case 1:
        $requirements = get_requirements() ;
        $error = check_requirements($requirements) ;
        break;
    case 2:
        if( Params::getParam('save_stats') == '1' ) {
            setcookie('osclass_save_stats', 1, time()+24*60*60) ;
        } else {
            setcookie('osclass_save_stats', 0, time()+24*60*60) ;
        }

        if( Params::getParam('ping_engines') == '1' ) {
            setcookie('osclass_ping_engines', 1, time()+24*60*60) ;
        } else {
            setcookie('osclass_ping_engines', 0, time()+24*60*60) ;
        }

        break;
    case 3:
        if( Params::getParam('dbname') != '' ) {
            $error = oc_install();
        }
        break;
    case 5:
        
        break;
    default:
        break;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en-US">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>OSClass Installation</title>
        <script src="<?php echo get_absolute_url(); ?>oc-includes/osclass/installer/jquery.js" type="text/javascript"></script>
        <script src="<?php echo get_absolute_url(); ?>oc-includes/osclass/installer/jquery-ui.js" type="text/javascript"></script>
        <script src="<?php echo get_absolute_url(); ?>oc-includes/osclass/installer/vtip/vtip.js" type="text/javascript"></script>
        <script src="<?php echo get_absolute_url(); ?>oc-includes/osclass/installer/jquery.jsonp.js" type="text/javascript"></script>
        <script src="<?php echo get_absolute_url(); ?>oc-includes/osclass/installer/install.js" type="text/javascript"></script>
        <?php if($step == 5) { ?>
        <script src="<?php echo get_absolute_url(); ?>oc-includes/osclass/strengthPasswd/password_strength_plugin.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_absolute_url(); ?>oc-includes/osclass/strengthPasswd/style.css" />
        <?php } ?>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_absolute_url(); ?>oc-includes/osclass/installer/install.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_absolute_url(); ?>oc-includes/osclass/installer/vtip/css/vtip.css" />
        <?php if( $step == 5 ) {?>
        <script>
            $(document).ready( function() {
                //BASIC
                $(".password_test").passStrength({
                    userid:	"#user_id",
                    messageloc:		1
                });
            });
        </script>
        <?php } ?>
    </head>
    <body>
        <div id="wrapper">
            <div id="container">
                <div id="header" class="installation">
                    <h1 id="logo">
                        <img src="<?php echo get_absolute_url(); ?>oc-includes/images/osclass-logo.png" alt="OSClass" title="OSClass"/>
                    </h1>
                    <?php if(in_array($step, array(2,3,4))) { ?>
                    <ul id="nav">
                        <li class="<?php if($step == 2) { ?>actual<?php } elseif($step < 2) { ?>next<?php } else { ?>past<?php }?>">1 - Database</li>
                        <li class="<?php if($step == 3) { ?>actual<?php } elseif($step < 3) { ?>next<?php } else { ?>past<?php }?>">2 - Target</li>
                        <li class="<?php if($step == 4) { ?>actual<?php } elseif($step < 4) { ?>next<?php } else { ?>past<?php }?>">3 - Categories</li>
                    </ul>
                    <div class="clear"></div>
                    <?php } ?>
                </div>
                <div id="content">
                <?php if($step == 1) { ?>
                    <h2 class="target">Welcome</h2>
                    <form action="install.php" method="POST">
                        <div class="form-table">
                        <?php if($error) { ?>
                            <p>Check the next requirements:</p>
                            <div style="-moz-border-radius: 10px 10px 10px 10px;background: none repeat scroll 0 0 #FFFF99;font-size: 12px;padding: 20px;text-align: left;">
                                <p><b>Info can help you...</b></p>
                                <ul>
                                <?php $solve_requirements = get_solution_requirements(); foreach($requirements as $k => $v) { ?>
                                    <?php  if(!$v && $solve_requirements[$k] != ''){ ?>
                                    <li><?php echo $solve_requirements[$k]; ?></li>
                                    <?php } ?>
                                <?php } ?>
                                    <li><a target="_blank" href="http://forums.osclass.org/">Forums can help you.</a></li>
                                </ul>
                            </div>
                        <?php } else { ?>
                            <p>All right! All the requirements have met:</p>
                        <?php } ?>
                            <ul>
                            <?php foreach($requirements as $k => $v) { ?>
                                <li><?php echo $k; ?> <img src="<?php echo get_absolute_url(); ?>oc-includes/images/<?php echo $v ? 'tick.png' : 'cross.png'; ?>" alt="" title="" /></li>
                            <?php } ?>
                            </ul>
                            <div class="more-stats">
                                <input type="checkbox" name="ping_engines" id="ping_engines" checked="checked" value="1"/>
                                <label for="ping_engines">
                                    Allow my site to appear in search engines like Gooogle.
                                </label>
                                <br/>
                                <input type="checkbox" name="save_stats" id="save_stats" checked="checked" value="1"/>
                                <input type="hidden" name="step" value="2" />
                                <label for="save_stats">
                                    Help make OSClass better by automatically sending usage statistics and crash reports to OSClass.
                                </label>
                            </div>
                        </div>
                        <?php if($error) { ?>
                        <p class="margin20">
                            <input type="button" class="button" onclick="document.location = 'install.php?step=1'" value="Try again" />
                        </p>
                        <?php } else { ?>
                        <p class="margin20">
                            <input type="submit" class="button" value="Run the install" />
                        </p>
                    <?php } ?>
                    </form>
                <?php } elseif($step == 2) {
                         display_database_config();
                    } elseif($step == 3) {
                        if( !isset($error["error"]) ) {
                            display_target();
                        } else {
                            display_database_error($error, ($step - 1));
                        }
                    } elseif($step == 4) {
                        display_categories();
                    } elseif($step == 5) {
                        // ping engines
                        ping_search_engines( $_COOKIE['osclass_ping_engines'] ) ;
                        display_finish();
                    }
                ?>
                </div>
                <div id="footer">
                    <ul>
                        <li>
                            <a href="<?php echo get_absolute_url(); ?>readme.php" target="_blank">Readme</a>
                        </li>
                        <li>
                            <a href="http://osclass.org/contact/" target="_blank">Feedback</a>
                        </li>
                        <li>
                            <a href="http://forums.osclass.org/index.php" target="_blank">Forums</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
