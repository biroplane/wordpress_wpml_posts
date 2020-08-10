<?php

/**
 * Plugin Name: Wordpress WPML Posts
 * Description: Show grouped post on REST Api by language
 * Version: 1.1.0
 * Author: Biro
 * Author URI: https://github.com/biroplane
 */

define( 'ROOT_API', 'qb/v2' );


function add_taxonomies_to_pages() {
	register_taxonomy_for_object_type( 'post_tag', 'page' );
	register_taxonomy_for_object_type( 'category', 'page' );
}

add_action( 'init', 'add_taxonomies_to_pages' );

add_action( 'init', 'wordpress_wpml_posts' );
function wordpress_wpml_posts() {
	if ( function_exists( 'icl_object_id' ) ) {
		add_action( 'rest_api_init', function () {
			register_rest_field( array( "post", "page" ), 'locale', array(
				'get_callback'    => 'add_locale_field',
				'update_callback' => null,
				'schema'          => null
			) );

			register_rest_field( array( "post", "page" ), 'related', array(
				'get_callback'    => 'add_related_field',
				'update_callback' => null,
				'schema'          => null
			) );


			register_rest_route(
				ROOT_API,
				'list/posts',
				array(
					'callback' => 'get_post_listed',
					'methods'  => 'GET',
					'args'     => array(
						'return_type' => 'post',
						'categories'  => array(
							'validate_callback' => function ( $param, $request, $key ) {
								// print_r($param);
								// print_r($request);
								// print_r($key);
								return is_numeric( $param );
							}
						),
						'tag'         => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return esc_html( $param );
							}
						),
						'exact_date'  => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return preg_match( '/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $param );
							}
						)
					)
				)
			);
			register_rest_route(
				ROOT_API,
				'list/pages',
				array(
					'callback' => 'get_post_listed',
					'methods'  => 'GET',
					'args'     => array(
						'return_type' => 'page',
						'categories'  => array(
							'validate_callback' => function ( $param, $request, $key ) {
								// print_r($param);
								// print_r($request);
								// print_r($key);
								return is_numeric( $param );
							}
						),
						'tag'         => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return esc_html( $param );
							}
						),
						'exact_date'  => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return preg_match( '/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $param );
							}
						)
					)
				)
			);

			register_rest_route(
				ROOT_API,
				'group/posts',
				array(
					'callback' => 'get_post_grouped',
					'methods'  => 'GET',
					'args'     => array(
						'return_type' => 'post',
						'categories'  => array(
							'validate_callback' => function ( $param, $request, $key ) {
								// print_r($param);
								// print_r($request);
								// print_r($key);
								return is_numeric( $param );
							}
						),
						'tag'         => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return esc_html( $param );
							}
						),
						'exact_date'  => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return preg_match( '/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $param );
							}
						)
					)
				)
			);

			register_rest_route(
				ROOT_API,
				'group/pages',
				array(
					'callback' => 'get_post_grouped',
					'methods'  => 'GET',
					'args'     => array(
						'return_type' => 'page',
						'categories'  => array(
							'validate_callback' => function ( $param, $request, $key ) {
								// print_r($param);
								// print_r($request);
								// print_r($key);
								return is_numeric( $param );
							}
						),
						'tag'         => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return esc_html( $param );
							}
						),
						'exact_date'  => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return preg_match( '/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $param );
							}
						)
					)
				)
			);

			register_rest_route(
				ROOT_API,
				'locales/posts',
				array(
					'callback' => 'get_post_translated',
					'methods'  => 'GET',
					'args'     => array(
						'return_type' => 'post',
						'categories'  => array(
							'validate_callback' => function ( $param, $request, $key ) {
								// print_r($param);
								// print_r($request);
								// print_r($key);
								return is_numeric( $param );
							}
						),
						'tag'         => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return esc_html( $param );
							}
						),
						'exact_date'  => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return preg_match( '/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $param );
							}
						)
					)
				)
			);
			register_rest_route(
				ROOT_API,
				'locales/pages',
				array(
					'callback' => 'get_post_translated',
					'methods'  => 'GET',
					'args'     => array(
						'return_type' => 'page',
						'categories'  => array(
							'return_type'       => 'page',
							'validate_callback' => function ( $param, $request, $key ) {
								// print_r($param);
								// print_r($request);
								// print_r($key);
								return is_numeric( $param );
							}
						),
						'tag'         => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return esc_html( $param );
							}
						),
						'exact_date'  => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return preg_match( '/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $param );
							}
						)
					)
				)
			);
			register_rest_route(
				ROOT_API,
				'locales/posts/(?P<id>\d+)',
				array(
					'callback' => 'get_single_post_translated',
					'methods'  => 'GET',
					'args'     => array(
						'id' => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return is_numeric( $param );
							}
						),

					)
				)
			);
			register_rest_route(
				ROOT_API,
				'locales/pages/(?P<id>\d+)',
				array(
					'callback' => 'get_single_page_translated',
					'methods'  => 'GET',
					'args'     => array(
						'id' => array(
							'validate_callback' => function ( $param, $request, $key ) {
								return is_numeric( $param );
							}
						)
					)
				)
			);
		} );
	}
}

