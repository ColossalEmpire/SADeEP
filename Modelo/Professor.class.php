<?php
include_once("../Interface/IModelo.class.php");
/**
 * 
 */
class Professor extends Usuario {
	public $id_professor;
	public $nome;
	private $db;
	
	function __construct() {
		$this->db = new DAO();
	}
	
	public function buscar($id){
		$query = "select * from view_professor where id_professor = :id_professor";
		$params = array(':id_professor' => $id);
		$retorno = $this->db->selectInClass($query, $params, "Professor");
		
		return $retorno[0];
	}
	
	public function buscarLogin($_login){
		$query = "select p.* from professor p inner join usuario u ON u.id_usuario = p.id_usuario where u.login = :login";
		$params = array(':login' => $_login);
		$retorno = $this->db->selectInClass($query, $params, "Professor");
		
		return $retorno[0];
	}
	
	public function buscarNome($obj){
		$query = "SELECT * FROM professor WHERE nome = :nome";
		$params = array(':nome' => $obj->Nome());
		$retorno = $this->db->selectInClass($query, $params, "Professor");
		
		return $this->montarObjeto($obj, $retorno[0]);
	}
	

	function listar($numeroRegistros,$pagina,$order){
		$query = "SELECT * FROM professor ORDER BY :order LIMIT :limit OFFSET :offset ";
		$params[":order"] = $order;
		$params[":limit"] = $numeroRegistros;
		$params[":offset"] = ($pagina - 1) * $numeroRegistros;
		$list = $this->db->selectInClass($query, $params, "Professor");
		/*$usuarioList = array();
		$count = 0;
		foreach($list as $usuario){
			$usuarioList[$count] = new Usuario();
			$this->montarObjeto($usuarioList[$count], $usuario);
			$count++;
		}*/
		
		return $list;
	}
	
	function listarPorInstituicao($instituicao,$numeroRegistros,$pagina,$order){
		$query = "SELECT * FROM professor WHERE id_instituicao = :id_instituicao ORDER BY :order LIMIT :limit OFFSET :offset ";
		$params[":id_instituicao"] = $instituicao;
		$params[":order"] = $order;
		$params[":limit"] = $numeroRegistros;
		$params[":offset"] = ($pagina - 1) * $numeroRegistros;
		$list = $this->db->selectInClass($query, $params, "Professor");
		/*$usuarioList = array();
		$count = 0;
		foreach($list as $usuario){
			$usuarioList[$count] = new Usuario();
			$this->montarObjeto($usuarioList[$count], $usuario);
			$count++;
		}*/
		
		return $list;
	}
	
	function listarAssync($nome){
		$query = "select * from professor where nome ilike :nome order by nome limit 10 ";
		$params[":nome"] = "%".$nome."%";
		
		$list = $this->db->selectInClass($query, $params, "Professor");
		/*$usuarioList = array();
		$count = 0;
		foreach($list as $usuario){
			$usuarioList[$count] = new Usuario();
			$this->montarObjeto($usuarioList[$count], $usuario);
			$count++;
		}*/
		if(count($list) > 0){
			return $list;
		}else{
			return array();
		}
	}
	
	function Edit(){
		
		$query = "SELECT editar_professor(:id_professor::INT,:id_instituicao::INT,:status::INT,:nome::VARCHAR,:email::VARCHAR,:login::VARCHAR,:senha::VARCHAR); ";
		$params[":id_professor"] = $this->id_professor == "new"? 0 : $this->id_professor;
		$params[":id_instituicao"] = $this->id_instituicao;
		$params[":status"] = $this->status;
		$params[":nome"] = $this->nome;
		$params[":email"] = $this->email;
		$params[":login"] = $this->login;
		$params[":senha"] = $this->senha == "" || $this->senha == null ? "NULL" : $this->senha;
		
		return $this->db->execute($query, $params);	
	}
	 
	 public function setFromPostbackForm(){
	 	foreach($_POST as $name => $value){
	 		$this->$name = $value;
		}
	 }
	
}
?>