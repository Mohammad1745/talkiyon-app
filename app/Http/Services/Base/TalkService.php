<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\TalkRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Auth;

class TalkService extends Service
{
    /**
     * TimeLineService constructor.
     * @param TalkRepository $repository
     */
    public function __construct (TalkRepository $repository)
    {
        parent::__construct( $repository);
    }

    /**
     * @param $request
     * @return array
     */
    public function talkDataFormatter (array $request): array
    {
        if ($request){
            return [
                'user_id' => Auth::id(),
                'content' => $request['content'],
                'parent_id' => isset($request['parent_id']) ? $request['parent_id'] : null,
                'type' => $request['type'],
                'security_type' => $request['security_type']
            ];
        }
        return [];
    }
}
