<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\TalkResponseClapRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Auth;

class TalkResponseClapService extends Service
{

    /**
     * TalkResponseClapService constructor.
     * @param TalkResponseClapRepository $repository
     */
    public function __construct (TalkResponseClapRepository $repository)
    {
        parent::__construct( $repository);
    }

    /**
     * @param array $request
     * @return array
     */
    public function talkResponseClapDataFormatter (array $request): array
    {
        if ($request){
            return [
                'response_id' => decrypt($request['response_id']),
                'user_id' => Auth::id()
            ];
        }
        return [];
    }
}
