<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mandiri_Controller extends CI_Controller {
    public function __construct(){
        parent::__construct();
    }

    public function get_sidebar(){
        $sidebars = array(
            array(
                'id' => 1,
                'name' => 'Card',
                'url' => base_url().'card'
            ),
            array(
                'id' => 2,
                'name' => 'Cashback',
                'url' => base_url().'cashback'
            ),
            array(
                'id' => 3,
                'name' => 'Transaction',
                'url' => base_url().'transaction'
            ),
        );

        return $sidebars;
    }
}