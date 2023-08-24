


      <!-- partial -->
      <title><?=$company_name?> Online Booking System</title>
      
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-people mt-auto">

                  <div class="card">
                <div class="card-body">
                  <p class="card-title">Admin List</p>
                  <div class="row">
                   <div class="col-md-12 grid-margin stretch-card">
                      <div class="table-responsive">
                        <table width="100%" class="display expandable-table">
                          <thead>
                            <tr>
                              <th width="18%">First name</th>
                              <th width="15%">Last name</th>
                              <th width="25%">Email</th>
                              <th width="25%">Type</th>
                              <th width="15%">Phone</th>
                              <th width="13%">Action</th>
                              
                            </tr>
                        <?php
                        //   echo '<pre>';
                        //   print_r($admin_user);
                        //   exit;
                          if (count($admin_user)>0) {
                            foreach ($admin_user as $user) {
                              $admmin_type = $user->admin_type;
                              if($admmin_type==1)
                              {
                              $admmin_type='Super Admin';
                              }
                              else
                              {
                                $admmin_type='Sub Admin';
                              }
                        ?>
                            
                        <tr>
                          <td class="font-weight-bold"><?=$user->fname?></td>
                          <td class="font-weight-bold"><?=$user->lname?></td>
                          <td class="font-weight-bold"><?= $user->email ?></td>
                          <td class="font-weight-bold"><?= $admmin_type ?></td>
                          <td><?=$user->phone?></td>               
                          <td>
                              <a href='/ManageClient/delete/<?=$user->id?>' class="btn btn-light" onclick="return confirm('Are you sure you want to delete this event?');"> DELETE</a>
                              <input type="button" class="btn btn-light" onclick="document.location='/ManageClient/modify/<?=$user->id?>'" value="MODIFY" />
                          </td>                
                        </tr>
                        <?php
                            }
                            
                          } 
                        ?>
                          </thead>
                      </table>
                      </div>
                    </div>
                  </div>
              </div>
      </div>
     </div>
     </div>
    </div>
    </div>
    </div>
