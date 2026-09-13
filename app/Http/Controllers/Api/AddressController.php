<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    private const API_URL = 'https://psgc.gitlab.io/api';

    public function provinces()
    {
        return $this->fetch('/provinces/');
    }

    public function cities(string $provinceId)
    {
        return $this->fetch("/provinces/{$provinceId}/cities-municipalities/");
    }

    public function barangays(string $cityId)
    {
        return $this->fetch("/cities-municipalities/{$cityId}/barangays/");
    }

    private function fetch(string $path)
    {
        try {
            $records = Http::acceptJson()
                ->timeout(10)
                ->get(self::API_URL . $path)
                ->throw()
                ->json();

            return response()->json(collect($records)
                ->map(fn (array $record) => [
                    'psgc_id' => $record['code'],
                    'name' => $record['name'],
                ])
                ->sortBy(fn (array $record) => mb_strtolower($record['name']))
                ->values());
        } catch (ConnectionException|RequestException) {
            return response()->json([
                'message' => 'Address data is temporarily unavailable.',
            ], 502);
        }
    }
}