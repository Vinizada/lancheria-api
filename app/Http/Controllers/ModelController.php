<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class ModelController extends Controller
{
    /**
     * @return mixed
     */
    public abstract function index(Request $request);

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
    public abstract function listar(Request $request);

    /**
     * @param $id
     * @return mixed
     */
    public abstract function buscar($id);

    /**
     * @param $id
     * @return mixed
     */
    public abstract function deletar($id);

    /**
     * @param Request $request
     * @return mixed
     */
    public abstract function editar(Request $request);
}
