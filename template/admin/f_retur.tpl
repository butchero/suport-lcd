<html>
	<head>
		<title>Formular de retur</title>
		<style type="text/css" media="all">
		@import "{$DIR_TEMPLATE}admin/stylesheet.css";
		</style>
	</head>
	<body style="background-color:#F2F2F2">
	<script src="{$URL_BASE}javascript/scriptaculous-js-1.7.0/lib/prototype.js" type="text/javascript"></script>	
	<script src="{$URL_BASE}javascript/EditInPlace.js" type="text/javascript"></script>
	<script type="text/javascript">
		Event.observe(window, 'load', init, false);
		var id_formular='{$id_formular}';
		{literal}
		function init() {			
			EditInPlace.makeEditable ({
				type: 'textarea',
				id: 'editare_nota_admin',
				save_url: 'server_edit_in_place.php?id_formular='+id_formular	
			});	
		}				
		{/literal}
	</script>
	<center>
		<form action="" method="POST">			
			<table width="760" cellpadding="5" style="background-color:#FFFFFF;border-right:2px solid #C2C2C2;border-bottom:2px solid #C2C2C2;border-top:2px solid #F2F2F2;border-left:2px solid #F2F2F2">
				<tr>
					<td align="center" valign="top"><b>Nota admin:</b></td>
					<td><div style="padding:3px;font-size:10px;border:1px solid #F2F2F2;width:500px" id="editare_nota_admin">{$nota_admin}</div></td>
				</tr>
				<tr>
					<td colspan="2" align="right" class="no_print">
						<img src="{$DIR_TEMPLATE}img/print.gif" alt="Printeaza" onClick="window.print()" onMouseOver="this.style.cursor='pointer'">
					</td>
				</tr>
				<tr>
					<td width="100"><img src="{$DIR_TEMPLATE}img/sigla.jpg" alt="{$NUME_FIRMA}"></td>
					<td width="660" align="right">
						<b>{$NUME_FIRMA}, {$SEDIUL}</b>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="font-size:22px;font-weight:bold" align="center">
						<i>Formular de retur</i> <br /> <span style="font-size:11px">data: {$data_retur}</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="font-size:11px;padding:20px">
						{$text_formular_retur}
					</td>
				</tr>
				<tr>			
					<td colspan="2" style="text-align:center">
						{if $mesaj neq ""}
							<span class="eroare_text"><b>{$mesaj}</b></span> <br /><br />
						{/if}		
						<center>
						<table cellspacing="1" cellpadding="5" width="720" style="background-color:#CCCCCC">
							<tr>
								<td bgcolor="#F2F2F2" width="300" colspan="3"><b>Nume firma/nume persoana fizica:</b></td>
								<td bgcolor="#FFFFFF" width="420">{$date_user[0].societate} {if $date_user[0].societate neq ""}-{/if} {$date_user[0].nume} {$date_user[0].prenume}</td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" colspan="3"><b>Nume persoana contact:</b></td>
								<td bgcolor="#FFFFFF">{$nume_persoana_contact}</td>
							</tr>
							<tr>
								<td bgcolor="#F2F2F2" colspan="3"><b>Adresa:</b></td>
								<td bgcolor="#FFFFFF">{$adresa_livrare}</td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" colspan="3"><b>Nr. telefon:</b></td>
								<td bgcolor="#FFFFFF">{$nr_telefon}</td>
							</tr>
							<tr>
								<td bgcolor="#F2F2F2" colspan="3"><b>Email:</b></td>
								<td bgcolor="#FFFFFF">{$date_user[0].email}</td>
							</tr>
							<tr>
								<td bgcolor="#F2F2F2"><b>Nr.</b></td>
								<td bgcolor="#F2F2F2" width="40"><b>Cant.:</b></td>
								<td bgcolor="#F2F2F2"><b>Produs</b></td>
								<td bgcolor="#F2F2F2"><b>Descriere defectiune</b></td>
							</tr>
							{section name=sec loop=$produse}
							<tr>
								<td bgcolor="#FAFAFA">{$smarty.section.sec.index+1}.</td>
								<td bgcolor="#FFFFFF">{$produse[sec].cantitate}</td>
								<td bgcolor="#FFFFFF">{$produse[sec].produs}</td>
								<td bgcolor="#FFFFFF" valign="top">
									{$produse[sec].descriere}
								</td>
							</tr>						
							{/section}						
						</table>					
						</center>			
					</td>
				</tr>
			</table>	
			<br />	
			<span class="no_print">
				<a href="javascript:history.go(-1)">&laquo; Inapoi</a> -
				<a href="{$URL_ADMIN}comenzi_noi.php" title="Vezi comenzi noi">Comenzi noi</a> - 
				<a href="{$URL_ADMIN}comenzi.php?stare=onorate" title="Vezi comenzi onorate">Comenzi onorate</a>
			</span>
		</form>
	</center>	
	</body>
</html>