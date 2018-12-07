<?php
/**
 * Created by PhpStorm.
 * User: poste1
 * Date: 27/11/2018
 * Time: 18:52
 */

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB ;

class Session_prv
{

    public $var_1 ;
    public $var_2 ;
    public $var_3 ;
    public $var_4 ;

    /**
     * session_prv constructor.
     * @param $var_1
     * @param $var_2
     * @param $var_3
     * @param $var_4
     */
    public function __construct()
    {

    }




    /**
     * @return mixed
     */
    public function getVar1()
    {
        return $this->var_1;
    }

    /**
     * @param mixed $var_1
     */
    public function setVar1($var_1)
    {
        $this->var_1 = $var_1;
    }

    /**
     * @return mixed
     */
    public function getVar2()
    {
        return $this->var_2;
    }

    /**
     * @param mixed $var_2
     */
    public function setVar2($var_2)
    {
        $this->var_2 = $var_2;
    }

    /**
     * @return mixed
     */
    public function getVar3()
    {
        return $this->var_3;
    }

    /**
     * @param mixed $var_3
     */
    public function setVar3($var_3)
    {
        $this->var_3 = $var_3;
    }

    /**
     * @return mixed
     */
    public function getVar4()
    {
        return $this->var_4;
    }

    /**
     * @param mixed $var_4
     */
    public function setVar4($var_4)
    {
        $this->var_4 = $var_4;
    }


}