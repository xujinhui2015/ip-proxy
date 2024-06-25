<?php

namespace App\Models\Proxy;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int|null $id
 * @property string|null $pool_name 代理池名称
 * @property string|null $request_url 请求代理地址
 * @property int|null $ip_usable 是否可用
 * @property string $remark 备注
 * @property int $sort
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection|ProxyPoolLog[] $log
 *
 * @method static Builder|ProxyPool query()
 */
class ProxyPool extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'pool_name',
        'request_url',
        'ip_usable',
        'remark',
        'sort',
    ];

    public function log(): HasMany
    {
        return $this->hasMany(ProxyPoolLog::class);
    }
}
