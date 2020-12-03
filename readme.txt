/***
Dies ist die README zu dem Plugin Foreninterne Gesuche. Bitte durchlesen, bevor ihr ihn Installiert.
Es kam die ein oder andere Änderung hinzu.
***/

#wichtiges:
- Account Switcher muss Installiert sein
- kann über misc.php?action=wanted aufgerufen sein

/***
Datenbankänderungen
***/

folgende Datenbankänderungen wurden übernommen:

Gelöschte Spalte:
w_type

Hinzugefügte Spalten:
w_status (varchar) Default frei
w_title (varchar)

geänderte Spalte:
w_postfrequ -> anstatt int jetzt varchar
w_disc -> varchar in mediumtext

/***
Templates
***/
Umbenennen und mit Sprachvariabeln


# forenwanted_add
<html>
<head>
<title>{$mybb->settings['bbname']} - {$lang->forenwanted_add}</title>
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
</html>

# forenwanted_menu
<td width="180px" valign="top">
	<table class="tborder">
		<tr><td class="thead">{$lang->forenwanted_menu}</td></tr>
		<tr><td class="trow2"><a href="misc.php?action=forenwanted">{$lang->forenwanted}</a></td></tr>
		<tr><td class="trow1"><a href="misc.php?action=forenwantedadd">{$lang->forenwanted_add}</a></td></tr>
		<tr><td class="trow1"><a href="misc.php?action=forenwantedown">{$lang->forenwanted_own}</a></td></tr>
	</table>
</td>

# forenwanted_new_alert
<div class="pm_alert">
	<strong>{$lang->forenwanted_alert} {$forenwanted_read}</strong>
</div>
<br />

# forenwanted_show
<html>
<head>
<title>{$mybb->settings['bbname']} - {$lang->forenwanted}</title>
{$headerinclude}
</head>
<body>
{$header}
<table border="0" cellspacing="{$theme['borderwidth']}" cellpadding="{$theme['tablespace']}" class="tborder">
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
</html>

# forenwanted_show_bit
<div class="forenwanted_show_bit">
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
</div>

# forenwanted_show_edit
<style>.infopop { position: fixed; top: 0; right: 0; bottom: 0; left: 0; background: hsla(0, 0%, 0%, 0.5); z-index: 1; opacity:0; -webkit-transition: .5s ease-in-out; -moz-transition: .5s ease-in-out; transition: .5s ease-in-out; pointer-events: none; } .infopop:target { opacity:1; pointer-events: auto; } .infopop > .pop {width:50%; position: relative; margin: 10% auto; padding: 25px; z-index: 3; } .closepop { position: absolute; right: -5px; top:-5px; width: 100%; height: 100%; z-index: 2; }</style>
<div id="popinfo$row[geid]" class="infopop">
  <div class="pop"><form method="post" action=""><input type='hidden' value='{$row['geid']}' name='getgeid'>
<table border="0" cellspacing="5" cellpadding="{$theme['tablespace']}" class="tborder" style="margin:auto;" width="100%">
				<tr><td class="trow1" width="50%"><strong>{$lang->forenwanted_status}</strong>
	<div class="smalltext">{$lang->forenwanted_status_desc}</div></td><td width="400px" class="trow2"><input id="w_status" name="w_status" type="text" class="textbox"  style="width: 95%"  value="{$row['w_status']}" /></td></tr>
	<tr><td class="trow1"><strong>{$lang->forenwanted_title}</strong>
	<div class="smalltext">{$lang->forenwanted_title_desc}</div></td></td>
	<td  width="50%" class="trow2"><input id="w_title" name="w_title" type="text" class="textbox"  style="width: 95%" value="{$row['w_title']}" /></td></tr>
<tr><td class="trow1" width="50%"><strong>{$lang->forenwanted_who}</strong>
	<div class="smalltext">{$lang->forenwanted_who_desc}</div></td>
	<td  width="50%" class="trow2"><input id="w_wanted" name="w_wanted" type="text" class="textbox"  style="width: 95%" value="{$row['w_wanted']}" /></td></tr>
			<tr><td  width="50%" class="trow1"><strong>{$lang->forenwanted_postfrequ}</strong>
				<div class="smalltext">{$lang->forenwanted_postfrequ_desc}</div></td>
				<td  width="50%" class="trow2"><input id="w_postfre" name="w_postfre" type="text" class="textbox"  style="width: 95%"  value="{$row['w_postfre']}" /></td></tr>
<tr><td class="trow1" width="50%"><strong>{$lang->forenwanted_rela}</strong>
	<div class="smalltext">{$lang->forenwanted_rela_desc}</div></td>
	<td  width="50%" class="trow2"><input id="w_relation" name="w_relation" type="text" class="textbox"  style="width: 95%"  value="{$row['w_relation']}" /></td></tr>
<tr><td class="trow1" width="50%"><strong>{$lang->forenwanted_story}</strong>
	<div class="smalltext">{$lang->forenwanted_story_desc}</div></td><td  width="50%" class="trow2"><textarea class="textarea" name="w_disc" id="w_disc" rows="6" cols="30" style="width: 95%">{$row['w_disc']}</textarea></td></tr>
			<tr><td class="trow1" width="50%"><strong>{$lang->forenwanted_ava}</strong>
	<div class="smalltext">{$lang->forenwanted_ava_desc}</div></td><td width="400px" class="trow2"><input id="w_avatar" name="w_avatar" type="text" class="textbox"  style="width: 95%"  value="{$row['w_avatar']}" /></td></tr>
			<tr><td class="trow2" colspan="2"><div align="center">
						<input type="submit" name="editforenwanted" value="Editieren" id="submit" class="button">
				</div></td></tr></form></table>
		</div><a href="#closepop" class="closepop"></a>
</div>

<a href="#popinfo$row[geid]"><i class="fas fa-edit" aria-hidden="true"></i></a>


# forenwanted_show_own
<html>
<head>
<title>{$mybb->settings['bbname']} - {$lang->forenwanted_own}</title>
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
</html>

/***
CSS Dateien
***/
Diese Dateien bitte an Gewünschter Stelle einfügen
.forenwanted_show{
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
        
