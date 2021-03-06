<?php 
/*
JSON - JavaScript Object Notation

Enconding Data
*/
$array = ['foo', 'bar', 'baz'];

//echo json_encode($array); //["foo","bar","baz"]

//String keys

$array =  ['one' => 'foo', 'two' => 'bar', 'three' => 'baz'];

//echo json_encode($array);  // {"one":"foo","two":"bar","three":"baz"}

/*
json_encode suports numerous options, most of which were added in php 5.3

JSON_HEX_TAG - convert all &lt, to their hx equivalent
JSON_HEX_AMP - convert all &amp to their hex equivalent
JSON_HEX_APOS - convert all apostrophes
JSON_HEX_QUOT - convert all straight double quotes
JSON_FORCE_OBJECT - outpus an objects intead of an array
JSON_NUMERIC_CHECK - encodes numeric strings as numbers
JSON_BIGINT_AS_STRING - encodes large integer as string
JSON_PRETTY_PRINT - use whitespace to make it easier  to read
JSON_UNESCAPED_SLASHES - don't escape /
JSON_UNESCAPED_UNICEDE - Do not convert unicode characteres to escape sequences (\uXXXX)

JSON OPTIONS
*/

$array =  [
		'name' => 'David Smith', 
		'age' => '26',
	];

$options = JSON_PRETTY_PRINT | 
		   JSON_NUMERIC_CHECK | 
		   JSON_FORCE_OBJECT;
/*ECHO "<PRE>";
echo json_encode($array, $options);  // 
output:

{
    "name": "David Smith",
    "age": 26
}

Enconding Objects
*/
class User implements JsonSerializable
{
	public $first_name;
	public $last_name;
	public $email;
	public $password;

	function jsonSerialize(){
		return [
			"name" => $this->first_name. ' '.$this->last_name,
			"email_hash" => md5($this->email),
		];
	}
}

/*
Now, when we call json_encode() on instance of your User class, we get our custom back, given a user instance that looks, like this.
*/


//print_r(json_encode(new User())); //{"name":" ","email_hash":"d41d8cd98f00b204e9800998ecf8427e"}

/*
Decoding Data
*/

$json = '{ "name": "Jhon", "age": 25}';
$data = json_decode($json);
/*
var_dump($data);
outpus:
object(stdClass)#1 (2) { ["name"]=> string(4) "Jhon" ["age"]=> int(25) }

If you want to force json_encode to return an array, just pass true for the second argument assoc
*/

$data = json_decode($json, true);
/*
outups
var_dump($data);
array(2) { ["name"]=> string(4) "Jhon" ["age"]=> int(25) }

Dates and Times

*/

$date = new \DateTime();
/*echo '<pre>';
print_r($date);

DateTime Object
(
    [date] => 2016-03-22 03:54:18.000000
    [timezone_type] => 3
    [timezone] => Europe/Berlin
)*/
$date = new \DateTime('now');
/*echo '<pre>';
print_r($date);
DateTime Object
(
    [date] => 2016-03-22 03:54:18.000000
    [timezone_type] => 3
    [timezone] => Europe/Berlin
)*/

//current time yesterdat
$date = new \DateTime('yesterday');

//current time, two days ago
$date = new \DateTime('-2 days');

//current time, same day last week
$date = new \DateTime('last week');

//current time, same day 3 weeks ago
$date = new \DateTime('-3 week');

$timezone = new \DateTimeZone("America/Sao_Paulo");

//Specified timezone
$date = new \DateTime('3 week ago', $timezone);


//changing the current date
//$date->setDate('2016', '01','01');
//$date->setTime('01','02','03');
//$date->setTimestmp(''); unitimstamp
$date->setTimeZone(new \DateTimeZone("America/Sao_Paulo"));

/*
Retrieving Date/Time
*/

/*
$date->format() - acceps the same values as the date()
*/

 
$date->format('Y-D/m');
//echo ($date->format('Y-d-m')); //2016-01-03

date(DateTime::ATOM); //2016-03-23T03:44:15+01:00
date(DateTime::COOKIE); //Wednesday, 23-Mar-2016 03:44:55 CET
date(DateTime::RSS); //Wed, 23 Mar 2016 03:46:10 +0100
date(DateTime::W3C); //2016-03-23T03:46:43+01:00

/*
Handling Custom Format
*/
$ambiguousDate = '10/11/12';
$date = \DateTime::createFromFormat("d/m/y", $ambiguousDate);

/*
DateTime Comparing 
*/
$date = new \DateTime("2014-05-31 1:30pm EST");

$tz = new \DateTimeZone("Europe/Amsterdam");
$date2 = new \DateTime("2014-05-31 8:30pm", $tz);

if($date == $date2){
	//echo "these dates are the same date/time"
}

