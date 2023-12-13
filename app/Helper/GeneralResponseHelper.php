<?php


function makeResponse($result, $message, $code = 200, $data = null, $token = null): \Illuminate\Http\JsonResponse
{
    if ($token) {
        return response()->json([
            'result' => $result,
            'message' => $message,
            'data' => $data,
            'token' => $token
        ], $code);
    } else {
        return response()->json([
            'result' => $result,
            'message' => $message,
            'data' => $data
        ], $code);
    }

}

function makeWebResponse($result, $message, $url = null, $html = null): array
{
    return [
        'result' => $result,
        'message' => $message,
        'html' => $html,
        'url' => $url
    ];
}

function paginateResponse($data): array
{
    $finalArray = [
        'last_page' => $data->lastPage(),
        'current_page' => $data->currentPage(),
        'total_matching_record' => $data->total(),
        'item_per_page' => $data->perPage()
    ];

    return $finalArray;

}




