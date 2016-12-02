<?php
include 'DB.php';
$db = new DB();
$tblName = 'os';
if(isset($_REQUEST['type']) && !empty($_REQUEST['type'])){
    $type = $_REQUEST['type'];
    switch($type){
        case "view":
            $records = $db->getRows($tblName);
            if($records){
                $data['records'] = $db->getRows($tblName);
                $data['status'] = 'OK';
            }else{
                $data['records'] = array();
                $data['status'] = 'ERR';
            }
            echo json_encode($data);
            break;
        case "add":
            if(!empty($_POST['data'])){
                $userData = array(
                    'executor' => $_POST['data']['executor'],
                    'dia' => $_POST['data']['dia'],
                    'status' => $_POST['data']['status']
                );
                $insert = $db->insert($tblName,$userData);
                if($insert){
                    $data['data'] = $insert;
                    $data['status'] = 'OK';
                    $data['msg'] = 'User data has been added successfully.';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Algo deu errado, tente novamente';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = 'Algo deu errado, tente novamente';
            }
            echo json_encode($data);
            break;
        case "edit":
            if(!empty($_POST['data'])){
                $userData = array(
                    'executor' => $_POST['data']['executor'],
                    'dia' => $_POST['data']['dia'],
                    'status' => $_POST['data']['status']
                );
                $condition = array('id' => $_POST['data']['id']);
                $update = $db->update($tblName,$userData,$condition);
                if($update){
                    $data['status'] = 'OK';
                    $data['msg'] = 'User data has been updated successfully.';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Algo deu errado, tente novamente';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = 'Algo deu errado, tente novamente';
            }
            echo json_encode($data);
            break;
        case "delete":
            if(!empty($_POST['id'])){
                $condition = array('id' => $_POST['id']);
                $delete = $db->delete($tblName,$condition);
                if($delete){
                    $data['status'] = 'OK';
                    $data['msg'] = 'Apagado com sucesso.';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Algo deu errado, tente novamente';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = 'Algo deu errado, tente novamente';
            }
            echo json_encode($data);
            break;
        default:
            echo '{"status":"INVALID"}';
    }
}
