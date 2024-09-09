# feed-instagram-posts

Este plugin muestra todas las publicaciones almacenadas en Airtable y las ordena de más recientes a menos recientes. Hace peticiones a la API de Airtable para obtener los datos necesarios y mostrarlos en tu sitio de WordPress.

## Características

- **Obtiene Publicaciones y Usuarios desde Airtable**: Conecta con la API de Airtable para recuperar publicaciones y detalles de usuarios.
- **Ordenación de Publicaciones**: Muestra las publicaciones ordenadas de más recientes a menos recientes.
- **Visualización de Publicaciones**: Muestra imágenes o videos con el contenido de las publicaciones.
- **Modales para Visualización Detallada**: Permite la visualización detallada de las publicaciones en un modal.

## Instalación

1. **Sube el Plugin**: Sube el archivo del plugin al directorio `wp-content/plugins/`.
2. **Activa el Plugin**: Ve a la sección de Plugins en tu panel de administración de WordPress y activa el plugin `feed-instagram-posts`.

## Uso

- **Shortcode**: Utiliza el siguiente shortcode para mostrar todas las publicaciones en cualquier página o entrada de WordPress:

    ```[mostrar_todas_publicaciones]```

## Configuración

- **API Key**: Asegúrate de reemplazar `api_key` en el archivo del plugin con tu clave de API de Airtable.
- **URLs de Airtable**: Asegúrate de que las URLs para las tablas de `Posts` y `Usuarios` en el archivo del plugin coincidan con tus URLs de Airtable.

## Desarrollo

### Archivos Principales

- **`feed-instagram-posts.php`**: Archivo principal del plugin.
- **`css/custom-plugin-all-posts-style.css`**: Estilos CSS para el modal y la visualización de publicaciones.

### Funcionalidades

- **Obtención de Datos**: El plugin realiza solicitudes a la API de Airtable para obtener datos de publicaciones y usuarios.
- **Visualización**: Ordena las publicaciones por fecha y genera HTML para mostrar en el sitio web.
- **Modales**: Utiliza un modal para mostrar detalles de las publicaciones.

### Cambios

- **Versión 1.7**: Ajustes en la visualización de publicaciones y modales.

## Soporte

Para soporte adicional, abre un [ticket en el repositorio del plugin](#) o contacta con el autor a través de [chuy.dev.f@gmail.com](mailto:chuy.dev.f@gmail.com).

## Licencia

Este plugin está licenciado bajo la [Licencia GPL v2](https://www.gnu.org/licenses/gpl-2.0.html).

---

**Autor**: Jesus Jimenez  
**Descripción**: Plugin para mostrar publicaciones desde Airtable en WordPress.