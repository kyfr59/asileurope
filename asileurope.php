<?php
/*
Plugin Name: Asileurope
Description: Gère la partie fonctionnelle du projet AsilEurope
Version:     0.1
Author:      Franck Dupont <kyfr59@gmail.com>
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

/* Ajout des types de champs personalisés ainsi que des taxonomies */
function asileurope_custom_post_type()
{
  
  // Création de la taxonomie "mots clés"
  $args['labels'] = array('name'                        => 'Mots clés',
                          'menu_name'                   => 'Gérer les mots clés',
                          'separate_items_with_commas'  => "Communs aux notices lexico, icono et carto.<br />Séparez les mots clés par une virgule.<br />5 mots clés maximum.",
                          );
  register_taxonomy('taxonomie_asileurope', array(), $args);

  // Création de la taxonomie "mots clés base de données"
  $args['labels'] = array('name'                        => 'Mots clés base de données',
                          'menu_name'                   => 'Gérer les mots clés de la base de données',
                          'separate_items_with_commas'  => "Séparez les mots clés par une virgule.<br />5 mots clés maximum.",
                          );
  register_taxonomy('taxonomie_base_asileurope', array(), $args);


  // Création de la taxonomie "thématiques des notices carto" (catégories)
  $args = array(
    'hierarchical'      => true,
    'labels'            => array(),
    'show_ui'           => true,
    'show_in_menu'      => true,
    'show_admin_column' => true,
    'rewrite'           => array( 'slug' => 'thematiques' ),
    'labels'            => array('name' => 'Thématiques',
                                  'add_new_item' => 'Ajouter une nouvelle thématique'
                                  ),
  );
  register_taxonomy( 'thematiques_carto', array( 'thematiques' ), $args );


  // Création du type de contenu "asileurope_lexico"    
  register_post_type('asileurope_lexico',
                     [
                         'labels'      => [
                             'name'          => __('Notices lexicographiques'),
                             'singular_name' => __('Notice lexicographique'),
                             'add_new_item'  => __('Ajouter une notice lexicographique'),
                         ],
                        'public'             => true,
                        'publicly_queryable' => true,
                        'show_ui'            => true,
                        'show_in_menu'       => true,
                        'show_in_nav_menus'  => true,
                        'query_var'          => true,
                        'rewrite'            => array( 'slug' => 'notices-lexicographiques'),
                        'capability_type'    => 'post',
                        'has_archive'        => true,
                        'hierarchical'       => false,
                        'menu_position'      => null,
                        'supports'           => array('title', 'genre_pluriel'),
                       ]
    );

  // Création du type de contenu "asileurope_icono"    
  register_post_type('asileurope_icono',
                     [
                         'labels'      => [
                             'name'          => __('Notices iconographiques'),
                             'singular_name' => __('Notice iconographique'),
                             'add_new_item'  => __('Ajouter une notice iconographique'),
                         ],
                        'public'             => true,
                        'publicly_queryable' => true,
                        'show_ui'            => true,
                        'show_in_menu'       => true,
                        'show_in_nav_menus'  => true,
                        'query_var'          => true,
                        'rewrite'            => array( 'slug' => 'notices-iconographiques'),
                        'capability_type'    => 'post',
                        'has_archive'        => true,
                        'hierarchical'       => false,
                        'menu_position'      => null,
                        'supports'           => array('title', 'genre_pluriel'),
                       ]
  );

  // Création du type de contenu "asileurope_icono"    
  register_post_type('asileurope_carto',
                     [
                         'labels'      => [
                             'name'          => __('Notices cartographiques'),
                             'singular_name' => __('Notice cartographique'),
                             'add_new_item'  => __('Ajouter une notice cartographique'),
                         ],
                        'public'             => true,
                        'publicly_queryable' => true,
                        'show_ui'            => true,
                        'show_in_menu'       => true,
                        'show_in_nav_menus'  => true,
                        'query_var'          => true,
                        'rewrite'            => array( 'slug' => 'notices-cartographiques'),
                        'capability_type'    => 'post',
                        'has_archive'        => true,
                        'hierarchical'       => false,
                        'menu_position'      => null,
                        'supports'           => array('title', 'genre_pluriel'),
                        'taxonomies'          => array( 'thematiques_carto' ),
                       ]
  );

  // Création du type de contenu "asileurope_individuelle"    
  register_post_type('asileurope_individu',
                     [
                         'labels'      => [
                             'name'          => __('Notices individuelles'),
                             'singular_name' => __('Notice individuelle'),
                             'add_new_item'  => __('Ajouter une notice individuelle'),
                         ],
                        'public'             => true,
                        'publicly_queryable' => true,
                        'show_ui'            => true,
                        'show_in_menu'       => true,
                        'show_in_nav_menus'  => true,
                        'query_var'          => true,
                        'rewrite'            => array( 'slug' => 'notices-individuelles'),
                        'capability_type'    => 'post',
                        'has_archive'        => true,
                        'hierarchical'       => false,
                        'menu_position'      => null,
                        'supports'           => array('prenoms'),
                       ]
  );

  
  // Partage de la taxonomie "taxonomie_asileurope" entre les 3 types de contenus 
  register_taxonomy_for_object_type('taxonomie_asileurope', 'asileurope_lexico');
  register_taxonomy_for_object_type('taxonomie_asileurope', 'asileurope_icono');
  register_taxonomy_for_object_type('taxonomie_asileurope', 'asileurope_carto');

  // Assignation de la taxonomie "taxonomie_base_asileurope" aux notices individuelles
  register_taxonomy_for_object_type('taxonomie_base_asileurope', 'asileurope_individu');


}

