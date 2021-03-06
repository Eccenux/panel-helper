<?php

// <editor-fold defaultstate="collapsed" desc="generic test preparation">
date_default_timezone_set('Europe/Paris');
// include tested class
$testedClass = preg_replace(
	array(
		'#\\.tests\\\\#',
		'#Test(?=.php$)#'
	)
	, ""
	, __FILE__
);
include $testedClass;
// </editor-fold>

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-06-15 at 00:31:09.
 */
class CsvParserTest extends PHPUnit_Framework_TestCase
{
	private $profileCsv;
	private $profileOrder;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		echo "\nTest setUp"
			."\n-------------\n"
		;
		$this->profileCsv = __DIR__.'\profile.csv';
		$this->profileOrder = explode(',',  "-,group_name,sex,age_min_max,region,-,invites_no");
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * Check columns ignore.
	 * @covers CsvParser::parse
	 */
	public function testParse_Profile_Ignores()
	{
		$expectedColumnsCount = count($this->profileOrder) - 2;
		$parser = new CsvParser($this->profileCsv, $this->profileOrder);
		$parser->parse();
		//var_export($parser->rows);
		$firstRow = $parser->rows[CsvRowState::OK][0];
		$this->assertEquals($expectedColumnsCount, count($firstRow));
	}

	/**
	 * Check that raw CSV column is added.
	 * @covers CsvParser::parse
	 */
	public function testParse_Profile_RawCsv()
	{
		$parser = new CsvParser($this->profileCsv, $this->profileOrder);
		$parser->columnParsers['invites_no'] = function($name, $value){
			return CsvParser::parseColumnInteger($name, $value);
		};
		$parser->parse(true);
		$firstRow = $parser->rows[CsvRowState::OK][0];
		var_export($firstRow);
		$this->assertArrayHasKey('csv_row', $firstRow);
	}

	/**
	 * Check column parsers for profiles.
	 * @covers CsvParser::parse
	 */
	public function testParse_Profile_ColumnParsers()
	{
		$expectedColumnsCount = count($this->profileOrder) - 2 + 1;
		$parser = new CsvParser($this->profileCsv, $this->profileOrder);
		$parser->columnParsers['invites_no'] = function($name, $value){
			return CsvParser::parseColumnInteger($name, $value);
		};
		$parser->columnParsers['age_min_max'] = function($name, $value){
			return CsvParser::parseColumnRange('age_', $value);
		};
		$parser->parse();
		$firstRow = $parser->rows[CsvRowState::OK][0];
		var_export($firstRow);
		$this->assertEquals($expectedColumnsCount, count($firstRow));
		$this->assertArrayNotHasKey(CsvRowState::WARNING, $parser->rows);
		$this->assertArrayHasKey(CsvRowState::INVALID, $parser->rows);
	}

	/**
	 * Various, valid ranges test.
	 * @covers CsvParser::parseColumnRange
	 */
	public function testParseColumnRange()
	{
		$values = array(
			'123-345' => array('min'=>'123', 'max'=>'345'),
			'123,345' => array('min'=>'123', 'max'=>'345'),
			'123, 345' => array('min'=>'123', 'max'=>'345'),
			'345+' => array('min'=>'345'),
		);
		foreach ($values as $value => $expected)
		{
			$result = CsvParser::parseColumnRange("", $value);
			//var_export($result);
			$this->assertEquals($expected, $result['columns'], "Testing value: $value");//.var_export($expected, true));
		}
	}

	/**
	 * Basic parseRow test.
	 * @covers CsvParser::parseRow
	 */
	public function testParseRow()
	{
		$parser = new CsvParser(__FILE__, array('name', 'age'));
		$data = array('test', '1');
		$row = $parser->parseRow($data);
		var_export($row);
		$this->assertEquals($row['columns']['name'], 'test');
		$this->assertEquals($row['columns']['age'], '1');
		$this->assertEquals($row['state'], CsvRowState::OK);
	}
	/**
	 * Custom column functions test.
	 * @covers CsvParser::parseRow
	 */
	public function testParseRow_CustomFunction()
	{
		$parser = new CsvParser(__FILE__, array('name', 'age'));
		$parser->columnParsers['age'] = function($name, $value){
			return CsvParser::parseColumnInteger($name, $value);
		};
		// OK
		$data = array('test', '1');
		$row = $parser->parseRow($data);
		var_export($row);
		$this->assertEquals($row['columns']['name'], 'test');
		$this->assertSame($row['columns']['age'], 1);
		$this->assertEquals($row['state'], CsvRowState::OK);

		// invalid
		$data = array('test', 'abc');
		$row = $parser->parseRow($data);
		var_export($row);
		$this->assertEquals($row['columns']['name'], 'test');
		$this->assertEquals($row['state'], CsvRowState::INVALID);
	}
	/**
	 * Test requirement validation.
	 * @covers CsvParser::parseRow
	 */
	public function testParseRow_Requirement()
	{
		$parser = new CsvParser(__FILE__, array('name', 'age'));
		$parser->columnParsers['name'] = function($name, $value){
			return CsvParser::parseColumnRequired($name, $value);
		};
		$parser->columnParsers['age'] = function($name, $value){
			return CsvParser::parseColumnInteger($name, $value);
		};
		// OK
		$data = array('test', '1');
		$row = $parser->parseRow($data);
		var_export($row);
		$this->assertEquals($row['columns']['name'], 'test');
		$this->assertSame($row['columns']['age'], 1);
		$this->assertEquals($row['state'], CsvRowState::OK);

		$values = array(
			',123' => CsvRowState::INVALID,
			'a,123' => CsvRowState::OK,
			'123,123' => CsvRowState::OK,
			'123,abc' => CsvRowState::INVALID,	// valid name, but not age
		);
		foreach ($values as $value => $expected)
		{
			$data = explode(",", $value);
			$row = $parser->parseRow($data);
			$this->assertEquals($expected, $row['state'], "Testing value: $value");//.var_export($expected, true));
		}
	}

	/**
	 * State combination test.
	 * @covers CsvParser::parseRow
	 */
	public function testParseRow_StateCombination()
	{
		$columnParsers['ok'] = function($name, $value){
			return array(
				'state' => CsvRowState::OK,
				'columns' => array(
					$name => $value,
				)
			);
		};
		$columnParsers['invalid'] = function($name, $value){
			return array(
				'state' => CsvRowState::INVALID,
				'columns' => array(
					$name => $value,
				)
			);
		};
		$columnParsers['warning'] = function($name, $value){
			return array(
				'state' => CsvRowState::WARNING,
				'columns' => array(
					$name => $value,
				)
			);
		};

		// all states
		$parser = new CsvParser(__FILE__, array('ok', 'invalid', 'warning'));
		$parser->columnParsers = $columnParsers;
		$data = array(1,2,3);
		$row = $parser->parseRow($data);
		echo "\n"; var_export($row);
		$this->assertSame($row['state'], CsvRowState::OK | CsvRowState::INVALID | CsvRowState::WARNING);

		// non-ok
		$parser = new CsvParser(__FILE__, array('invalid', 'warning'));
		$parser->columnParsers = $columnParsers;
		$data = array(1,2,3);
		$row = $parser->parseRow($data);
		echo "\n"; var_export($row);
		$this->assertSame($row['state'], CsvRowState::INVALID | CsvRowState::WARNING);
		$this->assertNotEquals($row['state'], CsvRowState::OK);
		$this->assertNotEquals($row['state'], CsvRowState::INVALID);
		$this->assertNotEquals($row['state'], CsvRowState::WARNING);
	}
}
