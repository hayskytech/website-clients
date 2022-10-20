<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/table.min.css">
<?php
global $wpdb;
$rows = $wpdb->get_results("SELECT portfolio,domain,info,end_date FROM hostings WHERE portfolio != 'None'");
echo '
<table class="ui blue collapsing table" id="maintable">
	<thead>
		<tr>
			<th>No.</th>
			<th>Project Website and description</th>
		</tr>
	</thead>
	<tbody>'; 
foreach ($rows as $row) {
	if($row->end_date < date('Y-m-d')){
		continue;
	}
	echo '
		<tr>
			<td>'.++$i.'.</td><td> <a href="https://'.$row->domain.'" target="blank">'.$row->domain.'</a> <i class="right floated external icon"></i></td>
		</tr>';
}
echo '</tbody>
</table>';
?>
<style type="text/css">
	#maintable td{
		font-family: Arial !important;
	}
	#maintable td a{
		text-decoration: none !important;
		color: blue !important;
	}
</style>