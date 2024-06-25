<?php

namespace App\Models\Proxy;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @property int|null $id
 * @property int|null $proxy_pool_id
 * @property string|null $request_url 请求代理地址
 * @property int|null $response_code 响应状态码
 * @property string|null $response_data 响应数据
 * @property Carbon $created_at
 *
 * @method static Builder|ProxyPoolLog query()
 */
class ProxyPoolLog extends BaseModel
{
    const UPDATED_AT = null;

    protected $fillable = [
        'proxy_pool_id',
        'request_url',
        'response_code',
        'response_data',
    ];

}
