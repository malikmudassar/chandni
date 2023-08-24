<style>
    table.dataTable > thead > tr > td:not(.sorting_disabled) {
    padding-right: 23px;
    }
</style>
<script>
setTimeout(() => { 
        $('.alert').addClass('d-none');
    }, 3000);

    
</script>

      <!-- partial -->
      <title>Chandni Halls Online Booking System</title>
      
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">FAQs List</p>
                  <?php
                  $session = session();
                  $success = $session->getFlashdata('success');
                    if ($success) 
                    {
                        echo '<div class="alert alert-success">'.$success.'</div>';
                    }
                    ?>
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table width="100%" class="display expandable-table" id="example">
                          <thead>
                            <tr>
                              <th>Sr.#</th>
                              <th>Question</th>
                              <th>Answer</th>
                              <th>Action</th>
                            </tr>
                            <?php
                            if(isset($all_faqs)){
                            $i=0;
                              foreach($all_faqs as $faq) {
                                $i++;
                                ?>
                                <tr>
                                  <td><?=$i?></td>
                                  <td><?=$faq->question?></td>
                                  <td><?=$faq->answer?></td>
                                  
                                  <td><a href='/Administration/editFaq/<?=$faq->id?>' class="btn btn-light" style="
                                      background: #53cc96;color: white;" >EDIT</a>
                                      <a href='/Administration/delete/<?=$faq->id?>' class="btn btn-light" style="
                                      background: red;color: white;" onclick="return confirm('Are you sure you want to delete this record?')"> DELETE</a>
                                  </td>
                                </tr>
                                <?php
                              }}
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
        

