<div class="boxs">
  <div class="box-content">
    <div id="box-sidebar-category">
     
        <?php foreach ($categories as $category) { ?>
          <?php if ($category['category_id'] == $category_id) { ?>
         
        <div class="box-sidebar-top">
          <a  class="active"><?php echo $category['name']; ?></a>
             </div>
          <?php } else { ?>
          
        <div class="box-sidebar-top">
          <a class="active"><?php echo $category['name']; ?></a>
             </div>
          <?php } ?>
       
          <?php if ($category['children']) { ?>
          
            <div class="box-sidebar-children">
            <?php foreach ($category['children'] as $child) { ?>
          
              <?php if ($child['category_id'] == $child_id) { ?>
              <a href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a>
              <?php } else { ?>
              <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
              <?php } ?>
            
            <?php } ?>
          </div>
          <?php } ?>
       
        <?php } ?>
   

    </div>
    
    <a href="http://www.yrittajat.fi"><img style="margin-top:30px;margin-left:20px;" src="image/data/SY_jasenyritys_175x88px.png" alt=""/></a>
   
  </div>
</div>  
