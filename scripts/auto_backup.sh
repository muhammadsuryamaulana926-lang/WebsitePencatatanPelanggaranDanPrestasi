#!/bin/bash

# Auto Backup Script untuk Sistem Kesiswaan
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backup/database"
PROJECT_DIR="/Users/labsa.smkbn666.pk08/Documents/WebsideKesiswaanSurya"
STORAGE_BACKUP_DIR="$PROJECT_DIR/storage/app/backups"

# Baca konfigurasi database dari .env
DB_NAME=$(grep DB_DATABASE $PROJECT_DIR/.env | cut -d '=' -f2)
DB_USER=$(grep DB_USERNAME $PROJECT_DIR/.env | cut -d '=' -f2)
DB_PASS=$(grep DB_PASSWORD $PROJECT_DIR/.env | cut -d '=' -f2)
DB_HOST=$(grep DB_HOST $PROJECT_DIR/.env | cut -d '=' -f2)

# Buat direktori backup jika belum ada
mkdir -p $BACKUP_DIR
mkdir -p $STORAGE_BACKUP_DIR

# MySQL Backup
mysqldump -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME > $STORAGE_BACKUP_DIR/backup_$DATE.sql

# Compress
gzip $STORAGE_BACKUP_DIR/backup_$DATE.sql

# Clean old backups (keep 30 days)
find $STORAGE_BACKUP_DIR -name "*.gz" -mtime +30 -delete

echo "Backup completed: backup_$DATE.sql.gz"