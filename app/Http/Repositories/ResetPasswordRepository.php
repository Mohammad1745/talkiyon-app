<?php


namespace App\Http\Repositories;


use App\Models\ResetPassword;

class ResetPasswordRepository extends Repository
{
    /**
     * ResetPasswordRepository constructor.
     */
    public function __construct ()
    {
        parent::__construct( new ResetPassword());
    }
}
