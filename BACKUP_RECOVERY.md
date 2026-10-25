# Disaster Recovery & Backup Procedures

## Recommended Backup Frequency
- **Transactional Database**: Incremental backups every 15 minutes; full backup every 24 hours.
- **Uploaded Medical Documents & Imaging**: Hourly object sync to secondary cloud storage.
- **Audit Logs (`audit_events`)**: Immutable write-once storage; exported weekly to secure cold archive.

## Backup Commands
```bash
# SQLite backup
sqlite3 database/database.sqlite ".backup 'backups/backup-$(date +%F_%T).sqlite'"

# MySQL / MariaDB backup
mysqldump -u grandhealth -p grandhealth_db | gzip > backups/grandhealth_$(date +%F).sql.gz

# PostgreSQL backup
pg_dump -U grandhealth -d grandhealth_db -F c -b -v -f backups/grandhealth_$(date +%F).dump
```

## Restoration Verification
Always test database restoration in an isolated staging environment before committing changes to production infrastructure.

---
*Author: [Imran Ahmed](https://imrandev.bd) (me@imrandev.bd)*
