<?php echo $form->messages(); ?>

<div class="row">

  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Online Users</h3>
      </div>
      <div class="box-body">
        <?php echo $form->open(); ?>

        <?php echo $form->bs3_text('', 'username', NULL, ['style' => "display:none"]); ?>

        <?php echo $form->bs3_upload('Please select online users JSON file', 'online_users_json'); ?>

        <?php echo $form->bs3_submit(); ?>

        <?php echo $form->close(); ?>
      </div>
    </div>
  </div>
  
</div>