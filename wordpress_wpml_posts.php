<?php

/**
 * Plugin Name: Wordpress WPML Posts
 * Description: Show grouped post on REST Api by language
 * Version: 1.0
 * Author: Biro
 * Author URI: https://github.com/biroplane
 */

 add_action('init', 'wordpress_wpml_posts');
 function wordpress_wpml_posts()
 {
  if (function_exists('icl_object_id')) {

    add_action('rest_api_init', function () {
      register_rest_route('qubired/v2', '/locales/posts', array('callback' => 'get_post_translated', 'methods' => 'GET'));
      register_rest_route('qubired/v2', '/locales/pages', array('callback' => 'get_page_translated', 'methods' => 'GET'));
      register_rest_route('qubired/v2', '/locales/tags', array('callback' => 'get_tags_translated', 'methods' => 'GET'));
    });
  }
 //die;
 }
 function get_tags_translated($data){
  $args = array(
      'posts_per_page'   => -1,
      'orderby'          => 'date',
      'order'            => 'ASC',
      'post_type'        => 'post_tag',
      'suppress_filters' => 0 
  );
  $postQuery =  get_tags($args);
  print_r($postQuery);
  $localizedPosts = [];
  foreach($postQuery as $post){
      // print $post->ID;
      // print $post->post_title;
      // print "--------------------\n";
      $trid = apply_filters('wpml_element_trid',NULL,$post->ID);
      $group = apply_filters('wpml_get_element_translations',NULL,$trid);
      //print count($group);
      //if(count($group)!==1){

          $newPosts = array_map(function($obj) use (&$post){
              //print $g;
              //$newPost = $post;
              $arrayPost = (array) $post;
              //print_r($obj);
              //print $obj->language_code."\n";
              $field = get_post_field('post_name',$obj->element_id);
              $arrayPost['locale']=$obj->language_code;
              $arrayPost['locale_slug']=$field;
              // print $field;
              
              //print "--------------------\n";
              return $arrayPost;
          },$group);
          array_push($localizedPosts, $newPosts);
      //}
      // print_r($trid);
      // print_r($group);
      //print_r($post);
  }

  return $localizedPosts;
}
 function get_page_translated($data){
  $args = array(
      'posts_per_page'   => -1,
      'orderby'          => 'date',
      'order'            => 'ASC',
      'post_type'        => 'page',
      'suppress_filters' => 0 
  );
  $postQuery =  get_posts($args);
  $localizedPosts = [];
  foreach($postQuery as $post){
      // print $post->ID;
      // print $post->post_title;
      // print "--------------------\n";
      $trid = apply_filters('wpml_element_trid',NULL,$post->ID);
      $group = apply_filters('wpml_get_element_translations',NULL,$trid);
      //print count($group);
      //if(count($group)!==1){

          $newPosts = array_map(function($obj) use (&$post){
              //print $g;
              //$newPost = $post;
              $arrayPost = (array) $post;
              //print_r($obj);
              //print $obj->language_code."\n";
              $field = get_post_field('post_name',$obj->element_id);
              $arrayPost['locale']=$obj->language_code;
              $arrayPost['locale_slug']=$field;
              // print $field;
              
              //print "--------------------\n";
              return $arrayPost;
          },$group);
          array_push($localizedPosts, $newPosts);
      //}
      // print_r($trid);
      // print_r($group);
      //print_r($post);
  }

  return $localizedPosts;
}
 function get_post_translated($data){
  $args = array(
      'posts_per_page'   => -1,
      'orderby'          => 'date',
      'order'            => 'ASC',
      'post_type'        => 'post',
      'suppress_filters' => 0 
  );
  $postQuery =  get_posts($args);
  $localizedPosts = [];
  foreach($postQuery as $post){
      // print $post->ID;
      // print $post->post_title;
      // print "--------------------\n";
      $trid = apply_filters('wpml_element_trid',NULL,$post->ID);
      $group = apply_filters('wpml_get_element_translations',NULL,$trid);
      //print count($group);
      //if(count($group)!==1){

          $newPosts = array_map(function($obj) use (&$post){
              //print $g;
              //$newPost = $post;
              $arrayPost = (array) $post;
              //print_r($obj);
              //print $obj->language_code."\n";
              $field = get_post_field('post_name',$obj->element_id);
              $arrayPost['locale']=$obj->language_code;
              $arrayPost['locale_slug']=$field;
              // print $field;
              
              //print "--------------------\n";
              return $arrayPost;
          },$group);
          array_push($localizedPosts, $newPosts);
      //}
      // print_r($trid);
      // print_r($group);
      //print_r($post);
  }

  return $localizedPosts;
}