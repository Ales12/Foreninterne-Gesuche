<?php

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
    die("Direct initialization of this file is not allowed.");
}

/*
 * Hier befinden sich alle Hooks
 */
$plugins->add_hook('global_start', 'wanted_header_menu');
$plugins->add_hook('global_start', 'wanted_new');
$plugins->add_hook('misc_start', 'wanted_new_misc');
$plugins->add_hook('misc_start', 'wanted_add');
$plugins->add_hook('misc_start', 'wanted_show');
$plugins->add_hook('misc_start', 'wanted_show_own');
$plugins->add_hook('misc_start', 'wanted');


function gesuche_info()
{
    return array(
        "name"			=> "Foreninterne Gesuche",
        "description"	=> "Übersicht von Foreninterne Gesuche",
        "website"		=> "",
        "author"		=> "Ales",
        "authorsite"	=> "http://storming-gates.de/member.php?action=profile&uid=279",
        "version"		=> "2.0",
        "guid" 			=> "",
        "codename"		=> "",
        "compatibility" => "*"
    );
}

function gesuche_install()
{
    global $db;

    if($db->engine=='mysql'||$db->engine=='mysqli')
    {
        $db->query("CREATE TABLE `".TABLE_PREFIX."gesuche` (
          `geid` int(10) NOT NULL auto_increment,
          `uid` int(10) NOT NULL,
          `type` varchar(255) CHARACTER SET utf8 NOT NULL,
          `w_wanted` varchar(255) CHARACTER SET utf8 NOT NULL,
          `w_relation` varchar(255) CHARACTER SET utf8,
          `w_postfre` int(10),
          `w_disc` varchar(65535) CHARACTER SET utf8,
          `w_avatar` varchar(255) CHARACTER SET utf8,
          `w_datum` int(50) NOT NULL,
          PRIMARY KEY (`geid`)
        ) ENGINE=MyISAM".$db->build_create_table_collation());
    }

    $db->query("ALTER TABLE `".TABLE_PREFIX."users` ADD `w_seen` int(10) NOT NULL default '0' AFTER `sourceeditor`;");

//Templates
    $insert_array = array(
        'title' => 'wanted_welcome',
        'template' => $db->escape_string('<html>
<head>
<title>{$mybb->settings[\'bbname\']} - Willkommen bei Interne Gesuche</title>
{$headerinclude}
</head>
<body>
{$header}
<table width="100%" border="0" align="center">
<tr>	
{$forenintern_menu}
<td valign="top">	<table width="100%"><tr><td colspan="2" class="thead"><strong>Willkommen bei Interne Gesuche</strong></td></tr><tr><td class="trow1" align="center"><h1>Willkommen bei Interne Gesuche</h1>
	<br />
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Sed aliquam ultrices mauris. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Praesent adipiscing. Phasellus ullamcorper ipsum rutrum nunc. Nunc nonummy metus. Vestibulum volutpat pretium libero. Cras id dui. Aenean ut
	</td></tr></table>
</td>
</tr>
</table>
{$footer}
</body>
</html>'),
        'sid' => '-1',
        'version' => '',
        'dateline' => TIME_NOW
    );
    $db->insert_query("templates", $insert_array);

    $insert_array = array(
        'title' => 'wanted_add',
        'template' => $db->escape_string('<html>
<head>
<title>{$mybb->settings[\'bbname\']} - Internes Gesuch einreichen</title>
{$headerinclude}
</head>
<body>
{$header}
<table width="100%" border="0" align="center">
<tr>	
{$forenintern_menu}
<td valign="top">	<table width="100%"><tr><td colspan="2" class="thead"><strong>Foreninterne Gesuche einfügen</strong></td></tr><tr><td class="trow1" align="center">
<form id="wanted" method="post" action="misc.php?action=wantedadd">

		<table width="60%">
<tr><td class="trow1"><strong>Wer wird gesucht?</strong>
	<div class="smalltext">hier kannst du in einen Wort sagen, was gesucht wird. Zum Beispiel Namen, Bezeichnung etc.</div></td><td width="400px" class="trow2"><input id="w_wanted" name="w_wanted" type="text" class="textbox"  style="width: 95%" /></td></tr>
			<tr><td class="trow1"><strong>Postfrequenz</strong>
				<div class="smalltext">Was ist denn deine eigene Postfrequenz. (nur Zahlen eingeben)</div></td><td width="400px" class="trow2"><input id="w_postfre" name="w_postfre" type="text" class="textbox"  style="width: 95%" /></td></tr>
<tr><td class="trow1"><strong>Beziehungswünsche</strong>
	<div class="smalltext">Hast du Beziehungswünsche?</div></td><td width="400px" class="trow2"><input id="w_relation" name="w_relation" type="text" class="textbox"  style="width: 95%" /></td></tr>
<tr><td class="trow1"><strong>Weitere Informationen</strong>
	<div class="smalltext">Gebe hier alle weitere Informationen an, die du für wichtig hältst. Zum Beispiel <i>Alter, Beruf, Wohnort etc.</i>. Vergiss aber nicht, durch den Befehl br gewünschte Zeilenumbrüche einzufügen.</td><td width="400px" class="trow2"><textarea class="textarea" name="w_disc" id="w_disc" rows="6" cols="30" style="width: 95%"></textarea></td></tr>
			<tr><td class="trow1"><strong>Avatarvorschläge</strong>
				<div class="smalltext">Hast du Avatarvorschläge? Dann füge es hier ein.</td><td width="400px" class="trow2"><input id="w_avatar" name="w_avatar" type="text" class="textbox"  style="width: 95%" /></td></tr>
			<tr><td class="trow2" colspan="2"><div align="center">
						<input type="submit" name="wanted" value="einreichen" id="submit" class="button">
				</div></td></tr>
</table>

			</form></td></tr></table>
</td>
</tr>
</table>
{$footer}
</body>
</html>'),
        'sid' => '-1',
        'version' => '',
        'dateline' => TIME_NOW
    );
    $db->insert_query("templates", $insert_array);


    $insert_array = array(
        'title' => 'wanted_menu',
        'template' => $db->escape_string('<td width="180px" valign="top">
	<table class="tborder">
		<tr><td class="thead">Menü</td></tr>
		<tr><td class="trow1"><a href="misc.php?action=wantedadd">Internes Gesuch einreichen</a></td></tr>
		<tr><td class="trow2"><a href="misc.php?action=wantedshow">Internegesuche anzeigen</a></td></tr>
		<tr><td class="trow1"><a href="misc.php?action=wantedshowown">eigene Gesuche anzeigen</a></td></tr>
	</table>
</td>'),
        'sid' => '-1',
        'version' => '',
        'dateline' => TIME_NOW
    );

    $db->insert_query("templates", $insert_array);

    $insert_array = array(
        'title' => 'wanted_show',
        'template' => $db->escape_string('<html>
<head>
<title>{$mybb->settings[\'bbname\']} - Alle Interne Gesuche anzeigen</title>
{$headerinclude}
</head>
<body>
{$header}
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>	
{$forenintern_menu}
<td valign="top">
<table width="100%">
	<tr><td class="thead"><h1>Foreninterne Gesuche</h1>
		</td></tr>
<tr><td class="trow1"><div class="wanted_show">
	{$wanted_show_bit_user}
	</div>	</td>
</tr>
</table>
</td>
</tr>
</table>
{$footer}
</body>
</html>'),
        'sid' => '-1',
        'version' => '',
        'dateline' => TIME_NOW
    );

    $db->insert_query("templates", $insert_array);

    $insert_array = array(
        'title' => 'wanted_show_bit',
        'template' => $db->escape_string('<div class="gesucheMitg">
	<div class="gesuchUntertitel">Gesucht wird</div>
	<div class="gesuchName">{$wanted}</div>
	<div class="gesuchUntertitel">von {$user}</div>
<div style="height: 200px; margin-bottom: 3px;">
{$relationen}
{$postfre}
{$disc}
{$avatar}
	</div>
	<div class="gesuchErstellt">Gesucht seit <b>{$datum}</b></div>
	<div class="gesuchOptionen">{$delete} {$ueber} {$edit}</div>
</div>'),
        'sid' => '-1',
        'version' => '',
        'dateline' => TIME_NOW
    );

    $db->insert_query("templates", $insert_array);

    $insert_array = array(
        'title' => 'wanted_show_edit',
        'template' => $db->escape_string('<style>.infopop { position: fixed; top: 0; right: 0; bottom: 0; left: 0; background: hsla(0, 0%, 0%, 0.5); z-index: 1; opacity:0; -webkit-transition: .5s ease-in-out; -moz-transition: .5s ease-in-out; transition: .5s ease-in-out; pointer-events: none; } .infopop:target { opacity:1; pointer-events: auto; } .infopop > .pop {width:50%; position: relative; margin: 10% auto; padding: 25px; z-index: 3; } .closepop { position: absolute; right: -5px; top:-5px; width: 100%; height: 100%; z-index: 2; }</style>
<div id="popinfo$row[geid]" class="infopop">
  <div class="pop"><form method="post" action=""><input type=\'hidden\' value=\'{$row[\'geid\']}\' name=\'getgeid\'>
<table border="0" cellspacing="5" cellpadding="{$theme[\'tablespace\']}" class="tborder" style="margin:auto;" width="100%">
<tr><td class="trow1" width="50%"><strong>Wer wird gesucht?</strong>
	<div class="smalltext">hier kannst du in einen Wort sagen, was gesucht wird. Zum Beispiel Namen, Bezeichnung etc.</div></td>
	<td  width="50%" class="trow2"><input id="w_wanted" name="w_wanted" type="text" class="textbox"  style="width: 95%" value="{$row[\'w_wanted\']}" /></td></tr>
			<tr><td  width="50%" class="trow1"><strong>Postfrequenz</strong>
				<div class="smalltext">Was ist denn deine eigene Postfrequenz. (nur Zahlen eingeben)</div></td>
				<td  width="50%" class="trow2"><input id="w_postfre" name="w_postfre" type="text" class="textbox"  style="width: 95%"  value="{$row[\'w_postfre\']}" /></td></tr>
<tr><td class="trow1" width="50%"><strong>Beziehungswünsche</strong>
	<div class="smalltext">Hast du Beziehungswünsche?</div></td>
	<td  width="50%" class="trow2"><input id="w_relation" name="w_relation" type="text" class="textbox"  style="width: 95%"  value="{$row[\'w_relation\']}" /></td></tr>
<tr><td class="trow1" width="50%"><strong>Weitere Informationen</strong>
	<div class="smalltext">Gebe hier alle weitere Informationen an, die du für wichtig hältst. Zum Beispiel <i>Alter, Beruf, Wohnort etc.</i>. Vergiss aber nicht, durch den Befehl br gewünschte Zeilenumbrüche einzufügen.</td><td  width="50%" class="trow2"><textarea class="textarea" name="w_disc" id="w_disc" rows="6" cols="30" style="width: 95%">{$row[\'w_disc\']}</textarea></td></tr>
			<tr><td class="trow1" width="50%"><strong>Avatarvorschläge</strong>
				<div class="smalltext">Hast du Avatarvorschläge? Dann füge es hier ein.</td><td width="400px" class="trow2"><input id="w_avatar" name="w_avatar" type="text" class="textbox"  style="width: 95%"  value="{$row[\'w_avatar\']}" /></td></tr>
			<tr><td class="trow2" colspan="2"><div align="center">
						<input type="submit" name="editwanted" value="Editieren" id="submit" class="button">
				</div></td></tr></form></table>
		</div><a href="#closepop" class="closepop"></a>
</div>

<a href="#popinfo$row[geid]"><i class="fas fa-edit" aria-hidden="true"></i></a>'),
        'sid' => '-1',
        'version' => '',
        'dateline' => TIME_NOW
    );

    $db->insert_query("templates", $insert_array);

    $insert_array = array(
        'title' => 'wanted_show_own',
        'template' => $db->escape_string('<html>
<head>
<title>{$mybb->settings[\'bbname\']} - Eigene Interne Gesuche anzeigen</title>
{$headerinclude}
</head>
<body>
{$header}
<table width="100%" border="0" align="center">
<tr>	
{$forenintern_menu}
<td valign="top">
<table width="100%">
<tr><td class="thead">Alle eigenen Foreninterne Gesuche</td></tr>
<tr><td class="trow1">
	{$wanted_show_bit_user}
	</td>
</tr>
</table>
</td>
</tr>
</table>
{$footer}
</body>
</html>'),
        'sid' => '-1',
        'version' => '',
        'dateline' => TIME_NOW
    );

    $db->insert_query("templates", $insert_array);

    $insert_array = array(
        'title' => 'wanted_new_alert',
        'template' => $db->escape_string('<div class="pm_alert">
	<strong>Es gibt neue <b>Foreninterne Gesuche</b>. <a href="misc.php?action=wantedshow">Hier</a> kannst du es dir ansehen. {$wanted_read}</strong>
</div>
<br />'),
        'sid' => '-1',
        'version' => '',
        'dateline' => TIME_NOW
    );

    $db->insert_query("templates", $insert_array);
}

function gesuche_is_installed()
{
    global $db;
    if($db->table_exists("gesuche"))
    {
        return true;
    }
    return false;
}

function gesuche_uninstall()
{
    global $db;

    if($db->table_exists("gesuche"))
    {
        $db->drop_table("gesuche");
    }
    if($db->field_exists("w_seen", "users"))
    {
        $db->drop_column("users", "w_seen");
    }


    $db->delete_query("templates", "title LIKE '%wanted%'");
    rebuild_settings();
}

function gesuche_activate()
{
    require MYBB_ROOT."/inc/adminfunctions_templates.php";
    find_replace_templatesets("header", "#".preg_quote('{$pm_notice}')."#i", '{$new_wanted}{$pm_notice}');
}

function gesuche_deactivate()
{
    require MYBB_ROOT."/inc/adminfunctions_templates.php";
    find_replace_templatesets("header", "#".preg_quote('{$new_wanted}')."#i", '', 0);
}

function wanted_header_menu(){

    global $templates, $wanted_forenintern, $mybb ;
    if($mybb->user['uid'] != '0' || $mybb->user['uid'] != ''){
        eval("\$wanted_forenintern = \"" . $templates->get ("wanted_menu") . "\";");
    }


}

function wanted_new()
{
    global $db, $mybb, $templates, $new_wanted, $wanted_read;
    $uid = $mybb->user['uid'];
    $wanted_read = "<a href='misc.php?action=wantedread&read={$uid}'>[als gelesen markieren]</a>";
    $select = $db->query ("SELECT * FROM " . TABLE_PREFIX ."gesuche");

    $row_cnt = mysqli_num_rows ($select);

    if ($row_cnt > 0) {

        $select = $db->query ("SELECT w_seen FROM " . TABLE_PREFIX . "users WHERE uid = '" . $mybb->user['uid'] . "' LIMIT 1");

        $data = $db->fetch_array ($select);
        if ($data['w_seen'] == '0') {

            eval("\$new_wanted = \"" . $templates->get ("wanted_new_alert") . "\";");

        }

    }
}
function wanted_new_misc()
{
    global $db, $mybb, $templates, $lang, $header, $headerinclude, $footer, $page, $uid;

    if ($mybb->get_input ('action') == 'wantedread') {

        //welcher user ist online
        $this_user = intval ($mybb->user['uid']);

//für den fall nicht mit hauptaccount online
        $as_uid = intval ($mybb->user['as_uid']);
        $read = $mybb->input['read'];
        if ($read) {
            if($as_uid == 0){
                $db->query ("UPDATE " . TABLE_PREFIX . "users SET w_seen = 1  WHERE (as_uid = $this_user) OR (uid = $this_user)");
            }elseif ($as_uid != 0){
                $db->query ("UPDATE " . TABLE_PREFIX . "users SET w_seen = 1  WHERE (as_uid = $as_uid) OR (uid = $this_user) OR (uid = $as_uid)");
            }
            redirect("index.php");
        }
    }
}
function wanted()
{
    global $mybb, $templates, $lang, $header, $headerinclude, $footer;

    if($mybb->get_input('action') == 'wanted')
    {
        // Do something, for example I'll create a page using the hello_world_template

        // Add a breadcrumb
        add_breadcrumb('Interne Gesuche', "misc.php?action=wanted");

        //menü
        eval("\$forenintern_menu = \"" . $templates->get("wanted_menu") . "\";");

        // Using the misc_help template for the page wrapper
        eval("\$page = \"".$templates->get("wanted_welcome")."\";");
        output_page($page);
    }
}

// In the body of your plugin
function wanted_add()
{
    global $db, $mybb, $templates, $lang, $header, $headerinclude, $footer, $page, $uid;

    if ($mybb->get_input ('action') == 'wantedadd') {
        if ($mybb->usergroup['gid'] == '1') {

            error_no_permission ();
        } else {

            // Do something, for example I'll create a page using the hello_world_template

            // Add a breadcrumb
            add_breadcrumb ('Foreninterne Gesuche hinzufügen', "misc.php?action=wantedadd");


            if (isset($_POST['wanted'])) {
                $uid = $mybb->user['uid'];
                $wanted = $_POST['w_wanted'];
                $postfre = $_POST['w_postfre'];
                $relation = $_POST['w_relation'];
                $disc = $_POST['w_disc'];
                $avatar = $_POST['w_avatar'];
                $datum = TIME_NOW;

                $new_record = array(
                    "type" => "wanted",
                    "uid" => $db->escape_string ($uid),
                    "w_wanted" => $db->escape_string ($wanted),
                    "w_relation" => $db->escape_string ($relation),
                    "w_postfre" => $db->escape_string ($postfre),
                    "w_disc" => $db->escape_string ($disc),
                    "w_avatar" => $db->escape_string($avatar),
                    "w_datum" => $db->escape_string($datum)
                );

                $db->insert_query ("gesuche", $new_record);
                $db->query("UPDATE ".TABLE_PREFIX."users SET w_seen ='0'");
                redirect ("misc.php?action=wantedshow");
            }
            //menü
            eval("\$forenintern_menu = \"" . $templates->get ("wanted_menu") . "\";");

            //Aufrufen der Page
            eval("\$page = \"" . $templates->get ("wanted_add") . "\";");
            output_page ($page);
        }
    }
}

function wanted_show()
{
    global $db, $mybb, $templates, $lang, $header, $headerinclude, $footer, $page, $uid, $wanted_show_bit, $altbg, $pmhandler, $user, $w_wanted, $w_job, $w_relation, $w_disc;
    require_once MYBB_ROOT . "inc/datahandlers/pm.php";
    $pmhandler = new PMDataHandler();
    require_once MYBB_ROOT."inc/class_parser.php";
    $parser = new postParser;

    $options = array(
        "allow_html" => 1,
        "allow_mycode" => 1,
        "allow_smilies" => 1,
        "allow_imgcode" => $mybb->settings['userpages_images_active'],
        "filter_badwords" => $mybb->settings['userpages_badwords_active'],
        "nl2br" => 1,
        "allow_videocode" => $mybb->settings['userpages_videos_active']
    );

    add_breadcrumb('Foreninterne Gesuche', "misc.php?action=wantedshow");

    if ($mybb->get_input('action') == 'wantedshow') {
        $select = $db->query("SELECT *
        FROM " . TABLE_PREFIX . "gesuche g
        LEFT JOIN " . TABLE_PREFIX . "users u
        ON g.uid = u.uid
        WHERE type = 'wanted'
       ORDER BY w_datum DESC ");

        while ($row = $db->fetch_array($select)) {
            $altbg = alt_trow();
            $username = format_name($row['username'], $row['usergroup'], $row['displaygroup']);
            $user = build_profile_link($username, $row['uid']);
            $datum = my_date("relative", $row['w_datum']);

            $wanted = "";
            $relationen = "";
            $avatar = "";
            $disc = "";
            $postfre = "";

            $uid = $row['uid'];
            if ($mybb->user['modcp'] == 1 OR $mybb->user['admincp'] == 1 OR $mybb->user['uid'] == $row['uid']) {
                $delete = "<a href='misc.php?action=wantedshow&del=$row[geid]' title='Löschen'><i class=\"fas fa-eraser\"></i></a>";
            }
            if ($mybb->user['uid'] != 0) {
                $ueber = "<a href='misc.php?action=wantedshow&ueber=$row[geid]' title='Anfragen'><i class=\"fas fa-envelope-open-text\"></i> </a>";
            } else {
                $ueber = "Keine Bereichtung";
            }

            //Hier sind alle Variabeln, welche nur erscheinen, wenn etwas in der Datenbank steht. Dies bedeutet, dass nicht alle Automatisch angezeigt werden
            $wanted = $row['w_wanted'];

            if ($row['w_relation'] != NULL) {
                $relationen = "<div class=\"gesuchInfo\"><b>Beziehung</b> {$row['w_relation']}</div>";
            }
            if ($row['w_postfre'] != NULL) {
                $row['w_postfre'] = number_format($row['w_postfre'], '0', ',', '.');
                $postfre = "<div class=\"gesuchInfo\"><b>Postfrequenz</b> {$row['w_postfre']} Zeichen</div>";
            }

            if ($row['w_disc'] != NULL) {
                $row['w_disc'] = $parser->parse_message($row['w_disc'], $options);
                $disc = "<div class=\"gesuchInfobox\">{$row['w_disc']}</div>";

            }

            if ($row['w_avatar'] != NULL) {
                $avatar = "<div class=\"gesuchInfo\"><b>Avatarwunsch</b> {$row['w_avatar']}</div>";
            }
            eval("\$wanted_show_bit_user .= \"" . $templates->get("wanted_show_bit") . "\";");
        }

        $del = $mybb->input['del'];
        if ($del) {
            $db->delete_query("gesuche", "geid = '$del'");
            redirect("misc.php?action=wantedshow");
        }
        $uid = $mybb->user['uid'];


        $ueber = $mybb->input['ueber'];
        if ($ueber) {
            $select = $db->query("SELECT * 
          FROM " . TABLE_PREFIX . "gesuche g 
          LEFT JOIN " . TABLE_PREFIX . "users u 
          ON g.uid = u.uid
          WHERE geid = $ueber 
          ");
            $row = $db->fetch_array($select);
            $sucher = $row['uid'];
            $wanted = $row['w_wanted'];
            $pm_change = array(
                "subject" => "Interesse an deinem Foreninternem Gesuch",
                "message" => "Ich habe Interesse zu deinem Gesuch, bei dem du <b>{$wanted}</b> suchst. Melde dich doch bei mir, das wir darüber reden können.",
                //to: wer muss die anfrage bestätigen
                "fromid" => $uid,
                //from: wer hat die anfrage gestellt
                "toid" => $sucher
            );
            // $pmhandler->admin_override = true;
            $pmhandler->set_data($pm_change);
            if (!$pmhandler->validate_pm())
                return false;
            else {
                $pmhandler->insert_pm();
            }
        }
        //menü
        eval("\$forenintern_menu = \"" . $templates->get("wanted_menu") . "\";");

        //Aufrufen der Page
        eval("\$wanted_show_bit .= \"" . $templates->get("wanted_show_bit") . "\";");
        eval("\$page = \"" . $templates->get("wanted_show") . "\";");
        output_page($page);
    }
}
function wanted_show_own()
{
    global $db, $mybb, $templates, $lang, $header, $headerinclude, $footer, $page, $uid, $wanted_show_bit, $altbg, $pmhandler, $user, $w_wanted, $w_job, $w_relation, $w_disc;
    require_once MYBB_ROOT."inc/class_parser.php";
    $parser = new postParser;

    add_breadcrumb('eigene Foreninterne Gesuche', "misc.php?action=wantedshow");

    $options = array(
        "allow_html" => 1,
        "allow_mycode" => 1,
        "allow_smilies" => 1,
        "allow_imgcode" => $mybb->settings['userpages_images_active'],
        "filter_badwords" => $mybb->settings['userpages_badwords_active'],
        "nl2br" => 1,
        "allow_videocode" => $mybb->settings['userpages_videos_active']
    );

    if ($mybb->get_input('action') == 'wantedshowown') {

        //welcher user ist online
        $this_user = intval($mybb->user['uid']);

//für den fall nicht mit hauptaccount online
        $as_uid = intval($mybb->user['as_uid']);

// suche alle angehangenen accounts

        if ($as_uid == 0) {
            $select = $db->query("SELECT *
        FROM " . TABLE_PREFIX . "gesuche g
        LEFT JOIN " . TABLE_PREFIX . "users u
        ON g.uid = u.uid
        WHERE type = 'wanted'
       AND (u.as_uid = $this_user) OR (u.uid = $this_user)
       ORDER BY w_datum DESC ");
        }elseif($as_uid != 0){
            $select = $db->query("SELECT *
        FROM " . TABLE_PREFIX . "gesuche g
        LEFT JOIN " . TABLE_PREFIX . "users u
        ON g.uid = u.uid
        WHERE type = 'wanted'
       AND (u.as_uid = $as_uid) OR (u.uid = $this_user) OR (u.uid = $as_uid)
       ORDER BY w_datum DESC ");
        }
        while ($row = $db->fetch_array($select)) {
            $altbg = alt_trow();
            $username = format_name($row['username'], $row['usergroup'], $row['displaygroup']);
            $user = build_profile_link($username, $row['uid']);
            $datum = my_date("relative", $row['w_datum']);

            $wanted = "";
            $relationen = "";
            $avatar = "";
            $disc = "";
            $postfre = "";

            $uid = $row['uid'];

            $delete = "<a href='misc.php?action=wantedshow&del=$row[geid]' title='Löschen'><i class=\"fas fa-eraser\"></i></a>";
            eval("\$edit = \"" . $templates->get ("wanted_show_edit") . "\";");

            //Hier sind alle Variabeln, welche nur erscheinen, wenn etwas in der Datenbank steht. Dies bedeutet, dass nicht alle Automatisch angezeigt werden
            $wanted = $row['w_wanted'];

            if ($row['w_relation'] != NULL) {
                $relationen = "<div class=\"gesuchInfo\"><b>Beziehung</b> {$row['w_relation']}</div>";
            }
            if ($row['w_postfre'] != NULL) {
                $row['w_postfre'] = number_format($row['w_postfre'], '0', ',', '.');
                $postfre = "<div class=\"gesuchInfo\"><b>Postfrequenz</b> {$row['w_postfre']} Zeichen</div>";
            }

            if ($row['w_disc'] != NULL) {
                $row['w_disc'] = $parser->parse_message($row['w_disc'], $options);
                $disc = "<div class=\"gesuchInfobox\">{$row['w_disc']}</div>";
            }

            if ($row['w_avatar'] != NULL) {
                $avatar = "<div class=\"gesuchInfo\"><b>Avatarwunsch</b> {$row['w_avatar']}</div>";
            }
            eval("\$wanted_show_bit_user .= \"" . $templates->get("wanted_show_bit") . "\";");
        }


        //Gesuche löschen
        $del = $mybb->input['del'];
        if ($del) {
            $db->delete_query("gesuche", "geid = '$del'");
            redirect("misc.php?action=wantedshow");
        }
        $uid = $mybb->user['uid'];

        //Gesuche editieren
        if(isset($mybb->input['editwanted'])){
            $getgeid = $mybb->input['getgeid'];
            $w_wanted = $mybb->input['w_wanted'];
            $w_postfre = $mybb->input['w_postfre'];
            $w_relation = $mybb->input['w_relation'];
            $w_disc = $db->escape_string($mybb->input['w_disc']);
            $w_avatar = $mybb->input['w_disc'];

            $db->query("UPDATE ".TABLE_PREFIX."gesuche SET w_wanted ='".$w_wanted."', w_postfre = '".$w_postfre."', w_relation = '".$w_relation."', w_disc = '".$w_disc."',  w_avatar = '".$w_avatar."' WHERE geid = '".$getgeid."'");

            //Umleitung auf die Seite
            redirect("misc.php?action=wantedshowown");
        }


        //menü
        eval("\$forenintern_menu = \"" . $templates->get("wanted_menu") . "\";");

        //Aufrufen der Page
        eval("\$page = \"" . $templates->get("wanted_show_own") . "\";");
        output_page($page);
    }
}
