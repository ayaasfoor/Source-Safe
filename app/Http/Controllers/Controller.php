<?php

namespace App\Http\Controllers;

use App\Http\Middleware\LogRoute;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     *  middleware auth to all route
     */
    public function __construct()
    {
        $this->middleware(LogRoute::class);
        $this->middleware('auth:sanctum')->except('login', 'register');
    }


    /**
     * {@inheritdoc}
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}