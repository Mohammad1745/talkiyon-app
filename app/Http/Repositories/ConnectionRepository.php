<?php


namespace App\Http\Repositories;


use App\Models\Connection;

class ConnectionRepository extends Repository
{
    /**
     * ConnectionRepository constructor.
     */
    public function __construct ()
    {
        parent::__construct( new Connection());
    }
}
