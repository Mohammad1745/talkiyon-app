<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\TalkResponseBooRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Auth;

class TalkResponseBooService extends Service
{

    /**
     * TalkResponseBooService constructor.
     * @param TalkResponseBooRepository $repository
     */
    public function __construct (TalkResponseBooRepository $repository)
    {
        parent::__construct( $repository);
    }

    /**
     * @param array $request
     * @return array
     */
    public function talkResponseBooDataFormatter (array $request): array
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
