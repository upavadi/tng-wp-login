<?php
/********************
* NEEDS REFACTORING
* Insert Pages:-
	* Forgot your password
	* Password Reset
	* Registration
	* Profile / Account
*******************/

	function insert_page($slug, $post_content, $autor_id, $title){
		$page_array = array(
			'post_content'   => $post_content,
			'post_name'      => $slug,
			'post_author'	 =>	$author_id,
			'post_title'     => $title,
			'post_status'    => 'publish',
			'post_type'      => 'page',
			'ping_status'    => 'closed',
			'comment_status' => 'closed'
		);
			$query = new WP_Query( 'pagename=' . $slug );
	if ( !$query->have_posts() ) wp_insert_post($page_array );
	return $query;
	}
	
	function do_insert_pages() {
	// Insert Lost Password page
	$slug = 'wp-tng-lostPassword';
	$post_content = '[lost_Password_form]';
	$author_id = 1;
	$title = 'Password Lost';
	insert_page($slug, $post_content, $autor_id, $title);
	
	// Insert Reset Password page
	$slug = 'wp-tng-resetPassword';
	$post_content = '[reset_Password_form]';
	$author_id = 1;
	$title = 'Password Reset';
	insert_page($slug, $post_content, $autor_id, $title);
	
	// Insert Profile Page
	$slug = 'wp-tng-profile';
	$post_content = '[user_profile]';
	$author_id = 1;
	$title = 'Profile';
	insert_page($slug, $post_content, $autor_id, $title);
	
	// Insert Registration Page
	$slug = 'wp-tng-registration';
	$post_content = '[user_registration]';
	$author_id = 1;
	$title = 'Registration';
	insert_page($slug, $post_content, $autor_id, $title);
	return;
	}
