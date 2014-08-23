<?php 
session_start();
include_once("../DAO/Dao.class.php");
include_once("../Modelo/Usuario.class.php");
include_once("../Modelo/Professor.class.php");
include_once("../HtmlLayout/HtmlLayout.class.php");
include_once("_header.php");

$layout = new HtmlLayout("html/professorEdit.html", TRUE);
$layout->includes('header', $incHeader->getLayout());


if($_POST){
	$professor = new Professor();
	$professor->setFromPostbackForm();
	$layout->changeValue("id_professor",$professor->id_professor);
	
	$professor->Edit();
	
	header("location: professorListar.php?id=".$professor->id_instituicao);
}else{	
	$layout->changeValue("id_professor", $_GET['id'] != "" ? $_GET['id'] : "new");
	$layout->changeValue("id_instituicao", $_GET['id_instituicao']);
	if($_GET['id']!= "new"){
		$professor = new Professor();
		$professor = $professor->buscar($_GET['id']);
		$layout->changeValue("nome", $professor->nome);
		$layout->changeValue("email", $professor->email);
		$layout->changeValue("login", $professor->login);
		$layout->changeValue("selected".$professor->status, "selected='selected'");
		
	}else{
		$layout->changeValue("nome", "");
		$layout->changeValue("email", "");
		$layout->changeValue("login", "");
	}
	
	echo $layout->getLayout();
}





 ?>