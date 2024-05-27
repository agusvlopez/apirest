# API REST con PHP


**API RESTFUL** realizada en PHP con conexión a MySQL.
    
Se utilizó durante el desarrollo: Orientación a Objetos junto con el patrón de arquitectura MVC.



***

### Propósito de la API:

Realizar gestión de productos (CRUD) registrar, leer, actualizar y eliminar registros en la base de datos MySQL, realizar filtros de búsqueda para los productos y login.

### Utilización:

Instale RAPID API Client o Postman o cualquier otra herramienta que permita realizar consultas a la API.

**PARA UTILIZAR LA API DE MANERA LOCAL**
Defina la conexión de la base de datos a través del archivo ".env" que se encuentra en el directorio raíz del proyecto:

Cree una base de datos llamada "c0370409_agus" e importe el archivo "c0370409_agus.sql" que también se encuentra en el directorio raíz.

# Custom Settings #
APP_URL = http://localhost/apirest/public

# (JWT) JSON WEB TOKEN #
JWT_SECRET_KEY = MY_SECRET_KEY_JWT

# MySQL DATABASE #
DB_DRIVE = mysql
DB_HOST = localhost
DB_PORT = 3306
DB_NAME = c0370409_agus
DB_USER = root
DB_PASS =


**DE MANERA REMOTA**

