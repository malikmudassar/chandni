<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Chandni Halls Online Booking System</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?=site_url()?>/admin/vendors/feather/feather.css">
  <link rel="stylesheet" href="<?=site_url()?>/admin/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?=site_url()?>/admin/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?=site_url()?>/admin/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?=site_url()?>/admin/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
          <form method="POST" action="/Administration/setPassword">

            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo" style="text-align: center;">
                <?php echo img($logo, true); ?>
              </div>
              <h4>Set new password.</h4><br>

              <?php if ($errors) { ?>
                  <div class="alert alert-danger">
                      <ul>
                      <?php foreach ($errors as $error) { ?>
                          <li><?= $error ?></li>
                      <?php } ?>
                      </ul>
                  </div>
                   <?php }?>

              <?php if(session()->getFlashdata('required')):?>
                    <div class="alert alert-warning">
                       <?= session()->getFlashdata('required') ?>
                    </div>
                <?php endif;?>
              <div class="form-group">
                <input type="number" name="otp" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="OTP">
              </div>

              <div class="form-group">
                <input type="text" name="new_pass" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="New Password">
              </div>

              <div class="form-group">
                <input type="text" name="confirm_pass" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Confirm Password">
              </div>
              
              <input type="hidden" name="email" value="<?=$email?>" /> 

              <div class="mt-3">
                <input type="submit" value="SUBMIT" class="btn btn-block btn-outline-success btn-lg font-weight-medium auth-form-btn" /> 
              </div>

              
                
              </div>
            </form>

          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?=site_url()?>/admin/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="<?=site_url()?>/admin/js/off-canvas.js"></script>
  <script src="<?=site_url()?>/admin/js/hoverable-collapse.js"></script>
  <script src="<?=site_url()?>/admin/js/template.js"></script>
  <script src="<?=site_url()?>/admin/js/settings.js"></script>
  <script src="<?=site_url()?>/admin/js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
