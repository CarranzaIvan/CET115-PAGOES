#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/home/azureuser/CET115-PAGOES/backups"
FILENAME="pagomovil_es_backup_$DATE.sql"

# Crear directorio de backups si no existe
mkdir -p $BACKUP_DIR

# Ejecutar backup
cd /home/azureuser/CET115-PAGOES && docker-compose exec db mysqldump -u pagomoviles_user -padmin123 pagomovil_es > $BACKUP_DIR/$FILENAME

echo "Backup realizado: $BACKUP_DIR/$FILENAME"

