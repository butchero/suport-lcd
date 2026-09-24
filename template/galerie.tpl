<html>
	<head>
		<title>Galerie foto</title>		
 		<link href="{$DIR_TEMPLATE}stylesheet.css" type="text/css" rel="stylesheet">
	</head>
	<body>
		<table cellpadding="2" cellspacing="0" width="100%" height="100%">
			<tr><td colspan="2" height="80" style="padding:0px 5px 0px 5px"><img src="{$DIR_TEMPLATE}img/sigla.png" alt=""></td></tr>
			<tr bgcolor="#CCCCCC">
				<td height="30" style="padding-left:5px"><font color="white"><b>Poze produs: {$nume_produs}</b></font></td>
				<td align="right" style="padding-right:5px"><a href="javascript:window.self.close()" class="inchide_fereastra"><b>[Inchide fereastra]</b></a></td>
			</tr>
			<tr><td colspan="2" height="4" class="bg_spatiu"></td></tr>
			<tr colspan="2" height="10"><td></td></tr>
			<tr>
				<td colspan="2" align="center" valign="middle">
					<img src="{$poza}" border="0" id="poza_principala">
				</td>
			</tr>
			<tr colspan="2" height="10"><td></td></tr>
			<tr><td bgcolor="#F2F2F2" colspan="2" height="2"></td></tr>
			<tr>
				<td colspan="2" height="90" class="bg_spatiu">
					<table>
						<tr>
						{section name=galerie loop=$poze_sec_medii}							
						<td width="90" height="73" class="box_poze_mici" align="center" valign="middle" bgcolor="#F2F2F2">
							<a href="#" onClick="document.getElementById('poza_principala').src='{$poze_sec_supermari[galerie]}'; return false;">
								<img src="{$poze_sec_medii[galerie]}" alt="">
							</a>
						</td>
						{/section}
						</tr>
					</table>									
				</td>
			</tr>
			<tr><td align="center" colspan="2" height="10">&copy; 2007 {$NUME_FIRMA}</td></tr>
		</table>
	</body>
</html>