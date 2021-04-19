<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\TalkClapRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Auth;

class TalkClapService extends Service
{

    /**
     * TalkClapService constructor.
     * @param TalkClapRepository $repository
     */
    public function __construct (TalkClapRepository $repository)
    {
        parent::__construct( $repository);
    }

    /**
     * @param array $request
     * @return array
     */
    public function talkClapDataFormatter (array $request): array
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
