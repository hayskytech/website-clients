<?php
$id = $_GET['web'];
global $wpdb;
$row = $wpdb->get_row("SELECT * FROM hostings WHERE id=$id");
if ($args['show']=='url') {
	echo '<span contenteditable spellcheck="false">'.$row->domain.'</span>';
}
if ($args['show']=='title') {
	echo '<span contenteditable spellcheck="false">'.$row->info.'</span>';
}
if ($args["show"]=='desktop') {
	echo '<div style="width:1200px;height: 220px;direction: rtl;background-color:;">
<iframe src="https://'.$row->domain.'" style="transform: scale(0.28,0.28) translate(-1550px,-1000px);width: 1200px;height: 800px;border-radius: 50px;border: 5px solid black;" ></iframe>
</div>';
}
if ($args["show"]=='mobile') {
	echo '<div style="width:400px;height: 250px;direction: rtl;">
<iframe class="webdesign" src="https://'.$row->domain.'" style="transform: scale(0.28,0.28) translate(-200px,-1000px);width: 1000px;height: 800px;border-radius: 50px;border: 5px solid black;" ></iframe>
</div>';
}