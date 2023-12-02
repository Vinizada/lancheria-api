<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class ModelController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public abstract function create(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public abstract function validateRequest(Request $request);

    /**
     * @return mixed
     */
    public abstract function listar();

    /**
     * @param $id
     * @return mixed
     */
    public abstract function buscar($id);
}
