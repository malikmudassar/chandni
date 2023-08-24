


      <!-- partial -->
      <title><?=$company_name?> Online Booking System</title>
      
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome <?=$_SESSION["name"]?></h3>
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" aria-haspopup="true" aria-expanded="true">
                     <i class="mdi mdi-calendar"></i> Today (<?=date("d M Y")?>)
                    </button>
  
                  </div>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-people mt-auto">
                  <img src="/admin/images/dashboard/people.png" alt="people">
                  <div class="weather-info">
                    <div class="d-flex">
                      <?= $this->include("weather", $temperature); ?>                  
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            
          <div class="row">
                
              </div>
            </div>
        </div>
        

