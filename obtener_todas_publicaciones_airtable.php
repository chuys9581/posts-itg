<?php
/**
 * Plugin Name: feed-instagram-posts
 * Description: Muestra las Publicaciones de Airtable
 * Version: 1.7
 * Author: Jesus Jimenez
 */

function obtener_todas_publicaciones_airtable() {
    $api_key = 'aqui va la api key de quien use esta repo by Jesus Jimenez';
    $url_posts = 'https://api.airtable.com/v0/appzmB3zBmwWkhnkn/Posts';
    $url_usuarios = 'https://api.airtable.com/v0/appzmB3zBmwWkhnkn/Usuarios';

    // Obtener usuarios desde Airtable
    $response_usuarios = wp_remote_get($url_usuarios, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key
        )
    ));

    if (is_wp_error($response_usuarios)) {
        return 'Error obteniendo los datos de los usuarios desde Airtable.';
    }

    $body_usuarios = wp_remote_retrieve_body($response_usuarios);
    $data_usuarios = json_decode($body_usuarios, true);

    // Crear un array de usuarios usando el email como clave
    $usuarios = array();
    if (!empty($data_usuarios['records'])) {
        foreach ($data_usuarios['records'] as $usuario) {
            $email_usuario = !empty($usuario['fields']['email']) ? sanitize_email($usuario['fields']['email']) : '';
            $nombre = !empty($usuario['fields']['Nombre']) ? esc_html($usuario['fields']['Nombre']) : 'Usuario desconocido';
            $avatar = !empty($usuario['fields']['Avatar']) ? esc_url($usuario['fields']['Avatar']) : '';

            if ($email_usuario) {
                $usuarios[$email_usuario] = array(
                    'nombre' => $nombre,
                    'avatar' => $avatar
                );
            }
        }
    }

    // Obtener publicaciones desde Airtable
    $response_posts = wp_remote_get($url_posts, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key
        )
    ));

    if (is_wp_error($response_posts)) {
        return 'Error obteniendo los datos de las publicaciones desde Airtable.';
    }

    $body_posts = wp_remote_retrieve_body($response_posts);
    $data_posts = json_decode($body_posts, true);

    if (empty($data_posts['records'])) {
        return 'No se encontraron publicaciones en Airtable.';
    }

    // Ordenar publicaciones por fecha (de más recientes a más viejas)
    usort($data_posts['records'], function($a, $b) {
        $date_a = strtotime($a['createdTime']);
        $date_b = strtotime($b['createdTime']);
        return $date_b - $date_a;
    });

    $publicaciones_html = '<h3 class="text-all-posts">PUBLICACIONES</h3><div class="all-user-posts">';

    foreach ($data_posts['records'] as $record) {
        $imagen_video_url = !empty($record['fields']['Imagen/Video']) ? esc_url($record['fields']['Imagen/Video']) : '';
        $contenido = !empty($record['fields']['Contenido']) ? esc_html($record['fields']['Contenido']) : '';
        $email_usuario_post = !empty($record['fields']['Email de Usuario']) ? sanitize_email($record['fields']['Email de Usuario']) : '';
        $post_id = esc_attr($record['id']);
        $created_time = !empty($record['createdTime']) ? esc_html($record['createdTime']) : '';

        if ($imagen_video_url) {
            // Buscar el usuario por email
            $nombre_usuario = isset($usuarios[$email_usuario_post]) ? $usuarios[$email_usuario_post]['nombre'] : 'Usuario desconocido';
            $avatar_usuario = isset($usuarios[$email_usuario_post]) ? $usuarios[$email_usuario_post]['avatar'] : '';

            $publicaciones_html .= '<div class="all-user-post">';
            $publicaciones_html .= '<div class="post-content">';
            $publicaciones_html .= '<div class="user-info">';
            $publicaciones_html .= '<div class="user-avatar-container"><img src="' . $avatar_usuario . '" alt="Avatar de Usuario" class="user-avatar2" /></div>';
            $publicaciones_html .= '<div class="user-name-container"><span class="user-name">' . $nombre_usuario . '</span></div>';
            $publicaciones_html .= '</div>';
            $publicaciones_html .= '<div class="user-post2">';
            $publicaciones_html .= '<img src="' . $imagen_video_url . '" alt="Publicación" class="all-user-post-image2" data-post-id="' . $post_id . '" />';
            $publicaciones_html .= '</div>';
            $publicaciones_html .= '<p class="contenido-posts2">' . $contenido . '</p>';
            $publicaciones_html .= '</div>'; // Cierre del contenedor adicional
            $publicaciones_html .= '</div>';
        }
    }

    $publicaciones_html .= '</div>';

    // Modal HTML
    $publicaciones_html .= '
    <div id="postlike-modal" class="postlike-modal">
        <div class="postlike-modal-content">
            <span class="postlike-close">&times;</span>
            <div class="postlike-modal-body">
                <img id="postlike-modal-image" src="" alt="Imagen del Post" />
                <div id="postlike-modal-text"></div>
            </div>
        </div>
    </div>';

    return $publicaciones_html;
}

add_shortcode('mostrar_todas_publicaciones', 'obtener_todas_publicaciones_airtable');

function cargar_estilos_modal_plugin_todas() {
    wp_enqueue_style('custom-plugin-all-posts-style', plugins_url('css/custom-plugin-all-posts-style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'cargar_estilos_modal_plugin_todas');
