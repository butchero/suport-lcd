{include file="top.tpl"}
{include file="left.tpl"}
{strip}
<td valign="top" align="left">
	<form action="" method="POST">
	<table cellpadding="0" cellspacing="0" width="500" style="margin-top:10px;background:url({$DIR_TEMPLATE}{$POZE_DIR}/middle_chenar.gif);background-repeat:repeat-y">										
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/top_chenar.gif" alt="">
			</td>
		</tr>
		<tr>
			<td style="padding-left:5px">
				<table>
					<tr><td align="left"><h3>AUTENTIFICARE UTILIZATOR</h3></td></tr>
					<tr>
						<td><img src="{$DIR_TEMPLATE}img/cont_nou.jpg" alt="Cont nou"></td>
						<td align="left">
						<font class="eroare_form"><b>{$acces_check.eroare|upper}</b></font>
							<table>
								<tr><td align="right">Username:</td><td><input type="text" name="username" size="20"></td></tr>
								<tr><td align="right">Parola:</td><td><input type="password" name="parola" size="20"></td></tr>
								<tr><td></td><td>Tine-ma minte: <input type="checkbox" name="remember_me"></td></tr>
								<tr><td></td><td><input type="submit" name="login" value="AUTENTIFICARE" class="buton"></td></tr>
								<tr><td colspan="2" height="10"></td></tr>
								<tr>
									<td align="left" colspan="2">
									<ul>
										<li><a href="{$LINK_RECUPEREAZA_PAROLA}" class="link"><u>Am uitat parola</u></a></li>
										<li><a href="{$LINK_CONT_NOU}" class="link"><u>Creeaza cont nou</u></a></li>
									</ul>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>				
			</td>
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/bottom_chenar.gif" alt="">
			</td>
		</tr>	
	</table>
	</form>
</td>
{/strip}
{include file="right.tpl"}
{include file="bottom.tpl"}