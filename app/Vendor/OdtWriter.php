<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('Xml', 'Utility');

class OdtWriter {
	
	protected static function __extractODT(File $file = null) {
		if(!empty($file) && $file->exists()) {
			$temp = TMP . DS . rand();
			$extracted = new Folder($temp, true, 0777);
			$zip = new ZipArchive(); 
			if($zip->open($file->path)) {
				$zip->extractTo($temp);
				$zip->close(); 
			}
			return $extracted; 
		} else {
			throw new BadMethodCallException("File Doesn't even Exist!"); 
		}
	}
	
	public static function create(array $filenames = array(), $template = null) {
		if(empty($template)) {
			return false;  
		}
		if(!empty($filenames)) {
			$_path = TMP . DS . rand() . '.odt'; 
			$template = new File($template); 
			$template->copy($_path, true); 
			$template->close(); 
			
			$template = new File($_path); 
			
			$zip = new ZipArchive(); 
			$zip->open($template->path);
			
			foreach($filenames as $filename => $doc) {
				if($doc instanceof SimpleXMLElement) {
					$zip->addFromString($filename, $doc->asXML());
				} elseif(is_string($doc)) {
					$zip->addFromString($filename, $doc);
				} else {
					throw new InternalErrorException($file . ' is Not a SimpleXMLElement');
				}
			}
			
			$zip->close();
			
			return $template; 
		} else {

			return false;
		}
	}
	
	public static function extract(File $file = null) {
		if($extracted = self::__extractODT($file)) {
			try {
				$xml = Xml::build($extracted->path . DS . 'content.xml');
			} catch(XmlException $e) {
				if(!$extracted->delete()) {
					$this->log("Could not Delete: " . $temp);
				}
				throw new InternalErrorException("XML File is Corrupt: " . $e->getMessage());
			} 
			
			if(!$extracted->delete()) {
				$this->log("Could not Delete: " . $temp);
			}
			
			return $xml; 

		} else {
			throw new BadMethodCallException("Could Not Open ODT File"); 
		}
	}
	
	public static function InsertHtmlDocument($html = null, SimpleXMLElement $position = null) {
		if( !empty($html) && ($position instanceof SimpleXMLElement) ) {
			if($xml = Xml::build(self::HtmlToOdt($html))) {

				$position->{$xml->getName()} = $xml; 
				
				return $position;
			} else {
				throw new BadMethodCallException('Not HTML');
			}
		} else {
			return false; 
		}
	}
}