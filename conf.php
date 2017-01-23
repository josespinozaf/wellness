<link rel="stylesheet" type="text/css" href="style.css" media="screen">
<style>
<?php
include ("style.css");
?>
</style>
<?php
require_once (dirname ( __FILE__ ) . '/../../config.php');
global $USER, $CFG, $DB, $db;
require_once ($CFG->dirroot . '/my/lib.php');
redirect_if_major_upgrade_required ();
include ("connect.php");
$edit = optional_param ( 'edit', null, PARAM_BOOL ); // Turn editing on and off
$reset = optional_param ( 'reset', null, PARAM_BOOL );

require_login ();

$hassiteconfig = has_capability ( 'moodle/site:config', context_system::instance () );
if ($hassiteconfig && moodle_needs_upgrading ()) {
	redirect ( new moodle_url ( '/admin/index.php' ) );
}

$strmymoodle = get_string ( 'myhome' );

if (isguestuser ()) { // Force them to see system default, no editing allowed
                     // If guests are not allowed my moodle, send them to front page.
	if (empty ( $CFG->allowguestmymoodle )) {
		redirect ( new moodle_url ( '/', array (
				'redirect' => 0 
		) ) );
	}
	
	$userid = null;
	$USER->editing = $edit = 0; // Just in case
	$context = context_system::instance ();
	$PAGE->set_blocks_editing_capability ( 'moodle/my:configsyspages' ); // unlikely :)
	$header = "$SITE->shortname: $strmymoodle (GUEST)";
	$pagetitle = $header;
} else { // We are trying to view or edit our own My Moodle page
	$userid = $USER->id; // Owner of the page
	$context = context_user::instance ( $USER->id );
	$PAGE->set_blocks_editing_capability ( 'moodle/my:manageblocks' );
	$header = fullname ( $USER );
	$pagetitle = $strmymoodle;
}

// Get the My Moodle page info. Should always return something unless the database is broken.
if (! $currentpage = my_get_page ( $userid, MY_PAGE_PRIVATE )) {
	print_error ( 'mymoodlesetup' );
}

$userid= $USER->id;
$usermail= $USER->email;

?>