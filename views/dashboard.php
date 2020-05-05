  <?php 
           include "adminHeader.php" ;
           include "../core/mixC.php";  

           $mix = new MixC() ;
           $allCat = $mix->getAllrows("categorie") ;
           $allProd =$mix->getAllrows("produit") ;
           $allClient = $mix->getAllrows("client") ;  
           $client = $mix->afficher("client");  
           $prod = $mix->afficher("produit") ; 
           $cat = $mix->getProductsByCategory() ;  
           $EnPromo = $mix->getAllrowsEtat(1) ; 
           $PasEnPromo = $mix->getAllrowsEtat(0) ;
      ?>
<!DOCTYPE html>
<html>
   <head>
       <meta charset="utf-8" />
       <title>Carbone Restaurant</title>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
       <?php  
         $connect = mysqli_connect("localhost", "root", "", "e_restaurant");  
         $query = "SELECT category,COUNT(*) as total FROM `produit` GROUP by category";  
         $result = mysqli_query($connect, $query);  
         ?> 
      <script type="text/javascript">  
           google.charts.load('current', {'packages':['corechart']});  
           google.charts.setOnLoadCallback(drawChart);  
           function drawChart()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['category', 'Total'],  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                               echo "['".$row["category"]."', ".$row["total"]."],";  
                          }  
                          ?>  
                     ]);  
                var options = {  
                      title: 'Produit par categorie',  
                      //is3D:true,  
                      pieHole: 0.3  
                     };  
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                chart.draw(data, options);  
           }  
           </script>  
  </head>
   	<body>  	
    </body>
     <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg1"><i class="fa fa-product-hunt" aria-hidden="true" ></i></span>
                            <div class="dash-widget-info text-right">
                              <h3><?php echo $allProd ?></h3>
                              <span class="widget-title1">Produits <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
                            <div class="dash-widget-info text-right">
                                <h3><?php echo $allClient ?></h3>
                                <span class="widget-title2">Clients <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg3"><i class="fa fa-book" aria-hidden="true"></i></i></span>
                            <div class="dash-widget-info text-right">
                                <h3>0</h3>
                                <span class="widget-title3">Commandes <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg4"><i class="fa fa-cubes" aria-hidden="true" ></i></i></span>
                            <div class="dash-widget-info text-right">
                                <h3><?php echo $allCat ?></h3>
                                <span class="widget-title4">Categories <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div> 
               </div>

                <div class="row">
                  <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title d-inline-block">Menu</h4> <a href="listeProd.php" class="btn btn-primary float-right">Voir tous le menu</a>
                      </div>
                      <div class="card-body p-0">
                        <div class="table-responsive">
                          <table class="table mb-0">
                            <tbody>
                               <?php
                                    if(!empty($prod))
                                    {
                                      $count = 5 ;
                                      foreach($prod as $value)
                                      {
                                        if($count > 0) {?>
                                            <tr>
                                              <td style="min-width: 200px;">
                                                <img width="40" height="40" src="img/<?php echo $value['image'] ; ?>" class="rounded-circle m-r-5" alt="">
                                                <h2><a href=""><?php echo $value['nom'] ;?></a></h2>
                                              </td>                 
                                              <td>
                                                <h5 class="time-title p-0">Categorie</h5>
                                                <p><?php echo $value['category'] ;?></p>
                                              </td>
                                              <td>
                                                <h5 class="time-title p-0">Prix</h5>
                                                <p><?php echo $value['prix'] ;?> DNT</p>
                                              </td>
                                              <td class="text-right">
                                                <?php 
                                                   if($value['etatPromo']){
                                                ?>
                                                <p>En cours de  promo</p>
                                                <?php 
                                                   }
                                                  else{ ?>                                    
                                                <p></p>
                                                <?php 
                                              } 
                                              ?>
                                              </td>
                                            </tr> 
                                         <?php
                                            }
                                            $count-- ;
                                          }
                                        }

                                        ?>           
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="card member-panel">
              <div class="card-header bg-white">
                <h4 class="card-title mb-0">Clients</h4>
              </div>
                            <div class="card-body">
                                <ul class="contact-list">
                                  <?php
                                  if(!empty($client))
                                  {
                                    $nb = 6 ;
                                    foreach($client as $row)
                                    {
                                      if($nb > 0) {?>
                                      <li>
                                        <div class="contact-cont">
                                            <div class="float-left user-img m-r-10">
                                                <a href="profile.html" title="John Doe"><img src="assets/img/user.jpg" alt="" class="w-40 rounded-circle"><span class="status online"></span></a>
                                            </div>
                                            <div class="contact-info">
                                                <span class="contact-name text-ellipsis"><?php echo $row['nom'] . ' ' .$row['prenom'] ;?></span>
                                                <span class="contact-date"><?php echo $row['email'] ;?></span>
                                            </div>
                                        </div>
                                         </li> 

                                   <?php
                                      }
                                      $nb-- ;
                                    }
                                  }

                                  ?>
                                                                                                                                         
                                </ul>
                            </div>
                            <div class="card-footer text-center bg-white">
                                <a href="listeClient.php" class="text-muted">Voir tous les clients</a>
                            </div>
                        </div>
                    </div>
        </div>
        <div class="row">  
           <div style="width:100%;margin-left: 25px;">  
                <div id="piechart" style="width: 600px; height: 500px;float: left;margin-right: 25px;"></div> 
                <div id="columnchart_values" style="width: 600px; height: 500px;float: left;background-color: lightgray;">
                  
                </div> 
           </div>  
        </div>
        
      </div>
    </div>
    <script type="text/javascript">
              google.charts.load("current", {packages:['corechart']});
              google.charts.setOnLoadCallback(drawChart);
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ["", "", { role: "style" } ],
                  ["En Promo",<?php echo $EnPromo; ?>, "#c3d6f7"],
                  ["Pas de Promo",<?php echo $PasEnPromo;?>, "#456b53"],
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                                 { calc: "stringify",
                                   sourceColumn: 1,
                                   type: "string",
                                   role: "annotation" },
                                 2]);

                var options = {
                  title: "",
                  width: 600,
                  height: 500,
                  bar: {groupWidth: "95%"},
                  legend: { position: "none" },
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                chart.draw(view, options);
            }
  </script>
</html>