add_action('init', 'asileurope_custom_post_type');


/* Change le placeholder par défaut en fonction du type de contenu */
function asileurope_change_title_placeholder( $title ){
  
  $screen = get_current_screen();

  if  ( 'asileurope_icono' == $screen->post_type ) {
    $title = 'Titre complet de l\'oeuvre';
  } elseif ( 'asileurope_lexico' == $screen->post_type ) {
    $title = 'Terme lexical'; 
  } elseif ( 'asileurope_individu' == $screen->post_type ) {
    $title = 'Nom de l\'individu'; 
  }
  return $title;
}
add_filter( 'enter_title_here', 'asileurope_change_title_placeholder' ); 


/* Met à jour les permaliens */
add_action( 'init', 'flush_rewrite_rules' );


/* Ajoute des valeurs aux critères de recherche */
function asileurope_add_query_vars( $vars ){
  $vars[] = "motscles";
  $vars[] = "sexe";
  return $vars;
}
add_filter( 'query_vars', 'asileurope_add_query_vars' );


/* Gère la recherche avancée */
function asileurope_pre_get_posts( $q ) {

  if(is_admin()) {return $q;}

  if ($motscles = $q->get('motscles')) {
    $meta_query = array(
      'relation' => 'OR',
      array('key'     => 'prenoms', 'value'   => $motscles, 'compare' => 'LIKE'),
      array('key'     => 'titre',   'value'   => $motscles, 'compare' => 'LIKE'),
      );
    
    $q->set( 'meta_query', $meta_query );
  }

  return $q;
}
add_action( 'pre_get_posts', 'asileurope_pre_get_posts');


/* Construit le titre du post lors de l'ajout d'un champ custom */
function asileurope_meta_to_post_title($post_id)
{
    // Pour les notices individuelles
    if (get_post_type($post_id) == 'asileurope_individu') {
      $my_post = array();
      $my_post['ID'] = $post_id;
      $my_post['post_title'] = get_field( 'titre', $post_id ). ' '.get_field( 'prenoms', $post_id );
      wp_update_post( $my_post );
    }
    return $post_id;

}
add_action('acf/save_post', 'asileurope_meta_to_post_title');

function asileurope_filter_exceprt( $excerpt ) {
  if (get_post_type() == 'asileurope_lexico') {
    return wp_trim_words(get_field('partie_redigee'), 50);
  }
}
add_filter( 'get_the_excerpt', 'asileurope_filter_exceprt' );


