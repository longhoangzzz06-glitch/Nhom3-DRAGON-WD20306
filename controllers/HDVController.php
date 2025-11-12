<?php
// có class chứa các function thực thi xử lý logic 
class HDVController
{
    public $modelHDV;

    public function __construct()
    {
        $this->modelHDV = new HDVModel();
    }

}
