<?php
/*
	Compatibilitate PHP 7.2 si PHP 8.2.
	Functiile scoase din limbaj se definesc doar daca lipsesc,
	ca sa nu se suprapuna peste cele din PHP 7.2.
*/

if(PHP_VERSION_ID>=80000)
	error_reporting(E_ALL & ~E_DEPRECATED);

if(function_exists("mysqli_report"))
	mysqli_report(MYSQLI_REPORT_OFF);

if(!function_exists("get_magic_quotes_gpc"))
{
	function get_magic_quotes_gpc()
	{
		return false;
	}
}

if(!function_exists("get_magic_quotes_runtime"))
{
	function get_magic_quotes_runtime()
	{
		return false;
	}
}

if(!function_exists("set_magic_quotes_runtime"))
{
	function set_magic_quotes_runtime($new_setting)
	{
		return true;
	}
}

if(!function_exists("each"))
{
	function each(&$array)
	{
		if(!is_array($array))
			return false;

		$key=key($array);
		if($key===null)
			return false;

		$value=current($array);
		next($array);

		return array(1=>$value, "value"=>$value, 0=>$key, "key"=>$key);
	}
}

if(!function_exists("split"))
{
	function split($pattern, $string, $limit=-1)
	{
		$parts=preg_split(compat_posix_pattern($pattern), (string)$string, $limit);
		return ($parts===false || $parts===null)?false:$parts;
	}
}

if(!function_exists("ereg"))
{
	function ereg($pattern, $string, &$regs=null)
	{
		return compat_posix_match($pattern, $string, $regs, "", func_num_args()>=3);
	}
}

if(!function_exists("eregi"))
{
	function eregi($pattern, $string, &$regs=null)
	{
		return compat_posix_match($pattern, $string, $regs, "i", func_num_args()>=3);
	}
}

if(!function_exists("ereg_replace"))
{
	function ereg_replace($pattern, $replacement, $string)
	{
		return compat_posix_replace($pattern, $replacement, $string, "");
	}
}

if(!function_exists("eregi_replace"))
{
	function eregi_replace($pattern, $replacement, $string)
	{
		return compat_posix_replace($pattern, $replacement, $string, "i");
	}
}

function compat_posix_pattern($pattern, $modifiers="")
{
	return "~".addcslashes($pattern, "~")."~".$modifiers;
}

function compat_posix_match($pattern, $string, &$regs, $modifiers, $capture)
{
	$match=array();
	$found=@preg_match(compat_posix_pattern($pattern, $modifiers), (string)$string, $match);

	if($found!==1)
		return false;

	if($capture)
		$regs=$match;

	return strlen($match[0]);
}

function compat_posix_replace($pattern, $replacement, $string, $modifiers)
{
	$result=@preg_replace(compat_posix_pattern($pattern, $modifiers), (string)$replacement, (string)$string);
	return $result===null?false:$result;
}
