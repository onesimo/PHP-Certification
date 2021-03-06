<?php 
/*
Constante
*/

class Copo{
	const LIMIT = 100;

	public $tamanho; 
	public $cor;

	function adicionarBebida($bebida, $quantidade){
		if($quantidade > self::LIMIT){
			print 'A quantidade excede o limite suportado pelo copo';

			exit();
		}

		print 'bebida escolhida '.$bebida;
	}
}

$copo = new Copo();

/*
$data = get_class_methods('Copo');

Array
(
    [0] => adicionarBebida
)

*/
 
/*$data = get_class_vars('Copo');
Array
(
    [tamanho] =>
    [cor] =>
)


Duas formas de acessar uma constante

echo Copo::LIMIT;
echo $copo::LIMIT;


Class Abstratas

- metodos abstratos devem ser implementados na classe filha, caso contrário exibirá um FATAL ERROR
- metodos que não são abstratos precisam de um corpo
- classes abstratas não podem ser instancias, caso seja gerará um FATAL ERROR
*/

abstract class WebService{
	abstract function tratarRequisicao();
	abstract function tratarResposta();
}


class WebServiceJson extends WebService{
	function tratarRequisicao(){

	}

	function tratarResposta(){

	}
}

class WebServiceXml extends WebService{
	function tratarRequisicao(){

	}

	function tratarResposta(){

	}
}

/*
Traits
- podem ter propriedas assim como uma classe
- Metodos na classe filha sobrescreve os metodos da trait
- Podem ter metodos abstratos assim como em uma classe
*/

trait log{
	public function gravar($msg){
		return file_put_contents('log.txt', $msg);
	}
}

class GerenciadorDeLog{
	use Log;

	public function gravar($msgs){
		print 'esse metodo substitui o metodo da trait';
	}

}

$glog = new GerenciadorDeLog();
#$glog->gravar('essa msg');

/*
Interfaces
- Todos os metodos devem ser implementas na classe que implementa

*/


interface carro{
	public function acelerar();
	public function parar();
}

class CarroPequeno implements carro{
	public function acelerar(){}
	public function parar(){}
}

/*
FINAL -  a palavra reservada final bloquea a heranca da classe ou metodo.
- caso tente herdar um classa com a palavra FINAL exibirá um FATAL ERROR
- caso tente sobrescrever um metodo com palavra final exibira um FATAL ERROR
- uma classe com a palavra final pode ser instanciada normalmente, mas não herdad, um  metodo com a palavra final pode ser utilizado normalmente, mas não pode ser sobrescrito
*/

 class Tv{

	final public function mudarCanal2(){

	}
}

final class SmartTv extends Tv{
	 public function mudarCanal(){
		echo "teste";
	}
}

$tv = new SmartTv();

$tv->mudarCanal2();


/*
Modificadores de Acesso

public - pode ser acessado livremente
protected - so pode ser utilizar dento da classe ou de uma classe filha

private - pode ser acessado somente dentro da própria classe
*/

class Carro2{
	protected $marca ='GM';
}

$car = new Carro2;
//$car->marca = 'Ford'; // FATAR ERROR



/*
$this - variavel especial

$this = 'teste';
Fatal error: Cannot re-assign $this in D:\xampp\htdocs\php-certification\object-oriented-programming\oop_03.php on line 171


Métodos Mágicos
*/

Class Pessoa{ 

	function __construct(){
		//print ' construtor '.PHP_EOL;	
	}

	function __destruct(){
		//print ' destruidor '.PHP_EOL;
	}

	/*
	Chamado quando um metodo esta inacessivel ou é inexistente
	 - obrigatorio ter 2 parametros, metodo e argumentos
	*/
	function __call($method, array $args){
		
		print 'metodo '. $method.PHP_EOL;

		foreach ($args as $argumento) {
			print $argumento.PHP_EOL;
		}
	}

	public function __get($nome){
		// print 'tentando acessar propriedade '.$nome.PHP_EOL;
	}

	public function __set($nome, $valor){
		// print 'tentativa de acessar a propriedade '.$nome. ' valor '.$valor.PHP_EOL;
	}
}

$pessoa = new Pessoa();
//$pessoa->MetodoInexiste(1,2,3,3);

/*
echo $pessoa->nome; // chama get
$pessoa->nome = 'joao'; //chama set
*/

//sleep(2);


class Colecao{
	public  $dados = [];
 
	public function __set($nome, $valor){
		//echo " Atribuindo valor ";
		$this->dados[$nome] = $valor;

	} 

	/*public function __isset($name){
		echo "verifica se foi setado ";

		return array_key_exists($name, $this->dados);
	}*/

	public function __unset($name){
		echo "remove propriedade se ela existir no array";

		if(array_key_exists($name, $this->dados)){
			unset($this->dados[$nome]);
		}
	}

	function __sleep(){
		print 'metodo serialize';

		return[];
	}

	function __wakeup(){
		print 'metodo unserialize';

		return[];
	}

	function __toString(){
		return ' virei string ';
	}

	function __invoke(){
		print 'method invoke'.func_get_arg(1);
	}
}

$obj = new Colecao;

//$obj(45,454);
/*
echo $obj;
*/
$obj->a = 1;
$obj->b = 1;

//echo $dat = serialize($obj); // O:7:"Colecao":0:{}

//unserialize($dat);

//print_r(unserialize($dat));


unset($obj->dados['b']);
//print_r($obj);
//echo $obj->a;
//echo $obj->dados['a'];

$propriedade = isset($obj->a);
/*
var_dump($propriedade);


unset
clone = clonagem raza ou seja shallow para alterar o comportamento utiliza-se o metodo __clone ( clona outros objetos que estão instanciados dentro da classe clonada)


Exceções TRY/CATCH

-Será executado o bloco catch pela primeira classe que satisfazer a exceção que foi lançada.
- Finally sempre sera executado
-
*/

function nM($a=0, $b =0){
	if($a > $b){
		throw new Exception("o primeiro e maior");
	}

	if($a === $b){
		throw new InvalidArgumentException("São Iguais");	
	}
}

try{
	nM(1,2);
}catch(Exception $exec){
	print 'generico '.$exec->getMessage();
}catch(InvalidArgumentException $exec){
	print 'invalido '.$exec->getMessage();
}finally{
	//print 'sempre e executado';
}

/*
Criando sua própria Exceção
*/


class NumeroInvalido extends Exception{}

function lancarExcecao($numero){
	if(!is_numeric($numero)){
		throw new NumeroInvalido("somente numerico");
		
	}
}


try{
	lancarExcecao(1);
}catch (NumeroInvalido $execao){
	print $execao->getMessage();
}

/*
Late Static Binding e SELF
*/

Class A{
	public static function quem(){
		print __CLASS__;
	}

	public static function test(){
		//self chama da propria classe
		//static classe pelo qual foi chamado
		static::quem();
	}
}

class B extends A{
	public static function quem(){
		echo __CLASS__;
	}
}

//echo A::test(); //A

/*
Quiz
*/

abstract class myBaseClass{
	abstract protected function doSomething();

	function threeDots(){
		return '...';
	}
}

class myBaseA extends myBaseClass{
	protected function doSomething(){
		echo $this->threeDots();
	}
	function methodTest(){

	}
}

$a = new myBaseA();
//$a->doSomething();   // FATAL ERROR não é possivel acessar protected 

class Magic{
	public $a = 'A';
	protected $b = array("a"=>"A", "b"=>"B", "c"=>"C");
	protected $c = array(1,2,3);

	public function __get($v){
		echo "$v,";
		return $this->b[$v];
	}

	public function __set($var, $val){
		echo "$var : $val";
		$this->$var = $val;
	}
}

$m = new Magic();
/*
echo $m->a.", ".$m->b. ', '.$m->c.",";
$m->c = "CC";
echo $m->a.", ".$m->b. ", ".$m->c;


resultado : b,c,A, B, C,c : CCb,c,A, B, C

Qual a relação entre classe e objetos?

A classe é um modelo no qual os objetos serão criados.

Qual a princial diferença entre um método estático e um metodo normal?

R: métodos estáticos não podem  ser declarados dentro dentro de classes

$c = $a->getInstance()->methodTest();

Qual a saida

*/

interface foo{}

//cria alias baseado na classe original
class_alias('foo','bar');

interface_exists('bar') ? 'yes'  : 'no';
 
/*
R: yes


Qual classe SPL estende o Iterator padrão e permite retornar
um item específico de uma lista interna da class?

R: RecursiveIterator

Qual metodo é invocado quando um metodo da classe esta inacessivel ou não exite?

R: __call
*/



