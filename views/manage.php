<?php
if($secure == "OK"){
	function table_management(){
		?>
		<h1 class="titleproject">My Project</h1>
		<table id="myproject">
			<thead>
				<tr>
					<th>NO</th>
					<th>NAMA</th>
					<th>STATUS</th>
					<th>DEADLINE</th>
					<th width="150">NOTE</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody>
				<?php
			    $ffs = scandir("../");
			    $no=1;
			    foreach($ffs as $ff){
			        if($ff != '.' && $ff != '..' && $ff != "backups"){
			        	if(is_dir('../'.$ff)){
			        		echo '<tr>';
			        		if(file_exists("../".$ff.'/fnm_management.txt')){
				        		$fh = fopen("../".$ff.'/fnm_management.txt','r');
				        		$lines = array();
				        		while (!feof($fh))
				        		{
				        		    $line=fgets($fh);

				        		    $line=trim($line);

				        		    $lines[]=$line;

				        		}
				        		fclose($fh);

				        		$now = date('Y-m-d');
				        		$dead = date('Y-m-d',strtotime($lines[2]));
				        		if($dead >= $now){
					        		$date1 = new DateTime($now);
					        		$date2 = new DateTime($dead);
					        		$selisih = $date1->diff($date2)->format("%a");
					        		if($selisih >= 0 && $selisih <= 7 && $lines[1] != "Done"){
					        			$message = "<strong>".$lines[0]."</strong>&nbsp; is ".$selisih." days to deadline";
					        			if($selisih == 0){
					        				$message = "Last day for complete&nbsp; <b>".$lines[0]."</b>";
					        			}
					        			?>
					        			<script type="text/javascript">
					        				$(document).ready(function(){
					        					Materialize.toast("<?php echo $message;?>", 10000, 'toast-reminder');
					        				});
					        			</script>
					        			<?php
					        		}
					        	} else {
					        		if($lines[1] != "Done"){
					        			$message = "<strong>".$lines[0]."</strong>&nbsp;didn't complete from deadline";
					        			?>
					        			<script type="text/javascript">
					        				$(document).ready(function(){
					        					Materialize.toast("<?php echo $message;?>", 10000, 'toast-warning');
					        				});
					        			</script>
					        			<?php	
					        		}
					        	}
				        		?>
				        		<td><?php echo $no;?></td>
				        		<td><?php echo $lines[0];?></td>
				        		<td><?php echo $lines[1];?></td>
				        		<td><?php echo $lines[2];?></td>
				        		<td><?php if($lines[3] == "yes"){echo '<a href="http://localhost/'.$ff.'/fnm_notes.txt" target="_blank" title="Download">DOWNLOAD</a>';}else{echo "No Notes";}?></td>
				        		<?php
				        	} else {
				        		?>
				        		<td><?php echo $no;?></td>
				        		<td><?php echo $ff;?></td>
				        		<td>No file management</td>
				        		<td>No file management</td>
				        		<td>No file management</td>
				        		<?php
				        	}
			            	?>

			            	<td><a href="?page=show_form&project_key=<?php echo encrypt($ff);?>" title="Create / Update File Management"><img src="assets/img/input.png"></a> 
			            	<a href="http://localhost/<?php echo $ff;?>" title="Visit Project" target="_blank"><img src="assets/img/view.png"></a>
			            	<img src="assets/img/backup.png" class="do_backup" projectkey="<?php echo encrypt($ff);?>" title="Backup Project"></td>
			            	</tr><?php
			            	$no++;
			            }
			        }
			    }
			    ?>
			</tbody>
		</table>
		<script type="text/javascript">
			$(document).ready(function() {
			    $('#myproject').DataTable();
			});
			$(".do_backup").click(function(){
				$.ajax({
				    type: 'GET',
				    url: 'config/ajax.php',
				    data: 'act=do_backup&project_key='+$(this).attr("projectkey"),
				    dataType: 'html',
				    beforeSend: function() {
				        Materialize.toast("Process Backup Data", 5000);
				    },
				    success: function(response) {
				        Materialize.toast(response, 4000, 'toast-success');
				    }
				});
			});
		</script>
		<?php
	}

	function show_form(){
		$folder = decrypt($_GET['project_key']);
		$name = $folder; $status=""; $deadline=""; $note="";
		if(file_exists("../".$folder.'/fnm_management.txt')){
			$fh = fopen("../".$folder.'/fnm_management.txt','r');
			$lines = array();
			while (!feof($fh))
			{
			    $line=fgets($fh);

			    $line=trim($line);

			    $lines[]=$line;

			}
			fclose($fh);
			$name = $lines[0];
			$status = $lines[1];
			$deadline = $lines[2];
			$note = $lines[3];
			if($note == "yes"){
				$note = file_get_contents("../".$folder."/fnm_notes.txt");
			} else {
				$note = "";
			}
		}
		?>
		<div class="row">
			<a href="http://localhost/" title="Back"><button class="btn waves-effect waves-light btn-back">&laquo; Back</button></a>
			<h1 class="titleproject"><?php echo $name;?></h1>
			<div class="col s12 m12 l12">
				<form action="" method="POST">
					<div class="input-field col s12 m7 l7">
						<input value="<?php echo $name;?>" id="name" type="text" class="validate" name="name">
						<label class="active" for="name">Name</label>
					</div>
					<div class="input-field col s12 m7 l7">
						<select name="status">
					    	<option value="" disabled <?php if($status == "") echo "SELECTED";?>>Choose your option</option>
					    	<option value="Revision" <?php if($status == "Revision") echo "SELECTED";?>>Revision</option>
					    	<option value="Done" <?php if($status == "Done") echo "SELECTED";?>>Done</option>
					    	<option value="Pending" <?php if($status == "Pending") echo "SELECTED";?>>Pending</option>
					    	<option value="OnProgress" <?php if($status == "OnProgress") echo "SELECTED";?>>OnProgress</option>
						</select>
						<label>Status Project</label>
					</div>
					<div class="input-field col s12 m7 l7">
						<input type="date" class="datepicker" name="deadline" id="deadline" value="<?php echo $deadline;?>">
						<label class="active" for="name">Deadline</label>
					</div>
					<div class="input-field col s12 m7 l7">
						<i class="material-icons prefix">mode_edit</i>
					    <textarea id="icon_prefix2" class="materialize-textarea" name="notes"><?php echo $note;?></textarea>
					    <label for="icon_prefix2">Notes</label>
					</div>
					<div class="input-field col l12 m12 s12">
						<button class="btn waves-effect waves-light" type="submit" name="action">Submit
							<i class="material-icons right">send</i>
						</button>
					</div>
				</form>
			</div>
		</div>
		<?php
		if(isset($_POST['name'])){
			$myfile = fopen("../".$folder."/fnm_management.txt", "w") or die("Unable to open / create file management!");
			$txt = $_POST['name']. PHP_EOL;
			fwrite($myfile, $txt);
			$txt = $_POST['status'].PHP_EOL;
			fwrite($myfile, $txt);
			$txt = $_POST['deadline'].PHP_EOL;
			fwrite($myfile, $txt);
			if($_POST['notes'] != ""){
				$txt = "yes";
				$myfile2 = fopen("../".$folder."/fnm_notes.txt", "w") or die("Unable to open / create file notes!");
				$txt2 = trim(strip_tags($_POST['notes']));
				fwrite($myfile2, $txt2);
				fclose($myfile2);
			} else {
				$txt = "no";
			}
			fwrite($myfile, $txt);
			fclose($myfile);
			?>
			<script type="text/javascript">
				$(document).ready(function(){
					Materialize.toast('Update Success', 4000, 'toast-success');
				});
			</script>
			<meta http-equiv="refresh" content="3;http://localhost/"><?php
		}
	}

	if(empty($_GET['page'])){
		table_management();
	} elseif ($_GET['page'] == "show_form") {
		show_form();
	}
}
?>