Utilice RAPID API o Postman o cualquier otra herramienta que permita realizar consultas a la API utilizando [https://desarrollodesitios0.site/agustinachallenge/public/] como URI.

**El LOGIN y AUTHORIZATION no esta disponible de esta manera**

***

### 📖 Dependencias utilizadas:

**PARA UTILIZAR LA API DE MANERA LOCAL**

Ejecute el comando ``composer install`` para instalar todas las dependencias utilizadas en este proyecto.

| Nombre | Versión |
| --- | --- |
| **[vlucas/phpdotenv](https://packagist.org/packages/vlucas/phpdotenv)** | ^5.6 |
| **[coffeecode/router](https://packagist.org/packages/coffeecode/router)**| ^2.0 |
| **[firebase/php-jwt](https://github.com/firebase/php-jwt)**| ^6.10.0 |

### 📖 Authorization Bearer:

Para consumir la API, no es necesario siempre enviar un **Authorization Bearer** en el encabezado de la solicitud. Pero si lo es para realizar un POST, PUT o DELETE de un producto. 
Para poder obtener este Token es necesario iniciar sesión. Más abajo se mostrará un ejemplo de como utilizar la API donde se verá mas detallado el paso a paso.

| Header Name | Header Value |
| --- | --- |
| Authorization | Bearer `TOKEN` |


***

### Endpoints:

https://desarrollodesitios0.site/agustinachallenge/public/ `endpoint` o
http://localhost/apirest/public/ `endpoint`

| Endpoint | Acesso | Método       | Descripción |
| ---      | ---    | ---        | --- |
| `/products`  | - | **GET**    | _Obtiene una lista de todos los productos registrados_ |
| `/products/{id}`  | - | **GET**    | _Obtiene el detalle de un producto específico según su ID_ |
| `/brands`  | - | **GET**    | _Obtiene una lista de todas las marcas registradas con sus respectivos nombres y ID_ |
| `/products/brand/{brand_id}`  | - | **GET**    | _Obtiene una lista de los productos registrados según el ID de la marca registrada_ |
| `/products/pack_size/{pack_size}`  | - | **GET**    | _Obtiene una lista de los productos registrados según el tamaño del paquete, mas especificamente, la cantidad de cigarrillos que contiene (en general son 10 o 20)_ |
| `/products/max_price/{max_price}`  | - | **GET**    | _Obtiene una lista de los productos registrados según el precio máximo indicado (siempre números enteros)_ |
| `/account`  | - | **POST**    | _Crea un nuevo usuario_ |
| `/session`  | - | **POST**    | _Inicia sesión, esto me proporcionará como respuesta el token que debo agregar al header para realizar POST, PUT o DELETE de los productos_ |
| `/products`  | Authorization | **POST**    | _Crea un nuevo producto_ |
| `/products/{id}`  | Authorization | **PUT**    | _Actualiza la información del producto según su ID_ |
| `/products/{id}`  | Authorization | **DELETE**    | _Elimina un producto en específico según su ID_ |

****

## Ejemplo de uso de la API:

Utilizando RAPID API como herramienta de consultas a la API.

**1. LOGIN**
Para hacer el login y así, obtener el **Token** para enviar un **Authorization Bearer** en el encabezado de la solicitud, debemos realizar un POST a [https://localhost/apirest/public/session] indicando en el **Body** los datos del usuario. Indicamos lo siguiente:

    {
        "name": "Agus",
        "pass": "123"
    }

![Example for token request](https://i.postimg.cc/MKs6Fcmx/2024-04-03.png "Example for token request").

**2. AUTHORIZATION**

Una vez obtenido el Token, lo ubicamos en el Header de esta forma: 

| Header Name | Header Value |
| --- | --- |
| Authorization | Bearer `TOKEN` |


![Example for Authorization Bearer](https://i.postimg.cc/v8XTJ8rY/headers.png "Example for Authorization Bearer").

**3. POST DE UN PRODUCTO**

Primero hacemos una consulta GET [https://desarrollodesitios0.site/agustinachallenge/public/brands] o GET [https://localhost/apirest/public/brands] para ver las marcas disponibles y asi obtener el ID de la marca indicada.

![Example for GET brands](https://i.postimg.cc/QMc3TXSR/get-brands.png "Example for GET brands").

En este caso queremos subir un nuevo producto de la marca Parliament, que como vemos, su **ID** es **2**.

Ahora si, realizamos un POST [https://desarrollodesitios0.site/agustinachallenge/public/products] o POST [https://localhost/apirest/public/products] para crear un nuevo producto.

Indicamos lo siguiente en el Body: 

    {
        "brand_id": 2,
        "variant": "Gold",
        "price": 5,
        "pack_size": 20
    }

![Example for POST product](https://i.postimg.cc/LsCCrfst/post-product.png "Example for POST product").

Esto me devuelve el ID generado del producto.

**4.GET DEL PRODUCTO GENERADO**

Como sabemos el ID, podemos buscarlo realizando un GET [https://desarrollodesitios0.site/agustinachallenge/public/products/{id}] o GET [https://localhost/apirest/public/products/{id}] 

Indicamos lo siguiente: 

   GET [https://desarrollodesitios0.site/agustinachallenge/public/products/17] o
   GET [https://localhost/apirest/public/products/17]

![Example for GET product by ID](https://i.postimg.cc/zGZTGkvz/get-product-by-id.png "Example for GET product by ID").

Como vemos, al buscarlo nos trae todos los datos, incluido el nombre de la marca del producto.

**5. PUT DEL PRODUCTO GENERADO**

Ahora vamos a modificar el campo **pack_size** del producto generado. Para eso, realizamos un PUT [https://desarrollodesitios0.site/agustinachallenge/public/products/{id}] o PUT [https://localhost/apirest/public/products/{id}] 

Indicamos lo siguiente: 

    PUT [https://desarrollodesitios0.site/agustinachallenge/public/products/17] o
    PUT [https://localhost/apirest/public/products/17]

En el **Body** indicamos todos los campos necesarios modificando el campo o los campos que queremos actualizar, en este caso actualizamos el campo pack_size a 10: 

    {
        "brand_id": 2,
        "variant": "Gold",
        "price": 5,
        "pack_size": 10
    }
    
![Example for PUT product by ID](https://i.postimg.cc/bYB3hMt4/product-update.png "Example for PUT product by ID").

**5. DELETE DEL PRODUCTO GENERADO**

Para eliminar el producto es necesario indicar el id como parametro. De esta forma, realizamos un DELETE [https://desarrollodesitios0.site/agustinachallenge/public/products/{id}] o DELETE [https://localhost/apirest/public/products/{id}]

Indicamos lo siguiente: 

    DELETE [https://desarrollodesitios0.site/agustinachallenge/public/products/17] o
    DELETE [https://localhost/apirest/public/products/17]

![Example for DELETE product by ID](https://i.postimg.cc/s232Lc91/product-deleted.png "Example for DELETE product by ID").
    
**5. GET DE TODOS LOS PRODUCTOS**   

Por último, acudimos a: GET [https://desarrollodesitios0.site/agustinachallenge/public/products] o GET [https://localhost/apirest/public/products] y verificamos que el producto eliminado efectivamente ya no se encuentre.

![Example for GET products](https://i.postimg.cc/0QsDNDsw/get-products.png "Example for GET products").

**6. BUSCAR PRODUCTOS FILTRADOS POR UN PRECIO MÁXIMO**

Para realizar esta consulta (siempre con números enteros): GET [https://desarrollodesitios0.site/agustinachallenge/public/products/max_price/{max_price}] o GET [https://localhost/apirest/public/products/max_price/{max_price}]

En este caso, buscaremos todos los productos cuyo precio máximo sea de US$4. Indicamos lo siguiente: 

    GET [https://desarrollodesitios0.site/agustinachallenge/public/products/max_price/4] o
    GET [https://localhost/apirest/public/products/max_price/4]

![Example for GET products by max price](https://i.postimg.cc/TYwNVLyb/products-by-max-price.png "Example for GET products by max price").

**7. BUSCAR PRODUCTOS FILTRADOS POR MARCA**
Para realizar esta consulta: GET [https://desarrollodesitios0.site/agustinachallenge/public/products/brand/{brand_id}] o GET [https://localhost/apirest/public/products/brand/{brand_id}]

En este caso, buscaremos todos los productos cuyo ID de la marca es 4. Indicamos lo siguiente: 

    GET [https://desarrollodesitios0.site/agustinachallenge/public/products/brand/4] o
    GET [https://localhost/apirest/public/products/brand/4]

![Example for GET products by brand](https://i.postimg.cc/qMQF3fp1/products-by-brand.png "Example for GET products by brand").

**7. BUSCAR PRODUCTOS FILTRADOS POR TAMAÑO DE PAQUETE**
Para realizar esta consulta: GET [https://desarrollodesitios0.site/agustinachallenge/public/products/pack_size/{pack_size}] o GET [https://localhost/apirest/public/products/pack_size/{pack_size}]

En este caso, buscaremos todos los productos cuyo tamaño de paquete (su contenido), que en general son de 10 o 20. Indicamos lo siguiente: 

    GET [https://desarrollodesitios0.site/agustinachallenge/public/products/pack_size/10] o
    GET [https://localhost/apirest/public/products/pack_size/10]

![Example for GET products by pack size](https://i.postimg.cc/Y08w0hX3/get-product-by-pack-size.png "Example for GET products by pack size").

## Características y tecnologías:

* PHP >= 7.4 
* Modelo REST
* POO
* MVC
* JSON
* JWT
* Composer
* PSR-4
* PDO
* MySQL
* Bearer Authorization
* Métodos GET, PUT, POST e DELETE