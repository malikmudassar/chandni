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
          <form method="POST" action="/Administration/forgetPassEmail">

            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo" style="text-align: center;">
                <?php echo img($logo, true); ?>
              </div>
              <h4>Send email to get otp.</h4><br>
              <?php if(session()->getFlashdata('required')):?>
                    <div class="alert alert-warning">
                       <?= session()->getFlashdata('required') ?>
                    </div>
                <?php endif;?>
              <div class="form-group">
                <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
              </div>
              <div class="mt-3">
                <input type="submit" value="SEND" class="btn btn-block btn-outline-success btn-lg font-weight-medium auth-form-btn" /> 
              </div>
<?php
$session = session();
$redirect = $session->get('forgetPassRedirection');
?>
              <a href="<?=site_url().$redirect?>" class="auth-link text-black" style="float: right;margin-top: 10px;font-size: inherit;">Sign in</a> 

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
