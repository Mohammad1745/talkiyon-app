<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\TalkResponseRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Auth;

class TalkResponseService extends Service
{

    /**
     * TalkResponseService constructor.
     * @param TalkResponseRepository $repository
     */
    public function __construct (TalkResponseRepository $repository)
    {
        parent::__construct( $repository);
    }

    /**
     * @param array $request
     * @return array
     */
    public function talkResponseDataFormatter (array $request): array
    {
        if ($request){
            return [
                'talk_id' => decrypt($request['talk_id']),
                'user_id' => Auth::id(),
                'parent_id' => isset($request['parent_id']) ? decrypt($request['parent_id']) : null,
                'content' => $request['content']
            ];
        }
        return [];
    }
}
