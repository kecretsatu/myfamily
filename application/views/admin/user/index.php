<!-- Page Content -->
<div class="page-title-2">
	<div class="col-md-6"><h1>User</h1></div>
	<div class="col-md-6">
		<div class="control">
			<a href="<?php echo $addURL; ?>" class="add"><i class="fa fa-plus"></i>&nbsp; Add</a>
			<span>|</span>
			<a href="javascript:void(0)" onclick="script.refresh()" class="refresh"><i class="fa fa-refresh"></i>&nbsp; Refresh</a>
		</div>
	</div>
	<div class="col-md-12 table-fix-header">
		<table class="table">
			<thead>
				<th>No</th>
				<th>Email</th>
				<th>First Name</th>
				<th>Marga</th>
				<th class="action 1"></th>
			</thead>
		</table>
	</div>
</div>

<div class="col-md-12 page-content">
	<div class=" no-background no-padding">
		<div class="alert" role="alert"><p></p></div>
	</div>
	<div class="container">
		<div class="table-responsive">
			<table id="table" class="table table-striped">
				<thead>
					<th>No</th>
					<th>Email</th>
					<th>First Name</th>
					<th>Marga</th>
					<th class="action 1"></th>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>

<script>
var script;
$(document).ready(function(e){
	script = new Script("#table");
	script.refresh();
});

var Script = function(table){
	var tableColumnCount 	= 3;
	var table				= $(table);
	var data				= [];
	
	Script.prototype.refresh = function(){
		var parent = this;
		
		parent.setnotif('Mengambil data');
		
		$.ajax({type: "POST", url: "<?php echo $getURL; ?>", dataType: 'json', data: data, 
			success: function(data){
				parent.data = data;
				parent.build();
			},
			error: function (data) {
				parent.setnotif(JSON.stringify(data));
			table.DataTable();
			}
		});
	};
	
	Script.prototype.build = function(){
		var parent = this;
		var items = "";
		
		var n = 0;
		$.each(parent.data, function(index, array){
			n++;
			items += '<tr>';
			items += '<td>'+n+'</td>';
			
			for(var col = 1; col <= tableColumnCount; col++){
				items += '<td>'+array[col]+'</td>';
			}
			
			items += '<td class="action1">';
			//items += '<a href="<?php echo $editURL; ?>?key='+array["key"]+'" ><i class="fa fa-print"></i></a>';
			<?php if(!isset($_GET["key"])){ ?>
			items += '<a href="<?php echo $viewURL; ?>?key='+array["key"]+'" ><i class="fa fa-eye"></i></a>';
			<?php } ?>
			items += '<a href="<?php echo $editURL; ?>?key='+array["key"]+'" ><i class="fa fa-edit"></i></a>';
			items += '<a href="javascript:void(0)" onclick="show_form()"><i class="fa fa-trash"></i></a>';
			items += '</td>';
			items += '</tr>';
		});
		table.children("tbody").html(items);		
		
		
		try{
			table.DataTable();
			parent.syncTableFixedHeader();
		}
		catch(err){
			alert(err.message);
		}
	};
	
	Script.prototype.syncTableFixedHeader = function(){
		$(".page-title-2 .table-fix-header table").width(table.width());
		table.find("thead th").each(function(index, object){
			$(".page-title-2 .table-fix-header table thead th").eq(index).css("min-width", $(object).outerWidth()+"px");
		});
	};
	
	Script.prototype.setnotif = function(str){
		table.children("tbody").html('<tr><td colspan="100" style="text-align:center">'+str+'</td></tr>');
	};
}
</script>
