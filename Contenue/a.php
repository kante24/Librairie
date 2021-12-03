<?php


//creation du panier d'achat


function creationPanier(){
   if (!isset($_SESSION['panier'])){
      $_SESSION['panier']=array();
      $_SESSION['panier']['id_produit'] = array();
      $_SESSION['panier']['titre'] = array();
      $_SESSION['panier']['prixProduit'] = array();
      $_SESSION['panier']['qteProduit'] = array();
   }
   return true;
} 

function arraySearch2($var, $tab) 
{
    $temp = -1;
    foreach ($tab as $key => $value)
    {
        if($value == $var)
        {
            $temp = $key;
        }
    }
    if ($temp == -1)
    {
        return $temp;
    }
    else
    {
        return $temp;
    }
}


function ajouterArticle($id_p,$titr,$qtePr,$prixPr){
   //Si le panier existe
   if (creationPanier())
   {
      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = arraySearch2($id_p,  $_SESSION['panier']['id_produit']);
      if ($positionProduit != -1)
      {
         $_SESSION['panier']['qteProduit'][$positionProduit] += $qtePr ;
      }
      else
      {
         //Sinon on ajoute le produit
         array_push( $_SESSION['panier']['id_produit'],$id_p);
         array_push( $_SESSION['panier']['qteProduit'],$qtePr);
         array_push( $_SESSION['panier']['prixProduit'],$prixPr);
         array_push( $_SESSION['panier']['titre'],$titr);
      }
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

function MontantGlobal(){
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
   {
      $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
   }
   return $total;
}

function affiche_panier2()
{
    $count=count($_SESSION['panier']['id_produit']);
    echo("<table border>");
    echo("<tr><td colspan=5> Panier d'achat</td></tr>");
    echo("<tr><td>Titre</td><td>Id Produit</td><td >Quantité</td><td >Prix unitaire</td><td >Action</td></tr>");

    for ($i=0; $i <$count ; $i++) { 
      echo "<tr><td>".$_SESSION['panier']['titre'][$i]."</td><td> ".$_SESSION['panier']['id_produit'][$i]."</td><td> ".$_SESSION['panier']['qteProduit'][$i]." </td><td>".$_SESSION['panier']['prixProduit'][$i]."$</td><td>

      <a href=traitement.php?indice=".$i."><input type=submit name=supprimer value=supprimer /></a> 

      </td></tr>";
    }
   echo("<tr><td colspan=3> Total</td><td colspan=2> ".MontantGlobal()."$ </td></tr>");
    echo("<tr><td colspan=5> <a  href=commande.php><input type=submit name=valider value=valider et declarer le paiement><a> </td></tr>");
     echo("<tr><td colspan=5> <a > Vider mon panier</a></td></tr>");
     echo("<tr><td colspan=5> <a href=index2.php> Retour vers la boutique</a></td></tr>");
    echo("</table>");

}


function supprimerArticle($id_prod){
   //Si le panier existe
   if (creationPanier())
   {
      //Nous allons passer par un panier temporaire
      $tmp=array();
   	  $tmp['id_produit'] = array();
      $tmp['titre'] = array();
      $tmp['prixProduit'] = array();
      $tmp['qteProduit'] = array();


      for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
      {
         if ($_SESSION['panier']['id_produit'][$i] !== $id_prod)
         {
            array_push( $tmp['id_produit'],$_SESSION['panier']['id_produit'][$i]);
            array_push( $tmp['qteProduit'],$_SESSION['panier']['qteProduit'][$i]);
            array_push( $tmp['prixProduit'],$_SESSION['panier']['prixProduit'][$i]);
            array_push( $tmp['titre'],$_SESSION['panier']['titre'][$i]);
         }

      }
      //On remplace le panier en session par notre panier temporaire à jour
      $_SESSION['panier'] =  $tmp;
      //On efface notre panier temporaire
      unset($tmp);
      //echo 'test';
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

require("inc/fonctions.inc.php");

if(isset($_GET['indice']))
	
{
	$indice =(int)$_GET['indice'];
	echo $indice;
	$id = $_SESSION['panier']['id_produit'][$indice];
	echo $id;
	supprimerArticle($id);
?>
	<!--header("Location: panier.php" );-->
	<script>
	    window.location.replace("panier.php")
	</script>
	<?php
}