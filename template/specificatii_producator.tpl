{strip}
<html>
	<head>
		<title>Recomanda produs</title>		
 		<link href="{$DIR_TEMPLATE}stylesheet.css" type="text/css" rel="stylesheet">
	</head>
	<script src="/javascript/jslib/overlib.js" type="text/javascript"></script>
	<body>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr><td colspan="2" height="80" style="padding:10px"><img src="{$DIR_TEMPLATE}img/sigla.jpg" alt="Oraso Plant"></td></tr>
			<tr bgcolor="#0D9F0D">
				<td height="30" style="padding-left:5px"><font color="white"><b>Specificatii producator</b></font></td>
				<td align="right" style="padding-right:5px">
					<a href="javascript:window.self.close()" class="inchide_fereastra"><b>[Inchide fereastra]</b></a>
				</td>
			</tr>
			<tr><td colspan="2" height="4" class="bg_spatiu"></td></tr>			
			<tr>
				<td colspan="2" valign="top" align="left" style="padding:20px">
				<b>{$specs.nume_produs}</b>
				<br /><br />
				{$specs.specificatii}
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right" style="padding-right:10px">
					<a href="{$specs.link_producator}" rel="nofollow" class="link_default">Link producator</a>
				</td>
			</tr>
			<tr><td colspan="2" height="10"></td></tr>
			<tr><td align="center" colspan="2" height="10">&copy; 2006 {$NUME_FIRMA}</td></tr>
		</table>
	</body>
</html>
{/strip}