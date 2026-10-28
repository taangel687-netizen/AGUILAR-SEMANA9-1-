# Laboratorio 09 - Desarrollo de Aplicaciones Web (IS093A)

Tecnología web backend: arquitectura cliente-servidor, PHP y JSP.

## Estructura
- `lab09-php/` -> copiar a `xampp/htdocs/lab09/` (URL: http://localhost/lab09/)
- `lab09-jsp/` -> copiar a `tomcat/webapps/lab09/` (URL: http://localhost:8080/lab09/)

## Requisitos
- PHP 8.2+ (XAMPP/Laragon), Apache y MySQL
- JDK 17+ y Apache Tomcat 10.x (namespace `jakarta.*`)

## Pruebas rápidas (curl)
```
curl -i http://localhost/lab09/procesar.php
curl -i -X POST -d "nombre=Ana&email=ana@mail.com&edad=22&mensaje=Hola" http://localhost/lab09/procesar.php
curl -i http://localhost:8080/lab09/procesar.jsp
curl -i -X POST -d "nombre=Ana&email=ana@mail.com&edad=22&mensaje=Hola" http://localhost:8080/lab09/procesar.jsp
```

## Autor
Apellidos y nombres: ____________________
