<?php

class CalificationController {

    private $calificationModel;
    
    public function __construct(mysqli $conn) {
        $this -> calificationModel = new calification( $conn );
    }

    public function rate () {
        $data = $_POST;

        $calification = $this -> calificationModel -> getAll('*', '', 'WHERE `calificator_user_id` = '. $data['calificator_user_id'] ." AND `calification_object_type` = '" . $data['calification_object_type'] . "' AND calificated_object_id = " . $data['calificated_object_id']);

        $result = count($calification) > 0 ? $result = $this -> calificationModel -> updateById($calification[0]['calification_id'], $data) : $result = $this -> calificationModel -> insert($data);

        echo json_encode($result);

    }
}