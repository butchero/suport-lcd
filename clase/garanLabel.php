<?php
	/*
		@Class: eticheta UE GARAN
		Citeste copiile template-urilor oficiale si inlocuieste doar placeholder-ele permise.
	*/
	class garanLabel
	{
		var $cssFonturi=null;

		function generateWebSvg($produs)
		{
			return $this->genereaza($produs, "nested");
		}

		function generatePrintSvg($produs)
		{
			$svg=$this->genereaza($produs, "colour");
			if($svg===false)
				return false;

			return $this->pregatesteTipar($svg);
		}

		function numeFisier($cod_produs, $warranty_months)
		{
			$cod=preg_replace("/[^A-Za-z0-9._-]+/", "-", trim($cod_produs));
			$cod=trim($cod, "-.");
			if($cod==="")
				$cod="produs";

			$ani=formateazaAniGaran($warranty_months);
			$ani=str_replace(",", "-", $ani);

			return "garan-".$cod."-".$ani."-ani.svg";
		}

		function genereaza($produs, $varianta)
		{
			$ani=formateazaAniGaran($produs["warranty_months"]);
			if($ani==="")
				return false;

			$fisier=dirname(__FILE__)."/../private/garan/".(($varianta=="nested")?"nested.svg":"colour.svg");
			if(!is_file($fisier))
				return false;

			$svg=file_get_contents($fisier);
			$svg=str_replace("{{WARRANTY_YEARS}}", $this->escapeXml($ani), $svg);

			if($varianta!="nested")
			{
				$brand=trim($produs["brand"]);
				$model=trim($produs["model"]);
				$svg=preg_replace(
					'/<text class="cls-5" transform="translate\(6\.32 74\.52\)"><tspan x="0" y="0">\{\{BRAND\}\}<\/tspan><\/text>/',
					$this->textBrand($brand),
					$svg,
					1
				);
				$svg=preg_replace(
					'/<text class="cls-5" transform="translate\(196\.75 74\.52\)"><tspan x="0" y="0">\{\{MODEL\}\}<\/tspan><\/text>/',
					$this->textModel($model),
					$svg,
					1
				);
			}

			return $svg;
		}

		//@brand stanga, incape in zona dinaintea modelului
		function textBrand($brand)
		{
			$fontSize=$this->fontSizePentruText($brand, 9, 170);
			return '<text class="cls-5" transform="translate(6.32 74.52)" style="font-size:'.$fontSize.'px"><tspan x="0" y="0">'.$this->escapeXml($brand).'</tspan></text>';
		}

		//@model dreapta; pe un rand daca incape lizibil, altfel 2 randuri
		function textModel($model)
		{
			$xDreapta=258.5;
			$latimeUnRand=68;
			$latimeDouaRanduri=100;
			$fontMin=6.5;
			$fontSize=$this->fontSizePentruText($model, 9, $latimeUnRand, $fontMin);

			if($fontSize>=$fontMin && $this->estimeazaLatimeText($model, $fontSize)<=$latimeUnRand)
			{
				return '<text class="cls-5" text-anchor="end" transform="translate('.$xDreapta.' 74.52)" style="font-size:'.$fontSize.'px"><tspan x="0" y="0">'.$this->escapeXml($model).'</tspan></text>';
			}

			$linii=$this->imparteTextPeLinii($model, 2);
			$fontSize=$this->fontSizePentruText($linii[0], 8, $latimeDouaRanduri, 5.5);
			$fontSize=min($fontSize, $this->fontSizePentruText(isset($linii[1])?$linii[1]:"", 8, $latimeDouaRanduri, 5.5));
			$html='<text class="cls-5" text-anchor="end" transform="translate('.$xDreapta.' 70.2)" style="font-size:'.$fontSize.'px">';
			$html.='<tspan x="0" y="0">'.$this->escapeXml($linii[0]).'</tspan>';
			if(isset($linii[1]) && $linii[1]!="")
				$html.='<tspan x="0" y="'.round($fontSize*1.2, 2).'">'.$this->escapeXml($linii[1]).'</tspan>';
			$html.='</text>';
			return $html;
		}

		function fontSizePentruText($text, $fontInitial, $latimeMax, $fontMin=5)
		{
			$fontSize=(float)$fontInitial;
			$fontMin=(float)$fontMin;
			while($fontSize>$fontMin && $this->estimeazaLatimeText($text, $fontSize)>$latimeMax)
				$fontSize-=0.25;

			return round($fontSize, 2);
		}

		function estimeazaLatimeText($text, $fontSize)
		{
			$text=trim($text);
			if($text==="")
				return 0;

			$latime=0;
			$lungime=strlen($text);
			for($i=0;$i<$lungime;$i++)
			{
				$c=$text[$i];
				if($c===" " || $c==="." || $c==="," || $c==="-" || $c==="/")
					$latime+=0.32*$fontSize;
				elseif(ctype_upper($c) || ctype_digit($c))
					$latime+=0.72*$fontSize;
				else
					$latime+=0.58*$fontSize;
			}

			return $latime;
		}

		function imparteTextPeLinii($text, $nrLinii)
		{
			$text=trim(preg_replace("/\s+/", " ", $text));
			$text=str_replace("/", "/ ", $text);
			$cuvinte=preg_split("/\s+/", $text);
			$cuvinte=array_values(array_filter($cuvinte, "strlen"));
			if(count($cuvinte)<=1 || $nrLinii<2)
				return array(trim(str_replace("/ ", "/", $text)));

			$celMaiBun=1;
			$ceaMaiBunaDiff=null;
			for($i=1;$i<count($cuvinte);$i++)
			{
				$l1=trim(str_replace("/ ", "/", implode(" ", array_slice($cuvinte, 0, $i))));
				$l2=trim(str_replace("/ ", "/", implode(" ", array_slice($cuvinte, $i))));
				$diff=abs($this->estimeazaLatimeText($l1, 8)-$this->estimeazaLatimeText($l2, 8));
				if($ceaMaiBunaDiff===null || $diff<$ceaMaiBunaDiff)
				{
					$ceaMaiBunaDiff=$diff;
					$celMaiBun=$i;
				}
			}

			return array(
				trim(str_replace("/ ", "/", implode(" ", array_slice($cuvinte, 0, $celMaiBun)))),
				trim(str_replace("/ ", "/", implode(" ", array_slice($cuvinte, $celMaiBun))))
			);
		}

		function pregatesteTipar($svg)
		{
			$svg=preg_replace("/<svg\s/", "<svg width=\"95mm\" height=\"100mm\" ", $svg, 1);
			$css=$this->cssFonturiIngropate();
			if($css!=="")
				$svg=preg_replace("/<style>/", "<style>".$css, $svg, 1);

			return $svg;
		}

		function cssFonturiIngropate()
		{
			if($this->cssFonturi!==null)
				return $this->cssFonturi;

			$regular=$this->fontDataUri("Inter-Regular.ttf");
			$bold=$this->fontDataUri("Inter-ExtraBold.ttf");
			if($regular==="" || $bold==="")
			{
				$this->cssFonturi="";
				return $this->cssFonturi;
			}

			$this->cssFonturi="@font-face{font-family:\"Inter-Regular\";src:url(\"".$regular."\") format(\"truetype\");font-weight:100 900;font-style:normal;}@font-face{font-family:\"Inter\";src:url(\"".$regular."\") format(\"truetype\");font-weight:400;font-style:normal;}@font-face{font-family:\"Inter-ExtraBold\";src:url(\"".$bold."\") format(\"truetype\");font-weight:100 900;font-style:normal;}@font-face{font-family:\"Inter\";src:url(\"".$bold."\") format(\"truetype\");font-weight:700 900;font-style:normal;}";
			return $this->cssFonturi;
		}

		function fontDataUri($nume)
		{
			$cale=dirname(__FILE__)."/../private/garan/fonts/".$nume;
			if(!is_file($cale))
				return "";

			return "data:font/ttf;base64,".base64_encode(file_get_contents($cale));
		}

		function escapeXml($valoare)
		{
			return htmlspecialchars($valoare, ENT_QUOTES | ENT_XML1, "UTF-8");
		}
	}
?>
