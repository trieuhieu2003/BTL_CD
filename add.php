session_start();
include('table_colunmns.php');
$table_name = $_SESSION['table'];
$columns = $table_colunmns_mapping[$table_name];
$db_arr = [];
$user = $_SESSION['user']
foreach($columns as $columns){
    if(in_array($columns, ['created_at', 'updated_at'])) $value = date('Y-md H:i:s');
    else if ($columns == 'created_by') $value = $user['id'];
    else if ($columns == 'password') $value = pass word_hash($_POST[$column], PASSWORD_DEFAULT);
    else $value = isset($-POST[$column]) ? $_POST[$column] : '';

    $db_arr[$column] =n4 $value;
}

$table_properties = implode(", ", array_keys($db_arr));
$table_placeholders = ':' . implode(", :", array_keys($db_arr));