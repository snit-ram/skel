<?php
/**
 * Classe abstrata que provê os métodos básicos e a interface para
 * conexões com diversos SGBD
 * @author evaldobarbosa <tryadesoftware@gmail.com>
 * @since 28-06-2011
 */
abstract class SkelConnection {
	private $sqlStmt;
	private $rs;
	private $config;
	private $link;
	
	/**
	 * Inicia uma transação com o SGBD
	 * @return void
	 */
	abstract function startTransaction();
	
	/**
	 * Encerra uma transação bem sucedida
	 * @return void
	 */
	abstract function commit();
	
	/**
	 * Encerra uma transação mal sucedida
	 * @return void
	 */
	abstract function rollback();
	
	/**
	 * Executa uma sentença a última sql informada
	 * @return void
	 */
	abstract function execute();
	
	/**
	 * Realiza a conexão com o SGBD em questão e retorna o resouce criado
	 * @return resource
	 */
	abstract function createResource();
	
	/**
	 * Retorna o estado atual da conexão
	 * @return boolean
	 */
	abstract function connected();
	
	/**
	 * Executa um comando SQL dado e atribui o resultado a um
	 * recordset
	 * @param string $sql Comando SQL a ser executado
	 * @return resource
	 */
	function query($sql) {
		$this->sqlStmt = $sql;
		
		$this->rs = $this->execute();
		
		return $this->rs;
	}
	
	/**
	 * Retorna o valor do atributo $sqlStmt que contém a
	 * última string SQL executada pela conexão
	 * @return string
	 */
	function getLastSql() { return $this->sqlStmt; }
	
	/**
	 * Verifica se uma chave ($key) de configuração existe e retorna a mesma
	 * @param mixed $key chave a ser procurada
	 * @return mixed
	 */
	function __get($key) {
		return ( isset($this->config[$key]) )
			? $this->config[$key]
			: null;
	}
	
	/**
	 * Atribui a uma chave de configuração (existente ou não)
	 * um dado valor
	 * @param mixed $key nome da chave
	 * @param mixed $value valor a ser atribuido
	 * @return void
	 */
	function __set($key,$value) {
		if ( !isset($this->config[$key]) )
			$this->config[$key] = null;
		$this->config[$key] = $value;
	}
	
	/**
	 * Retorna o recurso de conexão com o SGBD
	 * @return resource
	 */
	protected function getLink() { return $this->link; }
	
	/**
	 * Construtor da Classe de Conexão
	 * @param string $dsn URL para conexão com o SGBD
	 * @return void
	 */
	function __construct($dsn) {
		$c = parse_url($dsn);
		$this->type = $c["scheme"];
		$this->user = $c["user"];
		$this->pass = $c["pass"];
		$this->host = $c["host"];
		
		if ( isset($c["port"]) )
			$this->port = $c["port"];
		if ( !isset($c["path"]) ) {
			throw new Exception("You should give a database name");
		}
		$p = preg_split( "(/|\?=)", substr( $c["path"], 1, strlen($c["path"])-1) );
		$this->dbname = $p[0];
		if ( isset($p[1]) )
			$this->scheme = $p[1];
		
		$this->link = $this->createResource();
	}
}