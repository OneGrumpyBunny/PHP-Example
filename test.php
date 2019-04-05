<?php include 'hs_wrap.php';?>

<!--  container row -->

<div class="row">
	

	<div class="col-lg-8 main-content">

		<div class="input-group" id="DateDemo">
			<input type="text" id="dd" name="dd" data-format="MM/DD/YYYY" placeholder="date"  class="form-control"/>
			<span class="input-group-btn">
				<button class="btn btn-green" type="button"><span class="glyphicon glyphicon-calendar"></i></button>
			</span>
		</div>
		<div class="input-group" id="TimeDemo">
			<input type="text" id="tt" name="InspectionDate" placeholder="time" class="form-control" />
			<span class="input-group-btn">
				<button class="btn btn-green" type="button"><i class="glyphicon glyphicon-time"></i></button>
			</span>
		</div>
    </div>
</div>


	</form>

	</div> <!-- col 8 -->

<div class="col-lg-4 sidebar">

<?php include $globals["INCL_DIR"].'sidebar.php';?>

</div> <!-- col 4-->
</div> <!-- row 8/4-->


<?php include $globals["INCL_DIR"].'footer.php';?>