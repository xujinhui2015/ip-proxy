<?php

namespace App\Http\Controllers\Api;

use App\Enums\Proxy\ProxyExtractPriorityEnum;
use App\Http\Controllers\Controller;
use App\Models\Proxy\ProxyIpExtract;
use App\Models\Proxy\ProxyPool;
use App\Services\ProxyService;
use GuzzleHttp\Client;

class ProxyController extends Controller
{
    /**
     * 获取代理IP
     */
    public function index(string $key, ProxyService $proxyService): string
    {
        $extract = ProxyIpExtract::query()
            ->where('ip_usable', true)
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
