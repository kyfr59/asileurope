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
  register_taxonomy(
    'taxonomie_asileurope',
    array(),
    $args
  );

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
                        'supports'           => array('title', 'genre_pluriel'),
                       ]
  );

  
  // Partage de la taxonomie "taxonomie_asileurope" entre les 3 types de contenus 
  register_taxonomy_for_object_type('taxonomie_asileurope', 'asileurope_lexico');
  register_taxonomy_for_object_type('taxonomie_asileurope', 'asileurope_icono');
  register_taxonomy_for_object_type('taxonomie_asileurope', 'asileurope_carto');
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


/* Ajoute le prénom au nom dans la liste des notices individuelle dans le backoffice */
function asileurope_admin_title() {
    add_filter(
        'the_title',
        'asileurope_construct_admin_title',
        100,
        2
    );
}

function asileurope_construct_admin_title( $title, $id ) {
    
    $post = get_post($id);
    if  ( 'asileurope_individu' == $post->post_type ) {
      $prenom  = get_field('prenoms');
      return $title .' '.$prenom;
    }
    return $title;
}

add_action('admin_head-edit.php', 'asileurope_admin_title');


/* Met à jour les permaliens */
add_action( 'init', 'flush_rewrite_rules' );
