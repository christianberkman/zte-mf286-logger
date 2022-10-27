<?php
/**
 * ZTE MF286 Data Usage Logger
 * 2022 by Christian Berkman
 * 
 * CVS Class
*/

namespace Logger;

class Csv{

    /**
     * Properties
     */
    private $file,      // absolute path to csv file
            $filesize,
            $handler,        // file handler
            $columns = [
                'date', 'rx (GiB)', 'tx (GiB)', 'total (GiB)', 'delta (MiB)'
            ];

    /**
     * Class constructor
     *
     * @param $handler File Handler
     */
    function __construct($handler){
        if(gettype($handler) != 'resource') throw new \Exception('Constructor expects fopen() resource');
        $this->handler = $handler;
    }

    /**
     * Append a new line
     *
     * @param array $columns array with columns
     * @return bool
     */
    public function appendLine(array $columns){
        $newLine = '';
        
        // Insert headers if blank file
        $filesize = fstat($this->handler)['size'];
        if($filesize = 0){
            $newline .= implode(',', $this->columns) . PHP_EOL;
        }
        
        $newLine .= implode(',', $columns) . PHP_EOL;
        $write = fwrite($this->handler, $newLine);
        if($write > 0) return true;
        else return false;
    }

    /**
     * Return columns in the last line in the CSV with data, omit first line
     *
     * @return null|array
     */
    public function lastLine(){
        $filesize = fstat($this->handler)['size'];
        if($filesize == 0) return null;
        $content = fread($this->handler, $filesize);
        $lines = explode(PHP_EOL, $content);

        // Only one line, return null
        if(count($lines) <= 2) return null;

        // Return last line
        $lastIndex = array_key_last($lines);
        $lastLine = $lines[$lastIndex -1];

        return explode(',', $lastLine);
    }

    public function records(){
        // Read file contents
        $filesize = fstat($this->handler)['size'];
        if($filesize == 0) return 0;
        $content = fread($this->handler, $filesize);
        $lines = explode(PHP_EOL, $content);

        // Remove first line
        unset($lines[0]);
        
        // Get columns
        $columns = [];
        foreach($lines as $line){
            if(empty($line)) continue;
            $columns[] = explode(',', $line);
        }

        return $columns;
    }

    /**
     * Close the file handler
     *
     * @return void
     */
    public function close(){
        fclose($this->handler);
    }

    /**
     * Magic getter
     *
     * @param string $property
     * @return void
     */
    public function __get(string $property){
        if(isset($this->$property)) return $this->$property;
        else return null;
    }
}
