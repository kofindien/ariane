<?php
function CLEAN($string)
{
	$remp = array( "á","à","ä","â","ã","ª","Á","À","Â","Ã","é","è","ê","ë","É","È","Ê","ö","ô","í","ì","î","Í","Ì","Î","ó","ò", "õ","º","Ò","Ô","Õ","Ó","ú","ù","û","Ù","Û","Ú","ñ","Ñ"," ","~","ç","Ç","@","#","&","%","$","£","§","'");
	$par = array( "a","a","a","a","a","a","A","A","A","A","e","e","e","e","E","E","E","o","o","i","i","i","I","I","I","o","o","o","o","O","O","O","O","u","u","u","U","U","U","n","n","_","_","c","C","a","_","_","_","_","_","_","_");
	return strtolower(str_replace($remp,$par,$string));
}

$content_dir_docs = '../telechargements/fichiers/'; // dossier où sera déplacé le document à télécharger
$content_dir_actus = '../actualites/images/'; // dossier où sera déplacé l'image illustrant l'actualité
$content_dir_photos = './photos/'; // dossier où sera déplacé le fichier
$mime_types_docs = array('application/msword','application/pdf');
$mime_types_images = array('image/gif','image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');
$taille_maxi_actus = 1048576;
$taille_maxi_docs = 2097152;
$taille_maxi_photo_membre = 1048576;
$hauteur_photo_membre = 142;
$largeur_photo_membre = 135;

function RedImage($img_src,$dst_w,$dst_h) { 
	// Lit les dimensions de l'image 
	$size = getimagesize($img_src);
	$src_w = $size[0]; $src_h = $size[1]; 
	
	// Teste les dimensions tenant dans la zone 
	$test_h = round(($dst_w / $src_w) * $src_h); 
	$test_w = round(($dst_h / $src_h) * $src_w); 
	
	// Si Height final non précisé (0) 
	if(!$dst_h) $dst_h = $test_h; 
	
	// Sinon si Width final non précisé (0) 
	elseif(!$dst_w) $dst_w = $test_w; 
	
	// Sinon teste quel redimensionnement tient dans la zone 
	elseif($test_h>$dst_h) $dst_w = $test_w; 
	else $dst_h = $test_h; 
	
	// Affiche les dimensions optimales 
	echo "WIDTH=".$dst_w." HEIGHT=".$dst_h; 
} 

function dateFR2dateEN($date){
	list($j,$m,$a) = explode('-',$date);
	return $a.'-'.$m.'-'.$j;
}

function dateEN2dateFR($date){
	list($a,$m,$j) = explode('-',$date);
	return $j.'/'.$m.'/'.$a;
}

function LongDateEN2dateFR($date){
	echo date("d/m/Y", strtotime($date));
}

function AffichageMinimale($texte, $max_caracteres){
	if (strlen($texte) > $max_caracteres){    
		//Séléction du maximum de caractères
		$tronque_description = substr($texte, 0, $max_caracteres);
		//Récupération de la position du dernier espace (afin d'éviter de tronquer un mot)
		$position_espace = strrpos($tronque_description, " ");    
		$tronque_description = substr($tronque_description, 0, $position_espace);    
		// Ajout des "..."
		$tronque_description = $tronque_description."...";
	}
	else {
		$tronque_description = $texte;
	}
	echo $tronque_description;
}

/**
 * paginate($url, $param, $total, $current [, $adj]) appelée à chaque affichage de la pagination
 * @param string $url - URL ou nom de la page appelant la fonction, ex: 'index.php' ou 'http://example.com/'
 * @param string $param - paramètre à ajouter à l'URL, ex: '?page=' ou '&amp;p='
 * @param int $total - nombre total de pages
 * @param int $current - numéro de la page courante
 * @param int $adj (facultatif) - nombre de numéros de chaque côté du numéro de la page courante (défaut : 3)
 * @return string $pagination
 */