/**
 * @param $data
 *
 * @return array
 */
function get_post_listed( $data ) {
	$return_type = '';
	if ( ! empty( $data->get_attributes() ) ) {
		$attrs       = $data->get_attributes();
		$return_type = $attrs['args']['return_type'];
	}
	$args = array(
		'posts_per_page'   => - 1,
		'orderby'          => 'date',
		'order'            => 'ASC',
		'post_type'        => $return_type,
		'post_status'      => 'publish',
		'suppress_filters' => 1
	);
	if ( ! empty( $data['categories'] ) ) {
		$args['category'] = $data['categories'];
	}
	if ( ! empty( $data['tag'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'post_tag',
				'field'    => 'name',
				'terms'    => $data['tag']
			)
		);
	}
	if ( $data['exact_date'] ) {
		list( $year, $month, $day ) = explode( '-', $data['exact_date'] );
		$args['date_query'] = array(
			'year'  => $year,
			'month' => $month,
			'day'   => $day,

		);
	}
	//print_r($args);

	$postQuery    = get_posts( $args );
	$groupedPosts = listPosts( $postQuery );

	return $groupedPosts;
}


/**
 * @param $data
 *
 * @return array
 */
function get_post_grouped( $data ) {
	$return_type = '';
	if ( ! empty( $data->get_attributes() ) ) {
		$attrs       = $data->get_attributes();
		$return_type = $attrs['args']['return_type'];
	}
	$args = array(
		'posts_per_page'   => - 1,
		'orderby'          => 'date',
		'order'            => 'ASC',
		'post_type'        => $return_type,
		'post_status'      => 'publish',
		'suppress_filters' => 1
	);
	if ( ! empty( $data['categories'] ) ) {
		$args['category'] = $data['categories'];
	}
	if ( ! empty( $data['tag'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'post_tag',
				'field'    => 'name',
				'terms'    => $data['tag']
			)
		);
	}
	if ( $data['exact_date'] ) {
		list( $year, $month, $day ) = explode( '-', $data['exact_date'] );
		$args['date_query'] = array(
			'year'  => $year,
			'month' => $month,
			'day'   => $day,

		);
	}


	$postQuery    = get_posts( $args );
	$groupedPosts = groupPosts( $postQuery );

	return $groupedPosts;
}

function get_post_translated( $data ) {
	if ( ! empty( $data->get_attributes() ) ) {
		$attrs       = $data->get_attributes();
		$return_type = $attrs['args']['return_type'];
	}
	$args = array(
		'posts_per_page'   => - 1,
		'orderby'          => 'date',
		'order'            => 'ASC',
		'post_type'        => $return_type,
		'post_status'      => 'publish',
		'suppress_filters' => 0
	);
	if ( ! empty( $data['categories'] ) ) {
		$args['category'] = $data['categories'];
	}
	if ( ! empty( $data['tag'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'post_tag',
				'field'    => 'name',
				'terms'    => $data['tag']
			)
		);
	}
	if ( $data['exact_date'] ) {
		list( $year, $month, $day ) = explode( '-', $data['exact_date'] );
		$args['date_query'] = array(
			'year'  => $year,
			'month' => $month,
			'day'   => $day,

		);
	}

	//print_r($args);
	$postQuery = get_posts( $args );

	$localizedPosts = formatResponse( $postQuery );

	return $localizedPosts;
}

function get_single_post_translated( $data ) {
	$args      = array(
		'p'                => $data['id'],
		'posts_per_page'   => - 1,
		'orderby'          => 'date',
		'order'            => 'ASC',
		'post_type'        => 'post',
		'post_status'      => 'publish',
		'suppress_filters' => 0
	);
	$postQuery = get_posts( $args );

	$localizedPosts = formatResponse( $postQuery );

	return $localizedPosts;
}

function get_single_page_translated( $data ) {
	$args      = array(
		'p'                => $data['id'],
		'posts_per_page'   => - 1,
		'orderby'          => 'date',
		'order'            => 'ASC',
		'post_type'        => 'page',
		'post_status'      => 'publish',
		'suppress_filters' => 0
	);
	$postQuery = get_posts( $args );

	$localizedPosts = formatResponse( $postQuery );

	return $localizedPosts;
}