/*
DateTime Math
*/
$date = new \DateTime();
//$date->modify("+1 month"); //more one month from now
/*
Working with intervals
$date->add(); $date->sub();


$interval = new \DateInterval('PiY3M4DT45M');
// Add 1 year, 3 mothns, 4 days, 45 minutes
//$a = $date->add($interval);

// subtract 1 year, 3 mothns, 4 days, 45 minutes
//$a = $date->sub($interval);


/*
Difference between Dates
DateTime->diff();

*/
$joao = new \DateTime("1984-05-31 00:00", new \DateTimeZone("Europe/London"));
$maria = new \DateTime("2014-04-07 00:00", new \DateTimeZone("America/New_York"));

$diff = $joao->diff($maria);
/*
var_dump($diff);
object(DateInterval)#7 (15) {
  ["y"]=>
  int(29)
  ["m"]=>
  int(10)
  ["d"]=>
  int(7)
  ["h"]=>
  int(5)
  ["i"]=>
  int(0)
  ["s"]=>
  int(0)
  ["weekday"]=>
  int(0)
  ["weekday_behavior"]=>
  int(0)
  ["first_last_day_of"]=>
  int(0)
  ["invert"]=>
  int(0)
  ["days"]=>
  int(10903)
  ["special_type"]=>
  int(0)
  ["special_amount"]=>
  int(0)
  ["have_weekday_relative"]=>
  int(0)
  ["have_special_relative"]=>
  int(0)
}

Extensible Markup Language(XML)

*An XML document can be well-formed an not valid, but it can never be valid and not well-formed.

A well-formed XML document can be as simple as 

<?xml version="1.0"?>
<message> Hello, World! </message>


A valid document xml 
<?xml version="1.0"?>
<!DOCTYPE message SYSTEM "message.dtd">
<message> Hello, World! </message>


Procedural Code
Load an XML string

*/
$xmlstr  = file_get_contents("library.xml");
$library = simplexml_load_string($xmlstr);
//Load an XML file
$library = simplexml_load_file("library.xml");

/*

Object-oriented (OOP) environment
Load an XML string 
*/
$xmlstr  = file_get_contents("library.xml");
$library = new SimpleXMLElement($xmlstr);

//Load an XML file
$library = new SimpleXMLElement("library.xml", NULL, true);
 
/*
Acessing Children Atribute
*/
foreach ($library as $book) {	
/*	echo $book['isbn'] . "\n";
	echo $book->title . "\n";
	echo $book->author . "\n";
	echo $book->publisher . "\n\n";
*/
}

/*
Iterating wit SimpleXML
SimpleXMLElement::children()

*/
foreach ($library->children() as $child) {
	//echo $child->getName(). ": \n";

	//Get attributes of this element
	foreach ($child->attributes() as $attr) {
		//echo ' '.$attr->getName(). ': '.$attr. "\n";
	}

	//Get children
	foreach ($child->children() as $subchild) {
		//echo ' '.$subchild->getName(). ': '.$subchild. "\n";
	}
}
/*
XPath Queries


*/

$results = $library->xpath('/library/book/title');

foreach ($results as $title) {
	//echo 'titulo '.$title.PHP_EOL;
}

/*
Adding Children
*/

$book = $library->addChild('book');
$book->addAttribute('isbn','00000000001');
$book->addChild('title',"Ender's Game");
$book->addChild('author',"Orson Scott Card");
$book->addChild('publisher',"Tor Science Fiction");

/*
To romve elements
*/
$library->book[0] = null;

//header('Content-type: text/xml');
//echo $library->asXML();

/*
Working With Namespaces

Returning document namespaces
*/

$namespaces = $library->getDocNamespaces();
foreach ($namespaces as $key => $value) {
	//echo "{$key} => {$value} \n";
}
/*
 => http://example.org/library
meta => http://example.org/book-meta
pub => http://example.org/publisher
foo => http://example.org/foo


Returning Used Namespaces
*/
$namespaces = $library->getNamespaces(true);
foreach ($namespaces as $key => $value) {
	//echo "{$key} => {$value} \n";
}
/*
λ php data_formats_second_cycle.php
 => http://example.org/library
meta => http://example.org/book-meta


DOM
Loading and Saving XML Documents

loading from a file:
*/
$dom = new DomDocument();
$dom->load('library.xml');

/*
loading from a string

$dom = new DomDocument();
$dom->loadXML($xml);
 
Listing - Loading XML with DOM
*/
$dom = new DomDocument();
$dom->load('library.xml');

//Do something with our XML here
//var_dump($dom);

$use_xhtml = false;

if($use_xhtml){
	$dom->save('library.xml');
}else{
	$dom->saveHTMLFile('library.xml');
}

//output
if($use_xhtml){
	//echo $dom->saveXML();
}else{
	//echo $dom->saveHTML();
}


/*
XPath Queries
*/
$dom = new DomDocument();
$dom->load('library.xml');

$xpath = new DomXPath($dom);

$xpath->registerNamespace(
	"lib", "http://example.org/library"
	);

