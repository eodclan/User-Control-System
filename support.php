<?php
// ************************************************************************************//
// * User Control Panel ( UCP )
// ************************************************************************************//
// * Author: DerStr1k3r
// ************************************************************************************//
// * Version: 1.4
// * 
// * Copyright (c) 2020 DerStr1k3r. All rights reserved.
// ************************************************************************************//
// * License Typ: GNU GPLv3
// ************************************************************************************//
require_once("include/features.php");

site_secure();
secure_url();

if (isset($_GET["support"])) $support = trim(htmlentities($_GET["support"]));
elseif (isset($_POST["support"])) $support = trim(htmlentities($_POST["support"]));
else $support = "view";

site_header();
site_navi_logged();
site_content_logged();

if(isset($_POST['posted_del'])){
	$sql3 = "DELETE FROM support";
	$result3 = mysqli_query($conn, $sql3);
	if($result3)
	{
		echo "
		<div class='content'>
        <div class='row'>
          <div class='col-md-12'>
            <div class='card'>
              <div class='card-header'>
                <h5 class='title'>".WELCOMETO." ".PROJECTNAME."!</h5>
                <p class='category'>User Control Panel | Dashboard</p>
              </div>
              <div class='card-body'>		  
			<div class='row'>			
				<div class='col-sm-12'>		
					<div class='alert alert-info alert-with-icon' data-notify='container'>
						<button type='button' aria-hidden='true' class='close'>
							<i class='now-ui-icons ui-1_simple-remove'></i>
						</button>
						<span data-notify='icon' class='now-ui-icons ui-1_bell-53'></span>
						<span data-notify='message'><b>".SUPPORTDELETEINFO."</b></span>
					</div>
					<br>
					".SUPPORTDELETE."	
				</div>				
			</div>										
		  </div>
		</div>
		</div>
		</div>
		</div>";
	}
	site_footer();
	$conn->close();
	die();
}

if ($support == "addticket") {
// } 
	if(isset($_POST['posted_sup'])){
		if(empty($_POST['username']) || empty($_POST['msg']) || empty($_POST['bug'])){
			site_login_notfound_done();
		}
		else
		{
			$username = xss_cleaner(trim(htmlspecialchars($_POST['username'])));
			$username = mysqli_real_escape_string($conn,$username);
			$msg 	= xss_cleaner(trim(htmlspecialchars($_POST['msg'])));
			$msg 	= mysqli_real_escape_string($conn,$msg);
			$bug 	= xss_cleaner(trim(htmlspecialchars($_POST['bug'])));
			$bug 	= mysqli_real_escape_string($conn,$bug);
			$posted 	= time();

			// CHECK USERNAME FROM KEY
			if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
				site_login_username_not_valid();
			}

			// CHECK USERNAME FROM KEY
			if (preg_match('/[A-Za-z0-9]+/', $_POST['msg']) == 0) {
				site_login_username_not_valid();
			}

			// CHECK USERNAME FROM KEY
			if (preg_match('/[A-Za-z0-9]+/', $_POST['bug']) == 0) {
				site_login_username_not_valid();
			}
			
			$sql = "insert into support (username, msg, bug, posted) value('".$username."', '".$msg."', '".$bug."', NOW())";
			$result = mysqli_query($conn, $sql);
			if($result)
			{
				site_support_posted_done();
			}
			$conn->close();
		}
	}
?>
      <div class='content'>
        <div class='row'>
          <div class='col-md-12'>
            <div class='card'>
              <div class='card-header'>
                <h5 class='title'><?php echo WELCOMETO; ?> <?php echo PROJECTNAME; ?>!</h5>
                <p class='category'>User Control Panel | Support System</p>
              </div>
			  <div class='card-body'>
				<div class='row'>			
					<div class='col-sm-12'>
						<b><?php echo SUPPORTINFO; ?></b>
					</div>
				</div>
			  </div>
			  <div class='card-body'>			  
				<div class='row'>			
					<div class='col-sm-12'>
			<?php	
				$sql = "SELECT username FROM users WHERE id = ".$_SESSION['secure_first']."";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
			?>
					<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?support=addticket" method='post' enctype='multipart/form-data'>
                      <tr>				  
                        <td>
							<h6>
								<?php echo SUPPORTUSERNAME; ?>
								<small class='text-muted'><?php echo SUPPORTUSERINFO1; ?></small>
							</h6>
							<div class='input-group'>
								<div class='input-group-prepend'>
									<div class='input-group-text'>
										<i class='now-ui-icons ui-2_settings-90'></i>
									</div>      
								</div>
								<input style='box-shadow: 0 0 1px rgba(0,0,0, .4);' type='text' name='username' size='50' maxlength='60' class='form-control' value='<?=$row["username"]?>' required>
							</div>	
                        </td>
					  </tr>
                      <tr>				  
                        <td>
							<h6>
								<?php echo SUPPORTSUBJECT; ?>
								<small class='text-muted'><?php echo SUPPORTUSERINFO2; ?></small>
							</h6>
							<div class='input-group'>
								<div class='input-group-prepend'>
									<div class='input-group-text'>
										<i class='now-ui-icons ui-2_settings-90'></i>
									</div>      
								</div>
								<input style='box-shadow: 0 0 1px rgba(0,0,0, .4);' type='text' name='bug' size='50' maxlength='60' class='form-control' required>
							</div>	
                        </td>
					  </tr>
                      <tr>					  
                        <td>
							<h6>
								<?php echo SUPPORTMSG; ?>
								<small class='text-muted'><?php echo SUPPORTUSERINFO3; ?></small>
							</h6>
							<div class='textarea-group'>
								<div class='textarea-group-prepend'>
									<div class='textarea-group-text'>
										<i class='now-ui-icons ui-1_settings-gear-63'></i>
									</div>      
								</div>						
								<textarea style='box-shadow: 0 0 1px rgba(0,0,0, .4);' type='text' name='msg' size='50' maxlength='60' class='form-control textarea' required></textarea>
							</div>	
                        </td>						
                      </tr>					  
                      <tr>					  
						<td>						
							<button type='submit' name='posted_sup' class='btn btn-primary btn-round'>
								<i class='now-ui-icons ui-1_check'></i> <?php echo SUPPORTSAVE; ?>
							</button>
							</submit>
                        </td>							
                      </tr>						
					</form>

		<?php
				}
				mysqli_close($conn);
			}
		?>						 
              </div>
            </div>
          </div>
        </div>
		</div>
	</div>
