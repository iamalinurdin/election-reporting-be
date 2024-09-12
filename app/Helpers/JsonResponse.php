<?php

namespace App\Helpers;

class JsonResponse
{
    public static $accept = 'application/json';

    public static function success(?int $code = 200, ?string $message = 'ok', $data = [], ?array $meta = null)
    {
        if (!$meta) {
            return response()->json([
              'message' => $message,
              'data'    => $data,
              'status'  => $code,
            ], $code)->withHeaders([
              'Accept' => JsonResponse::$accept,
            ]);
        }

        return response()->json([
          'message' => $message,
          'data'    => $data,
          'status'  => $code,
          'meta'    => $meta,
        ], $code)->withHeaders([
          'Accept' => JsonResponse::$accept,
        ]);
    }

    public static function error(?int $code = 500, ?string $message = 'error')
    {
        return response()->json([
          'status'  => $code,
          'message' => $message,
        ], $code)->withHeaders([
          'Accept' => JsonResponse::$accept,
        ]);
    }

    public static function meta($total, $page, $limit)
    {
        $totalPage = (int) ceil($total / $limit);

        return [
          'total'      => (int) $total,
          'current'    => (int) $page,
          'total_page' => (int) $totalPage,
        ];
    }
}
