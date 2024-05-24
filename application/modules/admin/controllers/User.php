<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Admin_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_builder');
    $this->load->model('Job_model', 'jobs');
  }

  // Frontend User CRUD
  public function index()
  {
    $crud = $this->generate_crud('users');
    $crud->columns('id', 'category', 'username', 'user_id', 'country', 'avatar', 'online', 'rate_count', 'rate_score', 'status', 'created_at', 'updated_at');

    $crud->callback_column('avatar', array($this, 'callback_profile_photo'));
    $crud->callback_column('country', array($this, 'callback_country'));
    $crud->callback_column('status', array($this, 'callback_status'));
    $crud->order_by('user_id', 'desc');
    $crud->where('status <', 1);

    $curUser = $this->session->userdata("username");
    if( $curUser != 'admin' ){
      $crud->where('created_at < DATE_SUB(CURDATE(), INTERVAL 3 DAY)');
    }

    // disable direct create / delete Frontend User 
    $crud->unset_add();
    $crud->unset_delete();

    $crud->add_action('Ban', '', '', 'fa fa-ban', array($this, 'ban_fiverr_url'));
    $crud->add_action('', '', '', 'fa fa-paper-plane', array($this, 'get_fiverr_url'));

    $this->mPageTitle = 'Users';
    $this->render_crud();
  }

  public function valid()
  {
    $crud = $this->generate_crud('users');
    $crud->columns('id', 'category', 'username', 'user_id', 'country', 'avatar', 'created_at');

    $crud->callback_column('avatar', array($this, 'callback_profile_photo'));
    $crud->callback_column('country', array($this, 'callback_country'));
    $crud->callback_column('status', array($this, 'callback_status'));

    $countryList = [
      'AR',
      'BZ',
      'BO',
      'CL',
      'CO',
      'CR',
      'CU',
      'DM',
      'DO',
      'EC',
      'SV',
      'GT',
      'GY',
      'HN',
      'JM',
      // 'MX',
      'NI',
      'PY',
      'PE',
      'PR',
      'SR',
      'UY',
      'VE'
    ];
    // $countryList = [
    //   'AR',
    //   'BO',
    //   'CO',
    //   'EC',
    //   'GT',
    //   'HN',
    //   'MX',
    //   'PY',
    //   'PE',
    //   'UY',
    // ];
    $where = "country IN (";
    foreach ($countryList as $country) {
      $where = $where . "'$country',";
    }
    $where = rtrim($where, ',');
    $where = $where . ")";
    $crud->order_by('user_id', 'desc');
    $crud->where('status <', 1);
    $curUser = $this->session->userdata("username");
    if( $curUser != 'admin' ){
      $crud->where('created_at < DATE_SUB(CURDATE(), INTERVAL 3 DAY)');
    }
    $crud->where($where);

    // disable direct create / delete Frontend User 
    $crud->unset_add();
    $crud->unset_delete();

    $crud->add_action('Ban', '', '', 'fa fa-ban', array($this, 'ban_fiverr_url'));
    $crud->add_action('', '', '', 'fa fa-paper-plane', array($this, 'get_fiverr_url'));

    $this->mPageTitle = 'Users';
    $this->render_crud();
  }

  public function online()
  {
    $crud = $this->generate_crud('users');
    $crud->columns('id', 'category', 'username', 'user_id', 'country', 'avatar', 'created_at');

    $crud->callback_column('avatar', array($this, 'callback_profile_photo'));
    $crud->callback_column('country', array($this, 'callback_country'));
    $crud->callback_column('status', array($this, 'callback_status'));

    $countryList = [
      'US',
    ];
    $where = "country IN (";
    foreach ($countryList as $country) {
      $where = $where . "'$country',";
    }
    $where = rtrim($where, ',');
    $where = $where . ")";
    $crud->order_by('user_id', 'desc');
    $crud->where('status <', 1);
    $curUser = $this->session->userdata("username");
    if( $curUser != 'admin' ){
      $crud->where('created_at < DATE_SUB(CURDATE(), INTERVAL 3 DAY)');
    }
    $crud->where($where);

    // disable direct create / delete Frontend User 
    $crud->unset_add();
    $crud->unset_delete();

    $crud->add_action('Ban', '', '', 'fa fa-ban', array($this, 'ban_fiverr_url'));
    $crud->add_action('', '', '', 'fa fa-paper-plane', array($this, 'get_fiverr_url'));

    $this->mPageTitle = 'Users';
    $this->render_crud();
  }

  public function eastEurope()
  {
    $crud = $this->generate_crud('users');
    $crud->columns('id', 'category', 'username', 'user_id', 'country', 'avatar', 'created_at');

    $crud->callback_column('avatar', array($this, 'callback_profile_photo'));
    $crud->callback_column('country', array($this, 'callback_country'));
    $crud->callback_column('status', array($this, 'callback_status'));

    $countryList = [
      'AL',
      'BG',
      'GE',
      'HU',
      'LV',
      'LT',
      'MD',
      'MK',
      'PL',
      'RO',
      'RS',
      'SI',
      'SK'

    ];
    $where = "country IN (";
    foreach ($countryList as $country) {
      $where = $where . "'$country',";
    }
    $where = rtrim($where, ',');
    $where = $where . ")";
    $crud->order_by('user_id', 'desc');
    $crud->where('status <', 1);
    $curUser = $this->session->userdata("username");
    if( $curUser != 'admin' ){
      $crud->where('created_at < DATE_SUB(CURDATE(), INTERVAL 3 DAY)');
    }
    $crud->where($where);

    // disable direct create / delete Frontend User 
    $crud->unset_add();
    $crud->unset_delete();

    $crud->add_action('Ban', '', '', 'fa fa-ban', array($this, 'ban_fiverr_url'));
    $crud->add_action('', '', '', 'fa fa-paper-plane', array($this, 'get_fiverr_url'));

    $this->mPageTitle = 'Users';
    $this->render_crud();
  }

  public function westEurope()
  {
    $crud = $this->generate_crud('users');
    $crud->columns('id', 'category', 'username', 'user_id', 'country', 'avatar', 'online', 'rate_count', 'rate_score', 'status', 'created_at', 'updated_at');

    $crud->callback_column('avatar', array($this, 'callback_profile_photo'));
    $crud->callback_column('country', array($this, 'callback_country'));
    $crud->callback_column('status', array($this, 'callback_status'));

    $countryList = [
      'AT',
      'BE',
      'DK',
      'FI',
      'FR',
      'DE',
      'GR',
      'IS',
      'IL',
      'IT',
      'LU',
      'NL',
      'NO',
      'PT',
      'ES',
      'SZ',
      'SE',
      'CH',

    ];
    $where = "country IN (";
    foreach ($countryList as $country) {
      $where = $where . "'$country',";
    }
    $where = rtrim($where, ',');
    $where = $where . ")";
    $crud->order_by('user_id', 'desc');
    $crud->where('status <', 1);
    $curUser = $this->session->userdata("username");
    if( $curUser != 'admin' ){
      $crud->where('created_at < DATE_SUB(CURDATE(), INTERVAL 3 DAY)');
    }
    $crud->where($where);

    // disable direct create / delete Frontend User 
    $crud->unset_add();
    $crud->unset_delete();

    $crud->add_action('Ban', '', '', 'fa fa-ban', array($this, 'ban_fiverr_url'));
    $crud->add_action('', '', '', 'fa fa-paper-plane', array($this, 'get_fiverr_url'));

    $this->mPageTitle = 'Users';
    $this->render_crud();
  }

  // public function online()
  // {
  //   $crud = $this->generate_crud('users');
  //   $crud->columns('id', 'category', 'username', 'user_id', 'country', 'avatar', 'online', 'rate_count', 'rate_score', 'status', 'created_at', 'updated_at');

  //   $crud->callback_column('avatar', array($this, 'callback_profile_photo'));
  //   $crud->callback_column('country', array($this, 'callback_country'));
  //   $crud->callback_column('status', array($this, 'callback_status'));
  //   $crud->order_by('user_id', 'desc');
  //   $crud->where('status <', 1);
  //   $crud->where('online =', 'true');

  //   // disable direct create / delete Frontend User
  //   $crud->unset_add();
  //   $crud->unset_delete();

  //   $crud->add_action('Ban', '', '', 'fa fa-ban', array($this, 'ban_fiverr_url'));
  //   $crud->add_action('', '', '', 'fa fa-paper-plane', array($this, 'get_fiverr_url'));

  //   $this->mPageTitle = 'Users';
  //   $this->render_crud();
  // }

  public function jobs()
  {
    $crud = $this->generate_crud('users');
    $crud->columns('id', 'category', 'username', 'user_id', 'country', 'avatar', 'online', 'rate_count', 'rate_score', 'status', 'created_at', 'updated_at');

    $crud->callback_column('avatar', array($this, 'callback_profile_photo'));
    $crud->callback_column('country', array($this, 'callback_country'));
    $crud->callback_column('status', array($this, 'callback_status'));

    $countryList = [
      'CA',
    ];
    $where = "country IN (";
    foreach ($countryList as $country) {
      $where = $where . "'$country',";
    }
    $where = rtrim($where, ',');
    $where = $where . ")";
    $crud->order_by('user_id', 'desc');
    $crud->where('status <', 1);
    $curUser = $this->session->userdata("username");
    if( $curUser != 'admin' ){
      $crud->where('created_at < DATE_SUB(CURDATE(), INTERVAL 3 DAY)');
    }
    $crud->where($where);

    // disable direct create / delete Frontend User 
    $crud->unset_add();
    $crud->unset_delete();

    $crud->add_action('Ban', '', '', 'fa fa-ban', array($this, 'ban_fiverr_url'));
    $crud->add_action('', '', '', 'fa fa-paper-plane', array($this, 'get_fiverr_url'));

    $this->mPageTitle = 'Users';
    $this->render_crud();



    // $crud = $this->generate_crud('jobs');
    // // $crud->columns('id', 'category', 'username', 'user_id', 'country', 'avatar', 'online', 'rate_count', 'rate_score', 'status', 'created_at', 'updated_at');

    // $crud->order_by('recno', 'desc');

    // // disable direct create / delete Frontend User
    // $crud->unset_add();
    // $crud->unset_delete();

    // $this->mPageTitle = 'Jobs';
    // $this->render_crud();
  }

  public function fiverr_ban()
  {
    $param = $this->input->get();
    $username = $param['username'];
    if (empty($username)) {
      return;
    }
    $this->users->setUserStatus($username, 2);
    redirect($_SERVER['HTTP_REFERER']);
  }

  public function fiverr()
  {
    $param = $this->input->get();
    $username = $param['username'];
    if (empty($username)) {
      return;
    }
    $this->users->setUserStatus($username, 1);
    redirect('https://www.fiverr.com/inbox/' . $username);
  }

  function ban_fiverr_url($primary_key, $row)
  {
    return base_url() . 'admin/user/fiverr_ban?username=' . $row->username;
  }

  function get_fiverr_url($primary_key, $row)
  {
    return base_url() . 'admin/user/fiverr?username=' . $row->username;
  }

  public function callback_profile_photo($value, $row)
  {
    if (empty($value)) {
      return "";
    }
    return "<img src='" . $value . "'></>";
  }

  public function callback_country($value, $row)
  {
    if (empty($value)) {
      return "";
    }

    $code = strtoupper($value);

    $countryList = array(
      'AF' => 'Afghanistan',
      'AX' => 'Aland Islands',
      'AL' => 'Albania',
      'DZ' => 'Algeria',
      'AS' => 'American Samoa',
      'AD' => 'Andorra',
      'AO' => 'Angola',
      'AI' => 'Anguilla',
      'AQ' => 'Antarctica',
      'AG' => 'Antigua and Barbuda',
      'AR' => 'Argentina',
      'AM' => 'Armenia',
      'AW' => 'Aruba',
      'AU' => 'Australia',
      'AT' => 'Austria',
      'AZ' => 'Azerbaijan',
      'BS' => 'Bahamas the',
      'BH' => 'Bahrain',
      'BD' => 'Bangladesh',
      'BB' => 'Barbados',
      'BY' => 'Belarus',
      'BE' => 'Belgium',
      'BZ' => 'Belize',
      'BJ' => 'Benin',
      'BM' => 'Bermuda',
      'BT' => 'Bhutan',
      'BO' => 'Bolivia',
      'BA' => 'Bosnia and Herzegovina',
      'BW' => 'Botswana',
      'BV' => 'Bouvet Island (Bouvetoya)',
      'BR' => 'Brazil',
      'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
      'VG' => 'British Virgin Islands',
      'BN' => 'Brunei Darussalam',
      'BG' => 'Bulgaria',
      'BF' => 'Burkina Faso',
      'BI' => 'Burundi',
      'KH' => 'Cambodia',
      'CM' => 'Cameroon',
      'CA' => 'Canada',
      'CV' => 'Cape Verde',
      'KY' => 'Cayman Islands',
      'CF' => 'Central African Republic',
      'TD' => 'Chad',
      'CL' => 'Chile',
      'CN' => 'China',
      'CX' => 'Christmas Island',
      'CC' => 'Cocos (Keeling) Islands',
      'CO' => 'Colombia',
      'KM' => 'Comoros the',
      'CD' => 'Congo',
      'CG' => 'Congo the',
      'CK' => 'Cook Islands',
      'CR' => 'Costa Rica',
      'CI' => 'Cote d\'Ivoire',
      'HR' => 'Croatia',
      'CU' => 'Cuba',
      'CZ' => 'Czech Republic',
      'DK' => 'Denmark',
      'DJ' => 'Djibouti',
      'DM' => 'Dominica',
      'DO' => 'Dominican Republic',
      'EC' => 'Ecuador',
      'EG' => 'Egypt',
      'SV' => 'El Salvador',
      'GQ' => 'Equatorial Guinea',
      'ER' => 'Eritrea',
      'EE' => 'Estonia',
      'ET' => 'Ethiopia',
      'FO' => 'Faroe Islands',
      'FK' => 'Falkland Islands (Malvinas)',
      'FJ' => 'Fiji the Fiji Islands',
      'FI' => 'Finland',
      'FR' => 'France, French Republic',
      'GF' => 'French Guiana',
      'PF' => 'French Polynesia',
      'TF' => 'French Southern Territories',
      'GA' => 'Gabon',
      'GM' => 'Gambia the',
      'GE' => 'Georgia',
      'DE' => 'Germany',
      'GH' => 'Ghana',
      'GI' => 'Gibraltar',
      'GR' => 'Greece',
      'GL' => 'Greenland',
      'GD' => 'Grenada',
      'GP' => 'Guadeloupe',
      'GU' => 'Guam',
      'GT' => 'Guatemala',
      'GG' => 'Guernsey',
      'GN' => 'Guinea',
      'GW' => 'Guinea-Bissau',
      'GY' => 'Guyana',
      'HT' => 'Haiti',
      'HM' => 'Heard Island and McDonald Islands',
      'VA' => 'Holy See (Vatican City State)',
      'HN' => 'Honduras',
      'HK' => 'Hong Kong',
      'HU' => 'Hungary',
      'IS' => 'Iceland',
      'IN' => 'India',
      'ID' => 'Indonesia',
      'IR' => 'Iran',
      'IQ' => 'Iraq',
      'IE' => 'Ireland',
      'IM' => 'Isle of Man',
      'IL' => 'Israel',
      'IT' => 'Italy',
      'JM' => 'Jamaica',
      'JP' => 'Japan',
      'JE' => 'Jersey',
      'JO' => 'Jordan',
      'KZ' => 'Kazakhstan',
      'KE' => 'Kenya',
      'KI' => 'Kiribati',
      'KP' => 'Korea',
      'KR' => 'Korea',
      'KW' => 'Kuwait',
      'KG' => 'Kyrgyz Republic',
      'LA' => 'Lao',
      'LV' => 'Latvia',
      'LB' => 'Lebanon',
      'LS' => 'Lesotho',
      'LR' => 'Liberia',
      'LY' => 'Libyan Arab Jamahiriya',
      'LI' => 'Liechtenstein',
      'LT' => 'Lithuania',
      'LU' => 'Luxembourg',
      'MO' => 'Macao',
      'MK' => 'Macedonia',
      'MG' => 'Madagascar',
      'MW' => 'Malawi',
      'MY' => 'Malaysia',
      'MV' => 'Maldives',
      'ML' => 'Mali',
      'MT' => 'Malta',
      'MH' => 'Marshall Islands',
      'MQ' => 'Martinique',
      'MR' => 'Mauritania',
      'MU' => 'Mauritius',
      'YT' => 'Mayotte',
      'MX' => 'Mexico',
      'FM' => 'Micronesia',
      'MD' => 'Moldova',
      'MC' => 'Monaco',
      'MN' => 'Mongolia',
      'ME' => 'Montenegro',
      'MS' => 'Montserrat',
      'MA' => 'Morocco',
      'MZ' => 'Mozambique',
      'MM' => 'Myanmar',
      'NA' => 'Namibia',
      'NR' => 'Nauru',
      'NP' => 'Nepal',
      'AN' => 'Netherlands Antilles',
      'NL' => 'Netherlands the',
      'NC' => 'New Caledonia',
      'NZ' => 'New Zealand',
      'NI' => 'Nicaragua',
      'NE' => 'Niger',
      'NG' => 'Nigeria',
      'NU' => 'Niue',
      'NF' => 'Norfolk Island',
      'MP' => 'Northern Mariana Islands',
      'NO' => 'Norway',
      'OM' => 'Oman',
      'PK' => 'Pakistan',
      'PW' => 'Palau',
      'PS' => 'Palestinian Territory',
      'PA' => 'Panama',
      'PG' => 'Papua New Guinea',
      'PY' => 'Paraguay',
      'PE' => 'Peru',
      'PH' => 'Philippines',
      'PN' => 'Pitcairn Islands',
      'PL' => 'Poland',
      'PT' => 'Portugal, Portuguese Republic',
      'PR' => 'Puerto Rico',
      'QA' => 'Qatar',
      'RE' => 'Reunion',
      'RO' => 'Romania',
      'RU' => 'Russian Federation',
      'RW' => 'Rwanda',
      'BL' => 'Saint Barthelemy',
      'SH' => 'Saint Helena',
      'KN' => 'Saint Kitts and Nevis',
      'LC' => 'Saint Lucia',
      'MF' => 'Saint Martin',
      'PM' => 'Saint Pierre and Miquelon',
      'VC' => 'Saint Vincent and the Grenadines',
      'WS' => 'Samoa',
      'SM' => 'San Marino',
      'ST' => 'Sao Tome and Principe',
      'SA' => 'Saudi Arabia',
      'SN' => 'Senegal',
      'RS' => 'Serbia',
      'SC' => 'Seychelles',
      'SL' => 'Sierra Leone',
      'SG' => 'Singapore',
      'SK' => 'Slovakia (Slovak Republic)',
      'SI' => 'Slovenia',
      'SB' => 'Solomon Islands',
      'SO' => 'Somalia, Somali Republic',
      'ZA' => 'South Africa',
      'GS' => 'South Georgia and the South Sandwich Islands',
      'ES' => 'Spain',
      'LK' => 'Sri Lanka',
      'SD' => 'Sudan',
      'SR' => 'Suriname',
      'SJ' => 'Svalbard & Jan Mayen Islands',
      'SZ' => 'Swaziland',
      'SE' => 'Sweden',
      'CH' => 'Switzerland, Swiss Confederation',
      'SY' => 'Syrian Arab Republic',
      'TW' => 'Taiwan',
      'TJ' => 'Tajikistan',
      'TZ' => 'Tanzania',
      'TH' => 'Thailand',
      'TL' => 'Timor-Leste',
      'TG' => 'Togo',
      'TK' => 'Tokelau',
      'TO' => 'Tonga',
      'TT' => 'Trinidad and Tobago',
      'TN' => 'Tunisia',
      'TR' => 'Turkey',
      'TM' => 'Turkmenistan',
      'TC' => 'Turks and Caicos Islands',
      'TV' => 'Tuvalu',
      'UG' => 'Uganda',
      'UA' => 'Ukraine',
      'AE' => 'United Arab Emirates',
      'GB' => 'United Kingdom',
      'US' => 'United States of America',
      'UM' => 'United States Minor Outlying Islands',
      'VI' => 'United States Virgin Islands',
      'UY' => 'Uruguay, Eastern Republic of',
      'UZ' => 'Uzbekistan',
      'VU' => 'Vanuatu',
      'VE' => 'Venezuela',
      'VN' => 'Vietnam',
      'WF' => 'Wallis and Futuna',
      'EH' => 'Western Sahara',
      'YE' => 'Yemen',
      'ZM' => 'Zambia',
      'ZW' => 'Zimbabwe',
      'XK' => 'Unknown',
    );

    $curDate = "";
    $timezoneArray = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $code);
    if (!empty($timezoneArray)) {
      $timezone = $timezoneArray[0];

      $date = new DateTime("now", new DateTimeZone($timezone));
      $curDate = $date->format('H:i');
    }

    if (!$countryList[$code]) {
      return $code;
    } else {
      $country = $countryList[$code];
      $countryWithDate = "$country ( $curDate )";
      return $countryWithDate;
    }
  }

  public function callback_status($value, $row)
  {
    if ($value == 0) {
      return "o";
    }
    return "Sent";
  }

  // Create Frontend User
  public function create()
  {
    $form = $this->form_builder->create_form(NULL, true);

    if ($form->validate()) {
      if (is_uploaded_file($_FILES['users_json']['tmp_name'])) {
        $file_path = UPLOAD_FILE_JSON . "users.json";

        $tmpFile = $_FILES['users_json']['tmp_name'];
        if (move_uploaded_file($tmpFile, $file_path)) {
          // Get the contents of the JSON file 
          $strUsers = file_get_contents($file_path);
          // Convert to array 
          $userArray = json_decode($strUsers, true);
          $data = $userArray['users'];
          $this->users->putBulk($data);
          $this->users->setStatusBlockCountries();
          $this->system_message->set_success('Success to upload users JSON file');
        } else {
          $this->system_message->set_error("Fail to upload users JSON file");
        }
      }
      refresh();
    }

    // get list of Frontend user groups
    $this->load->model('group_model', 'groups');
    $this->mViewData['groups'] = $this->groups->get_all();
    $this->mPageTitle = 'Upload users JSON files';

    $this->mViewData['form'] = $form;
    $this->render('user/create');
  }

  public function create_online()
  {
    $form = $this->form_builder->create_form(NULL, true);

    if ($form->validate()) {
      $this->users->clearOnline();

      if (is_uploaded_file($_FILES['online_users_json']['tmp_name'])) {
        $file_path = UPLOAD_FILE_JSON . "online_users.json";

        $tmpFile = $_FILES['online_users_json']['tmp_name'];
        if (move_uploaded_file($tmpFile, $file_path)) {
          // Get the contents of the JSON file 
          $strUsers = file_get_contents($file_path);
          // Convert to array 
          $userArray = json_decode($strUsers, true);
          $data = $userArray['online_users'];
          $this->users->putBulk($data);
          $this->users->setStatusBlockCountries();
          $this->system_message->set_success('Success to upload users JSON file');
        } else {
          $this->system_message->set_error("Fail to upload users JSON file");
        }
      }
      refresh();
    }



    // get list of Frontend user groups
    $this->load->model('group_model', 'groups');
    $this->mViewData['groups'] = $this->groups->get_all();
    $this->mPageTitle = 'Upload users JSON files';

    $this->mViewData['form'] = $form;
    $this->render('user/create_online');
  }

  public function create_jobs()
  {
    $form = $this->form_builder->create_form(NULL, true);

    if ($form->validate()) {
      if (is_uploaded_file($_FILES['jobs_json']['tmp_name'])) {
        $file_path = UPLOAD_FILE_JSON . "jobs.json";

        $tmpFile = $_FILES['jobs_json']['tmp_name'];
        if (move_uploaded_file($tmpFile, $file_path)) {
          // Get the contents of the JSON file 
          $strJobs = file_get_contents($file_path);
          // Convert to array 
          $jobArray = json_decode($strJobs, true);
          $data = $jobArray['jobs'];
          $this->jobs->putBulk($data);
          $this->system_message->set_success('Success to upload jobs JSON file');
        } else {
          $this->system_message->set_error("Fail to upload jobs JSON file");
        }
      }
      refresh();
    }

    // get list of Frontend user groups
    $this->load->model('group_model', 'groups');
    $this->mViewData['groups'] = $this->groups->get_all();
    $this->mPageTitle = 'Upload jobs JSON files';

    $this->mViewData['form'] = $form;
    $this->render('user/create_jobs');
  }
}
