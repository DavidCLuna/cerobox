# Backend Cerobox Entrevista
[Link del Proyecto](https://cerobox.vercel.app/)

## Pasos para instalación y correr el proyecto en local:
- Instalar dependencias:
```bash
composer update
```
- Ejecutar migraciones con seeders, para crear el usuario de prueba (Para ejecutar este comando, debe haber previamente creado la base de datos con el nombre "cerobox", y tener configurado el archivo .env en la raíz del proyecto, puede tomar de ejemplo el archivo llamado .env.example):
```bash
php artisan migrate --seed
```
- Opcionalmente puede correr las pruebas unitarias, con el comando:
```bash
php artisan test
```
- Finalmente para correr el proyecto, debe ejecutar el comando:
```bash
php artisan serve
```