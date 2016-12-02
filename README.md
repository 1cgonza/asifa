## Para Usuarios
Esta es una plantilla de WordPress diseñada específicamente para las necesidades de la pagina web de asifacolombia.org

Si desea instalarla, descargue todo el contenido de este repositorio haciendo clic en el botón "Clone or download" y elija la opción "Download ZIP". Este zip se puede instalar en WordPress como cualquier otra plantilla subiendo el archivo .zip desde la interfaz de administrador en su sitio.

Adicionalmente, debe instalar el plug-in [CMB2](https://srd.wordpress.org/plugins/cmb2/) para que funcione correctamente.

## Para desarrolladores

### Plug-ins de WP necesarios
- CMB2: Como se menciona en la sección **Para Usuarios**, la plantilla es dependiente de que el plug-in [CMB2](https://srd.wordpress.org/plugins/cmb2/) este instalado.

### CSS y JavaScript

#### Preparación ambiente de trabajo
Los archivos de CSS y JavaScript se procesan con una serie de módulos de node.js. Para actualizar estos archivos debe tener instalado:
- [Node](https://nodejs.org)
- gulp-cli: Una vez instalado node, puede instalar gulp-cli desde el terminal con el comando
``` shell
npm install --global gulp-cli
```

#### Actualizar archivos .css y .js
Una vez instalados node y gulp-cli, puede entrar a la carpeta de la plantilla desde el terminal y usar el comando
``` shell
gulp
```

#### CSS (SASS)
Para actualizar los estilos se debe hacer desde los archivos que están en `/dev/scss/` y gulp procesa y crea el archivo `style.min.css` que es el que finalmente se usa en la plantilla.

Todos los estilos están en una serie de archivos en formato .scss en la carpeta `/dev/scss/`.
Gulp los procesa para que los estilos tengan los *prefix* necesarios para las últimas dos versiones de todos los exploradores. Al final exporta un solo archivo comprimido que es el que usamos en la plantilla y lo copia en `/css/style.min.css`

#### JavaScript
Para actualizar el JavaScript se debe hacer desde los archivos que están en `/dev/js/` y gulp los procesa y crea el archivo `/js/scripts.min.js` que es el que finalmente se usa en la plantilla.
