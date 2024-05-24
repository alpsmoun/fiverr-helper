<?php

class User_model extends MY_Model
{

  protected $order_by = array('id', 'DESC');

  public function put($record)
  {
    $rows = $this->get_where('username', $record['username']);
    if (count($rows) > 0) {
      $this->update($rows[0]->id, $record);
    } else {
      $this->insert($record);
    }
  }

  public function putBulk($records)
  {
    foreach ($records as $record) {
      $rows = $this->get_where('username', $record['username']);
      if (count($rows) > 0) {
        $this->update($rows[0]->id, $record);
      } else {
        $this->insert($record);
      }
    }
  }

  public function setStatusBlockCountries()
  {
    $blockCountryList = ['GB', 'GH', 'IL', 'IN', 'JP', 'KE', 'KR', 'NG', 'UG', 'ZM', 'ZW'];
    $status = 1;
    foreach ($blockCountryList as $country) {
      $data = ['status' => $status];
      $this->db->where('country', $country);
      $this->db->update('users', $data);
    }
  }

  public function clearOnline()
  {
    $data = ['online' => 'false'];
    $this->update_all($data);
  }

  // status - 0: normal, 1: sent, 2: banned
  public function setUserStatus($username, $status)
  {
    $data = ['status' => $status];
    $this->db->where('username', $username);
    $this->db->update('users', $data);
  }
}
