
<h1>Bienvenido al Proyecto MoviePass</h1>
<p>Aplicación Web modelo MVC con PHP y SQL que simula venta de entradas de peliculas y administración de cines.</p>
<hr>

<h2 id="bienvenidos-al-proyecto-moviepass">Bienvenidos al Proyecto MoviePass</h2>

<p>MoviePass es un proyecto estudiantil en marco de la carrera de Tecnicatura Universitaria en Programación de la <a href="http://mdp.utn.edu.ar">Universidad Tecnológica Nacional de Mar del Plata</a> mantenido por  Juan Manuel Burgués Schaab <a href="http://github.com/jmburgues">jmburgues</a>, Jazmin Briasco <a href="http://github.com/JazminBriasco">JazminBriasco</a>, Lautaro Barreto <a href="http://github.com/LautaroBG">LautaroBG</a> y Rodrigo Montenegro <a href="http://github.com/rodrigomontenegro">rodrigomontenegro</a>.</p>

<p align="center">
<img align="center" src="https://camo.githubusercontent.com/891463343506da0a7ab648ef5ef66bbf513f8ff5f88f3826f9604090595e4408/68747470733a2f2f6c68332e676f6f676c6575736572636f6e74656e742e636f6d2f666966652f414253526c49706273563441615551376a554244325755344a587473434f546338594141784d747162374c3138756b4f3372713449536a4c5f69686c416d78416555766b326d4f6162444b77356662384e435953614c314c7a7868307333746d77784c5872387a6637586b747435706433354251777975534b6131617435744c335453586238616d784b646e495670584a6452515743416261585233514d4e7555624a6a78774569636337445843306f78585a34556164305f44655a4c764e334c6a7a726f3255705465644d6177725249537664704565413277796e78455951306871546c4e6b394d31752d304c436d79683932393638784377674f7276317765316163554e48735647765f576f6d6a7842477331526c5f484a7151786c47576f49777566493779586c4e4d4642426f456465417a556b65392d765137556e6f4843427958776f5a516d426d794e372d4f4643502d686d46326a6253493741633077766d6a6b30556d6d4f506b4a7044306e4576326b6a6f4b396f686551634e37304d66595f4a756648785f59466e4c42504670384633417a4e4149306675564f6a5a4d6f4e7552474341305745774b3545514c7a51474154386d66586a4d4d3252774c6951354d3065325855576a335f55585142526e6b4c6d4138544236456159535f666a775a517565596343452d4e4c422d4d6942384c723250644774634b5356464148554b2d416b4c306f34574a464a386f346277734a7a514c79706d46444258334a526d312d775152377a546230633664445771442d376d5456324f4e5974387757306767397569614f4134456751743750667171526e6572386e566e337871454e6a5877796a702d5f4f6f5768507a52566f63344248474944394c6269704855307a4b4b55614c4a5a5a6d44754a6d4b557a7134756c6a5630304a734861656646732d4a316e63456667775f797778556a765232496b5376374463394646714e5569486937644b48526a45347a6b325f505061736f7845446b4b59525346563255513d77313336362d683235312d6674" />
</p>

<h3 id="deployment-del-sitio---ver-en-githubcom---descargar-repositorio"><a href="http://themoviepass.herokuapp.com">Deployment del Sitio</a> - <a href="https://github.com/jmburgues/TP-MoviePass">Ver en GitHub.com</a> - <a href="https://github.com/jmburgues/TP-MoviePass/archive/main.zip">Descargar Repositorio</a></h3>

<h3 id="acerca-de">Acerca de:</h3>

<p>Hecho bajo diseño Modelo Vista Controlador, escrito en PHP y con persistencia de datos en MySQL, The MoviePass permite a los administradores de salas de cine publicar funciones en cartelera y vender entradas al público en general. Utiliza un servidor SMTP fines de enviar emails a sus usarios y codifica las entradas adquiridas en códigos QR.</p>

<h3 id="roles-de-usuario">Roles de Usuario:</h3>

<p>El sitio implementa cuatro tipo de roles de usuario: Visitante (Guest), usuario registrado, administrador y dueño del producto. <strong>**Utilicelos para probar el sistema**</strong></p>

<table>
  <thead>
    <tr>
      <th>ROL</th>
      <th>USUARIO</th>
      <th>CONTRASEÑA</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>Usuario</strong></td>
      <td>user</td>
      <td><strong>1234</strong></td>
    </tr>
    <tr>
      <td><strong>Admin</strong></td>
      <td>admin</td>
      <td><strong>1234</strong></td>
    </tr>
    <tr>
      <td><strong>Dueño</strong></td>
      <td>owner</td>
      <td><strong>1234</strong></td>
    </tr>
  </tbody>
</table>

<h3 id="modelo-conceptual">Modelo Conceptual</h3>

<p align="center">
<img align="center" src="https://i.ibb.co/8rKRS9d/Modelo-Conceptual-Movie-Pass.png" />
</p>

<h3 id="persistencia-de-datos-con-mysql">Persistencia de datos con MySQL</h3>

<p>MoviePass utiliza el sistema de base de datos relacional MySQL hosteado en <a href="http://clever-cloud.com">Clever-Cloud</a> para la persistencia de datos. La información interna de usuarios, transacciones realizadas, cinemas o funciones creadas entre otras se almacena en las tablas creadas a tal fin, las cuales se mapearan a objetos para ser utilizadas por el sistema.</p>

<p align="center">
<img align="center" src="https://i.ibb.co/QJ1Fr9P/DER-DB.png" />
</p>

<h3 id="conexión-con-api-externa">Conexión con API externa</h3>

<p>La aplicación se conecta con la API <a href="http://themoviedb.org">TheMovieDB</a> peticionando texto en formato json, el cual es procesado y utilizado para mostrar las películas que luego el administrador podrá proyectar.</p>

<p align="center">  
<img align="center" width="300" height="100" src="https://www.themoviedb.org/assets/2/v4/logos/v2/blue_short-8e7b30f73a4020692ccca9c88bafe5dcb6f8a62a4c6bc55cd9ba82bb2cd95f6c.svg" />
</p>

<p>Vea el deployment del sitio en <a href="http://themoviepass.herokuapp.com">HerokuApp</a></p>



      </section>

    </div>

    
  </body>
</html>
