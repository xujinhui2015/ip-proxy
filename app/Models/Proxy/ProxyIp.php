<?php

namespace App\Models\Proxy;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int|null $id
 * @property string|null $ip_address
 * @property int|null $ip_port
 * @property int|null $ip_usable 是否可用
 * @property string $remark 备注
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Builder|ProxyIp query()
 */
class ProxyIp extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'ip_address',
        'ip_port',
        'ip_usable',
        'remark',
    ];
}
