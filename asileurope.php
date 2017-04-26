<?php
/*
Plugin Name: Asileurope
Description: Gère la partie fonctionnelle du projet AsilEurope
Version:     0.1
Author:      Franck Dupont <kyfr59@gmail.com>
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// Ajout des types de champs personalisés ainsi que des taxonomies
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


  // Création de la taxonomie "localisation des notices" (catégories commune aux notices lexico & carto)
  $args = array(
    'hierarchical'      => true,
    'labels'            => array(),
    'show_ui'           => true,
    'show_in_menu'      => false,
    'show_admin_column' => false,
    'rewrite'           => array('slug' => 'localisation' ),
    'labels'            => array('name' => 'Localisations',
                                 'add_new_item' => 'Ajouter une nouvelle localisation'
                                  ),
  );
  register_taxonomy( 'localisations_lexico_carto', array( 'localisations' ), $args );



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
                        'rewrite'            => array( 'slug' => 'le-vocabulaire-de-lexil', 'with_front' => false),
                        'capability_type'    => 'post',
                        'has_archive'        => true,
                        'hierarchical'       => false,
                        'menu_position'      => null,
                        'supports'           => array('title', 'genre_pluriel'),
                        'taxonomies'         => array( 'localisations_lexico_carto' ),
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
                        'taxonomies'         => array( 'thematiques_carto', 'localisations_lexico_carto' ),
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


// Change le placeholder par défaut en fonction du type de contenu
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


// Met à jour les permaliens
add_action( 'init', 'flush_rewrite_rules' );


// Ajoute des valeurs aux critères de recherche
function asileurope_add_query_vars( $vars ){
  $vars[] = "motscles";
  $vars[] = "sexe";
  $vars[] = "lieu_de_naissance";
  $vars[] = "motifs_politiques";
  $vars[] = "secteur_professionnel";
  $vars[] = "profession";
  $vars[] = "annee_expulsion_debut";
  $vars[] = "annee_expulsion_fin";
  $vars[] = "motif_politique";
  $vars[] = "autorite_decisionnaire";
  $vars[] = "etat_etranger_expulse";
  $vars[] = "source_du_dossier_d’expulsion";
  return $vars;
}
add_filter( 'query_vars', 'asileurope_add_query_vars' );


// Gère la recherche avancée
function asileurope_pre_get_posts( $q ) {

  if(is_admin()) {return $q;}

  if ($q->get('motscles') ||
      $q->get('sexe') ||
      $q->get('lieu_de_naissance') ||
      $q->get('motifs_politiques') ||
      $q->get('secteur_professionnel') ||
      $q->get('profession') ||
      $q->get('annee_expulsion_debut') ||
      $q->get('annee_expulsion_fin') ||
      $q->get('autorite_decisionnaire') ||
      $q->get('motif_politique') ||
      $q->get('etat_etranger_expulse') ||
      $q->get('source_du_dossier_d’expulsion')
    ) {

    // Récupération des paramètres de la recherche
    $motscles               = stripslashes($q->get('motscles'));
    $sexe                   = stripslashes($q->get('sexe'));
    $lieu_de_naissance      = stripslashes($q->get('lieu_de_naissance'));
    $motifs_politiques      = stripslashes($q->get('motifs_politiques'));
    $secteur_professionnel  = stripslashes($q->get('secteur_professionnel'));
    $profession             = stripslashes($q->get('profession'));
    $annee_expulsion_debut  = stripslashes($q->get('annee_expulsion_debut'));
    $annee_expulsion_fin    = stripslashes($q->get('annee_expulsion_fin'));
    $motif_politique        = stripslashes($q->get('motif_politique'));
    $autorite_decisionnaire = stripslashes($q->get('autorite_decisionnaire'));
    $etat_etranger_expulse  = stripslashes($q->get('etat_etranger_expulse'));
    $source                 = stripslashes($q->get('source_du_dossier_d’expulsion'));

    // Gestion des mots clés
    $meta_query = array();
    if (strlen(trim($motscles))) {

      $tabMotsCles = explode(' ', $motscles);

      $motscles_query = array('relation' => 'OR');
      foreach ($tabMotsCles as $motcle) {
          $motscles_query[] = array('key'     => 'titre',   'value'   => $motcle, 'compare' => 'LIKE');
          $motscles_query[] = array('key'     => 'motif',   'value'   => $motcle, 'compare' => 'LIKE');
      }
      $meta_query[] = $motscles_query;
    }

    // Sexe
    if (strlen(trim($sexe))) {

      if ($sexe == 'Les2') {
        $sexe_query   = array('relation' => 'OR');
        $sexe_query[] = array('key'     => 'sexe', 'value'   => 'Masculin', 'compare' => '=');
        $sexe_query[] = array('key'     => 'sexe', 'value'   => 'Féminin', 'compare' => '=');
      } else {
        $sexe_query = array('key'     => 'sexe', 'value'   => $sexe, 'compare' => '=');
      }
      $meta_query[] = $sexe_query;
    }

    // Lieu de naissance
    if (strlen(trim($lieu_de_naissance))) {
      $lieu_de_naissance_query = array('key'     => 'lieu_de_naissance', 'value'   => $lieu_de_naissance, 'compare' => '=');
      $meta_query[] = $lieu_de_naissance_query;
    }

    // Motif politiques de l'arrivée en france
    if (strlen(trim($motifs_politiques))) {
      $motifs_politiques_query = array('key'     => 'motifs_politiques', 'value'   => $motifs_politiques, 'compare' => '=');
      $meta_query[] = $motifs_politiques_query;
    }

    // Secteur professionnel
    if (strlen(trim($secteur_professionnel))) {
      $secteur_professionnel_query = array('key'     => 'secteur_professionnel', 'value'   => $secteur_professionnel, 'compare' => '=');
      $meta_query[] = $secteur_professionnel_query;
    }

    // Profession
    if (strlen(trim($profession))) {
      $profession_query = array('key'     => 'profession', 'value'   => $profession, 'compare' => '=');
      $meta_query[] = $profession_query;
    }

    // Année d'expulsion
    if (strlen(trim($annee_expulsion_debut)) && strlen(trim($annee_expulsion_fin))) {
      $annee_query   = array('relation' => 'AND');
      $annee_query[] = array('key'     => 'annee_expulsion', 'value'   => $annee_expulsion_debut, 'compare' => '>=');
      $annee_query[] = array('key'     => 'annee_expulsion', 'value'   => $annee_expulsion_fin, 'compare' => '<=');
    } elseif (strlen(trim($annee_expulsion_debut))) {
      $annee_query = array('key'     => 'annee_expulsion', 'value'   => $annee_expulsion_debut, 'compare' => '>=');
    } elseif (strlen(trim($annee_expulsion_fin))) {
      $annee_query = array('key'     => 'annee_expulsion', 'value'   => $annee_expulsion_fin, 'compare' => '<=');
    }
    $meta_query[] = $annee_query;
  }

  // Expulsé pour motif politique
  if ($motif_politique == 'N/A') {
    $motif_politique_query = array('key'     => 'motif_politique', 'value'   => $motif_politique, 'compare' => 'NOT EXISTS');
    $meta_query[] = $motif_politique_query;
  }
  elseif (strlen(trim($motif_politique))) {
    $motif_politique_query = array('key'     => 'motif_politique', 'value'   => $motif_politique, 'compare' => '=');
    $meta_query[] = $motif_politique_query;
  }

  // Autortié décisionnaire
  if (strlen(trim($autorite_decisionnaire))) {
    $autorite_decisionnaire_query = array('key'     => 'autorite_decisionnaire', 'value'   => $autorite_decisionnaire, 'compare' => '=');
    $meta_query[] = $autorite_decisionnaire_query;
  }

  // Pays vers lequel l'idividu a été expulsé
  if (strlen(trim($etat_etranger_expulse))) {
    $etat_etranger_expulse_query = array('key'     => 'etat_etranger_expulse', 'value'   => $etat_etranger_expulse, 'compare' => '=');
    $meta_query[] = $etat_etranger_expulse_query;
  }

  // Source
  if (strlen(trim($source))) {
    $source_query = array('key'     => 'source_du_dossier_d’expulsion', 'value'   => $source, 'compare' => '=');
    $meta_query[] = $source_query;
  }


  $q->set( 'meta_query', $meta_query );

  return $q;
}
add_action( 'pre_get_posts', 'asileurope_pre_get_posts');



// Construit le titre du post lors de l'ajout d'un champ custom
function asileurope_meta_to_post_title($post_id)
{
    // Pour les notices individuelles
    if (get_post_type($post_id) == 'asileurope_individu') {
      $my_post = array();
      $my_post['ID'] = $post_id;
      $my_post['post_title'] = get_field( 'titre', $post_id ). ' '.get_field( 'prenoms', $post_id );

      if ($val = get_field("date_arrete_d’expulsion")) {
        $annee = trim(substr($val, -4, 4));
        if (is_numeric($annee))
          update_field('annee_expulsion', $annee);
      }


      wp_update_post( $my_post );
    }
    return $post_id;

}
add_action('acf/save_post', 'asileurope_meta_to_post_title');

// Gère l'extrait en fonction du type de contenu
function asileurope_filter_exceprt( $excerpt ) {
  if (get_post_type() == 'asileurope_lexico') {
    return wp_trim_words(get_field('partie_redigee'), 50);
  }
}
add_filter( 'get_the_excerpt', 'asileurope_filter_exceprt' );


// Supprime le lien "ajouter une nouvelle localisation" dans l'admin
function asileurope_admin_css() {
  echo '<style>
    #localisations_lexico_carto-add-toggle  {
    display:none;
  }
  div[data-field_name=annee_expulsion] {
    /*display:none;*/

  }
  </style>';
}
add_action('admin_head', 'asileurope_admin_css');