<?php 
   error_reporting(0);
   ini_set('display_errors', 0);
   if(isset($_POST) && $_POST != null){
   
   $total = 0;
       $vars = array_values($_POST);
      
       
       
       $etape1 = $vars[0] * $vars[1] * $vars[4] * 253;
       $etape2 = $vars[5] * ($vars[6]) * $vars[7];
       $etape3 = ($vars[1] * $vars[3] * $vars[0] * $vars[2] * 253) / $etape2; 
       $etape4 = $vars[8] * 5.95 * $vars[1] * 253;
       
       
       $total = $etape1 + $etape3 + $etape4;
       
       $total /= 1000000;
       $etape5 = ($etape3/$total)*100;
       $etape6 = ($etape1/$total)*100;
       $etape7 = ($etape4/$total)*100;
       
   }
   ?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="css/bootstrap.css">
      <script src="https://kit.fontawesome.com/c2dbfd9242.js" crossorigin="anonymous"></script>
      <title>Impressions : Bilan écologique</title>
      <header><img class="w-100" src="https://www.bureau-romand.ch/wp-content/uploads/2021/01/osez-le-vert.jpg"></header>
   <body>
      <form class="m-auto col-md-6 mb" method="post" action="#">
         <div id="carouselExampleIndicators" class="carousel slide" data-interval="false" data-ride="carousel">
            <ol class="carousel-indicators bg-dark">
               <?php 
                  $row = -1;
                  $quest = null;
                  $lines = [];
                  if (($handle = fopen("quest.csv", "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) 
                    { 
                      $data = array_map("utf8_encode", $data) ;
                                        $lines[] = $data ;
                      
                      if ($row == -1) {$row++;}
                      else{ 
                        if( $data[2] != null){
                          if ($row == 0) {
                           echo "<li data-target='#carouselExampleIndicators' data-slide-to='$row' class='active'></li>";
                           $row++;
                        }
                          else{
                            echo "<li data-target='#carouselExampleIndicators' data-slide-to='$row'></li>";
                            $row++;   
                          }
                        }
                      }
                    }
                    echo "<li data-target='#carouselExampleIndicators' data-slide-to='$row'></li>";
                  }
                  fclose($handle);
                  ?>
            </ol>
            <div class="carousel-inner">
               <?php 
                  $quest = null;
                  $data;
                    for ($i=1; $i < count($lines); $i++) { 
                          $data = $lines[$i]; 
                  
                            $quest = $data[2];?>
               <div class="carousel-item <?php if($i == 1){ echo "active";} ?> p-5">
                  <div class="card m-auto" >
                     <div class="card-header" font color="fff"><?php echo $data[2]; ?>
                     </div>
                     <div class="card-body">
                        <div class="form-row align-items-center">
                           <div class="form-group w-100 <?php if ($data[3] == "radio") {
                              echo "col-md-3 m-auto";
                              }?>">
                              <label for="Input<?php echo $i; ?>"><?php echo $data[4]; ?></label>
                              <input type="<?php echo $data[3]; ?>" class="form-control" id="Input<?php echo $i; ?> " <?php if ($data[3] == "radio") {
                                 $name = "name_$i";
                                 echo "name='$name'";
                                 }
                                 else {
                                 echo "name='name_$i'";
                                 }?>value="<?php echo $data[5]; ?>">
                           </div>
                           <?php 
                              $i++;
                              $data = $lines[$i]; 
                              while ( $data[2] == null && $i < count($lines)) { ?>
                           <div class="form-group col-md-3 m-auto">
                              <label for="Input<?php echo $i; ?>"><?php echo $data[4]; ?></label>
                              <input type="<?php echo $data[3]; ?>" class="form-control" id="Input<?php echo $i; ?>"  value="<?php echo $data[5]; ?>" 
                                 <?php if ($data[3] == "radio") {
                                    echo "name='$name'";
                                    }
                                    else {
                                    echo "name='name_$i'";
                                    }?>>
                           </div>
                           <?php
                              $i++;
                              if ($i < count($lines)) {
                                              $data = $lines[$i];
                                              }           
                              } 
                              $i--;
                              ?>
                        </div>
                     </div>
                  </div>
               </div>
               <?php
                  }
                  ?>
               <div class="carousel-item p-5">
                  <div class="card m-auto" style="width: 18rem;">
                     <div class="card-header">Fin
                     </div>
                     <div class="card-body">
                        <h5 class="card-title">Voir le résultat</h5>
                        <div class="form-group">
                           <button type="submit" class="btn btn-primary">Voir</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="d-flex">
               <a class="btn btn-primary ml-auto ml-5" href="#carouselExampleIndicators" role="button" data-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="" > Précédent</span>
               </a>
               <a class="btn btn-primary mr-auto ml-5" href="#carouselExampleIndicators" role="button" data-slide="next">
               <span class="">Suivant <span class="carousel-control-next-icon" aria-hidden="true"></span></span>
               </a>
            </div>
         </div>
      </form>
      <?php
         if (isset($total)) {
          ?>
      <div class="d-flex w-100">
         <h1 class="m-auto" > Vos impressions et envois d'emails représentent <?php  echo round( $total , 2 ); ?> Tonnes de CO2 par an !</h1>
      </div>
      <div class="text-centre">
      <p>Ce résultat est calculé selon vos réponses multipliés par le nombre d'employés présents dans votre entreprise.</p>
      <br><br>
      <hr style="width:70%;height:4px;border-width:0;color:gray;background-color:green">
      <h3>Comprendre votre calcul :</h3>
      <br>
      <div class="row">
         <div class="col-md-6 mb-5">
            <div class="card h-100">
               <div class="card-body  h-100">
                  <h2 class="card-title">L'imprimante représente <?php  echo round( $etape5 /= 1000000 , 1 ); ?> % du total.</h2>
                  <p class="card-text">Saviez-vous qu'un parc d'imprimante jet d'encre disposant des dernières technologies vous permettra de diviser par <b>3</b> votre empreinte carbone par rapport à un parc d'imprimante Laser ?
                     Temps de préchauffage, consommation électrique par impression, consommation en veille, émissions de CO2 et déchets sont un ensemble de facteurs sur lesquels votre entreprise gagnera en adoptant la technologie Jet D'encre.
                     En effet avec les dernieres technologies jet d'encre vous n'avez plus besoins de cartouches et vous réduisez vos déchets aux maximum, lorsqu'une imprimante laser produit de nombreux déchets ( photorécepteurs, développeurs, four, courroie de transfert etc.) On estime l'impact écologique par impression comme suit : <br><b>- Imprimante laser = 18.675g CO2/impression.   - Imprimante Jet d'encre = 7.285g CO2/impression. - Imprimante Jet d'encre Professionnelle = 5.376g CO2/impression.</b><br>
                  </p>
               </div>
               <div class="card-footer">
                  <a href="https://www.bureau-romand.ch/imprimantes-et-copieurs-multifonctions/#jet-dencre" class="btn btn-primary btn-sm">Nos imprimantes écologiques</a>
               </div>
            </div>
         </div>
         <!-- /.col-md-4 -->
         <div class="col-md-6 mb-5">
            <div class="card h-100">
               <div class="card-body h-100">
                  <h2 class="card-title">Le Papier représente <?php  echo round( $etape6  /= 1000000 , 1 ); ?> % du total.</h2>
                  <p class="card-text ">Réduire ses déchets papiers et son usage va vous permettre de réduire facilement votre impact environnemental, à conditions de mettre en place des règles simples applicable par l'ensemble de vos collaborateurs.
                     Tout d'abord l'usage de papier recyclé vous permet de réduire vos déchets sans changer les habitudes de vos collègues. En effet une impression sur du papier recyclé ne représente que 2.5g de CO2 lorsqu'une impression sur du papier standard émet 12g de CO2/impression. Mettre en place des poubelles de tri destinés aux papiers usagés va aussi permettre de renouveller le cycle d'utilisation du papier. En Bref le choix du papier a un impact important sur votre empreinte carbone.
                  </p>
               </div>
               <div class="card-footer">
                  <a href="https://223717.100.offix.ch/fr/catalog/papier-dimpression-7zNpNRL9L1K" class="btn btn-primary btn-sm">Notre gamme de papier</a>
               </div>
            </div>
         </div>
         <!-- /.col-md-4 -->
         <div class="col-md-6 mb-5">
            <div class="card h-100">
               <div class="card-body h-100">
                  <h2 class="card-title">Les emails ont une part de <?php  echo round( $etape7  /= 1000000 , 1 ); ?> % sur le total de votre empreinte écologique.</h2>
                  <p class="card-text h-100">Bien qu'on puisse penser que remplacer l'utilisation d'une imprimante par l'envoi d'email soit une solution, il faut bannir les envois inutiles. L'usage du numérique aussi à un impact sur l'environnement, souvent sous-estimé, on parle aujourd'hui de gaspillage quand vous envoyez des emails à de nombreux contact en copie sans qu'ils soient concernées. Une utilisation du numérique oui, mais à bon escient : optez plutôt pour une GED personnalisée que d'échanger des documents par  emails.</p>
               </div>
               <div class="card-footer">
                  <a href="https://www.bureau-romand.ch/ged-et-solutions/" class="btn btn-primary btn-sm">Notre GED</a>
               </div>
            </div>
         </div>
         <!-- /.col-md-4 -->
         <div class="col-md-6 mb-5">
            <div class="card h-100">
               <div class="card-body h-100">
                  <h2 class="card-title">L'entretien de vos imprimantes vous permet de réduire de <?php  echo round( $etape2 * 10, 0 ); ?> % l'impact de votre parc d'imprimante.</h2>
                  <p class="card-text">Un bon entretien de votre imprimante multifonction vous permet de réduire facilement ses déchets. Une mise en veille automatique permet d'éviter la consommation inutile d'électricité. L'entretien régulier de votre imprimante permet d'éviter l'usure prématurée de celle-ci.</p>
               </div>
               <div class="card-footer">
                  <a href="https://www.bureau-romand.ch/imprimantes/#leasing" class="btn btn-primary btn-sm">Nos comtrat de maintenance</a>
               </div>
            </div>
         </div>
      </div>
      <?php
         }
         
         ?>
      <script src="js/jquery.min.js" ></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>