

<li class="dropdown notifications-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
  <i class="fa fa-bell-o"></i>
     
  <?php
    if(count($cash_advance) >= 1 || count($leave) >= 1 || count($loan) >= 1 || count($update_rqst) >= 1){
  ?>
    <span class="label label-danger"> <?= count($cash_advance) + count($leave) + count($loan) + count($update_rqst);  ?> </span>
  <?php
    }
  ?>
  </a>
  <ul class="dropdown-menu">
    <li class="header">You have <?php
                                   if(count($cash_advance) + count($leave) + count($loan) >= 1 == 0){
                                    echo "no";
                                   }else{
                                    echo count($cash_advance) + count($leave) + count($loan) ;
                                   }
                                 ?> pending requests received.
     </li>
    <li>
      <!-- inner menu: contains the actual data -->
      <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
       
  
        <?php
          if(count($leave) >= 1){
        ?>
        <li>
          <a href="<?php echo base_url('index.php/admin/leave') ?>">
            <i class="fa fa-user-times"></i><?= count($leave) ?> leave                                                     
                                                  <?php 
                                                      if(count($leave )  > 1){
                                                        echo "requests are pending.";
                                                      }
                                                      if(count($leave) == 1){
                                                        echo "request is pending.";
                                                      } 
                                                    ?>
          </a>
        </li>
        <?php
          }
        ?>

        <?php
          if(count($cash_advance) >= 1){
        ?>

        <li>
          <a href="<?php echo base_url('index.php/admin/cash_advance') ?>">
            <i class="fa fa-money"></i><?= count($cash_advance) ?> cash advance                                                    
                                                    <?php 
                                                      if(count($cash_advance) > 1){
                                                        echo "requests are pending.";
                                                      }
                                                      if(count($cash_advance)==1){
                                                        echo "request is pending.";
                                                      } 
                                                    ?>
          </a>
        </li>

        <?php
          }
        ?>
        <?php
          if(count($loan) >= 1){
        ?>
        <li>
          <a href="<?php echo base_url('index.php/admin/loan') ?>">
            <i class="fa fa-money"></i><?= count($loan) ?> loan 
                                                     <?php 
                                                      if(count($loan) > 1){
                                                        echo "requests are pending.";
                                                      }
                                                      if(count($loan) == 1){
                                                        echo "request is pending.";
                                                      } 
                                                    ?>
          </a>
        </li>
        <?php
          }
        ?>

        <?php
            if(count($update_rqst) >= 1){            
        ?>
         <li>
          <a href="<?php echo '#'; ?>">
            <i class="fa fa-money"></i><?= count($update_rqst) ?> information update
                                                     <?php 
                                                      if(count($update_rqst) > 1){
                                                        echo "requests are pending.";
                                                      }
                                                      if(count($update_rqst) == 1){
                                                        echo "request is pending.";
                                                      } 
                                                    ?>
          </a>
        </li>
  
        <?php
          }
        ?>

      </ul>
      <div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
    </li>
  </ul>
</li>