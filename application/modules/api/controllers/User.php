<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Demo Controller with Swagger annotations
 * Reference: https://github.com/zircote/swagger-php/
 */
class User extends Base_Api_Controller
{

  public function index_get()
  {
    $data = $this->users
      ->select('id, username, email, active, first_name, last_name')
      ->get_all();
    $this->response($data);
  }

  public function id_get($id)
  {
    $data = $this->users
      ->select('id, username, email, active, first_name, last_name')
      ->get($id);
    $this->response($data);
  }

  public function signup_post()
  {
    $username = $this->post('username');
    $email = $this->post('email');
    $password = $this->post('password');

    $user = $this->users->get_first_one_where("email", $email);

    if ($user) {
      $this->response(array("status" => 0, "error" => "Email already exist."));
    }

    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
      $path = UPLOAD_PROFILE_PHOTO;

      $milliseconds = round(microtime(true) * 1000);
      $fileName = "profile_" . sprintf("%.0f", $milliseconds) . '.png';
      $file_path = $path . $fileName;

      $tmpFile = $_FILES['image']['tmp_name'];
      if (move_uploaded_file($tmpFile, $file_path)) {
        $additional_data = array(
          "username" => $username,
          "photo" => $fileName
        );
        $group = array('1');
        $user_id = $this->ion_auth->register($email, $password, $email, $additional_data, $group);
        if ($user_id) {
          $createdUser = $this->users->get($user_id);
          $this->register_active_compaign($createdUser);

          $result = array(
            "status" => 1,
            "data" => $createdUser
          );
          $this->response($result);
        } else {
          $this->error($this->ion_auth->errors());
        }
      } else {
        $this->response(array("status" => 0, "error" => "Image Upload failed"));
      }
    } else {
      $this->response(array("status" => 0, "error" => "Upload failed."));
    }
  }

  public function profile_filter_get()
  {
    $this->users->profile_filter();
    $this->response(array("status" => 1, "data" => "Profile filter success."));
  }

  public function login_post()
  {
    $version = $this->post('version');
    if (!$version) {
      $this->login_v0();
    } elseif ($version == 1) {
      $this->login_v1();
    }
  }

  public function login_v0()
  {
    $username = $this->post('username');
    $email = $this->post('email');

    $user = $this->users->get_first_one_where("email", $email);

    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
      $path = UPLOAD_PROFILE_PHOTO;

      $milliseconds = round(microtime(true) * 1000);
      $fileName = "profile_" . sprintf("%.0f", $milliseconds) . '.png';
      $file_path = $path . $fileName;

      $tmpFile = $_FILES['image']['tmp_name'];
      if (move_uploaded_file($tmpFile, $file_path)) {
        if ($user) {
          $update_data = array(
            "photo" => $fileName,
            "username" => $username
          );
          $this->users->update($user->id, $update_data);
          $user = $this->users->get($user->id);
          $this->register_active_compaign($user);

          $response = array(
            "status" => 1,
            "data" => $user
          );
          $this->response($response);
        } else {
          $additional_data = array(
            "username" => $username,
            "photo" => $fileName
          );
          $group = array('1');
          $user_id = $this->ion_auth->register($email, 'password', $email, $additional_data, $group);
          if ($user_id) {
            $createdUser = $this->users->get($user_id);
            $this->register_active_compaign($createdUser);

            $result = array(
              "status" => 1,
              "data" => $createdUser
            );
            $this->response($result);
          } else {
            $this->error($this->ion_auth->errors());
          }
        }
      } else {
        $this->response(array("status" => 0, "error" => "Image Upload failed"));
      }
    } else {
      $this->response(array("status" => 0, "error" => "Upload failed."));
    }
  }

  public function login_v1()
  {
    $email = $this->post('email');
    $password = $this->post('password');

    // proceed to login user
    $result = $this->login_email($email, $password);
    if ($result['status'] == 0) {
      $this->response($result);
    } else {
      $this->response($result);
    }
  }

  public function login_email($email, $password)
  {
    $logged_in = $this->ion_auth->login($email, $password, FALSE);
    if ($logged_in) {
      // get User object and remove unnecessary fields
      $user = $this->ion_auth->user()->row();
      $user = $this->users->get($user->id);

      $token = $this->generateRandomString(50);
      $this->users->update_field($user->id, 'token', $token);
      $user->token = $token;
      //            $user->photo = base_url() . UPLOAD_PROFILE_PHOTO . $user->photo;

      // return result
      $result = array(
        'status' => 1,
        'data' => $user
      );
      return $result;
    }

    return array(
      'status' => 0,
      'error' => $this->ion_auth->errors()
    );
  }

  public function login_facebook_post()
  {
    $fb_id = $this->post('fb_id');
    $username = $this->post('username');
    $email = $this->post('email');
    $picture = $this->post('picture');

    $fileName = '';
    if ($picture && $picture != "" && strpos($picture, 'http') !== false) {
      $path = UPLOAD_PROFILE_PHOTO;
      $milliseconds = round(microtime(true) * 1000);
      $fileName = "profile_" . sprintf("%.0f", $milliseconds) . '.png';
      $file_path = $path . $fileName;
      file_put_contents($file_path, file_get_contents($picture));
    }
    $password = $fb_id;

    $search_key = array(
      'social_id' => $fb_id,
      'social_type' => 'facebook'
    );
    $exist_users = $this->users->set_where($search_key)->get_all();
    if (count($exist_users) > 0) {
      $exist_user = $exist_users[0];
      $update_data = array(
        "username" => $username,
        "photo" => $fileName,
      );
      $this->users->update($exist_user->id, $update_data);

      $logged_in = $this->ion_auth->login($email, $password, FALSE);
      if ($logged_in) {
        // get User object and remove unnecessary fields
        $user = $this->ion_auth->user()->row();
        $user = $this->users->get($user->id);
        $this->register_active_compaign($user);

        // return result
        $result = array(
          "status" => 1,
          "is_login" => "1",
          "data" => $user
        );
        $this->response($result);
      } else {
        $this->error($this->ion_auth->errors());
      }
    } else {
      // additional fields
      //$photo = "http://graph.facebook.com/" . $fb_id . "/picture?type=square";
      $additional_data = array(
        "social_id" => $fb_id,
        "social_type" => 'facebook',
        "username" => $username,
        "photo" => $fileName,
      );

      // set user to "members" group
      $group = array('1');

      // proceed to create user
      $user_id = $this->ion_auth->register($username, $password, $email, $additional_data, $group);
      if ($user_id) {
        $createdUser = $this->users->get($user_id);
        $this->register_active_compaign($createdUser);

        $result = array(
          "status" => 1,
          "is_login" => "0",
          "data" => $createdUser
        );
        $this->response($result);
      } else {
        $this->error($this->ion_auth->errors());
      }
    }
  }

  public function update_profile_post()
  {
    $user_id = $this->post('user_id');
    $username = $this->post('username');
    $email = $this->post('email');

    $user = $this->users->get($user_id);
    if ($user->email != $email) {
      $user_with_email = $this->users->get_first_one_where('email', $email);
      if ($user_with_email) {
        $response = array(
          "status" => 0,
          "error" => "The email has already been taken, choose another one"
        );
        $this->response($response);
        return;
      }
    }

    $update_data = array(
      "username" => $username,
      "email" => $email
    );

    $this->users->update($user_id, $update_data);
    $mUser = $this->users->get($user_id);
    $this->register_active_compaign($mUser);

    $response = array(
      "status" => 1,
      "data" => $mUser
    );
    $this->response($response);
  }

  public function update_profile_with_image_post()
  {
    $user_id = $this->post('user_id');
    $username = $this->post('username');
    $email = $this->post('email');

    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
      $path = UPLOAD_PROFILE_PHOTO;

      $milliseconds = round(microtime(true) * 1000);
      $fileName = "profile_" . sprintf("%.0f", $milliseconds) . '.png';
      $file_path = $path . $fileName;

      $tmpFile = $_FILES['image']['tmp_name'];
      if (move_uploaded_file($tmpFile, $file_path)) {
        $update_data = array(
          "username" => $username,
          "email" => $email,
          "photo" => $fileName
        );

        $this->users->update($user_id, $update_data);
        $mUser = $this->users->get($user_id);
        $this->register_active_compaign($mUser);

        $response = array(
          "status" => 1,
          "data" => $mUser
        );
        $this->response($response);
      } else {
        $this->response(array("status" => 0, "error" => "Image Upload failed"));
      }
    } else {
      $this->response(array("status" => 0, "error" => "Upload failed."));
    }
  }

  public function register_active_compaign($user)
  {
    $fullname = $user->username;
    $names = explode(" ", $fullname);
    $fieldsArray = array(
      'email' => $user->email,
      'p[3]' => 3,
      'first_name' => count($names) > 0 ? $names[0] : "",
      'last_name' => count($names) > 1 ? $names[1] : ""
    );
    $fields = http_build_query($fieldsArray);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, ACTIVE_COMPAIGN_URL);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(AC_CONTENT_TYPE));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }

  public function test_compaign_api_get()
  {
    $user = $this->users->get($this->get('user_id'));
    $response = $this->register_active_compaign($user);
    $this->response($response);
  }


  public function register_push_token_post()
  {
    $user_id = $this->post('user_id');
    $one_signal_id = $this->post('one_signal_id');
    $token = $this->post('token');
    $device_id = $this->post('device_id');
    $device_type = $this->post('device_type');

    $search_key = array(
      'device_id' => $device_id
    );

    $user_token = $this->user_push_tokens->get_first_one_where($search_key);
    if ($user_token) {
      $update_data = array(
        'user_id' => $user_id,
        'token' => $token,
        'device_type' => $device_type,
        'one_signal_id' => $one_signal_id,
        'updated_at' => date("Y-m-d H:i:s")
      );
      $res = $this->user_push_tokens->update($user_token->id, $update_data);
    } else {
      $new_token = array(
        'user_id' => $user_id,
        'token' => $token,
        'one_signal_id' => $one_signal_id,
        'topic' => 'news',
        'device_id' => $device_id,
        'device_type' => $device_type,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
      );
      $res = $this->user_push_tokens->insert($new_token);
    }

    $result = array(
      "status" => 1,
      "data" => $res
    );
    $this->response($result);
  }

  public function notification_status_get()
  {
    $device_id = $this->get('device_id');

    $search_key = array(
      'device_id' => $device_id
    );

    $user_token = $this->user_push_tokens->get_first_one_where($search_key);
    if ($user_token) {
      $result = array(
        "status" => 1,
        "data" => $user_token->status
      );
    } else {
      $result = array(
        "status" => 0,
        "error" => "Device is not registered."
      );
    }

    $this->response($result);
  }

  public function notification_status_post()
  {
    $device_id = $this->post('device_id');
    $status = $this->post('status');

    $search_key = array(
      'device_id' => $device_id
    );

    $user_token = $this->user_push_tokens->get_first_one_where($search_key);
    if ($user_token) {
      $this->user_push_tokens->update_field($user_token->id, "status", $status);
      $result = array(
        "status" => 1,
        "data" => $status
      );
    } else {
      $result = array(
        "status" => 0,
        "error" => "Device is not registered."
      );
    }

    $this->response($result);
  }

  public function iap_status_post()
  {
    $device_id = $this->post('user_id');
    $status = $this->post('premium_type');

    $result = array(
      "status" => 1,
      "data" => ""
    );

    $this->response($result);
  }

  public function update_notification()
  {
    $device_id = $this->post('device_id');
    $status = $this->post('status');

    $search_key = array(
      'device_id' => $device_id
    );

    $user_token = $this->user_push_tokens->get_first_one_where($search_key);
    if ($user_token) {
      $this->user_push_tokens->update_field($user_token->id, "status", $status);
    }
  }

  public function update_profile_notification_post()
  {
    $this->update_notification();
    $this->update_profile_post();
  }

  public function update_profile_notification_with_image_post()
  {
    $this->update_notification();
    $this->update_profile_with_image_post();
  }
}
