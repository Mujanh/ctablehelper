<?php
namespace Limu\HTMLTable;

/**
* Simple class to create basic HTML tables with columns, rows and table headers.
* Some basic styling options are available if ctablehelper.css is included in your stylesheet.
* You can also add your own class name to handle the styling on your own.
*
* Available stylings:
*    'light'
*    'dark'
*    'oddeven'
*    'colorful'
*
*
* @package CTableHelper
*/

class CTableHelper {

    /**
    * Properties
    */

    private $cssClass;


    /**
    * Creates the table headers for each column (can be left as an empty array to exclude headers).
    *
    * @param array $headers contains headers for columns in table
    *
    * @return string $html, html code used to create table headers
    */
    private function createHeaders($headers) {
        $html = '<tr class="ctable-headertag">';
        foreach ($headers as $index => $header) {
            $html .= '<th>' . $header . '</th>';
        }
        $html .= '</tr>';
        return $html;

    }

    /**
    * Creates the table cells and rows.
    *
    * @param array $data contains the data that goes into the cells.
    *
    * @return string $html, html code used to create table cells and rows.
    */
    private function createCells($data){
        $html = '';
        foreach ($data AS $index => $row) {
            $html .= '<tr class="ctable-rows">';
            foreach ($row as $rownr => $data) {
                $html .= '<td>' . $data . '</td>';
            }
            $html .= '</tr>';
        }
        return $html;
    }

    /**
    * Checks if nr of headers are the same as nr of columns
    * @param array $headers all headers
    * @param array $headers all data cells
    *
    * @return true or false if different nr of columns and headers
    */
    private function checkNrOfHeaders($headers, $data) {
        $nrHeaders = count($headers);
        foreach ($data AS $key => $value) {
            $nrValue = count($value);
            if ($nrValue != $nrHeaders) {
                return "Failed to create HTMLTable, not an equal nr of headers and columns.";
            }
        }
    }

    /**
    * Checks if nr of cells are the same in each row
    * @param array $data all data cells
    *
    * @return bool true or false if different nr of cells on each row
    */
    private function checkNrOfCells($data) {
        //Check if there are the same number of cells in each row
        $checkValue = 0;
        $nrOfCells = count($data);
        for ($i = 0; $i < $nrOfCells; $i++) {
            foreach ($data AS $key => $value) {
                $counted = count($value);
                if ($i === 0) {
                    $checkValue = $counted;
                } elseif ($checkValue != $counted) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
    * Set the CSS class to be used for styling. Only accept strings.
    *
    * @param string $style the CSS class used for styling
    *
    * @return void
    */
    private function setStyle($style){
        //Checks if $style is a string, if not use default light as styling
        if(is_string($style)){
            $this->cssClass = $style;
        } else {
            $this->cssClass = 'light';
        }
    }

    /**
    * Creates a HTML Table.
    *
    * @param array $headers contains the table headers. Use empty array (array() or []) for table without headers.
    * @param nested array $data contains the data that goes into the cells.
    * @param string $style to choose which style to be used (optional).
    *
    * Example call to function:
    * $myheaders = ['header 1', 'header 2'];
    * $mydata = [['row1', 'row1'], ['row2', 'row2']];
    * createTable($myheaders, $mydata);
    *
    * @return string $html, html code used to create table cells and rows.
    */
    public function createTable($headers, $data, $style = '') {

        //Check if header or data is not an array
        if(!is_array($headers) || !is_array($data)) {
            return "Failed to create HTMLTable, header and data must be arrays.";
        }

        //Check that the nr of headers (if more than zero) matches nr of data columns
        // and if there are no headings, check that all rows contain the same number of columns
        if (!empty($headers)) {
            if(!$this->checkNrOfHeaders($headers, $data) === false) {
                return "Failed to create HTMLTable, not an equal nr of headers and columns.";
            }
        } else {
            if($this->checkNrOfCells($data) === false) {
                return "Failed to create HTMLTable, not equal nr of cells in each row.";
            }
        }

        //Set css class
        $this->setStyle($style);

        $tableHeader = $this->createHeaders($headers);
        $tableCells = $this->createCells($data);

        $html = <<< EOD
<table class="ctable-tabletag {$this->cssClass}">
{$tableHeader}
{$tableCells}
</table>
EOD;

        return $html;

    }
}