function paginate($url, $param, $total, $current, $adj=3)
{
	/* Déclaration des variables */
	$prev = $current - 1; // numéro de la page précédente
	$next = $current + 1; // numéro de la page suivante
	$n2l = $total - 1; // numéro de l'avant-dernière page (n2l = next to last)

	/* Initialisation : s'il n'y a pas au moins deux pages, l'affichage reste vide */
	$pagination = '';

	/* Sinon ... */
	if ($total > 1)
	{
		/* Concaténation du <div> d'ouverture à $pagination */
		$pagination .= "<div class=\"pagination\">\n";

		/* ////////// Début affichage du bouton [précédent] ////////// */
		if ($current == 2) // la page courante est la 2, le bouton renvoit donc sur la page 1, remarquez qu'il est inutile de mettre ?p=1
			$pagination .= "<a href=\"{$url}\">◄</a>";
		elseif ($current > 2) // la page courante est supérieure à 2, le bouton renvoit sur la page dont le numéro est immédiatement inférieur
			$pagination .= "<a href=\"{$url}{$param}{$prev}\">◄</a>";
		else // dans tous les autres, cas la page est 1 : désactivation du bouton [précédent]
			$pagination .= '<span class="inactive">◄</span>';
		/* Fin affichage du bouton [précédent] */

		/* ///////////////
		Début affichage des pages, l'exemple reprend le cas de 3 numéros de pages adjacents (par défaut) de chaque côté du numéro courant
		- CAS 1 : il y a au plus 12 pages, insuffisant pour faire une troncature
		- CAS 2 : il y a au moins 13 pages, on effectue la troncature pour afficher 11 numéros de pages au total
		/////////////// */

		/* CAS 1 */
		if ($total < 7 + ($adj * 2))
		{
			/* Ajout de la page 1 : on la traite en dehors de la boucle pour n'avoir que index.php au lieu de index.php?p=1 et ainsi éviter le duplicate content */
			$pagination .= ($current == 1) ? '<span class="active">1</span>' : "<a href=\"{$url}\">1</a>"; // Opérateur ternaire : (condition) ? 'valeur si vrai' : 'valeur si fausse'

			/* Pour les pages restantes on utilise une boucle for */
			for ($i = 2; $i<=$total; $i++)
			{
				if ($i == $current) // Le numéro de la page courante est mis en évidence (cf fichier CSS)
				$pagination .= "<span class=\"active\">{$i}</span>";
				else // Les autres sont affichés normalement
				$pagination .= "<a href=\"{$url}{$param}{$i}\">{$i}</a>";
			}
		}

		/* CAS 2 : au moins 13 pages, troncature */
		else
		{
			/*
			Troncature 1 : on se situe dans la partie proche des premières pages, on tronque donc la fin de la pagination.
			l'affichage sera de neuf numéros de pages à gauche ... deux à droite (cf figure 1)
			*/
			if ($current < 2 + ($adj * 2))
			{
				/* Affichage du numéro de page 1 */
				$pagination .= ($current == 1) ? "<span class=\"active\">1</span>" : "<a href=\"{$url}\">1</a>";

				/* puis des huit autres suivants */
				for ($i = 2; $i < 4 + ($adj * 2); $i++)
				{
				if ($i == $current)
					$pagination .= "<span class=\"active\">{$i}</span>";
					else
					$pagination .= "<a href=\"{$url}{$param}{$i}\">{$i}</a>";
				}

				/* ... pour marquer la troncature */
				$pagination .= ' ... ';

				/* et enfin les deux derniers numéros */
				$pagination .= "<a href=\"{$url}{$param}{$n2l}\">{$n2l}</a>";
				$pagination .= "<a href=\"{$url}{$param}{$total}\">{$total}</a>";
			}

			/*
			Troncature 2 : on se situe dans la partie centrale de notre pagination, on tronque donc le début et la fin de la pagination.
			l'affichage sera deux numéros de pages à gauche ... sept au centre ... deux à droite (cf figure 2)
			*/
			elseif ( (($adj * 2) + 1 < $current) && ($current < $total - ($adj * 2)) )
			{
				/* Affichage des numéros 1 et 2 */
				$pagination .= "<a href=\"{$url}\">1</a>";
				$pagination .= "<a href=\"{$url}{$param}2\">2</a>";

				$pagination .= ' ... ';

				/* les septs du milieu : les trois précédents la page courante, la page courante, puis les trois lui succédant */
				for ($i = $current - $adj; $i <= $current + $adj; $i++)
				{
					if ($i == $current)
					$pagination .= "<span class=\"active\">{$i}</span>";
					else
					$pagination .= "<a href=\"{$url}{$param}{$i}\">{$i}</a>";
				}

				$pagination .= ' ... ';

				/* et les deux derniers numéros */
				$pagination .= "<a href=\"{$url}{$param}{$n2l}\">{$n2l}</a>";
				$pagination .= "<a href=\"{$url}{$param}{$total}\">{$total}</a>";
			}

			/*
			Troncature 3 : on se situe dans la partie de droite, on tronque donc le début de la pagination.
			l'affichage sera deux numéros de pages à gauche ... neuf à droite (cf figure 3)
			*/
			else
			{
				/* Affichage des numéros 1 et 2 */
				$pagination .= "<a href=\"{$url}\">1</a>";
				$pagination .= "<a href=\"{$url}{$param}2\">2</a>";

				$pagination .= ' ... ';

				/* puis des neufs dernières */
				for ($i = $total - (2 + ($adj * 2)); $i <= $total; $i++)
				{
					if ($i == $current)
						$pagination .= "<span class=\"active\">{$i}</span>";
					else
						$pagination .= "<a href=\"{$url}{$param}{$i}\">{$i}</a>";
				}
			}
		}
		/* Fin affichage des pages */
		/* ////////// Début affichage du bouton [suivant] ////////// */
		if ($current == $total)
			$pagination .= "<span class=\"inactive\">►</span>\n";
		else
			$pagination .= "<a href=\"{$url}{$param}{$next}\">►</a>\n";
		/* Fin affichage du bouton [suivant] */

		/* </div> de fermeture */
		$pagination .= "</div>\n";
	}

	/* Fin de la fonction, renvoi de $pagination au programme */
	return ($pagination);
}


function GenerePassword($size)
{
	// Initialisation des caractères utilisables
	$characters = array(0 => array(0, 2, 3, 4, 5, 6, 7, 8, 9),
		                1 => array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"));
	$password_generated  = array();
	for($i = 0; $i < $size; $i++)
	{
		// On choisit au hasard entre quelle sorte de caractères choisir
		$p = rand(0, 1);
		switch($p)
		{
			case 0: $q = rand(0, 8);
			    	break;
			case 1: $q = rand(0, 24);
					break;
		}	
		$password_generated[$i] = $characters[$p][$q];
	}
	return implode("", $password_generated);
}
// génération
//$mon_mot_de_passe = Genere_Password(8);

//=============

function sanitizeString($s){
	$s = strip_tags($s);
	//$s = htmlentities($s);
	return mysql_real_escape_string($s);
}
?>