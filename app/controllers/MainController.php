<?php
class MainController extends Controller {
    function __construct(){
    }

    public function index($get_data){
        $this->view('index');
    }
}
