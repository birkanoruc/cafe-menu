<?php

namespace App\Services;

use App\Contracts\Services\LogInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class LogService implements LogInterface
{
    /**
     * Request verilerini loglar.
     * @param \Illuminate\Http\Request $request
     */
    public function logRequest(Request $request): void
    {
        try {
            $logData = $this->prepareRequestData($request);
            Log::info('Request:', $logData);
        } catch (Throwable $e) {
            Log::error('Request loglama sırasında hata: ' . $e->getMessage());
        }
    }

    /**
     * Response verilerini loglar.
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    public function logResponse($response): void
    {
        $logData = $this->prepareResponseData($response);
        Log::info('Response:', $logData);
    }

    /**
     * Request verilerini hazırlar.
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function prepareRequestData(Request $request): array
    {
        $data = $request->all();
        $headers = $request->headers->all();
        unset($headers['authorization']); // Authorization header'ını gizle

        if (isset($data['password'])) {
            $data['password'] = '[MASKED]';
        }

        if (isset($data['email'])) {
            $data['email'] = '[MASKED]';
        }

        return [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'headers' => $headers,
            'body' => json_encode($data),
        ];
    }

    /**
     * Response verilerini hazırlar.
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @return array
     */
    protected function prepareResponseData($response): array
    {
        $content = json_decode($response->getContent(), true);

        if (isset($content)) {
            $content = '[MASKED]';
        }

        return [
            'status' => $response->getStatusCode(),
            'headers' => $response->headers->all(),
            'body' => json_encode($content),
        ];
    }

    /**
     * Exception ile yakalanarak döndürülen cevapların detaylarını loglar.
     * @param Throwable $exception
     */
    public function logException(Throwable $exception): void
    {
        $logData = [
            'exception_class' => get_class($exception),
            'message' => $exception->getMessage(),
        ];
        Log::info('İstisna Yakalandı:', $logData);
    }
}
