# Deployment & DevOps Guide

## Production Requirements
- **Web Server**: Nginx or Apache with HTTP/2 and TLS 1.3
- **PHP**: 8.3 or 8.5 with OPcache enabled
- **Database**: MySQL 8.0+ or PostgreSQL 15+
- **Cache & Queues**: Redis 7+
- **Process Manager**: Supervisor for queue workers

## Production Configuration
```ini
; php.ini recommendations
memory_limit = 512M
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 60
opcache.enable = 1
opcache.enable_cli = 0
opcache.memory_consumption = 256
opcache.interned_strings_buffer = 16
opcache.max_accelerated_files = 20000
```

## Supervisor Configuration (`/etc/supervisor/conf.d/grandhealth-worker.conf`)
```ini
[program:grandhealth-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/grandhealth/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/grandhealth/storage/logs/worker.log
stopwaitsecs=3600
```

---
*Author: [Imran Ahmed](https://imrandev.bd) (me@imrandev.bd)*
