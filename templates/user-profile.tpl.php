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
<div class="clearfix">
  <div id="user-region1" class="clearfix">
    <div class="user-picture">
      <?php if ($account->picture): ?>
        <?php print $profile['user_picture']; ?>
      <?php else: ?>
        <div class="picture missing">
          <h2>Brukerbilde mangler</h2>
        </div>
      <?php endif; ?>
      <div>
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
      </div>
    </div>
    <?php $finn = '<div class="view-content">'; ?>
    <?php $innhold = (views_embed_view('user_bilder', $display_id='default')); ?>
    <?php if ($position = strrpos ($innhold, $finn)): ?>
      <h3>Nyeste bilder</h3>
      <?php print (views_embed_view('user_bilder', $display_id='default')); ?>
    <?php else: ?>
      Brukeren har ikke laste opp noen bilder.
    <?php endif; ?>
  </div>

  <div id="user-region2" class="clearfix">
    <div class="profile">
      <?php if ($account->profile_about_me): ?>
        <div class="title">
          <?php if (! $logged_in): ?>
            <div class="button right clearfix">
              <a href="/user">Logg inn</a>
            </div>
          <?php endif; ?>
        
          <?php if ($account->uid == $user->uid): ?>
            <span class="button right clearfix">
              <a class="test" href="<?php print $base_path; ?>user/<?php print $user->uid;?>/edit/Personlig informasjon?destination=<?php print $base_path; ?>user/<?php print $user->uid; ?>">Rediger</a>
            </span>
          <?php endif; ?>
          <h3>Om meg</h3>
        </div> <!-- .title -->
      
        <?php print $account->profile_about_me; ?>

      <?php else: ?>
        <div class"title">
          <?php if (! $logged_in): ?>
            <div class="button right clearfix">
              <a href="/user">Logg inn</a>
            </div>
          <?php endif; ?>
          <h3>Om meg</h3>
        </div>
        <p>Dessverre har ikke brukeren gitt noe informasjon om seg selv og hvor enorm god han/hun er til å seile.</p>
      <?php endif; ?>
    </div> <!-- .profile -->
  
    <div class="user_log">
      <?php $finn = '<div class="view-content">'; ?>
      <?php $innhold = (views_embed_view('user_log', $display_id = 'block_1')); ?>
      <?php if ($position = strrpos ($innhold, $finn)): ?>
        <div class="title">
          <?php if ($account->uid == $user->uid): ?>
            <span class="button right clearfix">
              <a href="/node/add/loggen">Opprett logg</a>
            </span>
          <?php endif; ?>
          <h3>Siste seilaser</h3>
        </div>
        <?php print (views_embed_view('user_log', $display_id = 'block_1')); ?>
      <?php else: ?>
        <h3>Krise</h3>Brukeren har ikke registert en eneste seilas. Landligge eller kronisk latskap?
      <?php endif; ?>
    </div>
  </div>
</div>