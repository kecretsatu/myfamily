
<!-- Page Content -->
<div class="page-title-2">
	<div class="col-md-6"><h1>Form User</h1></div>	
</div>

<div class="col-md-12 page-content">
	<div class=" no-background no-padding">
		<div class="alert" role="alert"><p></p></div>
	</div>
	<div class="container">
		<form id="form" class="form-horizontal label-left">
			<div class="col-md-6">
				<input type="hidden" name="key" value="<?php if($data){echo $data[0]["id"];} ?>" />
				<input type="hidden" name="crud" value="<?php echo $form; ?>" />

				<br />
				
				<div class="form-group">
					<label class="control-label col-sm-3" >Nama</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm" name="no_urut_kp" placeholder="Nomor Urut KP" value="<?php echo $data[0]["first_name"]; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" >Alias</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm" name="no_urut_kp" placeholder="Nomor Urut KP" value="<?php echo $data[0]["last_name"]; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" >Marga</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm" name="no_urut_kp" placeholder="Nomor Urut KP" value="<?php echo $data[0]["marga"]; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" >Jenis Kelamin</label>
					<div class="col-sm-3">
						<select class="form-control input-sm" >
							<option value="1" <?php if($data[0]["jenkel"] == 1)echo 'selected="selected"'; ?>>Laki-laki</option>
							<option value="0" <?php if($data[0]["jenkel"] == 0)echo 'selected="selected"'; ?>>Perempuan</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" >Hidup</label>
					<div class="col-sm-3">
						<select class="form-control input-sm" >
							<option value="1" <?php if($data[0]["hidup"] == 1)echo 'selected="selected"'; ?>>Ya</option>
							<option value="0" <?php if($data[0]["hidup"] == 0)echo 'selected="selected"'; ?>>Tidak</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" >Tempat Lahir</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm" name="no_urut_kp" placeholder="Nomor Urut KP" value="<?php echo $data[0]["tempat_lahir"]; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" >Alamat</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm" name="no_urut_kp" placeholder="Nomor Urut KP" value="<?php echo $data[0]["alamat"]; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" >Kota</label>
					<div class="col-sm-5">
						<input type="text" class="form-control input-sm" name="no_urut_kp" placeholder="Nomor Urut KP" value="<?php echo $data[0]["kota"]; ?>">
					</div>
				</div>
				
				<div class="col-md-12 line-break"><hr /></div>
				<div class="form-group">
					<label class="control-label col-sm-4" ></label>
					<div class="col-sm-8">
						<?php if($form == "add"){?>
						<button class="btn btn-sm btn-success" onclick="formx.post(this);" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Please wait..."><i class="fa fa-save" aria-hidden="true"></i>Simpan</button>
						<?php } ?>
						<?php if($form == "edit"){?>
						<button class="btn btn-sm btn-primary" onclick="formx.post(this);" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Please wait..."><i class="fa fa-edit" aria-hidden="true"></i>Edit</button>
						<button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>Hapus</button>
						<?php } ?>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>



<script>

var formx;

$(document).ready(function(e){
	formx = new Form("#form");
	
});

var Form = function(form){
	var tableColumnCount 	= 8;
	var form				= $(form);
	
	Form.prototype.post = function(btn){
		$(btn).button("loading");
		
		var data = new FormData(form[0]);
		$.ajax({type: "POST", url: "<?php echo $postURL; ?>", dataType: 'json', data: data, processData: false, contentType: false,
			success: function(data){				
				if(data[0].status == 1){
					showAlert(".alert", btn, "alert-success", data[0].msg);
				}
				else{
					showAlert(".alert", btn, "alert-danger", data[0].msg);
				}
			},
			error: function (data) {
				showAlert(".alert", btn, "alert-danger", JSON.stringify(data));
			},
			complete : function () {
				$('html, body').animate({ scrollTop: $("body").offset().top }, 500);
			}
		});
	};
}

$("#formxx").submit(function(e){
	e.preventDefault();
	
	$("#form .btn-suc")
	
});


</script>

