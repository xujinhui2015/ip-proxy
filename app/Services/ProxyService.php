<?php

namespace App\Services;

use App\Enums\Proxy\ProxyExtractPriorityEnum;
use App\Models\Proxy\ProxyIp;
use App\Models\Proxy\ProxyIpExtract;
use App\Models\Proxy\ProxyPool;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProxyService
{

    public function extract(ProxyIpExtract $extract): ?string
    {
        if (ProxyExtractPriorityEnum::Pool->isEq($extract->extract_priority)) {
            // 代理池优先
            $extractPoolResult = $this->extractFromPool();
            if ($extractPoolResult) {
                return $this->getPool($extract, $extractPoolResult);
            } else {
                $proxyIp = $this->extractFromIp();
                if (!$proxyIp) {
                    return null;
                }
                return $this->getIp($extract, $proxyIp);
            }
        } elseif (ProxyExtractPriorityEnum::Ip->isEq($extract->extract_priority)) {
            // 代理ip优先
            $proxyIp = $this->extractFromIp();
            if ($proxyIp) {
                return $this->getIp($extract, $proxyIp);
            } else {
                $extractPoolResult = $this->extractFromPool();
                if (!$extractPoolResult) {
                    return null;
                }
                return $this->getPool($extract, $extractPoolResult);
            }
        } else {
            return null;
        }
    }

    /**
     * 从代理池提取ip
     */
    public function extractFromPool(): ?array
    {
        $proxyPool = ProxyPool::query()
            ->where('ip_usable', true)
            ->first();

        if (!$proxyPool) {
            return null;
        }

        // 发起请求
        $response = Http::get($proxyPool->request_url);

        // 记录请求日志
        $proxyPool->log()->create([
            'request_url' => $proxyPool->request_url,
            'response_code' => $response->status(),
            'response_data' => $response->body(),
        ]);

        if ($response->status() != 200) {
            // 状态码异常
            return $this->setPoolInvalid($proxyPool);
        }

        $proxyIp = trim(filter_var($response->body()));

        if (!$this->isValidIpAddressWithPort($proxyIp)) {
            // 返回错误，不是有效的IP地址
            return $this->setPoolInvalid($proxyPool);
        }

        return [$proxyPool, $proxyIp];
    }

    /**
     * 从代理ip里面提取ip
     */
    public function extractFromIp(): ?ProxyIp
    {
        $proxyIp = ProxyIp::query()
            ->where('ip_usable', true)
            ->inRandomOrder()
            ->first();

        if (!$proxyIp) {
            return null;
        }

        // 检查代理ip是否可用
        try {
            $response = Http::withOptions([
                'proxy' => "http://$proxyIp->ip_address:$proxyIp->ip_port",
                'connect_timeout' => 3, // 设置连接超时时间，单位秒
                'timeout' => 5, // 设置请求超时时间，单位秒
            ])->get('https://api.m.jd.com/'); // 替换成你要验证的目标网站
        } catch (RequestException|ConnectionException $e) {
            // 请求异常处理,IP失效
            $this->setIpInvalid($proxyIp);

            Log::error("从代理ip里面提取ip异常", [
                $proxyIp->id,
                $proxyIp->ip_address,
                $proxyIp->ip_port,
                $e->getCode(),
                $e->getMessage(),
            ]);

            // 重新找另一个有效IP
            $proxyIp = $this->extractFromIp();

            if (!$proxyIp) {
                return null;
            }
        }

        if (isset($response) && $response->status() != 200) {
            // 重新找另一个有效IP
            $proxyIp = $this->extractFromIp();

            if (!$proxyIp) {
                return null;
            }
        }

        return $proxyIp;
    }

    private function getPool(ProxyIpExtract $extract, array $extractPoolResult): string
    {
        /** @var $proxyPool ProxyPool */
        list($proxyPool, $ipAddress) = $extractPoolResult;
        $extract->log()->create([
            'extract_relation_id' => $proxyPool->id,
            'extract_type' => ProxyExtractPriorityEnum::Pool,
            'ip_address' => $ipAddress,
            'from_ip_address' => request()->ip()
        ]);
        return $ipAddress;
    }

    private function getIp(ProxyIpExtract $extract, ProxyIp $proxyIp): ?string
    {
        $ipAddress = $proxyIp->ip_address . ':' . $proxyIp->ip_port;
        $extract->log()->create([
            'extract_relation_id' => $proxyIp->id,
            'extract_type' => ProxyExtractPriorityEnum::Ip,
            'ip_address' => $ipAddress,
            'from_ip_address' => request()->ip()
        ]);
        return $ipAddress;
    }

    private function setPoolInvalid(ProxyPool $proxyPool): null
    {
        $proxyPool->update([
            'ip_usable' => false,
        ]);
        return null;
    }

    private function setIpInvalid(ProxyIp $proxyIp): void
    {
        $proxyIp->update([
            'ip_usable' => false,
        ]);
    }

    /**
     * 判断代理地址是否有效
     * @param $ip
     * @return bool
     */
    private function isValidIpAddressWithPort($ip): bool
    {
        // 使用 parse_url 函数解析 IP 地址和端口号
        $parsed = parse_url($ip);

        // 检查是否解析成功，并且 host 部分是有效的 IP 地址
        if ($parsed && isset($parsed['host']) && filter_var($parsed['host'], FILTER_VALIDATE_IP)) {
            return true;
        }

        return false;
    }
}
