<?php
// sudo apt install php-imagick

/*session_start();

require_once("./DB.class.php");
require_once("Lang.class.php");

$cert_db = new PDO('sqlite:../db/certs.sqlite3');
if(isset($_GET['id'])) {
   $stmt = $cert_db->prepare("SELECT name FROM certs WHERE cert_id = :c");
   $stmt->execute(array(":c" => $_GET['id']));
   $allResults = $stmt->fetchAll();
   if(count($allResults)<1) { die('invalid id'); }
   $playername = $allResults[0]["name"];
   $cert_id = $_GET['id'];
} else {
   if(isset($_SESSION['dbID'])) {
        $db = new DB($_SESSION['dbID']);
   } else {
	die("invalid session");
   }
   if(@$_SESSION['extreme'] === true) { require_once("./ExtremeGame.class.php"); } else { require_once("./Game.class.php"); }
   if(isset($_SESSION['currentExercise'])) {
        $game = new Game($_SESSION['currentExercise']);
   } else {
	die("invalid game");
   }
   if($game->getExercise() != null) {
   	die("game not yet finished");
   }

   $playername = $db->getPlayerName();
   $cert_id = substr(md5($_SESSION['dbID']),-10);

   $stmt = $cert_db->prepare("INSERT OR REPLACE INTO certs(cert_id, game_id, name) VALUES (:c, :g, :n)");
   $stmt->execute(array(":c" => $cert_id, ":g" => $_SESSION['dbID'], ":n" => $playername));
}*/

$playername = "Peter";
$cert_id = "ihewfiuehtiu2t";

$html = <<<HTML
<html>
<body style="font-family:Helvetica">

<h1 style="color:white; text-align:center; font-size:40pt">MonstER Park</h1>
<h1 style="font-size:5pt">&nbsp;</h1>
<h1 style="text-align:center; font-size:32pt">Certificate of Completion</h1>
<h1 style="text-align:center; font-size:22pt">This is to certify that</h1>
<h1 style="text-align:center; font-size:32pt">$playername</h1>
<h1 style="text-align:center; font-size:22pt">has successfully completed the<br>learning game MonstER Park.</h1>
<h1 style="font-size:15.2pt;"><br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br></h1>
<h1 style="text-align:center; font-size:16pt;">$cert_id</h1>
<h1 style="text-align:center; font-size:16pt;">URL: https://www.monst-er.de/cert.php?id=$cert_id</h1>
<h1 style="text-align:right; font-size:10pt">monst-er.de</h1>

</body></html>
HTML;



//////////////////////////// Erzeugung eures PDF Dokuments \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

// TCPDF Library laden
require_once('tcpdf/tcpdf.php');

// Erstellung des PDF Dokuments
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Dokumenteninformationen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("sql-island.de");
$pdf->SetTitle('Certificate');
$pdf->SetSubject('Certificate');


// Header und Footer Informationen
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// Auswahl des Font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


// Auswahl der MArgins
$pdf->SetMargins(PDF_MARGIN_LEFT, 0.2*PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Automatisches Autobreak der Seiten
$pdf->SetAutoPageBreak(TRUE, 0.0*PDF_MARGIN_BOTTOM);

// Image Scale
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Schriftart
$pdf->SetFont('helvetica', '', 10);

// Neue Seite
$pdf->AddPage();

//$pdf->SetFillColor(84, 192, 238 );
//$pdf->Rect(0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'DF', "");

// Fügt den HTML Code in das PDF Dokument ein

// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

$pdf->Image("images/certificate_ribbon.png", 17, 20, 714/4, 122/4, '', '', '', false, 300, '', false, false, 0);
$pdf->Image("images/trina.png", 150, 7, 140/5, 288/5, '', '', '', false, 300, '', false, false, 0);
$pdf->StartTransform();
$pdf->MirrorH(50);
$pdf->Image("images/fibi.png", 40, 228, 140/6, 288/6, '', '', '', false, 300, '', false, false, 0);
$pdf->StopTransform();
$pdf->Image("images/bolbo.png", 150, 218, 140/5, 288/5, '', '', '', false, 300, '', false, false, 0);
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->deletePage(2);

//Ausgabe der PDF

//Variante 1: PDF direkt an den Benutzer senden:
$pdf->Output("Certificate_SQL-Island.pdf", 'I');

//Variante 2: PDF im Verzeichnis abspeichern:
//$pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
//echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';

?>
