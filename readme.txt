/***
Dies ist die README zu dem Plugin Foreninterne Gesuche. Bitte durchlesen, bevor ihr ihn Installiert.
Es kam die ein oder andere Änderung hinzu.
***/

#wichtiges:
- Account Switcher muss Installiert sein
- kann über misc.php?action=wanted aufgerufen sein

#Navigator
- Datenbankänderungen
- Templates
- CSS Dateien

/***
Datenbankänderungen
***/

folgende Datenbankänderungen wurden übernommen:

Gelöschte Spalte:
w_job

Hinzugefügte Spalten:
w_postfre (int) und w_avatar (varchar (255))

Zudem wurde für ALLE Spalten Null akzeptiert, außerfür uid, type und w_wanted. (Wichtig, um die Unterscheidung zu ermöglich). 

/***
Templates
***/

Templates wurden Teilweise neu gestaltet bzw. neu hinzugefügt. Hier die gesamte Auflistung:

# wanted_welcome

<html>
<head>
<title>{$mybb->settings['bbname']} - Willkommen bei Interne Gesuche</title>
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
</html>

# wanted_add
<html>
<head>
<title>{$mybb->settings['bbname']} - Internes Gesuch einreichen</title>
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
				<div class="smalltext">Was ist denn deine eigene Postfrequenz.</div></td><td width="400px" class="trow2"><input id="w_postfre" name="w_postfre" type="text" class="textbox"  style="width: 95%" /></td></tr>
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
</html>

#wanted_menu
<td width="180px" valign="top">
	<table class="tborder">
		<tr><td class="thead">Menü</td></tr>
		<tr><td class="trow1"><a href="misc.php?action=wantedadd">Internes Gesuch einreichen</a></td></tr>
		<tr><td class="trow2"><a href="misc.php?action=wantedshow">Internegesuche anzeigen</a></td></tr>
		<tr><td class="trow1"><a href="misc.php?action=wantedshowown">eigene Gesuche anzeigen</a></td></tr>
	</table>
</td>

#wanted_new_alert
<div class="pm_alert">
	<strong>Es gibt neue <b>Foreninterne Gesuche</b>. <a href="misc.php?action=wantedshow">Hier</a> kannst du es dir ansehen. {$wanted_read}</strong>
</div>
<br />

#wanted_show
<html>
<head>
<title>{$mybb->settings['bbname']} - Alle Interne Gesuche anzeigen</title>
{$headerinclude}
</head>
<body>
{$header}
<table width="100%" border="0" align="center">
<tr>	
{$forenintern_menu}
<td valign="top">
<table width="100%">
<tr><td class="thead">Foreninterne Gesuche</td></tr>
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
</html>

#wanted_show_bit
<div class="gesucheMitg">
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
</div>

#wanted_show_own
<html>
<head>
<title>{$mybb->settings['bbname']} - Eigene Interne Gesuche anzeigen</title>
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
</html>


# wanted_show_edit
<style>.infopop { position: fixed; top: 0; right: 0; bottom: 0; left: 0; background: hsla(0, 0%, 0%, 0.5); z-index: 1; opacity:0; -webkit-transition: .5s ease-in-out; -moz-transition: .5s ease-in-out; transition: .5s ease-in-out; pointer-events: none; } .infopop:target { opacity:1; pointer-events: auto; } .infopop > .pop {width:50%; position: relative; margin: 10% auto; padding: 25px; z-index: 3; } .closepop { position: absolute; right: -5px; top:-5px; width: 100%; height: 100%; z-index: 2; }</style>
<div id="popinfo$row[geid]" class="infopop">
  <div class="pop"><form method="post" action=""><input type='hidden' value='{$row['geid']}' name='getgeid'>
