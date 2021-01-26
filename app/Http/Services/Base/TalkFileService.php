<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\TalkFileRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Auth;

class TalkFileService extends Service
{

    /**
     * TalkFileService constructor.
     * @param TalkFileRepository $repository
     */
    public function __construct (TalkFileRepository $repository)
    {
        parent::__construct( $repository);
    }

    /**
     * @param $request
     * @return array
     */
    public function talkFileDataFormatter (array $request): array
    {
        if ($request){
            return [
                'talk_id' => Auth::id(),
                'file' => $request['file']
            ];
        }
        return [];
    }
}
