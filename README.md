# TP-MoviePass
Trabajo Práctico Final para las materias Metodologia de la Investigación y Laboratorio IV (UTN MdP)

Trabajo práctico integrador
Metodología de Sistemas I y Laboratorio IV, año 2020
Técnico Superior en Programación
Sistema de venta de entradas para películas (MoviePass)

1) Requisitos funcionales:

Una empresa que se dedica a organizar y vender entradas de cine nos solicita el desarrollo de un
software que les permita a sus clientes comprar la entrada para una película en un determinado cine
a través de un sitio web.
Los clientes se deben registrar con su email y una clave. También debe existir la posibilidad de
registrarse vía su cuenta de Facebook.

El cliente (C) podrá realizar las siguientes actividades:
  a) Consultar películas por fecha y/o categoría.
  b) Seleccionar una película para su compra. A continuación se visualizarán los cines donde se
proyecta con sus horarios (solo aquellos que tengan aún entradas disponibles). Una vez
seleccionado horario y cine se deben detallar la cantidad de entradas a comprar, visualizando el total
de la compra.
La compra sólo podrá realizarse con tarjeta de crédito, mediante un proceso que solicitará la
autorización del pago a la corresp. Cia de crédito (Visa ó Master)
Al recibir la autorización del pago, el sistema genera las entradas, enviando una copia al email.
Cada entrada tendrá un número y un código QR que permitirá ingresar al cine (entrada individual).
Existe una política de descuento en el sitio que consiste en cobrar 25% menos el valor de las
entradas los días martes y miércoles, debiendo al menos comprar 2 entradas.
  c) Consultar las entradas adquiridas, ordenadas por película ó por fecha.

El administrador (A) podrá realizar las siguientes actividades:
  a) Ingresar películas a la cartelera del cine con sus días y horarios de proyección.
  b) Administrar cines. Cada registro debe tener el nombre del cine, su capacidad total, dirección y
valor único de entrada.
  c) Consultar cantidades vendidas y remanentes de las proyecciones (Película, Cine, Turno)
  d) Consultar totales vendidos en pesos (por película ó por cine, entre fechas)

2) Requisitos no funcionales:

Programación en capas de la aplicación respetando la arquitectura de 3 capas lógicas vista durante
la cursada. Esto implica el desarrollo de las clases que representen las entidades del modelo y
controladoras de los casos de uso, las vistas y la capa de acceso a datos.
El acceso a las películas y categorías (temas) de las mismas será efectuado a través del uso de una
API pública del sitio TheMovieDb (​ www.themoviedb.org​ ), donde el alumno deberá crearse una
cuenta y asi obtener la Api Key necesaria para acceder a los recursos detallados en
https://developers.themoviedb.org/3​ . De alli usaremos los GET:
- movie/now_playing : retorna la lista de películas actuales
- genre/movie/list : retorna la lista de géneros (temas)3) ​ Implementación mínima para la aprobación:


1 Revisión

  1.1 - Administrar Cines (A- Item b, con dao en memoria)
  1.2 - Consulta de películas actuales (C- Item a - get de la api)

2 Revisión
  
  2.1 - Ingresar películas a la cartelera del cine junto con los días y horarios de exhibición (A - item a)
  2.2 – Agregar a 1.2 los filtros por categoría (temas) y fechas
 
3 Revisión
  
  3.1 - Seleccionar y comprar entradas para una proyección de película determinada (C – item b, sin
pago ni descuentos)
