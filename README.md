# IP代理平台

## 配置指南

```bash
# 安装包管理
composer update --no-dev
# 创建软连接
php artisan storage:link
# 创建配置文件并配置好数据库以及APP_URL
cp .\.env.example .env
# 生成APP_KEY
php artisan key:generate
# 执行迁移
php artisan migrate
# 生成超级管理员账号
php artisan make:filament-user
```
