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
            $fh,        // file handler
            $columns = [
                'date', 'rx (GiB)', 'tx (GiB)', 'total (GiB)', 'delta (MiB)'
            ];

    /**
     * Class constructor
     *
     * @param string $logPath
     * @param string $csvFile
     */
    function __construct(string $logPath, string $csvFile){
        touch($logPath . '/'. $csvFile);
        $this->file = realpath($logPath .'/' . $csvFile);
        $this->fh = fopen($this->file, 'a+');

        // Write header columns if file is empty
        if(filesize($this->file) == 0){
            $this->appendLine($this->columns);
        }
    }

    /**
     * Append a new line
     *
     * @param array $columns array with columns
     * @return bool
     */
    public function appendLine(array $columns){
        $newLine = implode(',', $columns) . PHP_EOL;
        $write = fwrite($this->fh, $newLine);
        if($write > 0) return true;
        else return false;
    }

    /**
     * Return columns in the last line in the CSV with data, omit first line
     *
     * @return null|array
     */
    public function lastLine(){
        $content = fread($this->fh, filesize($this->file));
        $lines = explode(PHP_EOL, $content);

        // Only one line, return null
        if(count($lines) <= 2) return null;

        // Return last line
        $lastIndex = array_key_last($lines);
        $lastLine = $lines[$lastIndex -1];

        return explode(',', $lastLine);
    }

    /**
     * Close the file handler
     *
     * @return void
     */
    public function close(){
        fclose($this->fh);
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