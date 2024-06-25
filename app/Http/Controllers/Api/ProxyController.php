<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proxy\ProxyExtract;
use App\Services\ProxyService;

class ProxyController extends Controller
{
    /**
     * 获取代理IP
     */
    public function index(string $key, ProxyService $proxyService): string
    {
        $extract = ProxyExtract::query()
            ->where('is_usable', true)
            ->where('extract_key', $key)
            ->first();

        if (!$extract) {
            return '未知提取';
        }

        $ipAddress = $proxyService->extract($extract);

        if (!$ipAddress) {
            return '无可用代理';
        }

        return $ipAddress;
    }
}
