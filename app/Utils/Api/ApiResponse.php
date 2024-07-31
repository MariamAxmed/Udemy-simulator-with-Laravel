<?php

namespace App\Utils\Api;

trait ApiResponse
{
    private function response($message, $data = null, $code = 200, $meta = null)
    {
        return response([
            'message' => $message,
            'data' => $data,
            'meta' => $meta
        ], $code);
    }

    public function withDataResponse($data = null, $meta = null)
    {
        return $this->response(
            'Ugurla getirildi',
            $data,
            200,
            $meta
        );
    }

    public function createdResponse($data = null)
    {
        return $this->response(
            'Ugurla yaradildi',
            $data,
            201,
        );
    }

    public function updatedResponse()
    {
        return $this->response(
            'Ugurla yenilendi',
            null,
            200,
        );
    }

    public function deletedResponse()
    {
        return $this->response(
            'Ugurla silindi',
            null,
        );
    }
}