</div>
<?php
	site_footer();
	die();		
}
?>
    <div class='content'>
        <div class='row'>
          <div class='col-md-12'>
            <div class='card'>
              <div class='card-header'>
                <h5 class='title'><?php echo WELCOMETO; ?> <?php echo PROJECTNAME; ?>!</h5>
                <p class='category'>User Control Panel | Support</p>
              </div>
              <div class='card-body'>		  
				<div class='row'>			
					<div class='col-sm-12'>
						<b><?php echo WELCOMETO; ?>
					<?php
						$id = 0 + $_COOKIE["secure"];
						$securecode = $row["id"];
						$sql = "SELECT username FROM users WHERE id = ".$_SESSION['secure_first']."";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								echo $row["username"];
							}
						}
					?>						
						Support System!</b>
					</div>
				</div>				
			  </div>										
            </div>
			<div class='row'>			
				<div class='col-sm-12'>
					<div class='card'>
						<div class='card-header'>
							<h4 class='card-title'> Support Control System - <?php echo SUPPORTADDTICKET1; ?></h4>
						</div>
						<div class='card-body'>
							<h6>
								<?php echo SUPPORTADDTICKET1; ?>
								<small class='text-muted'><a href="<?php echo $_SERVER["PHP_SELF"]; ?>?support=addticket"><?php echo SUPPORTADDTICKET2; ?></a></small>
							</h6>
						</div>
					</div>				
				</div>										
			</div>

<?php
	if(intval($_SESSION['secure_staff']) >= 3) {
?>
		<div class='row'>
          <div class='col-md-12'>
            <div class='card'>
              <div class='card-header'>
                <h4 class='card-title' style='float: left;'> Support Control System - <?php echo SUPPORTDELETE2; ?></h4>
					<?php
						if(intval($_SESSION['secure_staff']) >= 10) {
					?>
						<h4 style='float: right;'>		
							<form action='<?php echo $_SERVER['PHP_SELF'];?>?=posted_del' method='post' enctype='multipart/form-data'>
								<button class='form-control btn-round btn-icon border-gray' name='posted_del'><i class='now-ui-icons ui-1_simple-remove'></i> <?php echo SUPPORTDELETE2; ?></button>
							</form>
						</h4>
					<?php	
						}
					?>	 
				
              </div>
              <div class='card-body'>
                <div class='table-responsive'>
                  <table class='table'>
                    <thead class=' text-primary'>
                      <th>
                        <?php echo SUPPORTUSERID; ?>
                      </th>
                      <th>
					  	<?php echo SUPPORTUSERNAME; ?>
                      </th>					  
                      <th>
					  	<?php echo SUPPORTSUBJECT; ?>
                      </th>
                      <th>
					  	<?php echo SUPPORTMSG; ?>
                      </th>				  
                      <th>
					  	<?php echo SUPPORTDATE; ?>
                      </th>
                    </thead>
                    <tbody>
		<?php
			$sql = "SELECT id, username, msg, bug, posted FROM support ORDER BY posted";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
						// output data of each row
				while($row = $result->fetch_assoc()) {
		?>
                      <tr>
                        <td>
                          <?=$row["id"]?>
                        </td>
                        <td>
                          <?=$row["username"]?>
                        </td>						
                        <td>
                          <?=$row["bug"]?>
                        </td>
                        <td>
                          <?=$row["msg"]?>
                        </td>
                        <td>
                          <?=$row["posted"]?>
                        </td>
                      </tr>
		<?php	  
				}
			}
		?>									  
                    </tbody>
                  </table>
                </div>
			  </div>
		  </div>
	   </div>
<?php
	}
?>
		</div>
	 </div>		 		  
   </div>
</div>
<?php
site_footer();
?>