<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\TalkBooRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Auth;

class TalkBooService extends Service
{

    /**
     * TalkBooService constructor.
     * @param TalkBooRepository $repository
     */
    public function __construct (TalkBooRepository $repository)
    {
        parent::__construct( $repository);
    }

    /**
     * @param array $request
     * @return array
     */
    public function talkBooDataFormatter (array $request): array
    {
        if ($request){
            return [
                'talk_id' => decrypt($request['talk_id']),
                'user_id' => Auth::id()
            ];
        }
        return [];
    }
}