/* -------------------------------------------------------------------------- */
/*                               FORMAT RESPONSE                              */
/* -------------------------------------------------------------------------- */

function listPosts( $posts ) {

	$addLocalPost = array_map( function ( $post ) {
		// print $post->ID."\n";
		$locale = apply_filters( 'wpml_post_language_details', null, $post->ID );


		$image = null;
		if ( has_post_thumbnail( $post ) ) {
			$image = get_the_post_thumbnail_url( $post );
			//$image = wp_get_attachment_image_src($post);
		}
		$categories = wp_get_post_categories( $post->ID, array( 'fields' => 'all' ) );
		$tags       = wp_get_post_tags( $post->ID );

		$trid  = apply_filters( 'wpml_element_trid', null, $post->ID );
		$group = apply_filters( 'wpml_get_element_translations', null, $trid );


		//print_r($group[$locale['language_code']]);
		$post->post_author    = array(
			'id'   => get_post_field( 'post_author', $post->ID ),
			'name' => get_the_author_meta( 'display_name', get_post_field( 'post_author', $post->ID ) )
		);
		$post->locale         = $locale['language_code'];
		$post->featured_image = $image;
		$post->categories     = $categories;
		$post->tags           = $tags;
		$post->is_sticky      = is_sticky( $post->ID );
		$post->related        = array_values( array_filter( $group, function ( $g ) use ( $locale ) {
			$field            = get_post_field( 'post_name', $g->element_id );
			$g->locale_slug   = $field;
			$g->category_slug = @wp_get_post_categories( $g->element_id, array( 'fields' => 'slugs' ) )[0];

			return $g->language_code != $locale['language_code'];
		} ) );

		return $post;
	}, $posts );


	// $group = group_by('locale', $addLocalPost);
	// return $group;

	return $addLocalPost;
	// foreach($posts as $post){
	//     print $post->ID;
	//     print_r($locale);
	// }
}

function groupPosts( $posts ) {
	$list = listPosts( $posts );

	$group = [];
	foreach ( $list as $post ) {
		$group[ $post->locale ][] = $post;
	}

	return $group;
}

function formatResponse( $posts ) {
	if ( empty( $posts ) ) {
		return [];
	}

	$localizedPosts = [];
	foreach ( $posts as $post ) {
		// print $post->ID;
		// print $post->post_title;
		// print "--------------------\n";
		$image = null;
		if ( has_post_thumbnail( $post ) ) {
			$image = get_the_post_thumbnail_url( $post );
			//$image = wp_get_attachment_image_src($post);
		}
		$categories = wp_get_post_categories( $post->ID );
		$tags       = wp_get_post_tags( $post->ID );
		$trid       = apply_filters( 'wpml_element_trid', null, $post->ID );
		$group      = apply_filters( 'wpml_get_element_translations', null, $trid );
		//print count($group);
		//if(count($group)!==1){

		$newPosts = array_map( function ( $obj ) use ( &$post, $image, $categories, $tags ) {
			//print $g;
			//$newPost = $post;
			$arrayPost = (array) get_post( $obj->element_id );
			//print_r($obj);
			//print $obj->language_code."\n";
			$field                       = get_post_field( 'post_name', $obj->element_id );
			$arrayPost['locale']         = $obj->language_code;
			$arrayPost['locale_slug']    = $field;
			$arrayPost['featured_image'] = $image;
			$arrayPost['categories']     = $categories;
			$arrayPost['tags']           = $tags;
			// print $field;

			//print "--------------------\n";
			return $arrayPost;
		}, $group );
		array_push( $localizedPosts, $newPosts );
		//}
		// print_r($trid);
		// print_r($group);
		//print_r($post);
	}

	return $localizedPosts;
}



function add_locale_field($post){
	//print_r($post);
	$locale = apply_filters( 'wpml_post_language_details', null, $post['id'] );


	return $locale['language_code'];
}

function add_related_field($post){
	$locale = apply_filters( 'wpml_post_language_details', null, $post['id'] );


	$trid  = apply_filters( 'wpml_element_trid', null, $post['id']);
	$group = apply_filters( 'wpml_get_element_translations', null, $trid );

	return array_values( array_filter( $group, function ( $g ) use ( $locale ) {
		$field            = get_post_field( 'post_name', $g->element_id );
		$g->locale_slug   = $field;
		$g->category_slug = @wp_get_post_categories( $g->element_id, array( 'fields' => 'slugs' ) )[0];

		return $g->language_code != $locale['language_code'];
	} ) );
}


