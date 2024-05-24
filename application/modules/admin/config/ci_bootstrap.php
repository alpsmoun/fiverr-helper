<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| CI Bootstrap 3 Configuration
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views 
| when calling MY_Controller's render() function. 
| 
| See example and detailed explanation from:
| 	/application/config/ci_bootstrap_example.php
*/

$config['ci_bootstrap'] = array(

  // Site name
  'site_name' => 'Admin Panel',

  // Default page title prefix
  'page_title_prefix' => '',

  // Default page title
  'page_title' => '',

  // Default meta data
  'meta_data'  => array(
    'author'    => '',
    'description'  => '',
    'keywords'    => ''
  ),

  // Default scripts to embed at page head or end
  'scripts' => array(
    'head'  => array(
      'assets/dist/admin/adminlte.min.js',
      'assets/dist/admin/lib.min.js',
      'assets/dist/admin/app.min.js'
    ),
    'foot'  => array(),
  ),

  // Default stylesheets to embed at page head
  'stylesheets' => array(
    'screen' => array(
      'assets/dist/admin/adminlte.min.css',
      'assets/dist/admin/lib.min.css',
      'assets/dist/admin/app.min.css'
    )
  ),

  // Default CSS class for <body> tag
  'body_class' => '',

  // Multilingual settings
  'languages' => array(),

  // Menu items
  'menu' => array(
    'home' => array(
      'name'    => 'Home',
      'url'    => '',
      'icon'    => 'fa fa-home',
    ),
    'user' => array(
      'name'    => 'Users',
      'url'    => 'user',
      'icon'    => 'fa fa-users',
      'children'  => array(
        'All Users'      => 'user',
        'Latin America'      => 'user/valid',
        'US'      => 'user/online',
        'Canada'      => 'user/jobs',
        'East Europe' => 'user/eastEurope',
        'West Europe' => 'user/westEurope',
        'Create Users'    => 'user/create',
        'Create Online'    => 'user/create_online',
        'Create Jobs'    => 'user/create_jobs',
      )
    ),

    'other' => array(
      'name'    => 'Other',
      'url'    => 'other',
      'icon'    => 'ion ion-edit',  // can use Ionicons instead of FontAwesome
      'children'  => array(
        'Study Guides'  => 'other/study',
      )
    ),
    'notification' => array(
      'name'    => 'Send Notification',
      'url'    => 'notification',
      'icon'    => 'fa fa-send',  // can use Ionicons instead of FontAwesome
      'children'  => array(
        'Sent Notifications'    => 'notification',
        'Create Notification'    => 'notification/create_notification'
      )
    ),
    'util' => array(
      'name'    => 'Utilities',
      'url'    => 'util',
      'icon'    => 'fa fa-cogs',
      'children'  => array(
        'Quotes'        => 'settings/quotes',
        'Settings'      => 'settings/',
      )
    ),
    'logout' => array(
      'name'    => 'Sign Out',
      'url'    => 'panel/logout',
      'icon'    => 'fa fa-sign-out',
    )
  ),

  // Login page
  'login_url' => 'admin/login',

  // Restricted pages
  'page_auth' => array(
    'user/create'        => array('webmaster', 'admin', 'manager'),
    'user/group'        => array('webmaster', 'admin', 'manager'),
    'panel'            => array('webmaster'),
    'panel/admin_user'      => array('webmaster'),
    'panel/admin_user_create'  => array('webmaster'),
    'panel/admin_user_group'  => array('webmaster'),
    'util'            => array('webmaster'),
    'util/list_db'        => array('webmaster'),
    'util/backup_db'      => array('webmaster'),
    'util/restore_db'      => array('webmaster'),
    'util/remove_db'      => array('webmaster'),
  ),

  // AdminLTE settings
  'adminlte' => array(
    'body_class' => array(
      'webmaster'  => 'skin-red',
      'admin'    => 'skin-purple',
      'manager'  => 'skin-black',
      'staff'    => 'skin-blue',
    )
  ),

  // Useful links to display at bottom of sidemenu
  'useful_links' => array(),

  // Debug tools
  'debug' => array(
    'view_data'  => FALSE,
    'profiler'  => FALSE
  ),
);

/*
| -------------------------------------------------------------------------
| Override values from /application/config/config.php
| -------------------------------------------------------------------------
*/
$config['sess_cookie_name'] = 'ci_session_admin';
