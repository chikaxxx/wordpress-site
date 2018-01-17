<?php


require_once dirname(__FILE__) . '/functions/custom-fields.php';
require_once dirname(__FILE__) . '/functions/custom-post-type.php';

/**
 * 管理画面に更新通知を表示しない設定
 */

//WordPress 本体の更新通知を非表示
add_filter('pre_site_transient_update_core', create_function('$a', "return  null;"));

//プラグイン更新通知を非表示
remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );

//テーマ更新通知を非表示
remove_action( 'load-update-core.php', 'wp_update_themes' );
add_filter( 'pre_site_transient_update_themes', create_function( '$a', "return null;" ) );


// ページに表示するitem個数の設定
function custom_main_query( $query ) {
  if ( is_admin() || !$query->is_main_query() ) return;

  if ( $query->is_post_type_archive( 'news' ) ) {
    $query->set( 'posts_per_page' , '14' );
  }
}
add_action( 'pre_get_posts', 'custom_main_query' );


// サイト設定を管理画面に表示する設定
if ( function_exists( 'acf_add_options_page' ) ) {
  acf_add_options_page( array(
    'page_title' => 'サイト設定',
    'menu_title' => 'サイト設定',
    'menu_slug' => 'theme-options',
    'capability' => 'edit_posts',
    'parent_slug' => '',
    'position' => false,
    'icon_url' => false,
    'redirect' => false
  ) );

}

//------------------------------------
// UA判別
//------------------------------------
function is_android() {
    $is_android = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Android');
    if ($is_android) {
        return true;
    } else {
        return false;
    }
}

//------------------------------------
// ナビゲーション
//------------------------------------
register_nav_menus( array() );

function no_menu() {
  return false;
}


// file更新日時
function file_date($filename){
  if (file_exists($filename)) {
    return date('Y-m-d-His', filemtime($filename));
  }
}


// get page title
function get_page_title($sns = null) {
  global $wp_query;
  $title = '';
  $main_site_title = get_field('site_name', 'options');

  if (is_home()) {
    $title = get_field('site_name', 'options');
  }

  if(is_single() ){
    $post_obj = get_post_type_object(get_post_type());
    $post_label = $post_obj->labels->name ? $post_obj->labels->name . ' - ' : '';
    $post_type = $post_obj->name ? $post_obj->name : '';
    $title = wp_title(' | ', false, 'right') . $main_site_title;
  }

  if(is_post_type_archive()) {
    $post_label = get_queried_object()->label;
    $title = $post_label. ' | ' . $main_site_title;
  }

  if (is_404() ) {
    $title = 'お探しのページが見つかりませんでした'. ' | ' . $main_site_title;
  }

  return $title;
}


function get_page_description() {
  global $wp_query;
  $title = '';

  $main_site_title = get_field('site_name', 'options');
  $description = get_field('description', 'options');

  if(is_post_type_archive()){
    $post_label = get_queried_object()->label;
    $description = $post_label.'です。'.$description;

  } else if(is_singular('news') && !empty(get_field('pdf'))){

    $description = 'この記事にはPDFが添付されています。続きはリンク先のPDFファイルからお読みください。';

  } else if(is_single()){
    $remove_tags_content = wp_strip_all_tags((get_post(get_the_ID())->post_content));

    if($remove_tags_content != '') {
      $description = get_substring($remove_tags_content,140);
    }
  }

  return $description;
}


/**
 * OG画像
 * @param  masterのサイト設定og-imageフィールド
 * @return OG画像パス
 */
function get_OG_image($field) {
	$image_url = '';
  if( ! empty($field) && is_array($field) ) {
    $image_url = $field['url'];
  }
  return $image_url;
}



/**
 * 短縮文字列
 *
 * @param  string 元の文字列, integer 短縮する文字数
 * @return string 短縮した文字列
 */
function get_substring($org = '', $limit = 60) {
  $replace = str_replace(array("\r\n", "\r", "\n"), '', strip_tags($org));

  if (strlen($replace) == mb_strlen($replace)) {
    // $textは全部英語（全部シングルバイト文字）
    $orglen = strlen($replace);
    $limit  = $limit * 1.9;
  } else {
    // $textには日本語が含まれている（マルチバイト文字が含まれている）
    $orglen   = mb_strlen($replace);
  }

  $str = $orglen > $limit ? mb_substr($replace, 0, $limit - 1) . '...' : strip_tags($org);

  return $str;
}


/**
 * パンくずナビ
 * @return array パンくず
*/
function get_breadcrumbs() {
  if ( is_home() ) return array();
  global $wp_query;
  $breadcrumbs = array(
    array(
      'title' => 'TOP',
      'url'   => home_url(),
    ),
  );

  if ( is_page() ) {
    $post_obj = $wp_query->get_queried_object();
    // 親ページがない（一番上のページ）
    if ( $post_obj->post_parent == 0 ) {
      array_push($breadcrumbs, array(
        'title' => get_the_title(),
        'url' => get_permalink(),
      ));
    } else {
      // 現在の記事の親IDを取得＆並べ替え
      $ancestors = array_reverse(get_post_ancestors( $post_obj->ID ));
      // 自分のIDを最後に挿入
      array_push($ancestors, $post_obj->ID);
      // 配列に格納
      foreach( $ancestors as $id ) {
        array_push($breadcrumbs, array(
          'title' => get_the_title($id),
          'url' => get_permalink($id),
        ));
      }
    }
  } // end is_page


  if(is_post_type_archive() ){
    // カスタム投稿名取得
    $post_obj = $wp_query->get_queried_object();
    $post_type = get_query_var( 'post_type' );

    array_push($breadcrumbs, array(
      'title' => $post_obj->label,
      'url' => get_post_type_archive_link($post_type),
    ));

  }//end post type archive

  if( is_single()) {
    $post_type = get_query_var('post_type');
    $post_obj  = get_post_type_object($post_type);

    if( $post_type == '') {
      // デフォルト投稿
      array_push($breadcrumbs, array(
        'title' => get_the_title(),
        'url' => get_permalink(),
      ));
    } else if ($post_type == 'about') {
      // 現在のページ
      array_push($breadcrumbs, array(
        'title' => $post_obj->label.'_'.get_the_title(),
        'url' => get_permalink(),
      ));
    } else {
      // アーカイブページ
      array_push($breadcrumbs, array(
        'title' => $post_obj->label,
        'url' => get_post_type_archive_link(get_query_var('post_type')),
      ));
      // 現在のページ
      array_push($breadcrumbs, array(
        'title' => get_the_title(),
        'url' => get_permalink(),
      ));
    }
  }

  return $breadcrumbs;
}



