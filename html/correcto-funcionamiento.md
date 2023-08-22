### como estaremos usando htaccess, debemos configurar nuestro entorno para su correcto funcionamiento
### ah seguir les dejo un pequeño tutorial



Si estás utilizando un contenedor Docker con Apache y deseas asegurarte de que Apache reconozca y aplique las reglas definidas en el archivo `.htaccess`, debes realizar los siguientes pasos:

1. **LEVANTAR DOCKER Y ENTRAR EN MODO CONSOLA EN EL CONTAINER HTML**
```bash
sudo docker-compose up -d

sudo docker exec -it html bash

```



1. **Habilitar el módulo `mod_rewrite`:** El módulo `mod_rewrite` es necesario para que Apache pueda procesar las reglas de reescritura definidas en el archivo `.htaccess`. Asegúrate de que el módulo `mod_rewrite` esté habilitado en tu contenedor. Puedes habilitarlo ejecutando el siguiente comando dentro del contenedor:

   ```bash
   a2enmod rewrite

   ```

   Después de habilitar el módulo, reinicia Apache para que los cambios surtan efecto.

2. **INTAL NANO Y EDITAR EL ARCHIVO apache2.config***
```bash
apt install nano

nano /etc/apache2/apache2.conf

```




3. **Modificar la configuración de Apache:** Asegúrate de que la configuración de Apache dentro del contenedor permita la lectura de archivos `.htaccess` y permita las reescrituras. Normalmente, esto se hace ajustando la configuración de los directorios en el archivo de configuración de Apache (`httpd.conf`). Aquí hay un ejemplo de cómo podría verse una sección relevante de la configuración:

   ```apache

   <Directory /var/www/html>
       Options Indexes FollowSymLinks
       AllowOverride All
       Require all granted
   </Directory>

   ```

   En este ejemplo, `AllowOverride All` permite que las reglas definidas en el archivo `.htaccess` sean aplicadas. Asegúrate de que la configuración dentro del contenedor esté ajustada de manera similar.

4. **Reiniciar Apache:** Después de realizar cambios en la configuración de Apache, asegúrate de reiniciar Apache para que los cambios surtan efecto:

   ```bash
   service apache2 restart

   ```

Una vez que hayas realizado estos ajustes, Apache debería reconocer y aplicar las reglas definidas en el archivo `.htaccess` en tu contenedor Docker. Si continúas teniendo problemas, verifica la configuración de Apache y asegúrate de que las rutas y las reglas en el archivo `.htaccess` sean correctas. Además, revisa los registros de errores de Apache para obtener información sobre posibles problemas con la configuración.





###### CREAR UN ARCHIVO LLAMADO php-error.log dentro de la carpeta html 
###### CREAR UN CARPETA config con los archivos de configuraciones