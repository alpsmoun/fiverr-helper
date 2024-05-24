<?php

class Job_model extends MY_Model
{

  protected $order_by = array('id', 'DESC');

  public function putBulk($records)
  {
    foreach ($records as $record) {
      $validRecord = [
        'title' => $record['title'],
        'created_on' => $record['createdOn'],
        'type' => $record['type'],
        'description' => $record['description'],
        'duration' => $record['duration'],
        'engagement' => $record['engagement'],
        'recno' => $record['recno'],
        'uid' => $record['uid'],
        'client_payment_status' => intval($record['client']['paymentVerificationStatus']),
        'client_review_score' => $record['client']['totalFeedback'],
        'client_review_count' => $record['client']['totalReviews'],
        'client_money_spent' => $record['client']['totalSpent'],
        'client_country' => $record['client']['location']['country'],
      ];
      $rows = $this->get_where('uid', $validRecord['uid']);
      if (count($rows) > 0) {
        $this->update($rows[0]->id, $validRecord);
      } else {
        $this->insert($validRecord);
      }
    }
  }
}
