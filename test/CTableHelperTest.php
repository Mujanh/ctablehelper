<?php

namespace Limu\HTMLTable;

class CTableHelperTest extends \PHPUnit_Framework_TestCase
{

    private $headers = ['header1', 'header2'];
    private $data = [['row1', 'row1'], ['row2', 'row2']];

    public function testCreateTable_noCSS(){
        $table = new \Limu\HTMLTable\CTableHelper();
        $res = $table->createTable($this->headers, $this->data);
        $exp = <<<EOD
<table class="ctable-tabletag ">
<tr class="ctable-headertag"><th>header1</th><th>header2</th></tr>
<tr class="ctable-rows"><td>row1</td><td>row1</td></tr><tr class="ctable-rows"><td>row2</td><td>row2</td></tr>
</table>
EOD;

        $this->assertEquals($res, $exp, "Create test table without css missmatch");

    }

    public function testCreateTable_CSS(){
        $table = new \Limu\HTMLTable\CTableHelper();
        $res = $table->createTable($this->headers, $this->data, 'light');
        $exp = <<<EOD
<table class="ctable-tabletag light">
<tr class="ctable-headertag"><th>header1</th><th>header2</th></tr>
<tr class="ctable-rows"><td>row1</td><td>row1</td></tr><tr class="ctable-rows"><td>row2</td><td>row2</td></tr>
</table>
EOD;

        $this->assertEquals($res, $exp, "Create test table with css missmatch");
    }

    public function testCreateTable_noHeaders(){
        $table = new \Limu\HTMLTable\CTableHelper();
        $res = $table->createTable(array(), $this->data);
        $exp = <<<EOD
<table class="ctable-tabletag ">
<tr class="ctable-headertag"></tr>
<tr class="ctable-rows"><td>row1</td><td>row1</td></tr><tr class="ctable-rows"><td>row2</td><td>row2</td></tr>
</table>
EOD;

        $this->assertEquals($res, $exp, "Create test table with css missmatch");
    }

    public function testValidationArrays() {
        $table = new \Limu\HTMLTable\CTableHelper();

        // Two strings instead of arrays
        $res = $table->createTable('header', 'data');
        $exp = "Failed to create HTMLTable, header and data must be arrays.";

        $this->assertEquals($res, $exp, "Validation of arrays (two strings) missmatch");

        // Headers = string, rows = array
        $cells = [['row1'], ['row2']];
        $res = $table->createTable('header', $cells);
        $exp = "Failed to create HTMLTable, header and data must be arrays.";

        $this->assertEquals($res, $exp, "Validation of arrays (header string) missmatch");

        // Rows = string, headers = array
        $header = ['header'];
        $res = $table->createTable($header, 'row');
        $exp = "Failed to create HTMLTable, header and data must be arrays.";

        $this->assertEquals($res, $exp, "Validation of arrays (row string) missmatch");

    }

    public function testValidationEquality(){
        $table = new \Limu\HTMLTable\CTableHelper();

        // Fewer row columns than header columns
        $cells = [['row1'], ['row2']];
        $res = $table->createTable($this->headers, $cells);
        $exp = "Failed to create HTMLTable, not an equal nr of headers and columns.";

        $this->assertEquals($res, $exp, "Validation of equal nr of rows (fewer) and cols (more) missmatch");

        // Fewer header columns than row columns
        $header = ['header'];
        $res = $table->createTable($header, $this->data);
        $exp = "Failed to create HTMLTable, not an equal nr of headers and columns.";

        $this->assertEquals($res, $exp, "Validation of equal nr of rows (more) and cols (fewer) missmatch");

        // Not equal nr of table cells in each row (no headers)
        $datacells = [['row1', 'row1'], ['row2']];
        $res = $table->createTable(array(), $datacells);
        $exp = "Failed to create HTMLTable, not equal nr of cells in each row.";

        $this->assertEquals($res, $exp, "Validation of equal nr of datacells missmatch");
    }

    public function testValidationCSS() {
        $table = new \Limu\HTMLTable\CTableHelper();
        $res = $res = $table->createTable($this->headers, $this->data, array('notstring'));
        $exp = <<<EOD
<table class="ctable-tabletag light">
<tr class="ctable-headertag"><th>header1</th><th>header2</th></tr>
<tr class="ctable-rows"><td>row1</td><td>row1</td></tr><tr class="ctable-rows"><td>row2</td><td>row2</td></tr>
</table>
EOD;
        $this->assertEquals($res, $exp, "Validation of CSS type missmatch");
    }


}
