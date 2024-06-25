<?php

namespace App\Models\Proxy;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int|null $id
 * @property int|null $extract_priority 提取优先权1代理池2代理IP
 * @property string|null $extract_key 提取key
 * @property int|null $ip_usable 是否可用
 * @property string $remark 备注
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Builder|ProxyIpExtract query()
 */
class ProxyIpExtract extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'extract_priority',
        'extract_key',
        'ip_usable',
        'remark',
    ];

    public function log(): HasMany
    {
        return $this->hasMany(ProxyIpExtractLog::class);
    }

}
