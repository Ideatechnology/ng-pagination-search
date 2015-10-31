<?php 
$pagenum = @$_GET['page'];
$pagesize = @$_GET['size'];
$offset = ($pagenum - 1) * $pagesize;
//$offset = 0;
$conn = new PDO("mysql:host=localhost;dbname=angular", "root", "");
$search = @$_GET['search'];



	if ($search != "") {
    $where = "WHERE nama LIKE '%" . $search . "%'";
} else {
    $where = "";
}


$sql = "SELECT COUNT(*) AS count FROM biodata $where";
$result = $conn->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$count = $row['count'];

$query = "SELECT * FROM biodata $where ORDER BY nama LIMIT $offset, $pagesize";

$result = $conn->query($query);

while ($row =$result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = array(
        'id_biodata' => $row['id_biodata'],
        'nama' => $row['nama'],
        'jenis_kelamin' => $row['jenis_kelamin'],
        'telpon' => $row['telpon']
        );
}

$myData = array('Biodata' => $data, 'totalCount' => $count);

echo json_encode($myData);

?>
