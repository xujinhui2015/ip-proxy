<?php

namespace App\Models\Proxy;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @property int|null $id
 * @property int|null $proxy_ip_extract_id
 * @property int|null $extract_relation_id 提取关联id,代理池id或代理ip的id
 * @property int|null $extract_type 提取类型1代理池2代理IP
 * @property string|null $ip_address 提取的ip地址
 * @property Carbon $created_at
 *
 * @method static Builder|ProxyIpExtractLog query()
 */
class ProxyIpExtractLog extends BaseModel
{
    const UPDATED_AT = null;

    protected $fillable = [
        'proxy_ip_extract_id',
        'extract_relation_id',
        'extract_type',
        'ip_address',
        'from_ip_address',
    ];

}
