<?php include('header.php');
if(!isset($_SESSION['user']))
{
	header('location:login.php');
}
	$qry2=mysqli_query($con,"select * from tbl_match where match_id='".$_SESSION['movie']."'");
	$movie=mysqli_fetch_array($qry2);
	?>
<div class="content">
	<div class="wrap">
		<div class="content-top">
				<div class="section group">
					<div class="about span_1_of_2">	
						<h3><?php echo $movie['match_name']; ?></h3>	
							<div class="about-top">	
								<div class="grid images_3_of_2">
									<img src="<?php echo $movie['image']; ?>" alt=""/>
								</div>
								<div class="desc span_3_of_2">
									<!-- <p class="p-link" style="font-size:15px"><b>Cast : </b><?php echo $movie['cast']; ?></p> -->
									<p class="p-link" style="font-size:15px"><b> Date : </b><?php echo date('d-M-Y',strtotime($movie['match_date'])); ?></p>
									<p style="font-size:15px"><?php echo $movie['desc']; ?></p>
									<!-- <a href="<?php echo $movie['video_url']; ?>" target="_blank" class="watch_but">Watch Trailer</a> -->
								</div>
								<div class="clear"></div>
							</div>
							<table class="table table-hover table-bordered text-center">
							<?php
								$s=mysqli_query($con,"select * from tbl_matchinfo where m_id='".$_SESSION['show']."'");
								$shw=mysqli_fetch_array($s);
								
									$t=mysqli_query($con,"select * from tbl_stadium where id='".$shw['stadium_id']."'");
									$theatre=mysqli_fetch_array($t);
									?>
									<tr>
										<td class="col-md-6">
											Stadium: 
										</td>
										<td>
											<?php echo $theatre['name'].", ".$theatre['place'];?>
										</td>
									</tr>
									<tr>
										<td>
											Seat Type: 
										</td>
										<td>
											<select name="language" id="language">
											<option value="front">Front Row</option>
											<option value="back" selected>Back Row</option>
											</select>
											<?php 
												$ttm=mysqli_query($con,"select  * from tbl_match_time where mt_id='".$shw['mt_id']."'");
												$ttme=mysqli_fetch_array($ttm);
												$sn=mysqli_query($con,"select  * from tbl_zone where zone_id='".$ttme['zone_id']."'");
												$screen=mysqli_fetch_array($sn);?>
										</td> 
									</tr>
									<tr>
										<td>
											Time
										</td>
										<td>
											<?php echo date('h:i A',strtotime($ttme['start_time']));?> 
										</td>
									</tr>

									<tr>
										<td>
											Number of Seats
										</td>
										<td>
											
										<?php $av=mysqli_query($con,"select sum(no_seats) from tbl_bookings where match_info_id='".$_SESSION['show']."'");
								$avl=mysqli_fetch_array($av); ?>
											<form  action="process_booking.php" method="post">
											<input type="hidden" name="screen" value="<?php echo $screen['zone_id'];?>"/>
											<input type="number" required tile="Number of Seats" max="<?php echo $screen['seats']-$avl[0];?>" min="0" name="seats" class="form-control" value="1" style="text-align:center" id="seats"/>
											<input type="hidden" name="amount" id="hm" value="<?php echo $screen['charge'];?>"/>
											<input type="hidden" name="date" value="<?php echo $date;?>"/>
										</td>
									</tr>
									<tr>
										<td>
											Amount
										</td>
										<td id="amount" style="font-weight:bold;font-size:18px">
											Rs <?php echo $screen['charge'];?>
										</td>
									</tr>
									<tr>
										<td colspan="2"><?php if($avl[0]==$screen['seats']){?><button type="button" class="btn btn-danger" style="width:100%">House Full</button><?php } else { ?>
										<button class="btn btn-info" style="width:100%">Book Now</button>
										<?php } ?>
										</form></td>
									</tr>
						<table>
							<tr>
								<td></td>
							</tr>
						</table>
					</div>			
				<?php include('match_sidebar.php');?>
			</div>
				<div class="clear"></div>		
			</div>
	</div>
</div>
<?php include('footer.php');?>
<script type="text/javascript">
	$('#seats').change(function(){
		var charge=<?php echo $screen['charge'];?>;
		amount=charge*$(this).val();
		$('#amount').html("Rs "+amount);
		$('#hm').val(amount);
	});
</script>