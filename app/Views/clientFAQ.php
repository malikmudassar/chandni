	<!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                   <h4 class="card-title">FAQs</h4>
                   <div class="card-body">
            <?php 
            if (isset($all_faqs)){
                $i=0;
                foreach($all_faqs as $faq){
                    $i++;
            ?>
                  <p class="card-description"><?=$i?>) <?=$faq->question?></p>
                  <p class="card-description"><?=$faq->answer?></p>
                <?php }} ?>
                </div>
              </div>
            </div>
              </div>

              
            </div>
          </div>
        
        </div>
        

