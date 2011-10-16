<?php

class Template
{
	var $buffer;
	var $assignments;
	
	function Template()
	{
		$this->buffer = "";
		$this->assignments = array();
	}
	
	function load($file_name)
	{
		$fh = fopen($file_name, 'r');
		
		while(($buffer = fgets($fh)) !== FALSE)
			$this->buffer .= $buffer;
		
		fclose($fh);
	}
	
	function assign($key, $value = null)
	{
		$this->assignments[$key] = $value;
	}
	
	function render_value($key, $value = null, $buffer = '')
	{
		if(!$buffer)
			$buffer = $this->buffer;
		
		return str_replace("{{$key}}", $value, $buffer);
	}
	
	function render_block($key, $value = array(), $buffer = '')
	{
		if(!$buffer)
			$buffer = $this->buffer;
		
		$matches = array();
		
		$block_exp = "/\{block:{$key}\}(.*?)\{\/block:{$key}\}/s";
		$block_body = "";
		$block_result = "";
		
		preg_match_all($block_exp, $buffer, $matches);
		
		$block_body = trim($matches[1][0]);
		
		for($i = 0; $i < count($value); $i++) {
			$r = $block_body;
			
			foreach($value[$i] as $k => $v) {
				if(!is_array($v))
					continue;
				
				$r = $this->render_block($k, $v, $block_body);
			}
			
			foreach($value[$i] as $k => $v) {
				if(is_array($v))
					continue;
				
				$r = $this->render_value($k, $v, $r);
			}
			
			$block_result .= $r;
		}
		
		$buffer = preg_replace($block_exp, $block_result, $buffer);
		
		return $buffer;
	}
	
	function render()
	{
		$buffer = "";
		
		foreach($this->assignments as $key => $value) {
			if(!is_array($value))
				continue;
			$buffer = $this->render_block($key, $value);
		}
		
		foreach($this->assignments as $key => $value) {
			if(is_array($value))
				continue;
			$buffer = $this->render_value($key, $value);
		}
		
		$this->buffer = $buffer;
	}
}

?>