<table border="0" cellspacing="5" cellpadding="{$theme['tablespace']}" class="tborder" style="margin:auto;" width="100%">
<tr><td class="trow1" width="50%"><strong>Wer wird gesucht?</strong>
	<div class="smalltext">hier kannst du in einen Wort sagen, was gesucht wird. Zum Beispiel Namen, Bezeichnung etc.</div></td>
	<td  width="50%" class="trow2"><input id="w_wanted" name="w_wanted" type="text" class="textbox"  style="width: 95%" value="{$row['w_wanted']}" /></td></tr>
			<tr><td  width="50%" class="trow1"><strong>Postfrequenz</strong>
				<div class="smalltext">Was ist denn deine eigene Postfrequenz. (nur Zahlen eingeben)</div></td>
				<td  width="50%" class="trow2"><input id="w_postfre" name="w_postfre" type="text" class="textbox"  style="width: 95%"  value="{$row['w_postfre']}" /></td></tr>
<tr><td class="trow1" width="50%"><strong>Beziehungswünsche</strong>
	<div class="smalltext">Hast du Beziehungswünsche?</div></td>
	<td  width="50%" class="trow2"><input id="w_relation" name="w_relation" type="text" class="textbox"  style="width: 95%"  value="{$row['w_relation']}" /></td></tr>
<tr><td class="trow1" width="50%"><strong>Weitere Informationen</strong>
	<div class="smalltext">Gebe hier alle weitere Informationen an, die du für wichtig hältst. Zum Beispiel <i>Alter, Beruf, Wohnort etc.</i>. Vergiss aber nicht, durch den Befehl br gewünschte Zeilenumbrüche einzufügen.</td><td  width="50%" class="trow2"><textarea class="textarea" name="w_disc" id="w_disc" rows="6" cols="30" style="width: 95%">{$row['w_disc']}</textarea></td></tr>
			<tr><td class="trow1" width="50%"><strong>Avatarvorschläge</strong>
				<div class="smalltext">Hast du Avatarvorschläge? Dann füge es hier ein.</td><td width="400px" class="trow2"><input id="w_avatar" name="w_avatar" type="text" class="textbox"  style="width: 95%"  value="{$row['w_avatar']}" /></td></tr>
			<tr><td class="trow2" colspan="2"><div align="center">
						<input type="submit" name="editwanted" value="Editieren" id="submit" class="button">
				</div></td></tr></form></table>
		</div><a href="#closepop" class="closepop"></a>
</div>

<a href="#popinfo$row[geid]"><i class="fas fa-edit" aria-hidden="true"></i></a>

/***
CSS Dateien
***/
Diese Dateien bitte an Gewünschter Stelle einfügen

.gesucheMitg{
	float: left;
	width: 22%;
	height: 300px;
	margin-left: 5px;
		margin:4px;
	padding: 4px;
	box-sizing: border-box;
	background: #F5F5F5;
	border-radius: 6px 6px 0px 0px;
	
}

.gesuchName{
font-family: Tahoma;
font-style: normal;
font-weight: normal;
font-size: 24px;
line-height: 29px;
text-align: center;
text-transform: uppercase;
line-height: 22px;
color: #0072BC;
}

.gesuchUntertitel{
	font-family: Tahoma;
font-style: normal;
font-weight: normal;
font-size: 13px;
line-height: 16px;
text-align: center;
letter-spacing: 0.5em;
text-transform: uppercase;

color: #0072BC;
}

.gesuchInfo{
font-family: Tahoma;
font-style: normal;
font-size: 12px;
line-height: 14px;
text-transform: uppercase;

color: #000000;
}

.gesuchInfobox{
font-family: Tahoma;
font-style: normal;
font-size: 12px;
line-height: 14px;
margin: 3px 0;
color: #000000;
text-align: justify;
overflow: auto;
height: 151px;
}

.gesuchInfo b{
	color: #0072BC;
	font-weight: bold;
}

.gesuchErstellt{
	font-family: Tahoma;
font-style: normal;
font-weight: normal;
font-size: 9px;
line-height: 11px;
text-transform: uppercase;
text-align: center;
color: #000000;
}

.gesuchOptionen{
	color: #0072BC;
	font-weight: bold;
	font-size: 16px;
	text-align: center;
}
