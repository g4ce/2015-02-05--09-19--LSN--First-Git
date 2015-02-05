 <div class="training_wrapper">

    <?php if (strcmp($training_1_on, 'Yes') == 0){ ?>

      <div class="row training_row">
        <div class="col-md-4">
          <p><?php echo $date_1;  ?></p>
        </div>
        <!-- -->
        <div class="col-md-4">
          <?php get_calendar_snippet($date_1); ?>
        </div>
        <!-- -->
        <div class="col-md-4">
          <?php if (strcmp($availability_1, 'Yes') == 0){
            echo $code_1;
          }
          else
          {  ?>
            <p class="training_booked_out">Booked Out</p>
          <?php } ?>
        </div>
        <!-- -->
      </div>
    <?php } ?>

    <?php if (strcmp($training_2_on, 'Yes') == 0){ ?>

      <div class="row training_row">
        <div class="col-md-4">
          <p><?php echo $date_2;  ?></p>
        </div>
        <!-- -->
        <div class="col-md-4">
          <?php get_calendar_snippet($date_2); ?>
        </div>
        <!-- -->
        <div class="col-md-4">
          <?php if (strcmp($availability_2, 'Yes') == 0){
            echo $code_2;
          }
          else
          {  ?>
            <p class="training_booked_out">Booked Out</p>
          <?php } ?>
        </div>
        <!-- -->
      </div>
    <?php } ?>

    <?php if (strcmp($training_3_on, 'Yes') == 0){ ?>

      <div class="row training_row">
        <div class="col-md-4">
          <p><?php echo $date_3;  ?></p>
        </div>
        <!-- -->
        <div class="col-md-4">
          <?php get_calendar_snippet($date_3); ?>
        </div>
        <!-- -->
        <div class="col-md-4">
          <?php if (strcmp($availability_3, 'Yes') == 0){
            echo $code_3;
          }
          else
          {  ?>
            <p class="training_booked_out">Booked Out</p>
          <?php } ?>
        </div>
        <!-- -->
      </div>
    <?php } ?>

  </div>
<?php

?>

<div class="training_wrapper">
<!-- if first training is switched on -->
<?php if (strcmp($training_1_on,'Yes') == 0){
	// if true, training is switched on ?>
	
	<div class="row training_row">
		
	</div>
	<!-- end training row -->

<?php
}
// end if ?>


<?php if (strcmp($training_2_on,'Yes') == 0){
	// if true, training is switched on ?>
	
	<div class="row training_row">
		
	</div>
	<!-- end training row -->

<?php
}
// end if ?>



<?php if (strcmp($training_3_on,'Yes') == 0){
	// if true, training is switched on ?>
	
	<div class="row training_row">
		
	</div>
	<!-- end training row -->

<?php
}
// end if ?>

</div>
<!-- end training wrapper -->