$result = $xpath->query("//lib:title/text()");

if($result->length > 0){
	//Random access
	$book = $result->item(0);
	//echo $book->data;

	//sequential access
	foreach ($result as $book) {
		//echo $book->data."\r\n";
	} 
}

/*

Modifying XML Documents 
*/

$dom = new DomDocument();
$dom->load("library.xml");

$book = $dom->createElement("book");
$book->setAttribute("meta:isbn", '00000002');

$title = $dom->createElement("title");
$text = $dom->createTextNode("Mastering the SPL library");

$title->appendChild($text);
$book->appendChild($title);

$author = $dom->createElement("author","Joshua THijssen");
$book->appendChild($author);

$publisher = $dom->createElement(
	"pub:publisher", "musketeers.me, LLC."
	);
$book->appendChild($publisher);

$dom->documentElement->appendChild($book);
/*
header('Content-type: text/xml');
echo $dom->saveXML();
//var_dump($dom);

Moving data 
*/

$dom = new DomDocument();
$dom->load("library.xml");
$xpath = new DomXPath($dom);
$xpath->registerNamespace(
	"lib",
	"http://example.org/library"
	);

$result = $xpath->query("//lib:book");
$result->item(1)->parentNode->insertBefore(
	$result->item(1), $result->item(0)
	);

$result = $xpath->query("//lib:book");
$result->item(1)->parentNode->appendChild($result->item(0)
	);

/*
Duplicating a node with DOM

*/

$dom = new DomDocument();
$dom->load("library.xml");
$xpath = new DomXPath($dom);
$xpath->registerNamespace(
	"lib",
	"http://example.org/library"
	);

$result = $xpath->query("//lib:book");
$clone = $result->item(0)->cloneNode();
$result->item(1)->parentNode->appendChild($clone);

/*
Moving Data
*/
$xml = <<<XML
<xml>
	<text> some text here </text>
</xml>
XML;

$dom = new DOMDocument();
$dom->loadXML($xml);

$xpath = new DomXPath($dom);

$node= $xpath->query("//text/text()")->item(0);
$node->data = ucwords($node->data);
/*
output
<?xml version="1.0"?>
<xml>
        <text> Some Text Here </text>
</xml>

*/
/*
Removing Data
*/

$xml = <<<XML
<xml>
	<text type='misc'> some text here </text>
	<text type='misc'> some more text here </text>
	<text type='misc'> yet more text here </text>

</xml>
XML;

$dom = new DOMDocument();
$dom->loadXML($xml);

$xpath = new DomXPath($dom);

$result = $xpath->query("//text");
$result->item(0)->parentNode->removeChild($result->item(0));
$result->item(1)->removeAttribute('type');

$result = $xpath->query('text()', $result->item(2));
$result->item(0)->deleteData(0, $result->item(0)->length);
/*
echo $dom->saveXML();
output:

λ php data_formats_second_cycle.php
<?xml version="1.0"?>
<xml>

        <text> some more text here </text>
        <text type="misc"></text>

</xml>

Working With Namespaces
*/

$dom = new DomDocument();

$node = $dom->createElement('ns1:somenode');

$node->setAttribute('ns2:someattribute','somevalue');
$node2 = $dom->createElement('ns3:anothernode');
$node->appendChild($node2);

//set xmlns:*attributes

$node->setAttribute('xmlns:ns1','http://example.com/ns1');
$node->setAttribute('xmlns:ns2','http://example.com/ns2');
$node->setAttribute('xmlns:ns3','http://example.com/ns3');

$dom->appendChild($node);

$dom->saveXML();

/*
listin namespaces in DOM
*/


$dom = new DomDocument();

$node = $dom->createElementNS('http://example.com/ns1','ns1:somenode');

$node->setAttributeNS('http://example.com/ns2','ns2:someattribute','somevalue');

$node2 = $dom->createElementNS('http://example.com/ns3','ns3:anothernode');


$node3 = $dom->createElementNS('http://example.com/ns1','ns1:anothernode');

$node->appendChild($node2);
$node->appendChild($node3);

$dom->appendChild($node);

$dom->formatOutput = true;
/*
echo $dom->saveXML();
<?xml version="1.0"?>
<ns1:somenode xmlns:ns1="http://example.com/ns1" xmlns:ns2="http://example.com/ns2" xmlns:ns3="http://example.com/ns3" ns2:someattribute="somevalue">
  <ns3:anothernode xmlns:ns3="http://example.com/ns3"/>
  <ns1:anothernode/>
</ns1:somenode>

Interfacing with SimpleXML

 
$xml = simplexml_load_file('library.xml');

$node = dom_import_simplexml($xml);
$dom = new DomDocument();
$dom->importNode($node, true);

$dom->appendChild($node);
 
Listing 
*/

$dom = new DOMDocument();
$dom->load('library.xml');

$sxe = simplexml_import_dom($dom);
echo $sxe->book[0]->title;