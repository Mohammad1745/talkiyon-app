<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\ConnectionRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Auth;

class ConnectionService extends Service
{
    /**
     * TimelineService constructor.
     * @param ConnectionRepository $repository
     */
    public function __construct (ConnectionRepository $repository)
    {
        parent::__construct( $repository);
    }

    /**
     * @param int $userId
     * @param array $request
     * @return array
     */
    public function connectionDataFormatter (int $userId, array $request): array
    {
        if ($request){
            return [
                'user_id' => $userId,
                'connected_with' => $request['connected_with'],
                'type' => $request['type'],
            ];
        }
        return [];
    }
}
