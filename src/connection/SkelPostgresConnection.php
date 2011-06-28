<?php
/**
 * Classe que implementa a conexão com Postgresql
 * @author evaldobarbosa <tryadesoftware@gmail.com>
 * @since 28-06-2011
 */
class SkelPostgresConnection extends SkelConnection {
	/**
	 * Conecta ao Postgres e atribui ao atributo $link (herdado)
	 * o resultado da conexão
	 * @see connection/SkelConnection#createResource()
	 * @return void
	 * @todo Verificar se faz-se necessário tratar algum erro de conexão
	 */
	function createResource() {
		return pg_connect( $this->createConnString() );
	}
	
	function startTransaction() {
		$this->query("BEGIN WORK;");
	}
	
	function commit() {
		$this->query("COMMIT;");
	}
	
	function rollback() {
		$this->query("ROLLBACK;");
	}
	
	function execute() {
		return pg_query( $this->getLink(), $this->getLastSql() );
	}
	
	/**
	 * Cria a string de conexão com o Postgres e a retorna
	 * @return string
	 */
	private function createConnString() {
		$params = array();
		
		if ( $this->user ) {
			$params[] = "user={$this->user}";
		}
		if ( $this->pass ) {
			$params[] = "password={$this->pass}";
		}
		$params[] = "host={$this->host}";
		$params[] = "dbname={$this->dbname}";
		
		return implode(" ",$params);
	}
	
	function connected() {
		return pg_connection_status( $this->getLink() ) === 0;
	}
}