# Prestashop Module

## Inicio de Instalación
* Instalar docker y docker compose

* Dirigirse al directorio que contiene el proyecto donde se encuentra el archivo docker-compose.yml
* ejecutar):
> [!NOTE]
> Puedes cambiar contraseña, entorno, u otras variables del archivo a voluntad.
```bash
docker compose up -d
```
* Una vez hayamos levantado los contenedores, validaremos accediendo a:
[localhost](http://localhost:8080)

* Continuaremos los pasos de la instalación, siguiendo la guía que proporciona la interfaz, no hace falta introducir ningún dato a parte de los evidentes como email, nombre de la tienda, password...
* En cuanto a la configuración de la base de datos:
  * Indica en __dirección del servidor__ **db** (así se le llama en el docker-compose.yml, sé consecuente si lo cambias).
  * Nombre de base de datos, usuario y contraseña indicado en el docker-compose.yml

* Para poder entrar a la consola de administrador de la tienda, prestashop requiere ciertos requisitos, como eliminar la carpeta /install generada. Como estamos trabajando en un contenedor, deberemos eliminarla desde su interior:
  * Borraremos la carpeta del interior del contenedor **(si has llamado a tu contenedor de otra forma, cambia el comando)** :
```bash
docker exec -it prestashop-app rm -rf /var/www/html/install
```
* Una vez borrada la carpeta podremos entrar al administrador de prestashop utilizando las credenciales indicadas durante la instalación.
 
> [!WARNING]
> En el gitignore se incluye la carpeta prestashop que genera el contenedor, no modifiques el gitignore, o al menos esta carpeta a no ser que quieras modificar en si misma la instancia de prestashop en vez del módulo que se trabaja.

### Si tenemos ya una tienda online activa con prestashop:
