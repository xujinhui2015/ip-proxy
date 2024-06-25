<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proxy_ips', function (Blueprint $table) {
            $table->id();

            $table->ipAddress();
            $table->unsignedSmallInteger('ip_port');

            $table->boolean('ip_usable')->default(true)->comment('是否可用');

            $table->string('remark')->nullable()->comment('备注');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proxy_pools', function (Blueprint $table) {
            $table->id();

            $table->string('pool_name')->comment('代理池名称');
            $table->string('request_url')->comment('请求代理地址');

            $table->boolean('ip_usable')->default(true)->comment('是否可用');
            $table->string('remark')->nullable()->comment('备注');

            $table->unsignedInteger('sort')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proxy_pool_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proxy_pool_id');
            $table->string('request_url')->comment('请求代理地址');
            $table->unsignedSmallInteger('response_code')->comment('响应状态码');
            $table->text('response_data')->comment('响应数据');

            $table->timestamp('created_at')->nullable();
        });

        Schema::create('proxy_ip_extracts', function (Blueprint $table) {
            $table->id();

            $table->unsignedTinyInteger('extract_priority')->comment('提取优先权1代理池2代理IP');
            $table->string('extract_key')->comment('提取key');
            $table->boolean('ip_usable')->default(true)->comment('是否可用');
            $table->string('remark')->nullable()->comment('备注');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proxy_ip_extract_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proxy_ip_extract_id');
            $table->foreignId('extract_relation_id')->comment('提取关联id,代理池id或代理ip的id');
            $table->unsignedTinyInteger('extract_type')->comment('提取类型1代理池2代理IP');
            $table->ipAddress()->comment('提取的ip地址');
            $table->ipAddress('from_ip_address')->nullable()->comment('来自哪个IP地址请求过来的');

            $table->timestamp('created_at')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
