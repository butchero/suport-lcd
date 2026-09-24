function showStatus(sMsg) 
{
    window.status = sMsg ;
    return true ;
}

function NewWindow(mypage, myname, w, h, scroll)
{
	var win = null;
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
	win = window.open(mypage, myname, settings)
}

function modCant(id, operatie)
{
	var cantitate=parseInt(document.getElementById(id).value);

	if(isNaN(cantitate))
	{
		alert("Cantitatea trebuie sa fie numerica!")
		document.getElementById(id).value=1;
		return;
	}
	else
	{
		if(operatie=="+")
			document.getElementById(id).value=cantitate+1;
		else
		{
			if(cantitate>=1)
				document.getElementById(id).value=parseInt(cantitate)-1;	
		}
	}
}

function toggle(id)
{
	var obiect=document.getElementById(id);
	if(obiect.style.display=="none")
		obiect.style.display="block";
	else
		obiect.style.display="none";	
}

function valideazaComanda(total_comanda, comanda_minima, url, id_form, erori_cos, username)
{	
	if(parseInt(total_comanda)==0)
	{
		alert("Nu aveti nici un produs in cos!");
		return false;
	}
	else if(parseInt(total_comanda)<parseInt(comanda_minima))
	{
		alert("Valoarea cosului este mai mica decat comanda minima!");
		return false;
	}
	else if(parseInt(erori_cos)>0)
	{
		alert("Pentru a finaliza comanda, trebuie sa stergeti produsele din cos care nu mai sunt pe stoc!");
	}
	else if(username=="")
	{
		alert("Pentru a finaliza comanda trebuie sa fiti logat!");
	}
	else
	{
		document.getElementById("finalizeaza_comanda").value="1";
		document.getElementById(id_form).action=url;
		document.getElementById(id_form).submit();
		
		return true;
	}
}

function toggleCampuri(id, arr_ids, arr_values)
{
	var checkbox=document.getElementById(id);
	
	if(checkbox.checked)
	{
		for(var i=0;i<arr_ids.length;i++)
		{
			document.getElementById(arr_ids[i]).value="";
			document.getElementById(arr_ids[i]).disabled=false;
		}
	}
	else
	{
		for(var i=0;i<arr_ids.length;i++)
		{
			document.getElementById(arr_ids[i]).value=arr_values[i];
			document.getElementById(arr_ids[i]).disabled=true;
		}
	}
}

function checkForm(arr_ids, arr_err_msg)
{
	for(i=0;i<arr_ids.length;i++)
	{
		if(document.getElementById(arr_ids[i]).value=="")
		{
			alert(arr_err_msg[i]);
			return false;
		}
	}
}

function doSearch(id_form, id_camp)
{	
	var search_string=document.getElementById(id_camp).value;
	var search_form=document.getElementById(id_form);

	if(search_string.length<3)
	{
		alert("Cautarea se face dupa minim 3 caractere!");
		return false;
	}
	else
	{
		search_form.action=URL_BASE+"cautare/"+search_string.replace(/[^A-Za-z0-9]/g, "-");
		search_form.submit();
		return true;
	}
}

function afiseazaCatSec(id)
{

	if(document.getElementById("toggle_cat_"+id).style.display=="none")
	{
		document.getElementById("toggle_cat_"+id).style.display="block";
		document.getElementById("actiune_"+id).innerHTML='<a href="#" onClick="afiseazaCatSec(\''+id+'\'); return false;" class="subcategorii_secundare" style="color:#E41F15"><b>x - inchide</u></b>';		
	}
	else
	{
		document.getElementById("toggle_cat_"+id).style.display="none";
		document.getElementById("actiune_"+id).innerHTML='<a href="#" onClick="afiseazaCatSec(\''+id+'\'); return false;" class="subcategorii_secundare"><b>&raquo; mai multe afectiuni</b></a>';
	}
}

function textCounter(field, cntfield, maxlimit) 
{
	if (field.value.length > maxlimit) 
		field.value = field.value.substring(0, maxlimit);
	else
		cntfield.value = maxlimit - field.value.length;
}