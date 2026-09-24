var indicatii_afisate=0;

function showIndicatii()
{
	if(indicatii_afisate==0)
	{  
		Effect.SlideDown('indicatii');
		indicatii_afisate=1;
		$('arrow_indicatii').src=dir_admin_img+"arr_up.gif";
	}
	else
	{
		Effect.SlideUp('indicatii');
		indicatii_afisate=0;
		$('arrow_indicatii').src=dir_admin_img+"arr_down.gif";
	}
}

function NewWindow(mypage, myname, w, h, scroll)
{
	var win = null;
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
	win = window.open(mypage, myname, settings)
}