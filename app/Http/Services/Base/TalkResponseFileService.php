<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\TalkResponseFileRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Auth;

class TalkResponseFileService extends Service
{

    /**
     * TalkResponseFileService constructor.
     * @param TalkResponseFileRepository $repository
     */
    public function __construct (TalkResponseFileRepository $repository)
    {
        parent::__construct( $repository);
    }

    /**
     * @param int $responseId
     * @param array $request
     * @return array
     */
    public function talkResponseFileDataFormatter (int $responseId, array $request): array
    {
        if ($request){
            return [
                'response_id' => $responseId,
                'file' => $request['file']
            ];
        }
        return [];
    }
}
