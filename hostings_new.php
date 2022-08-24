<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/sp-1.0.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/sp-1.0.1/datatables.min.js"></script>

<?php
if(is_admin()) {
    echo '<div style="padding-top: 20px; padding-right: 20px">';
}
$table_name = 'hostings';
global $wpdb;
if (isset($_FILES["import"])) {
    if (pathinfo($_FILES["import"]["name"],PATHINFO_EXTENSION)==="csv") {
        $targetPath = dirname(__FILE__)."/" .rand(11,99). $_FILES["import"]["name"];
        move_uploaded_file($_FILES["import"]["tmp_name"], $targetPath);
        $handle = fopen($targetPath, "r");
        $imported = 0; $failed = 0;
        while(($filesop = fgetcsv($handle, 1000, ",")) !== false) {
            if (!$col) {
                for ($i=0; $i < count($filesop); $i++) { 
                    $col[$i] = $filesop[$i];
                }
            } else {
                for ($i=0; $i < count($filesop); $i++) { 
                    $data[$col[$i]] = sanitize_text_field($filesop[$i]);
                    if ($col[$i]=="start_date") {
                        $data[$col[$i]] = date("Y-m-d",strtotime($data[$col[$i]]));
                    }
                    if ($col[$i]=="end_date") {
                        $data[$col[$i]] = date("Y-m-d",strtotime($data[$col[$i]]));
                    } 
                }
                $wpdb->insert($table_name,$data);
                if ($wpdb->insert_id) {
                    $imported++;
                } else {
                    $failed++;
                }
            }
        }
        echo $imported." rows imported. ".$failed." rows failed.";
        fclose($handle);
        unlink($targetPath);
        if (function_exists("redirect_to_same")) {
            redirect_to_same();
        }
    } else {
        $message = "Invalid File Type. Upload Excel File.";
        echo $message;
    }
}
if($_POST["action"]){
    $data["domain"] = $_POST["domain"];
    $data["info"] = $_POST["info"];
    $data["amount"] = $_POST["amount"];
    $data["start_date"] = $_POST["start_date"];
    $data["end_date"] = $_POST["end_date"];
    $data["cycle"] = $_POST["cycle"];
    $data["status"] = $_POST["status"];
    $data["portfolio"] = $_POST["portfolio"];
    if($_POST["action"]=='Add'){
        $wpdb->insert($table_name,$data);
        if(function_exists("redirect_to_same")){
            redirect_to_same();
        }
    } else if($_POST["action"]=='Add New' || $_POST["action"]=='Edit'){
    $columns = rawurlencode('"domain","info","amount","start_date","end_date","cycle","status","portfolio"');
    ?>
    <h2>Import from CSV (excel)</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="import">
        <input type="submit" name="import_csv" value="Import (csv)" class="ui grey button">
        <a href="data:text/plain;charset=UTF-8,<?php echo $columns; ?>" download="filename.csv">Download Sample CSV</a>
    </form>
    <hr>
    <form method="POST" enctype="multipart/form-data">
        <h2 id="small_frm">Add New Here</h2>
        <input type="hidden" name="id">
        <table class="ui blue striped table collapsing">
        <tr>
            <td>Domain</td>
            <td><input type="text" name="domain">
            </td>
        </tr>
        <tr>
            <td>Info</td>
            <td><input type="text" name="info">
            </td>
        </tr>
        <tr>
            <td>Amount</td>
            <td><input type="text" name="amount">
            </td>
        </tr>
        <tr>
            <td>Start Date</td>
            <td><input type="date" name="start_date">
            </td>
        </tr>
        <tr>
            <td>End Date</td>
            <td><input type="date" name="end_date">
            </td>
        </tr>
        <tr>
        <td>Cycle</td>
        <td><select class="ui search dropdown" name="cycle">
                <option value="">Select</option>
                <option value="Monthly">Monthly</option>
                <option value="Half Yearly">Half Yearly</option>
                <option value="Yearly">Yearly</option>
            </select>
            <script type="text/javascript">
                $(".ui.dropdown").dropdown();
            </script>
        </td>
        </tr>
        <tr>
        <td>Status</td>
        <td><select class="ui search dropdown" name="status">
                <option value="">Select</option>
                <option value="Active">Active</option>
                <option value="Suspended">Suspended</option>
            </select>
            <script type="text/javascript">
                $(".ui.dropdown").dropdown();
            </script>
        </td>
        </tr>
        <tr>
        <td>Portfolio</td>
        <td><select class="ui search dropdown" name="portfolio">
                <option value="">Select</option>
                <option value="Website">Website</option>
                <option value="App">App</option>
                <option value="None">None</option>
            </select>
            <script type="text/javascript">
                $(".ui.dropdown").dropdown();
            </script>
        </td>
        </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="action" value="Add" class="ui blue mini button"></td>
            </tr>
        </table>
        </form>
        <style type="text/css">
            .ui.dropdown{
                width: 100% !important;
            }
        </style>
        <?php
    }
    if($_POST["action"]=='Edit'){
        $id = $_POST["id"];
        $row = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id",ARRAY_A);
        $data = $row;
        ?>
        <script type="text/javascript">
            $('input[name=action]').val('Save');
            $('input[name=id]').val('<?php echo $_POST["id"]; ?>');
            $('#small_frm').html('Edit Here');
        </script>
    <script type="text/javascript">
        $('input[name=domain]').val('<?php echo $data["domain"]; ?>');
        $('input[name=info]').val('<?php echo $data["info"]; ?>');
        $('input[name=amount]').val('<?php echo $data["amount"]; ?>');
        $('input[name=start_date]').val('<?php echo $data["start_date"]; ?>');
        $('input[name=end_date]').val('<?php echo $data["end_date"]; ?>');
        $('select[name=cycle]').val('<?php echo $data["cycle"]; ?>');
        x = $('select[name=cycle]').children('option[value="<?php echo $data["cycle"]; ?>"]').text();
        $("select[name=user]").parent().children(".text").html(x);
        y = $('select[name=cycle]').parent().children(".text");
        y.html(x);
        y.css("color","black");
        $('select[name=status]').val('<?php echo $data["status"]; ?>');
        x = $('select[name=status]').children('option[value="<?php echo $data["status"]; ?>"]').text();
        $("select[name=user]").parent().children(".text").html(x);
        y = $('select[name=status]').parent().children(".text");
        y.html(x);
        y.css("color","black");
        $('select[name=portfolio]').val('<?php echo $data["portfolio"]; ?>');
        x = $('select[name=portfolio]').children('option[value="<?php echo $data["portfolio"]; ?>"]').text();
        $("select[name=user]").parent().children(".text").html(x);
        y = $('select[name=portfolio]').parent().children(".text");
        y.html(x);
        y.css("color","black");
    </script>
        <?php
    }
    if($_POST["action"]=='Save'){
        $id = $_POST["id"];
        $wpdb->update($table_name,$data,array('id' => $id));
        if(function_exists("redirect_to_same")){
            redirect_to_same();
        }
    }
    if($_POST["action"]=='Delete'){
        $id = $_POST["id"];
        $wpdb->delete($table_name,array('id' => $id));
        if(function_exists("redirect_to_same")){
            redirect_to_same();
        }
    }
} 
if(($_POST["action"]!='Edit') && $_POST["action"]!='Add New') {
    ?>
    <form method="POST"><input type="submit" name="action" value="Add New" class="ui green mini button"></form><br>
    <div style="overflow-x:auto">
    <table id="myTable" class="ui unstackable celled table dataTable">
        <thead>
            <tr>
                <th>Domain</th>
                <th>Info</th>
                <th>Amount</th>
                <th>Start Date</th>
                <th id="end_date">End Date</th>
                <th>Cycle</th>
                <th>Status</th>
                <th>Portfolio</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $income = 0;
            $arr["Yearly"] = 1;
            $arr["Monthly"] = 12;
            $arr["Half Yearly"] = 6;
            $rows = $wpdb->get_results("SELECT * FROM $table_name ORDER BY end_date ASC");
            foreach($rows as $row){
                if ($row->end_date < date('Y-m-d')) {
                    $overdue = ' overdue';
                } else {
                    $overdue = '';
                    $income += $row->amount * $arr[$row->cycle];
                }
                echo '<tr class="'.$row->status.''.$overdue.'" row-id="'.$row->id.'">';
                echo '<td class="ftd">'.$row->domain.'<a href="https://whois.com/whois/'.$row->domain.'" target="_blank"><i class="ui external icon"></i></a></td>';
                echo '<td>'.$row->info.'</td>';
                echo '<td>'.$row->amount.'</td>';
                echo '<td>'.$row->start_date.'</td>';
                echo '<td>'.$row->end_date.'</td>';
                echo '<td>'.$row->cycle.'</td>';
                echo '<td>'.$row->status.'</td>';
                echo '<td>'.$row->portfolio.'</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    </div>
    <div style="font-size: 25px; line-height: 1.3">
        Annual Income: ₹<?php echo $income; ?><br>
        Monthly Income: ₹<?php echo round($income/12); ?>
    </div>
    <form method="post" id="action_form">
        <input type="hidden" name="id">
        <input type="hidden" name="action">
    </form>
    <script type="text/javascript">
        $(document).ready(function(){
            $("td:last-child").append('<i class="trash alternate red icon" onclick="delete_now(this)"></i> <i class="edit blue icon" onclick="edit_now(this)"></i>');
        });
        function edit_now(x){
            var id = $(x).parent().parent().attr("row-id");
            var frm = $("#action_form")
            frm.children("input[name=id]").val(id);
            frm.children("input[name=action]").val("Edit");
            frm.submit();
        }
        function delete_now(x){
            var id = $(x).parent().parent().attr("row-id");
            var frm = $("#action_form")
            frm.children("input[name=id]").val(id);
            frm.children("input[name=action]").val("Delete");
            if (confirm("Do you want to delete?")) {
            frm.submit();
            }
        }
    </script>
    <style type="text/css">
        .edit.icon, .trash.icon{
            float: right !important;
            font-size: 140%;
            cursor: pointer;
        }
        .overdue{ background-color: #ffe59e !important }
        .Suspended{ background-color: #ff9e9e !important }
        .ftd{
            position: relative;
        }
        .ui.icon{
            color: green;
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#myTable").DataTable( {
            dom: "Blfrtip",
            buttons: [
                "csv", "excel", "pdf", "print"
            ],
             "pageLength": 50
        } );
    } );
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#end_date').click();
        });
    </script>
    <?php
}
if(is_admin()) {
    echo '</div>';
}