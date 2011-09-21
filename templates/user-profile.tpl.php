<?php
// $Id: user-profile.tpl.php,v 1.2.2.2 2009/10/06 11:50:06 goba Exp $

/**
 * @file user-profile.tpl.php
 * Default theme implementation to present all user profile data.
 *
 * This template is used when viewing a registered member's profile page,
 * e.g., example.com/user/123. 123 being the users ID.
 *
 * By default, all user profile data is printed out with the $user_profile
 * variable. If there is a need to break it up you can use $profile instead.
 * It is keyed to the name of each category or other data attached to the
 * account. If it is a category it will contain all the profile items. By
 * default $profile['summary'] is provided which contains data on the user's
 * history. Other data can be included by modules. $profile['user_picture'] is
 * available by default showing the account picture.
 *
 * Also keep in mind that profile items and their categories can be defined by
 * site administrators. They are also available within $profile. For example,
 * if a site is configured with a category of "contact" with
 * fields for of addresses, phone numbers and other related info, then doing a
 * straight print of $profile['contact'] will output everything in the
 * category. This is useful for altering source order and adding custom
 * markup for the group.
 *
 * To check for all available data within $profile, use the code below.
 * @code
 *   print '<pre>'. check_plain(print_r($profile, 1)) .'</pre>';
 * @endcode
 *
 * Available variables:
 *   - $user_profile: All user profile data. Ready for print.
 *   - $profile: Keyed array of profile categories and their items or other data
 *     provided by modules.
 *
 * @see user-profile-category.tpl.php
 *   Where the html is handled for the group.
 * @see user-profile-item.tpl.php
 *   Where the html is handled for each item in the group.
 * @see template_preprocess_user_profile()
 */

global $base_url, $base_path, $base_root;

?>
<div class="clearfix profile">
  <div id="user-region1" class="clearfix">
  
    <div class="user-picture">
      <?php if ($account->picture): ?>
        <?php print $profile['user_picture']; ?>
      <?php else: ?>
        <h2 class="picture missing"><?php print t('Brukerbilde mangler'); ?></h2>
      <?php endif; ?>
    </div> <!--user-picture-->
      
    <table>
      <tbody>
        <?php if ($account->profile_real_name): ?>
          <tr class="first odd">
            <td class="tittel"><?php print $account->profile_real_name_title; ?></td>
            <td><?php print $account->profile_real_name; ?></td>
          </tr>
        <?php endif; ?>
        <?php if ($account->profile_klubb): ?>
          <tr class="even">
            <td class="tittel"><?php print $account->profile_klubb_title ?></td>
            <td><?php print $account->profile_klubb ?></td>
          </tr>
        <?php endif; ?>
        <?php if ($account->profile_homepage): ?>
          <tr class="odd">
            <td class="tittel"><?php print $account->profile_homepage_title ?></td>
            <td><?php print $account->profile_homepage ?></td>
          </tr>
        <?php endif; ?>
          <tr class="last even">
            <td class="tittel"><?php print $account->member_for_title; ?></td>
            <td><?php print $account->member_for; ?></td>
          </tr>
      </tbody>
    </table>
      
    <?php $finn = '<div class="view-content">'; ?>
    <?php $innhold = (views_embed_view('user_bilder', $display_id='default')); ?>

    <?php if ($position = strrpos ($innhold, $finn)): ?>
      <h3 class="title">Nyeste bilder</h3>
      <?php print (views_embed_view('user_bilder', $display_id='default')); ?>
    <?php else: ?>
      <?php print t('Brukeren har ikke enda lastet opp noen bilder'); ?>
    <?php endif; ?>
  </div> <!--user-region1-->

  <div id="user-region2" class="clearfix">
    <?php $destination = drupal_get_destination(); ?>
    <?php $path = drupal_get_path_alias($_GET['q']); ?>
    <?php $destination = '?destination=' . $path; ?>
    <?php dpm($destination); ?>

    <?php if (! $logged_in): ?>
      <div class="button right clearfix">
        <a href="/user">Logg inn</a>
      </div>
    <?php endif; ?>

    <?php if ($account->profile_about_me): ?>
      
      <?php if ($account->uid == $user->uid): ?>
        <span class="button right clearfix">
          <a href="<?php print($base_path . 'user/' . $user->uid . '/edit/Personlig%20informasjon' . $destination); ?>">Rediger</a>
        </span>
      <?php endif; ?>
      <h3 class="title">Om meg</h3>
      <?php print $account->profile_about_me; ?>
    <?php else: ?>
      <h3 class"title">Om meg</h3>
      <?php print t('Dessverre har ikke brukeren gitt noe informasjon om seg selv og hvor enorm god han/hun er til å seile.'); ?>
    <?php endif; ?>
  
    <div class="user_log">
      <?php $finn = '<div class="view-content">'; ?>
      <?php $innhold = (views_embed_view('user_log', $display_id = 'block_1')); ?>
      <?php if ($position = strrpos ($innhold, $finn)): ?>

        <?php if ($account->uid == $user->uid): ?>
          <span class="button right clearfix">
            <a href="/node/add/loggen<?php print $destination; ?>">Opprett logg</a>
          </span>
        <?php endif; ?>

        <h3 class="title">Siste seilaser</h3>
        <?php print (views_embed_view('user_log', $display_id = 'block_1')); ?>

      <?php else: ?>
        <h3 class="title"><?php print t('Siste seilaser'); ?></h3>
        <?php print t('Brukeren har ikke registert noe fysikt aktivitet'); ?>
      <?php endif; ?>
    </div>

  </div> <!--user-region2-->
</div>
