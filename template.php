<?php
// $Id: template.php,v 1.21 2009/08/12 04:25:15 johnalbin Exp $

/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to tbsk_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: tbsk_breadcrumb()
 *
 *   where tbsk is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/**
 * Implementation of HOOK_theme().
 */
function tbsk_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  // @TODO: Needs detailed comments. Patches welcome!
  return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
function tbsk_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function
function tbsk_preprocess_page(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
  print dsm($vars['title']);
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function tbsk_preprocess_node(&$vars, $hook) {
}
// */


/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function tbsk_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function tbsk_preprocess_block(&$vars, $hook) {
  $block = $vars['block'];
  if ($block->module == 'weather' && $block->region == 'content_top'):
    $vars['classes_array'][] = 'clearfix';
  endif;
}
// */

/* function tbsk_preprocess_content_field (&$vars, $hook) {
  if ($vars['field_name'] == 'field_artikkelbilde_extra') {
  }
}
*/

function tbsk_preprocess_user_profile (&$vars, $hook) {
  $account = $vars['account'];

  if ($account->profile_real_name):
    $account->profile_real_name_title = $account->content['Personlig informasjon']['profile_real_name']['#title'];
  endif;
  
  if ($account->profile_klubb): 
    $account->profile_klubb_title = $account->content['Personlig informasjon']['profile_klubb']['#title'];
  endif;
  
  if ($account->profile_homepage):
    $account->profile_homepage = "<a href=\"" . $account->profile_homepage . '" ' . "target=\"_blank\" >" . $account->profile_homepage . "</a>";
    $account->profile_homepage_title = $account->content['Personlig informasjon']['profile_homepage']['#title'];
  endif;
  
  $account->member_for = ($account->content['summary']['member_for']['#value']);
  $account->member_for_title = ($account->content['summary']['member_for']['#title']);
}

function tbsk_service_links_node_format($links) {
  return '<div class="service-links"><div class="service-label">'. t('Bookmark/Search this post with: ') .theme('links', $links) .'</div></div>';
}

function tbsk_taxonomy_term_page($tids, $result) {
  drupal_add_css(drupal_get_path('module', 'taxonomy') .'/taxonomy.css');
  $output = '';
  // Only display the description if we have a single term, to avoid clutter and confusion.
  if (count($tids) == 1) {
    $term = taxonomy_get_term($tids[0]);
    $description = $term->description;
    // Check that a description is set.
    if (!empty($description)) {
      $output .= '<div class="taxonomy-term-description">';
      $output .= filter_xss_admin($description);
      $output .= '</div>';
      $output = '';
    }
  }
  $output .= taxonomy_render_nodes($result);
  return $output;
}

function tbsk_preprocess_fieldgroup_simple(&$vars) {
  if ($vars['group_name'] == 'group_info') {
    $node = $vars['element']['#node'];
    $bruker = user_load($node->uid);
    global $base_url, $base_path, $base_root;

    if ($bruker->profile_real_name):
      $real_name = ('<div class="field"><div class="field field-label-inline-first">' . t('Seiler') . ':</div> <a href="' . $base_url . $base_path . 'user/' . $bruker->uid . '">' . check_plain($bruker->profile_real_name) . '</a></div>');
     else:
      $real_name = ('<div class="field-label"><div class="field field-label-inline-first">' . t('Seiler') . ':</div><a href="' . $base_url . $base_path . 'user/' . $bruker->uid . '">' . $bruker->name . '</a></div>');
    endif;
    
    if ($bruker->profile_klubb):
      $klubb = ('<div class="field"><div class="field field-label-inline-first">' . t('Klubb') . ':</div> ' . check_plain($bruker->profile_klubb) . '</div>');
     else:
      $klubb = ('<div class="field"><div class="field field-label-inline-first">' . t('Klubb') . ':</div>' . t("Ingen klubb") . '</div>');
    endif;

    $vars['content'] = $real_name . $klubb . $vars['content'];
    //dpm($node->uid);
  }
}
