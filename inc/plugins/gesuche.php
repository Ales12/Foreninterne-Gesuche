<?php

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
    die("Direct initialization of this file is not allowed.");
}

/*
 * Hier befinden sich alle Hooks
 */
$plugins->add_hook('global_start', 'forenwanted_global');
$plugins->add_hook('misc_start', 'forenwanted');


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
          `w_title` varchar(255) CHARACTER SET utf8 NOT NULL,
          `w_wanted` varchar(255) CHARACTER SET utf8 NOT NULL,
          `w_relation` varchar(255) CHARACTER SET utf8,
          `w_postfre` varchar(255) CHARACTER SET utf8,
          `w_disc` mediumtext CHARACTER SET utf8,
          `w_avatar` varchar(255) CHARACTER SET utf8,
          `w_datum` int(50) NOT NULL,
          `w_status` VARCHAR(255) NOT NULL DEFAULT 'frei',
          PRIMARY KEY (`geid`)
        ) ENGINE=MyISAM".$db->build_create_table_collation());
    }

    $db->query("ALTER TABLE `".TABLE_PREFIX."users` ADD `w_seen` int(10) NOT NULL default '0' AFTER `sourceeditor`;");

//Templates
    $insert_array = array(
        'title' => 'forenwanted_add',
        'template' => $db->escape_string('<html>
<head>
<title>{$mybb->settings[\'bbname\']} - {$lang->forenwanted_add}</title>
{$headerinclude}
</head>
<body>
{$header}
<table width="100%" border="0" align="center">
<tr>	
{$forenintern_menu}
<td valign="top">	<table width="100%"><tr><td colspan="2" class="thead"><strong>{$lang->forenwanted_add}</strong></td></tr><tr><td class="trow1" align="center">
<form id="forenwanted" method="post" action="misc.php?action=forenwantedadd">

		<table width="90%">
			<tr><td class="trow1"><strong>{$lang->forenwanted_title}</strong>
	<div class="smalltext">{$lang->forenwanted_title_desc}</div></td><td width="400px" class="trow2"><input id="w_title" name="w_title" type="text" class="textbox"  style="width: 95%" /></td></tr>
<tr><td class="trow1"><strong>{$lang->forenwanted_who}</strong>
	<div class="smalltext">{$lang->forenwanted_who_desc}</div></td><td width="400px" class="trow2"><input id="w_wanted" name="w_wanted" type="text" class="textbox"  style="width: 95%" /></td></tr>
			<tr><td class="trow1"><strong>{$lang->forenwanted_postfrequ}</strong>
				<div class="smalltext">{$lang->forenwanted_postfrequ_desc}</div></td><td width="400px" class="trow2"><input id="w_postfre" name="w_postfre" type="text" class="textbox"  style="width: 95%" /></td></tr>
<tr><td class="trow1"><strong>{$lang->forenwanted_rela}</strong>
	<div class="smalltext">{$lang->forenwanted_rela_desc}</div></td><td width="400px" class="trow2"><input id="w_relation" name="w_relation" type="text" class="textbox"  style="width: 95%" /></td></tr>
<tr><td class="trow1"><strong>{$lang->forenwanted_story}</strong>
	<div class="smalltext">{$lang->forenwanted_story_desc}</div></td><td width="400px" class="trow2"><textarea class="textarea" name="w_disc" id="w_disc" rows="6" cols="30" style="width: 95%"></textarea></td></tr>
			<tr><td class="trow1"><strong>{$lang->forenwanted_ava}</strong>
	<div class="smalltext">{$lang->forenwanted_ava_desc}</div></td></td><td width="400px" class="trow2"><input id="w_avatar" name="w_avatar" type="text" class="textbox"  style="width: 95%" /></td></tr>
			<tr><td class="trow2" colspan="2"><div align="center">
						<input type="submit" name="forenwanted" value="einreichen" id="submit" class="button">
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
        'title' => 'forenwanted_menu',
        'template' => $db->escape_string('<td width="180px" valign="top">
	<table class="tborder">
		<tr><td class="thead">{$lang->forenwanted_menu}</td></tr>
		<tr><td class="trow2"><a href="misc.php?action=forenwanted">{$lang->forenwanted}</a></td></tr>
		<tr><td class="trow1"><a href="misc.php?action=forenwantedadd">{$lang->forenwanted_add}</a></td></tr>
		<tr><td class="trow1"><a href="misc.php?action=forenwantedown">{$lang->forenwanted_own}</a></td></tr>
	</table>
</td>'),
        'sid' => '-1',
        'version' => '',
        'dateline' => TIME_NOW
    );

    $db->insert_query("templates", $insert_array);

    $insert_array = array(
        'title' => 'forenwanted_show',
        'template' => $db->escape_string('<html>
<head>
<title>{$mybb->settings[\'bbname\']} - {$lang->forenwanted}</title>
{$headerinclude}
</head>
<body>
{$header}
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>	
{$forenintern_menu}
<td valign="top">
<table width="100%">
	<tr><td class="thead"><strong>{$lang->forenwanted}</h1>
		</td></tr>
<tr><td class="trow1"><div class="forenwanted_show">
	{$forenwanted_show_bit_user}
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
        'title' => 'forenwanted_show_bit',
        'template' => $db->escape_string('<div class="wanted_show_bit">
	{$title}
	<div class="gesuchUntertitel">Gesucht wird</div>
	<div class="gesuchName">{$forenwanted}</div>
	<div class="gesuchUntertitel">von {$user}</div>
	<div class="gesuchInfo"><b>{$lang->forenwanted_status}</b> {$status}</div>
{$relationen}
{$postfre}
{$disc}
{$avatar}
	<div class="gesuchErstellt">Gesucht seit <b>{$datum}</b></div>
	<div class="gesuchOptionen">{$delete} {$ueber} {$edit}</div>
</div>'),
        'sid' => '-1',
        'version' => '',
        'dateline' => TIME_NOW
    );

    $db->insert_query("templates", $insert_array);

    $insert_array = array(
        'title' => 'forenwanted_show_edit',
        'template' => $db->escape_string('<style>.infopop { position: fixed; top: 0; right: 0; bottom: 0; left: 0; background: hsla(0, 0%, 0%, 0.5); z-index: 1; opacity:0; -webkit-transition: .5s ease-in-out; -moz-transition: .5s ease-in-out; transition: .5s ease-in-out; pointer-events: none; } .infopop:target { opacity:1; pointer-events: auto; } .infopop > .pop {width:50%; position: relative; margin: 10% auto; padding: 25px; z-index: 3; } .closepop { position: absolute; right: -5px; top:-5px; width: 100%; height: 100%; z-index: 2; }</style>
<div id="popinfo$row[geid]" class="infopop">
  <div class="pop"><form method="post" action=""><input type=\'hidden\' value=\'{$row[\'geid\']}\' name=\'getgeid\'>
<table border="0" cellspacing="5" cellpadding="{$theme[\'tablespace\']}" class="tborder" style="margin:auto;" width="100%">
				<tr><td class="trow1" width="50%"><strong>{$lang->forenwanted_status}</strong>
	<div class="smalltext">{$lang->forenwanted_status_desc}</div></td><td width="400px" class="trow2"><input id="w_status" name="w_status" type="text" class="textbox"  style="width: 95%"  value="{$row[\'w_status\']}" /></td></tr>
	<tr><td class="trow1"><strong>{$lang->forenwanted_title}</strong>
	<div class="smalltext">{$lang->forenwanted_title_desc}</div></td></td>
	<td  width="50%" class="trow2"><input id="w_title" name="w_title" type="text" class="textbox"  style="width: 95%" value="{$row[\'w_title\']}" /></td></tr>
<tr><td class="trow1" width="50%"><strong>{$lang->forenwanted_who}</strong>
	<div class="smalltext">{$lang->forenwanted_who_desc}</div></td>
	<td  width="50%" class="trow2"><input id="w_wanted" name="w_wanted" type="text" class="textbox"  style="width: 95%" value="{$row[\'w_wanted\']}" /></td></tr>
			<tr><td  width="50%" class="trow1"><strong>{$lang->forenwanted_postfrequ}</strong>
				<div class="smalltext">{$lang->forenwanted_postfrequ_desc}</div></td>
				<td  width="50%" class="trow2"><input id="w_postfre" name="w_postfre" type="text" class="textbox"  style="width: 95%"  value="{$row[\'w_postfre\']}" /></td></tr>
<tr><td class="trow1" width="50%"><strong>{$lang->forenwanted_rela}</strong>
	<div class="smalltext">{$lang->forenwanted_rela_desc}</div></td>
	<td  width="50%" class="trow2"><input id="w_relation" name="w_relation" type="text" class="textbox"  style="width: 95%"  value="{$row[\'w_relation\']}" /></td></tr>
<tr><td class="trow1" width="50%"><strong>{$lang->forenwanted_story}</strong>
	<div class="smalltext">{$lang->forenwanted_story_desc}</div></td><td  width="50%" class="trow2"><textarea class="textarea" name="w_disc" id="w_disc" rows="6" cols="30" style="width: 95%">{$row[\'w_disc\']}</textarea></td></tr>
			<tr><td class="trow1" width="50%"><strong>{$lang->forenwanted_ava}</strong>
	<div class="smalltext">{$lang->forenwanted_ava_desc}</div></td><td width="400px" class="trow2"><input id="w_avatar" name="w_avatar" type="text" class="textbox"  style="width: 95%"  value="{$row[\'w_avatar\']}" /></td></tr>
			<tr><td class="trow2" colspan="2"><div align="center">
						<input type="submit" name="editforenwanted" value="Editieren" id="submit" class="button">
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
        'title' => 'forenwanted_show_own',
        'template' => $db->escape_string('<html>
<head>
<title>{$mybb->settings[\'bbname\']} - {$lang->forenwanted_own}</title>
{$headerinclude}
</head>
<body>
{$header}
<table width="100%" border="0" align="center">
<tr>	
{$forenintern_menu}
<td valign="top">
<table width="100%">
<tr><td class="thead">{$lang->forenwanted_own}</td></tr>
<tr><td class="trow1"><div class="forenwanted_show">
	{$forenwanted_show_bit_user}
	</div></td>
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
        'title' => 'forenwanted_new_alert',
        'template' => $db->escape_string('<div class="pm_alert">
	<strong>{$lang->forenwanted_alert} {$forenwanted_read}</strong>
</div>
<br />'),
        'sid' => '-1',
        'version' => '',
        'dateline' => TIME_NOW
    );

    $db->insert_query("templates", $insert_array);

    //CSS einfügen
    $css = array(
        'name' => 'foreninterne gesuche.css',
        'tid' => 1,
        'attachedto' => '',
        "stylesheet" =>    '.forenwanted_show{
     display: flex;
  flex-wrap: wrap;
}

.forenwanted_show > .forenwanted_show_bit{
    width:345px;
    height: auto;
margin:4px;
    padding: 4px;
    box-sizing: border-box;
   
}

.gesucheTitle{
text-align: center;
font-size: 13px;
}

.gesuchName{
font-size: 15px;
	text-align: center;
	color: #0066a2;
	font-weight: bold;
}

.gesuchUntertitel{
text-align: center;
font-size: 13px;
}

.gesuchInfo{
font-size: 12px;
}

.gesuchInfobox{
height: 190px;
	overflow: auto;
	font-size: 12px;
}

.gesuchInfo b{
color: #0072BC;
font-weight: 600;
}

.gesuchErstellt{
font-size: 11px;
}

.gesuchOptionen{
text-align: center;
}

.gesuchOptionen i{
text-align: center;
width: 30px;
}
        
        ',
        'cachefile' => $db->escape_string(str_replace('/', '', 'foreninterne gesuche.css')),
        'lastmodified' => time()
    );

    require_once MYBB_ADMIN_DIR . "inc/functions_themes.php";

    $sid = $db->insert_query("themestylesheets", $css);
    $db->update_query("themestylesheets", array("cachefile" => "css.php?stylesheet=" . $sid), "sid = '" . $sid . "'", 1);

    $tids = $db->simple_select("themes", "tid");
    while ($theme = $db->fetch_array($tids)) {
        update_theme_stylesheet_list($theme['tid']);
    }
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


    $db->delete_query("templates", "title LIKE '%forenwanted%'");

    require_once MYBB_ADMIN_DIR."inc/functions_themes.php";
    $db->delete_query("themestylesheets", "name = 'foreninterne gesuche.css'");
    $query = $db->simple_select("themes", "tid");
    while($theme = $db->fetch_array($query)) {
        update_theme_stylesheet_list($theme['tid']);
    }
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

function forenwanted_global(){
    
    global $templates, $forenwanted_forenintern, $mybb, $lang ;
	
	//Die Sprachdatei
    $lang->load('forenwanted');
	
    if($mybb->user['uid'] != '0' || $mybb->user['uid'] != ''){
        eval("\$forenwanted_forenintern = \"" . $templates->get ("forenwanted_menu") . "\";");
    }


    global $db, $mybb, $templates, $new_wanted, $forenwanted_read;
    $uid = $mybb->user['uid'];
    $forenwanted_read = "<a href='misc.php?action=forenwantedread&read={$uid}'>[als gelesen markieren]</a>";
    $select = $db->query ("SELECT * FROM " . TABLE_PREFIX ."gesuche");

    $row_cnt = mysqli_num_rows ($select);

    if ($row_cnt > 0) {

        $select = $db->query ("SELECT w_seen FROM " . TABLE_PREFIX . "users WHERE uid = '" . $mybb->user['uid'] . "' LIMIT 1");

        $data = $db->fetch_array ($select);
        if ($data['w_seen'] == '0') {

            eval("\$new_wanted = \"" . $templates->get ("forenwanted_new_alert") . "\";");

        }

    }
}
function forenwanted()
{
    global $db, $mybb, $templates, $lang, $header, $headerinclude, $footer, $page, $uid, $forenwanted_show_bit, $altbg, $pmhandler, $user, $w_wanted, $w_job, $w_relation, $w_disc;
    require_once MYBB_ROOT . "inc/datahandlers/pm.php";
    $pmhandler = new PMDataHandler();
    require_once MYBB_ROOT."inc/class_parser.php";
    $parser = new postParser;
    //Die Sprachdatei
    $lang->load('forenwanted');


    /*
     * Formatierung definieren.
     * Erlaubt mycodes und html, generiert Zeilenumbrüche und co. So muss man nicht mehr alles Hand schreiben
     */
    $options = array(
        "allow_html" => 1,
        "allow_mycode" => 1,
        "allow_smilies" => 1,
        "allow_imgcode" => 1,
        "filter_badwords" => 1,
        "nl2br" => 1,
        "allow_videocode" => 0
    );

    //Navigation bauen :D

    switch($mybb->input['action'])
    {
        case "forenwanted":
            add_breadcrumb($lang->forenwanted);
            break;
        case "forenwantedadd":
            add_breadcrumb($lang->forenwanted_add);
            break;
        case "forenwantedown":
            add_breadcrumb($lang->forenwanted_own);
            break;
    }


    // Interne Gesuche hinzufügen
    if ($mybb->get_input ('action') == 'forenwantedadd') {
        if ($mybb->usergroup['gid'] == '1') {

            error_no_permission ();
        } else {


            if (isset($_POST['forenwanted'])) {
                $uid = $mybb->user['uid'];
                $forenwanted = $_POST['w_wanted'];
                $title = $_POST['w_title'];
                $postfre = $_POST['w_postfre'];
                $relation = $_POST['w_relation'];
                $disc = $_POST['w_disc'];
                $avatar = $_POST['w_avatar'];
                $datum = TIME_NOW;

                $new_record = array(
                    "uid" => $db->escape_string ($uid),
                    "w_title" => $db->escape_string ($title),
                    "w_wanted" => $db->escape_string ($forenwanted),
                    "w_relation" => $db->escape_string ($relation),
                    "w_postfre" => $db->escape_string ($postfre),
                    "w_disc" => $db->escape_string ($disc),
                    "w_avatar" => $db->escape_string($avatar),
                    "w_datum" => $db->escape_string($datum)
                );

                $db->insert_query ("gesuche", $new_record);
                $db->query("UPDATE ".TABLE_PREFIX."users SET w_seen ='0'");
                redirect ("misc.php?action=forenwanted");
            }
            //menü
            eval("\$forenintern_menu = \"" . $templates->get ("forenwanted_menu") . "\";");

            //Aufrufen der Page
            eval("\$page = \"" . $templates->get ("forenwanted_add") . "\";");
            output_page ($page);
        }
    }



    if ($mybb->get_input('action') == 'forenwanted') {
        $select = $db->query("SELECT *
        FROM " . TABLE_PREFIX . "gesuche g
        LEFT JOIN " . TABLE_PREFIX . "users u
        ON g.uid = u.uid
       ORDER BY w_datum DESC ");

        while ($row = $db->fetch_array($select)) {
            $altbg = alt_trow();
            $username = format_name($row['username'], $row['usergroup'], $row['displaygroup']);
            $user = build_profile_link($username, $row['uid']);
            $datum = my_date("relative", $row['w_datum']);

            $forenwanted = "";
            $relationen = "";
            $avatar = "";
            $disc = "";
            $postfre = "";
            $status = "";

            $uid = $row['uid'];
            if ($mybb->user['modcp'] == 1 OR $mybb->user['admincp'] == 1 OR $mybb->user['uid'] == $row['uid']) {
                $delete = "<a href='misc.php?action=forenwanted&del=$row[geid]' title='Löschen'><i class=\"fas fa-eraser\"></i></a>";
            }
            if ($mybb->user['uid'] != 0) {
                $ueber = "<a href='misc.php?action=forenwanted&ueber=$row[geid]' title='Anfragen'><i class=\"fas fa-envelope-open-text\"></i> </a>";
            } else {
                $ueber = "Keine Bereichtung";
            }



            //Hier sind alle Variabeln, welche nur erscheinen, wenn etwas in der Datenbank steht. Dies bedeutet, dass nicht alle Automatisch angezeigt werden
            $forenwanted = $row['w_wanted'];
            $status = $row['w_status'];

            if ($row['w_title'] != NULL) {
                $title = "<div class=\"gesucheTitle\">{$row['w_title']}</div>";
            }

            if ($row['w_relation'] != NULL) {
                $relationen = "<div class=\"gesuchInfo\"><b>{$lang->forenwanted_relation}</b> {$row['w_relation']}</div>";
            }
            if ($row['w_postfre'] != NULL) {
                $postfre = "<div class=\"gesuchInfo\"><b>{$lang->forenwanted_postfrequenz}</b> {$row['w_postfre']}</div>";
            }

            if ($row['w_disc'] != NULL) {
                $row['w_disc'] = $parser->parse_message($row['w_disc'], $options);
                $disc = "<div class=\"gesuchInfobox\">{$row['w_disc']}</div>";

            }

            if ($row['w_avatar'] != NULL) {
                $avatar = "<div class=\"gesuchInfo\"><b>{$lang->forenwanted_ava}</b> {$row['w_avatar']}</div>";
            }
            eval("\$forenwanted_show_bit_user .= \"" . $templates->get("forenwanted_show_bit") . "\";");
        }

        $del = $mybb->input['del'];
        if ($del) {
            $db->delete_query("gesuche", "geid = '$del'");
            redirect("misc.php?action=forenwanted");
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
            $forenwanted = $row['w_wanted'];
            $pm_change = array(
                "subject" => "{$lang->forenwanted_pntitle}",
                "message" => "Ich habe Interesse zu deinem Gesuch, bei dem du <b>{$forenwanted}</b> suchst. Melde dich doch bei mir, das wir darüber reden können.",
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
        eval("\$forenintern_menu = \"" . $templates->get("forenwanted_menu") . "\";");

        //Aufrufen der Page
        eval("\$forenwanted_show_bit .= \"" . $templates->get("forenwanted_show_bit") . "\";");
        eval("\$page = \"" . $templates->get("forenwanted_show") . "\";");
        output_page($page);
    }


    //alle eigenen Gesuche. Hier können User ihre Gesuche bearbeiten und Löschen
    if ($mybb->get_input('action') == 'forenwantedown') {

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
        WHERE (u.as_uid = $this_user) OR (u.uid = $this_user)
       ORDER BY w_datum DESC ");
        }elseif($as_uid != 0){
            $select = $db->query("SELECT *
        FROM " . TABLE_PREFIX . "gesuche g
        LEFT JOIN " . TABLE_PREFIX . "users u
        ON g.uid = u.uid
        WHERE (u.as_uid = $as_uid) OR (u.uid = $this_user) OR (u.uid = $as_uid)
       ORDER BY w_datum DESC ");
        }
        while ($row = $db->fetch_array($select)) {
            $altbg = alt_trow();
            $username = format_name($row['username'], $row['usergroup'], $row['displaygroup']);
            $user = build_profile_link($username, $row['uid']);
            $datum = my_date("relative", $row['w_datum']);

            $forenwanted = "";
            $relationen = "";
            $avatar = "";
            $disc = "";
            $postfre = "";
            $status = "";

            $uid = $row['uid'];

            $delete = "<a href='misc.php?action=forenwanted&del=$row[geid]' title='Löschen'><i class=\"fas fa-eraser\"></i></a>";
            eval("\$edit = \"" . $templates->get ("forenwanted_show_edit") . "\";");

            //Hier sind alle Variabeln, welche nur erscheinen, wenn etwas in der Datenbank steht. Dies bedeutet, dass nicht alle Automatisch angezeigt werden
            $forenwanted = $row['w_wanted'];
            $status = $row['w_status'];

            if ($row['w_title'] != NULL) {
                $title = "<div class=\"gesucheTitle\">{$row['w_title']}</div>";
            }

            if ($row['w_relation'] != NULL) {
                $relationen = "<div class=\"gesuchInfo\"><b>{$lang->forenwanted_relation}</b> {$row['w_relation']}</div>";
            }
            if ($row['w_postfre'] != NULL) {
                $postfre = "<div class=\"gesuchInfo\"><b>{$lang->forenwanted_postfrequenz}</b> {$row['w_postfre']}</div>";
            }

            if ($row['w_disc'] != NULL) {
                $row['w_disc'] = $parser->parse_message($row['w_disc'], $options);
                $disc = "<div class=\"gesuchInfobox\">{$row['w_disc']}</div>";

            }


            if ($row['w_avatar'] != NULL) {
                $avatar = "<div class=\"gesuchInfo\"><b>{$lang->forenwanted_ava}</b> {$row['w_avatar']}</div>";
            }
            eval("\$forenwanted_show_bit_user .= \"" . $templates->get("forenwanted_show_bit") . "\";");
        }


        //Gesuche löschen
        $del = $mybb->input['del'];
        if ($del) {
            $db->delete_query("gesuche", "geid = '$del'");
            redirect("misc.php?action=forenwanted");
        }
        $uid = $mybb->user['uid'];

        //Gesuche editieren
        if(isset($mybb->input['editforenwanted'])){
            $getgeid = $mybb->input['getgeid'];
            $status = $mybb->input['w_status'];
            $forenwanted = $mybb->input['w_wanted'];
            $title = $mybb->input['w_title'];
            $postfre = $mybb->input['w_postfre'];
            $relation = $mybb->input['w_relation'];
            $disc = $mybb->input['w_disc'];
            $avatar = $mybb->input['w_avatar'];

            $update_record = array(
                "uid" => $db->escape_string ($uid),
                "w_title" => $db->escape_string ($title),
                "w_wanted" => $db->escape_string ($forenwanted),
                "w_relation" => $db->escape_string ($relation),
                "w_postfre" => $db->escape_string ($postfre),
                "w_disc" => $db->escape_string ($disc),
                "w_avatar" => $db->escape_string($avatar),
                "w_status" => $db->escape_string($status)
            );

            $db->update_query("gesuche", $update_record, "geid='{$getgeid}'");

            //Umleitung auf die Seite
            redirect("misc.php?action=forenwantedown");
        }


        //menü
        eval("\$forenintern_menu = \"" . $templates->get("forenwanted_menu") . "\";");

        //Aufrufen der Page
        eval("\$page = \"" . $templates->get("forenwanted_show_own") . "\";");
        output_page($page);
    }


    //Trage ein, wenn ein User angegeben hat, dass er die Info, dass es neue interne Gesuche gibt, gelesen hat
    if ($mybb->get_input ('action') == 'forenwantedread') {

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
