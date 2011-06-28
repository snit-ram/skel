<?php
require("../Skel.php");
require("../connection/SkelConnection.php");
require("../connection/SkelPostgresConnection.php");
/**
 *  test case.
 */
class SkelTest extends PHPUnit_Framework_TestCase {
	private $dsn;
	
	function testInstance() {
		$conn = new SkelPostgresConnection( $this->dsn );
		
		$this->assertTrue( $conn instanceof SkelPostgresConnection );
		
		$this->assertTrue( $conn instanceof SkelConnection );
	}
	
	function testConnecting() {
		$dsn = $this->dsn;
		$conn = new SkelPostgresConnection( $dsn );
		
		$this->assertTrue( $conn->connected() );
	}
	
	function testQuery() {
		$dsn = $this->dsn;
		$conn = new SkelPostgresConnection( $dsn );
		
		$conn->startTransaction();
		
		$x1 = $conn->query( "SELECT 1 as numero" );
			$x1 = pg_fetch_all($x1);
		$this->assertArrayHasKey( "numero", $x1[0] );
			
		$conn->commit();
		$this->assertEquals( "COMMIT;", $conn->getLastSql() );
		
		$conn->startTransaction();
			$x2 = $conn->query( "SELECT 2 as numero" );
			$x2 = pg_fetch_all($x2);
			$this->assertEquals( 2, $x2[0]["numero"] );
		$conn->rollback();
		$this->assertEquals( "ROLLBACK;", $conn->getLastSql() );
	}
	
	/**
	 * @expectedException Exception
	 */
	function testConnectNohost() {
		$dsn = 'postgres://postgres:postgres123@:5432/delivery/teste_schema';
		$conn = new SkelPostgresConnection( $dsn );
	}
	
	function testConnectLocalhost() {
		$dsn = 'postgres://postgres:postgres123@localhost:5432/delivery/teste_schema';
		$conn = new SkelPostgresConnection( $dsn );
	}
	
	function setUp() {
		parent::setUp();
		
		$this->dsn = 'postgres://postgres:postgres123@localhost:5432/delivery/teste_schema';
	}
}
?>