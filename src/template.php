<?php

class Template
{
	var $buffer;
	
	function load($file_name)
	{
		$fh = fopen($file_name, 'r');
		
		while(($buffer = fgets($fh)) !== FALSE)
			$this->buffer .= $buffer;
		
		fclose($fh);
	}
	
	function assign($key, $value = '')
	{
		if(is_array($value))
			return $this->assign_block($key, $value);
		
		$this->buffer = str_replace("{{$key}}", $value, $this->buffer);
	}
	
	function assign_block($key, $value = array())
	{
		$matches = array();
		
		$block_exp = "/\{block:{$key}\}(.*?)\{\/block:{$key}\}/s";
		$block_body = "";
		$block_result = "";
		
		preg_match_all($block_exp, $this->buffer, $matches);
		
		$block_body = trim($matches[1][0]);
		
		for($i = 0; $i < count($value); $i++) {
			$r = $block_body;
			
			foreach($value[$i] as $k => $v) {
				$r = str_replace("{{$k}}", $v, $r);
			}
			
			$block_result .= "\t" . $r . "\r\n";
		}
		
		$block_result = rtrim($block_result);
		
		$this->buffer = preg_replace($block_exp, $block_result, $this->buffer);
	}
}

?>