<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
include_once 'config/dao.php';
$dao = new Dao();
/* ================================================== */
$proc = $_POST['proc'];
$usrid = $_POST['usrid'];
if ($proc == "usrdel") {
    $query = "DELETE FROM users WHERE id=$usrid";
}elseif ($proc == "usrin" && $usrid == 0) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $telp = $_POST['telp'];
    $baned = $_POST['baned'];
    $akses = $_POST['akses'];
    $aks = 0;
    for ($index = 0; $index < count($akses); $index++) {
        $aks = $aks + $_POST['akses'][$index];
    }
    //end for
    $query = "INSERT INTO users (username,password,fullname,email,telp,baned,akses) "
            . "VALUE ('$username',PASSWORD('$password'),"
            . "'$fullname','$email','$telp','$baned',$aks)";    
}elseif ($proc == "usredt" && $usrid > 0) {
    $query = "SELECT id,username,fullname,email,telp,baned,akses FROM users WHERE id=".$usrid;
    $result = $dao->execute($query);
    $list = mysqli_fetch_array($result);
    echo json_encode($list);
    exit();
}elseif ($proc == "usrin" && $usrid > 0) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $telp = $_POST['telp'];
    $query = "UPDATE users SET username='$username',fullname='$fullname',email='$email',telp='$telp' WHERE id=".$usrid;    
}

$in = $dao->execute($query);

if (!$in) {
    $msg[0] = "0";
    $msg[1] = $in;
} else {
    $result = $dao->read();
    $i = 1;
    $userlist = "";
    $msg[0] = "1";
    foreach ($result as $value) {
        $userlist .= "<tr>
                <td>" . $i . "</td>
                <td>" . $value['id'] . "</td>
                <td>" . $value['username'] . "</td>
                <td>" . $value['fullname'] . "</td>
                <td>" . $value['email'] . "</td>
                <td>" . $value['telp'] . "</td>
                <td>" . $value['baned'] . "</td>
                <td>" . $value['logintime'] . "</td>
                <td>" . $value['akses'] . "</td>
                <td nowrap>
                    <button type=\"button\" class=\"btn btn-primary btn-sm\">
                        <i class=\"fa fa-list\"></i> Detail
                    </button>
                    <button type=\"button\" onclick=\"showModalEdt(".$value['id'].");\" class=\"btn btn-success btn-sm\">
                        <i class=\"fa fa-edit\"></i> Edit
                    </button>
                    <button type=\"button\" onclick=\"showModalDel(".$value['id'].",'".$value['fullname']."');\" class=\"btn btn-danger btn-sm\">
                        <i class=\"fa fa-trash\"></i> Del 
                    </button>
                </td>
            </tr>";
        $i++;
    }
    $msg[1] = $userlist;
}
/* ================================================== */
echo json_encode($msg);