/**
 * ページネーション
 * @param mixd $args
 * @return nonev
*/
function get_pagination( $args = null ) {
  global $wp_rewrite, $wp_query, $paged;

  $defaults = array(
    'container_class' => 'pagination',
    'prev_text' => '&laquo; Back',
    'next_text' => 'Next &raquo;',
  );
  $r = wp_parse_args( $args, $defaults );

  $paginate_base = get_pagenum_link( 1 );
  if ( strpos($paginate_base, '?' ) || ! $wp_rewrite->using_permalinks() ) {
    $paginate_format = '';
    $paginate_base = add_query_arg( 'paged', '%#%' );

    $tmp = $paginate_base;
    $tmp = preg_replace( "/\&paged\=\%\#\%/", "", $tmp);
    $tmp = preg_replace( "/\/page\/[0-9]+/", "", $tmp);

    $tmp = preg_match( "/^(?P<fst>.*)(?P<sec>\?.*)$/", $tmp, $matches);
    $paginate_base = $matches["fst"] .'page/%#%/' . $matches["sec"];

  } else {
    $paginate_format = ( substr($paginate_base, -1 ,1) == '/' ? '' : '/' ) .user_trailingslashit('page/%#%/', 'paged');
    $paginate_base .= '%_%';
  }

  $pagination = array(
    'base' => $paginate_base,
    'format' => $paginate_format,
    'total' => $wp_query->max_num_pages,
    'mid_size' => 5,
    'current' => ($paged ? $paged : 1),
    'prev_text' => $r['prev_text'],
    'next_text' => $r['next_text'],
  );
  $tmp_format = str_replace( "/page/1/", "/", paginate_links($pagination));
  if( !empty($tmp_format) ) {
    echo '<div class="'.$r['container_class'].'">'. $tmp_format .'</div>';
  }
}



/**
 * ページネーション for SP数字のナビがないver
 * @param mixd $args
 * @return nonev
*/
function get_pagination_sp( $args = null ) {
  global $wp_rewrite, $wp_query, $paged;

  $defaults = array(
    'container_class' => 'pagination',
    'prev_text' => '&laquo; Back',
    'next_text' => 'Next &raquo;',
  );
  $r = wp_parse_args( $args, $defaults );

  $paginate_base = get_pagenum_link( 1 );
  if ( strpos($paginate_base, '?' ) || ! $wp_rewrite->using_permalinks() ) {
    $paginate_format = '';
    $paginate_base = add_query_arg( 'paged', '%#%' );

    $tmp = $paginate_base;
    $tmp = preg_replace( "/\&paged\=\%\#\%/", "", $tmp);
    $tmp = preg_replace( "/\/page\/[0-9]+/", "", $tmp);

    $tmp = preg_match( "/^(?P<fst>.*)(?P<sec>\?.*)$/", $tmp, $matches);
    $paginate_base = $matches["fst"] .'page/%#%/' . $matches["sec"];

  } else {
    $paginate_format = ( substr($paginate_base, -1 ,1) == '/' ? '' : '/' ) .user_trailingslashit('page/%#%/', 'paged');
    $paginate_base .= '%_%';
  }

  $pagination = array(
    'base' => $paginate_base,
    'format' => $paginate_format,
    'total' => $wp_query->max_num_pages,
    'mid_size' => 5,
    'current' => ($paged ? $paged : 1),
    'prev_text' => $r['prev_text'],
    'next_text' => $r['next_text'],
  );
  $tmp_format = str_replace( "/page/1/", "/", paginate_links($pagination));
  if( !empty($tmp_format) ) {
    echo '<div class="'.$r['container_class'].'">'. $tmp_format .'</div>';
  }
}


// post_item_nav
function post_item_nav( $args = null ){
  $defaults = array(
    'container_class' => 'm-page-nav-01',
    'prev_text' => ' 前の記事',
    'next_text' => ' 次の記事',
    'archive_text' => '一覧',
  );
  $r = wp_parse_args( $args, $defaults );
  $prev_post = get_previous_post();
  $next_post = get_next_post();

  if( !$prev_post && !$next_post ) return;

  echo '<nav class="'.$r['container_class'].'"><ul>';

  //前の記事のリンク
  if($prev_post) {
    echo '<li class="is-prev">';
      previous_post_link('%link', $r['prev_text']);
    echo '</li>';
  }

  // アーカイブへのリンク
  $link_archive = get_post_type_archive_link(get_post_type());
  echo '<li class="is-archive"><div class="m-btn-03">';
    echo '<a class="archive" href="'.$link_archive.'">'.$r['archive_text'].'</a>';
  echo '</div></li>';


  if($next_post) {
    echo '<li class="is-next">';
      next_post_link('%link', $r['next_text']);
    echo '</li>';
  }

  echo '</ul></nav>';
}