<?php
function getTrailersDate($mysqlDateTime) {
	$months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$t = strtotime($mysqlDateTime);
	return date("d" , $t) . " de " . $months[((int)date('m' , $t))-1] . " de " . date("Y",$t);
}

add_action('init', 'registrar_trailers_dcinehd');

function registrar_trailers_dcinehd() {


	$labels = array(
		'name' => _x('Trailers', 'post type general name'),
		'singular_name' => _x('Trailer', 'post type singular name'),
		'add_new' => _x('Añadir nuevo', 'portfolio item'),
		'add_new_item' => __('Añadir nuevo Trailer'),
		'edit_item' => __('Editar Trailer'),
		'new_item' => __('Nuevo Trailer'),
		'view_item' => __('Ver Trailer'),
		'search_items' => __('Buscar Trailers'),
		'not_found' =>  __('Nada ncontrado'),
		'not_found_in_trash' => __('Nada encontrado en la papelera'),
		'parent_item_colon' => ''
	);


	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		//'menu_icon' => get_stylesheet_directory_uri() . 'trailers/imagenes/prueba.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail', 'comments', 'trackbacks')
	  ); 


	register_post_type( 'trailers' , $args );
}


register_taxonomy("Genero", array("trailers"), array("hierarchical" => true, "label" => "Generos", "singular_label" => "Genero", "rewrite" => true));
register_taxonomy("ano_produccion", array("trailers"), array("hierarchical" => true, "label" => "Años", "singular_label" => "Año", "rewrite" => true));
register_taxonomy("directores_peliculas", array("trailers"), array("hierarchical" => true, "label" => "Directores", "singular_label" => "Director", "rewrite" => true));
register_taxonomy("interpretes_peliculas", array("trailers"), array("hierarchical" => true, "label" => "Intérpretes", "singular_label" => "Intérprete", "rewrite" => true));
register_taxonomy("edad_recomendada", array("trailers"), array("hierarchical" => true, "label" => "Edades recomendadas", "Edad recomendada" => "Intérprete", "rewrite" => true));
add_action("admin_init", "admin_init");



function admin_init(){

	
	add_meta_box("trailers_meta", "Información Trailer", "trailers_meta", "trailers", "normal", "low");
}


function trailers_meta() {


  global $post;


  $custom = get_post_custom($post->ID);
  $pagina_oficial = $custom["pagina_oficial"][0];
  $sinopsis = $custom["sinopsis"][0];
  $imagen_fondo = $custom["imagen_fondo"][0];
  $juego_colores = $custom["juego_colores"][0];
  $comprar_dvd = $custom["comprar_dvd"][0];
  $comprar_bluray = $custom["comprar_bluray"][0];
  $TrailerCustomData=get_post_custom($post->ID);
	//var_dump($TrailerCustomData);
   ?>


   <script type="text/javascript">
        jQuery(document).ready(function() {
        jQuery('#textareaID').addClass('mceEditor');
        if ( typeof( tinyMCE ) == 'object' && typeof( tinyMCE.execCommand ) == 'function' ) {
        tinyMCE.execCommand('mceAddControl', false, 'textareaID');
        }
        
        });
        </script>
        <style>
                /*Allows us to add a border to the tinymce area in this field. Just looks better */
                #textareaID_ifr {
                        border:1px solid #DFDFDF; background-color:#FFF;
                        }
        </style>



<p>
  <label>Página oficial:</label>
  <br />
  <textarea cols="30" rows="1" name="pagina_oficial"><?php echo $pagina_oficial; ?></textarea>
</p>


<p>
  <label>Sinopsis:</label>
  <textarea class="textareaID" id="textareaID" style="width: 100%;" rows="20" name="sinopsis"><?php echo $sinopsis; ?></textarea>
</p>
    <script type="text/javascript">
		jQuery(document).ready(function() {

jQuery('#upload_image_button').click(function() {
 formfield = jQuery('#upload_image').attr('name');
 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 return false;
});

window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 jQuery('#upload_image').val(imgurl);
 tb_remove();
}

});
    </script> 

