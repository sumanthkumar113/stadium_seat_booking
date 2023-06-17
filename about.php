<?php include('header.php');
	$qry2=mysqli_query($con,"select * from tbl_match where match_id='".$_GET['id']."'");
	$movie=mysqli_fetch_array($qry2);
	?>
<div class="content">
	<div class="wrap">
		<div class="content-top">
				<div class="section group">
					<div class="about span_1_of_2">	
						<h3 style="color:#444; font-size:23px;" class="text-center"><?php echo $movie['match_name']; ?></h3>	
							<div class="about-top">	
								<div class="grid images_3_of_2">
									<img src="<?php echo $movie['image']; ?>" alt=""/>
								</div>
								<div class="desc span_3_of_2">
									<!-- <p class="p-link" style="font-size:15px"><b>Cast : </b><?php echo $movie['cast']; ?></p> -->
									<p class="p-link" style="font-size:15px"><b>Date : </b><?php echo date('d-M-Y',strtotime($movie['match_date'])); ?></p>
									<p style="font-size:15px"><?php echo $movie['desc']; ?></p>
									<!-- <a href="<?php echo $movie['video_url']; ?>" target="_blank" class="watch_but" style="text-decoration:none;">Watch Trailer</a> -->
								</div>
								<div class="clear"></div>
							</div>
							<?php $s=mysqli_query($con,"select DISTINCT stadium_id from tbl_matchinfo where match_id='".$movie['match_id']."'");
							if(mysqli_num_rows($s))
							{?>
							<table class="table table-hover table-bordered text-center">
								<h3 style="color:#444;" class="text-center">Seats are Available</h3>

								<thead>
										<tr>
											<th class="text-center" style="font-size:16px;"><b>Stadium </b></th>
											<th class="text-center" style="font-size:16px;"><b></b></th>
										</tr>
									</thead>
							<?php

							
								
								while($shw=mysqli_fetch_array($s))
								{
									
									$t=mysqli_query($con,"select * from tbl_stadium where id='".$shw['stadium_id']."'");
									$theatre=mysqli_fetch_array($t);
									?>
									

									<tbody>
									<tr>
										<td >
											<?php echo $theatre['name'].", ".$theatre['place'];?>
										</td>
										<td>
											<?php $tr=mysqli_query($con,"select * from tbl_matchinfo where match_id='".$movie['match_id']."' and stadium_id='".$shw['stadium_id']."'");
											while($shh=mysqli_fetch_array($tr))
											{
												$ttm=mysqli_query($con,"select  * from tbl_match_time where mt_id='".$shh['mt_id']."'");
												$ttme=mysqli_fetch_array($ttm);
												
												?>
												
												<a href="check_login.php?show=<?php echo $shh['m_id'];?>&movie=<?php echo $shh['match_id'];?>&theatre=<?php echo $shw['stadium_id'];?>"><button class="btn btn-default">SELECT</button></a>
												<?php
											}
											?>
										</td>
									</tr>
									</tbody>
									<?php
								}
							?>
						</table>
							<?php
							}
						
							else
							{
								?>
								<h3 style="color:#444; font-size:23px;" class="text-center">SOLD OUT!</h3>
								<p class="text-center">Please check back later!</p>
								<?php
							}
							?>
						
					</div>			
				<?php include('match_sidebar.php');?>
			</div>
				<div class="clear"></div>		
			</div>
	</div>
</div>
<?php include('footer.php');?>