<p>
  <label>Imagen de fondo:</label>
  <br />
	<input id="upload_image" type="text" size="36" name="imagen_fondo" value="<?php echo $imagen_fondo; ?>" />
	<input id="upload_image_button" type="button" value="Subir imagen" />
</p>


<p>
  <label>Juego de colores: </label>
  <SELECT name="juego_colores">
    <OPTION VALUE="ninguno" <?php if ($TrailerCustomData['juego_colores'][0]=="ninguno") echo "selected"; ?>>Seleccionar un juego de colores</OPTION>
    <OPTION VALUE="negro.css" <?php if ($TrailerCustomData['juego_colores'][0]=="negro.css") echo "selected"; ?>>Negro</OPTION>
    <OPTION VALUE="rojo.css" <?php if ($TrailerCustomData['juego_colores'][0]=="rojo.css") echo "selected"; ?>>Rojo</OPTION>
    <OPTION VALUE="verde.css" <?php if ($TrailerCustomData['juego_colores'][0]=="verde.css") echo "selected"; ?>>Verde</OPTION>
    <OPTION VALUE="amarillo.css" <?php if ($TrailerCustomData['juego_colores'][0]=="amarillo.css") echo "selected"; ?>>Amarillo</OPTION>
    <OPTION VALUE="blanco.css" <?php if ($TrailerCustomData['juego_colores'][0]=="blanco.css") echo "selected"; ?>>Blanco</OPTION>
    <OPTION VALUE="azul-claro.css" <?php if ($TrailerCustomData['juego_colores'][0]=="azul-claro.css") echo "selected"; ?>>Azul Claro</OPTION>
  </SELECT>
</p>


<p>
	<label>Enlace a DVD:</label>
	<br />
	<textarea cols="100" rows="1" name="comprar_dvd"><?php echo $comprar_dvd; ?></textarea>
	<br />
	<label>Enlace a Bluray:</label>
	<br />
	<textarea cols="100" rows="1" name="comprar_bluray"><?php echo $comprar_bluray; ?></textarea>
</p>
<?php }


add_action('save_post', 'save_details');


function save_details($post_id){


global $post;


if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
return $post_id;


if (isset($_POST["pagina_oficial"]) && $_POST["pagina_oficial"] <> '') update_post_meta($post->ID, "pagina_oficial", $_POST["pagina_oficial"]);
if (isset($_POST["sinopsis"]) && $_POST["sinopsis"] <> '') update_post_meta($post->ID, "sinopsis", $_POST["sinopsis"]);
if (isset($_POST["imagen_fondo"]) && $_POST["imagen_fondo"] <> '') update_post_meta($post->ID, "imagen_fondo", $_POST["imagen_fondo"]);
if (isset($_POST["juego_colores"]) && $_POST["juego_colores"] <> '') update_post_meta($post->ID, "juego_colores", $_POST["juego_colores"]);
if (isset($_POST["comprar_dvd"]) && $_POST["comprar_dvd"] <> '') update_post_meta($post->ID, "comprar_dvd", $_POST["comprar_dvd"]);
if (isset($_POST["comprar_bluray"]) && $_POST["comprar_bluray"] <> '') update_post_meta($post->ID, "comprar_bluray", $_POST["comprar_bluray"]);


}


add_action("manage_posts_custom_column",  "trailers_columnas_personalizadas");
add_filter("manage_edit-trailers_columns", "trailers_editar_columnas");


function trailers_editar_columnas($columns){


  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Título trailer",
    "sinopsis" => "Sinopsis",
    "ano_produccion" => "Año producción",
    "edad_recomendada" => "Edad recomendada",
    "genero" => "Genero",
  );


  return $columns;
}


function trailers_columnas_personalizadas($column){


  global $post;
  switch ($column) {
    
    case "sinopsis":
      $custom = get_post_custom();
      echo $custom["sinopsis"][0];
      break;
    
    case "ano_produccion":
    echo get_the_term_list($post->ID, 'ano_produccion', '', ', ','');
      break;


	  case "edad_recomendada":
      echo get_the_term_list($post->ID, 'edad_recomendada', '', ', ','');
      // echo $custom["edad_recomendada"][0];
      break;


    case "genero":
      echo get_the_term_list($post->ID, 'Genero', '', ', ','');
      break;
  }
 }
