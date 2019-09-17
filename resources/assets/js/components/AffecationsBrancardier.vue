<template>
<div>
<div class="mt-5 mb-5" v-show="!loaded"  style="min-height:100%;width:100%">
        <div class="row" style="min-height:100%;width:100%">
          <div class="col-md-12"><div class = "centered">
	<div class = "blob-1"></div>
	<div class = "blob-2"></div>
</div>

          </div>
          </div>
</div>
    <div class="mt-5 mb-5" v-show="loaded" >
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="row justify-content-between mb-5">
                             <div class="col-md-12">
                      <h4>Les affectations</h4>
                     </div>

                        
                
</div>
 
              
                    <div class="card-body">
<div class="row justify-content-center">
<div class="col-md-12">
  <h3> Affectations du <span class="badge badge-secondary mr-2"> {{dateAffectation.date_debut}}</span> jusqu'au <span class="badge badge-secondary mr-2">{{dateAffectation.date_fin}}</span></h3>
</div>

</div>
</div>
<div style="overflow-x:auto;" class="mb-4 mt-4">
<table class="calendar table table-bordered "   >
    <thead>
        <tr>
            <th width="9%">&nbsp;</th>
            <th width="13%">  Lundi </th>
            <th width="13%">  Mardi </th>
            <th width="13%">Mercredi</th>
            <th width="13%">  Jeudi </th>
            <th width="13%">Vendredi</th>
            <th width="13%"> Samedi </th>
            <th width="13%">Dimanche</th>
            
          
            
            
            
            
        </tr>
    </thead>
    <tbody>
         <tr>
            <td>00:00 -> 08:00</td>


            <td class="has-events" rowspan="1" v-show="semaineCount.lundi2!==0">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                  <div v-for="lundi2 in semaine.lundi2" :key="lundi2.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="lundi2.fixe===0 && lundi2.urgence===0">{{lundi2.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="lundi2.fixe===1 && lundi2.urgence===0">{{lundi2.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="lundi2.urgence===1">{{lundi2.intitule}}</span>

                    </div>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.lundi2===0">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
</td>

          <td class=" has-events" rowspan="1"  v-show="semaineCount.lundi1!==0"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   <div v-for="lundi1 in semaine.lundi1" :key="lundi1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="lundi1.fixe===0 && lundi1.urgence===0">{{lundi1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="lundi1.fixe===1 && lundi1.urgence===0">{{lundi1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="lundi1.urgence===1">{{lundi1.intitule}}</span>

                    </div>
                </div></td>

            <td class=" has-events" rowspan="1"  v-show="semaineCount.lundi1===0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   
                </div></td>
                
            <td class=" has-events" rowspan="1"  v-show="semaineCount.mardi1!==0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                  <div v-for="mardi1 in semaine.mardi1" :key="mardi1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="mardi1.fixe===0 && mardi1.urgence===0">{{mardi1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="mardi1.fixe===1 && mardi1.urgence===0">{{mardi1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="mardi1.urgence===1">{{mardi1.intitule}}</span>

                    </div>
                </div></td>

   <td class=" has-events" rowspan="1"  v-show="semaineCount.mardi1===0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


            
                </div></td>


            <td class=" has-events" rowspan="1"  v-show="semaineCount.mercredi1!==0"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                  <div v-for="mercredi1 in semaine.mercredi1" :key="mercredi1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="mercredi1.fixe===0 && mercredi1.urgence===0">{{mercredi1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="mercredi1.fixe===1 && mercredi1.urgence===0">{{mercredi1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="mercredi1.urgence===1">{{mercredi1.intitule}}</span>

                    </div>
                </div></td>
  <td class=" has-events" rowspan="1"  v-show="semaineCount.mercredi1===0"  ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


    
                </div></td>

         <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudi1!==0"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                  <div v-for="jeudi1 in semaine.jeudi1" :key="jeudi1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="jeudi1.fixe===0 && jeudi1.urgence===0">{{jeudi1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="jeudi1.fixe===1 && jeudi1.urgence===0">{{jeudi1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="jeudi1.urgence===1">{{jeudi1.intitule}}</span>

                    </div>
                </div></td>
 <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudi1===0"  > <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                
                </div></td>

<td class="has-events" rowspan="1" v-show="semaineCount.vendredi1!==0">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   <div v-for="vendredi1 in semaine.vendredi1" :key="vendredi1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="vendredi1.fixe===0 && vendredi1.urgence===0">{{vendredi1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="vendredi1.fixe===1 && vendredi1.urgence===0">{{vendredi1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="vendredi1.urgence===1">{{vendredi1.intitule}}</span>

                    </div>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.vendredi1===0" >
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 

            <td class="has-events" rowspan="1" v-show="semaineCount.samedi1!==0">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                 <div v-for="samedi1 in semaine.samedi1" :key="samedi1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="samedi1.fixe===0 && samedi1.urgence===0">{{samedi1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="samedi1.fixe===1 && samedi1.urgence===0">{{samedi1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="samedi1.urgence===1">{{samedi.intitule}}</span>

                    </div>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.samedi1===0" >
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 


        </tr>
        <tr>
            <td>08:00 -> 16:30</td>
 <td class=" has-events" rowspan="2"  v-show="semaineCount.lundi!==0"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   <div v-for="lundi in semaine.lundi" :key="lundi.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="lundi.fixe===0 && lundi.urgence===0">{{lundi.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="lundi.fixe===1 && lundi.urgence===0">{{lundi.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="lundi.urgence===1">{{lundi.intitule}}</span>

                    </div>
                
                </div></td>

            <td class=" has-events" rowspan="2"  v-show="semaineCount.lundi===0"  ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   
                </div></td>
                
            <td class=" has-events" rowspan="2"  v-show="semaineCount.mardi!==0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   <div v-for="mardi in semaine.mardi" :key="mardi.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="mardi.fixe===0 && mardi.urgence===0">{{mardi.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="mardi.fixe===1 && mardi.urgence===0">{{mardi.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="mardi.urgence===1">{{mardi.intitule}}</span>

                    </div>
                </div></td>

   <td class=" has-events" rowspan="2"  v-show="semaineCount.mardi===0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


            
                </div></td>


            <td class=" has-events" rowspan="2"  v-show="semaineCount.mercredi!==0"><div class="row-fluid lecture" style="width: 99%; height: 100%;">

<div v-for="mercredi in semaine.mercredi" :key="mercredi.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="mercredi.fixe===0 && mercredi.urgence===0">{{mercredi.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="mercredi.fixe===1 && mercredi.urgence===0">{{mercredi.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="mercredi.urgence===1">{{mercredi.intitule}}</span>

                    </div>
                </div></td>
  <td class=" has-events" rowspan="2"  v-show="semaineCount.mercredi===0"  ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


    
                </div></td>

         <td class=" has-events" rowspan="2"  v-show="semaineCount.jeudi!==0" > 
             <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    
<div v-for="jeudi in semaine.jeudi" :key="jeudi.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="jeudi.fixe===0 && jeudi.urgence===0">{{jeudi.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="jeudi.fixe===1 && jeudi.urgence===0">{{jeudi.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="jeudi.urgence===1">{{jeudi.intitule}}</span>

                    </div>
                </div></td>
 <td class=" has-events" rowspan="2"  v-show="semaineCount.jeudi===0" > <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                
                </div></td>

<td class="has-events" rowspan="2" v-show="semaineCount.vendredi!==0" >
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">

<div v-for="vendredi in semaine.vendredi" :key="vendredi.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="vendredi.fixe===0 && vendredi.urgence===0">{{vendredi.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="vendredi.fixe===1 && vendredi.urgence===0">{{vendredi.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="vendredi.urgence===1">{{vendredi.intitule}}</span>

                    </div>
                </div>
            </td>
 <td class="has-events" rowspan="2" v-show="semaineCount.vendredi===0">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 

            <td class="has-events" rowspan="2" v-show="semaineCount.samedi!==0">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


<div v-for="samedi in semaine.samedi" :key="samedi.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="samedi.fixe===0 && samedi.urgence===0">{{samedi.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="samedi.fixe===1 && samedi.urgence===0">{{samedi.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="samedi.urgence===1">{{samedi.intitule}}</span>

                    </div>
                </div>
            </td>
 <td class="has-events" rowspan="2" v-show="semaineCount.samedi===0" >
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 

            <td class="has-events" rowspan="2" v-show="semaineCount.dimanche!==0">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   
<div v-for="dimanche in semaine.dimanche" :key="dimanche.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="dimanche.fixe===0 && dimanche.urgence===0">{{dimanche.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="dimanche.fixe===1 && dimanche.urgence===0">{{dimanche.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="dimanche.urgence===1">{{dimanche.intitule}}</span>

                    </div>
                </div>
            </td>
 <td class="has-events" rowspan="2" v-show="semaineCount.dimanche===0">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 


        </tr>
        <tr><td rowspan="2">16:30 -> 18:00 </td></tr>
          <tr>  
            

                <td class=" has-events" rowspan="1"  v-show="semaineCount.lundiTemp!==0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   <div v-for="lundiTemp in semaine.lundiTemp" :key="lundiTemp.id" >
                    <span class="badge badge-info mt-2" style="font-size: 18px;width: 100%;">{{lundiTemp.intitule}}</span>

                    </div>
                </div></td>

            <td class=" has-events" rowspan="1"  v-show="semaineCount.lundiTemp===0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   
                </div></td>
                
            <td class=" has-events" rowspan="1"  v-show="semaineCount.mardiTemp!==0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                     <div v-for="mardiTemp in semaine.mardiTemp" :key="mardiTemp.id" >
                    <span class="badge badge-info mt-2" style="font-size: 18px;width: 100%;">{{mardiTemp.intitule}}</span>

                    </div>
                </div></td>

   <td class=" has-events" rowspan="1"  v-show="semaineCount.mardiTemp===0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


            
                </div></td>


            <td class=" has-events" rowspan="1"  v-show="semaineCount.mercrediTemp!==0"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <div v-for="mercrediTemp in semaine.mercrediTemp" :key="mercrediTemp.id" >
                    <span class="badge badge-info mt-2" style="font-size: 18px;width: 100%;">{{mercrediTemp.intitule}}</span>

                    </div>
                </div></td>
  <td class=" has-events" rowspan="1"  v-show="semaineCount.mercrediTemp===0"  ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


    
                </div></td>

         <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudiTemp!==0"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                      <div v-for="jeudiTemp in semaine.jeudiTemp" :key="jeudiTemp.id" >
                    <span class="badge badge-info mt-2" style="font-size: 18px;width: 100%;">{{jeudiTemp.intitule}}</span>

                    </div>
                </div></td>
 <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudiTemp===0" > <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                
                </div></td>

<td class="has-events" rowspan="1" v-show="semaineCount.vendrediTemp!==0">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   <div v-for="vendrediTemp in semaine.vendrediTemp" :key="vendrediTemp.id" >
                    <span class="badge badge-info mt-2" style="font-size: 18px;width: 100%;">{{vendrediTemp.intitule}}</span>

                    </div>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.vendrediTemp===0">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            <td></td> <td></td> 

        <tr>
            <td>18:00 -> 00:00</td>

          <td class=" has-events" rowspan="1"  v-show="semaineCount.lundi1!==0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   <div v-for="lundi1 in semaine.lundi1" :key="lundi1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="lundi1.fixe===0 && lundi1.urgence===0">{{lundi1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="lundi1.fixe===1 && lundi1.urgence===0">{{lundi1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="lundi1.urgence===1">{{lundi1.intitule}}</span>

                    </div>
                </div></td>

            <td class=" has-events" rowspan="1"  v-show="semaineCount.lundi1===0"  ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   
                </div></td>
                
            <td class=" has-events" rowspan="1"  v-show="semaineCount.mardi1!==0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <div v-for="mardi1 in semaine.mardi1" :key="mardi1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="mardi1.fixe===0 && mardi1.urgence===0">{{mardi1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="mardi1.fixe===1 && mardi1.urgence===0">{{mardi1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="mardi1.urgence===1">{{mardi1.intitule}}</span>

                    </div>
                </div></td>

   <td class=" has-events" rowspan="1"  v-show="semaineCount.mardi1===0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


            
                </div></td>


            <td class=" has-events" rowspan="1"  v-show="semaineCount.mercredi1!==0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   <div v-for="mercredi1 in semaine.mercredi1" :key="mercredi1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="mercredi1.fixe===0 && mercredi1.urgence===0">{{mercredi1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="mercredi1.fixe===1 && mercredi1.urgence===0">{{mercredi1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="mercredi1.urgence===1">{{mercredi1.intitule}}</span>

                    </div>
                </div></td>
  <td class=" has-events" rowspan="1"  v-show="semaineCount.mercredi1===0" ><div class="row-fluid lecture" style="width: 99%; height: 100%;">


    
                </div></td>

         <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudi1!==0"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                     <div v-for="jeudi1 in semaine.jeudi1" :key="jeudi1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="jeudi1.fixe===0 && jeudi1.urgence===0">{{jeudi1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="jeudi1.fixe===1 && jeudi1.urgence===0">{{jeudi1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="jeudi1.urgence===1">{{jeudi1.intitule}}</span>

                    </div>
                </div></td>
 <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudi1===0"  > <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                
                </div></td>

<td class="has-events" rowspan="1" v-show="semaineCount.vendredi1!==0">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   <div v-for="vendredi1 in semaine.vendredi1" :key="vendredi1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="vendredi1.fixe===0 && vendredi1.urgence===0">{{vendredi1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="vendredi1.fixe===1 && vendredi1.urgence===0">{{vendredi1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="vendredi1.urgence===1">{{vendredi1.intitule}}</span>

                    </div>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.vendredi1===0" >
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 

            <td class="has-events" rowspan="1" v-show="semaineCount.samedi1!==0" >
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                  <div v-for="samedi1 in semaine.samedi1" :key="samedi1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="samedi1.fixe===0 && samedi1.urgence===0">{{samedi1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="samedi1.fixe===1 && samedi1.urgence===0">{{samedi1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="samedi1.urgence===1">{{samedi.intitule}}</span>

                    </div>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.samedi1===0" >
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 
        <td class="has-events" rowspan="1" v-show="semaineCount.dimanche1!==0" >
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


              <div v-for="samedi1 in semaine.dimanche1" :key="dimanche1.id" >
                    <span class="badge badge-warning mt-2" style="font-size: 18px;width: 100%;"  v-show="dimanche1.fixe===0 && dimanche1.urgence===0">{{dimanche1.intitule}}</span>
                     <span class="badge badge-success mt-2" style="font-size: 18px;width: 100%;"  v-show="dimanche1.fixe===1 && dimanche1.urgence===0">{{dimanche1.intitule}}</span>
                    <span class="badge badge-danger mt-2" style="font-size: 18px;width: 100%;"  v-show="dimanche1.urgence===1">{{dimanche1.intitule}}</span>

                    </div>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.dimanche1===0" >
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
</td>
        </tr>

        
    </tbody>
</table>

</div>

</div>
 <div class="row justify-content-center">
                <div @click="backWeek" >  <a class="previous round mr-4">&#8249;</a></div></a>
<div @click="nextWeek" ><a class="next round">&#8250;</a></div>
                </div>
                    </div>



       
       
    
    
  </div> </div>
    </div>
    </div>
</template>

<script>
    export default {
    data () {
        return {
            loaded:false,
          nextSem:1,  
           backSem:1,
brancardierSelcted :{},
AffectationSelcted :'',
brancardiers:{},
selectedItem: '',
selectedItemChange: '',
indexDay:'',
dateAffectation: new Form({
date_debut:'',
date_fin:'',
}),
            semaine: new Form({
                lundi:{},
                mardi:{},
                mercredi:{},
                jeudi:{},
                vendredi:{},
                samedi:{},
                dimanche:{},

                 lundi1:{},
                 lundi2:{},
                mardi1:{},
                mercredi1:{},
                jeudi1:{},
                vendredi1:{},
                samedi1:{},
                dimanche1:{},

                lundiTemp:{},
                mardiTemp:{},
                mercrediTemp:{},
                jeudiTemp:{},
                vendrediTemp:{},
            }),
             semaineCount: new Form({
                lundi:'',
                mardi:'',
                mercredi:'',
                jeudi:'',
                vendredi:'',
                samedi:'',
                dimanche:'',
                 lundi1:'',
                lundi2:'',
                mardi1:'',
                mercredi1:'',
                jeudi1:'',
                vendredi1:'',
                samedi1:'',
                dimanche1:'',


                 lundiTemp:{},
                mardiTemp:{},
                mercrediTemp:{},
                jeudiTemp:{},
                vendrediTemp:{},
            }),
            dates: new Form({
        DateDebut: "",
        DateFin: "",
      }),
        

       
        }
    },
        methods: {

      nextWeek(){
                axios.get('api/affectationBrancardierNextWeek/'+this.nextSem+'/'+this.backSem).then(({data})=>(
           this.semaine.lundi=data.lundi,
           this.semaine.mardi=data.mardi,
           this.semaine.mercredi=data.mercredi,
           this.semaine.jeudi=data.jeudi,
           this.semaine.vendredi=data.vendredi,
           this.semaine.samedi=data.samedi,
           this.semaine.dimanche=data.dimanche,

            this.semaine.lundi1=data.lundi1,
           this.semaine.lundi2=data.lundi2,
           this.semaine.mardi1=data.mardi1,
           this.semaine.mercredi1=data.mercredi1,
           this.semaine.jeudi1=data.jeudi1,
           this.semaine.vendredi1=data.vendredi1,
           this.semaine.samedi1=data.samedi1,
           this.semaine.dimanche1=data.dimanche1,


           this.semaine.lundiTemp=data.lundiTemp,
           this.semaine.mardiTemp=data.mardiTemp,
           this.semaine.mercrediTemp=data.mercrediTemp,
           this.semaine.jeudiTemp=data.jeudiTemp,
           this.semaine.vendrediTemp=data.vendrediTemp,

           this.semaineCount.lundi=data.lundi.length,
           this.semaineCount.mardi=data.mardi.length,
           this.semaineCount.mercredi=data.mercredi.length,
           this.semaineCount.jeudi=data.jeudi.length,
           this.semaineCount.vendredi=data.vendredi.length,


           this.semaineCount.lundi1=data.lundi1.length,
           this.semaineCount.lundi2=data.lundi2.length,
           this.semaineCount.mardi1=data.mardi1.length,
           this.semaineCount.mercredi1=data.mercredi1.length,
           this.semaineCount.jeudi1=data.jeudi1.length,
           this.semaineCount.vendredi1=data.vendredi1.length,
           
           this.semaineCount.lundiTemp=data.lundiTemp.length,
           this.semaineCount.mardiTemp=data.mardiTemp.length,
           this.semaineCount.mercrediTemp=data.mercrediTemp.length,
           this.semaineCount.jeudiTemp=data.jeudiTemp.length,
           this.semaineCount.vendrediTemp=data.vendrediTemp.length,

           this.semaineCount.samedi=data.samedi.length,
           this.semaineCount.dimanche=data.dimanche.length,
           this.semaineCount.samedi1=data.samedi1.length,
           this.semaineCount.dimanche1=data.dimanche1.length,
            this.dateAffectation.date_debut= this.$options.filters.DateTrans(data.date_debut),
           this.dateAffectation.date_fin= this.$options.filters.DateTrans(data.date_fin),
           
           console.log("lundi" +this.semaineCount.lundi)));
           
           this.nextSem++;
           
           
           
           
      },
      backWeek(){

                axios.get('api/affectationBrancardierBackWeek/'+this.backSem+'/'+this.nextSem).then(({data})=>(
           this.semaine.lundi=data.lundi,
           this.semaine.mardi=data.mardi,
           this.semaine.mercredi=data.mercredi,
           this.semaine.jeudi=data.jeudi,
           this.semaine.vendredi=data.vendredi,
           this.semaine.samedi=data.samedi,
           this.semaine.dimanche=data.dimanche,

            this.semaine.lundi1=data.lundi1,
            this.semaine.lundi2=data.lundi2,
           this.semaine.mardi1=data.mardi1,
           this.semaine.mercredi1=data.mercredi1,
           this.semaine.jeudi1=data.jeudi1,
           this.semaine.vendredi1=data.vendredi1,
           this.semaine.samedi1=data.samedi1,
           this.semaine.dimanche1=data.dimanche1,


           this.semaine.lundiTemp=data.lundiTemp,
           this.semaine.mardiTemp=data.mardiTemp,
           this.semaine.mercrediTemp=data.mercrediTemp,
           this.semaine.jeudiTemp=data.jeudiTemp,
           this.semaine.vendrediTemp=data.vendrediTemp,

           this.semaineCount.lundi=data.lundi.length,
           this.semaineCount.mardi=data.mardi.length,
           this.semaineCount.mercredi=data.mercredi.length,
           this.semaineCount.jeudi=data.jeudi.length,
           this.semaineCount.vendredi=data.vendredi.length,


           this.semaineCount.lundi1=data.lundi1.length,
           this.semaineCount.lundi2=data.lundi2.length,
           this.semaineCount.mardi1=data.mardi1.length,
           this.semaineCount.mercredi1=data.mercredi1.length,
           this.semaineCount.jeudi1=data.jeudi1.length,
           this.semaineCount.vendredi1=data.vendredi1.length,
           
           this.semaineCount.lundiTemp=data.lundiTemp.length,
           this.semaineCount.mardiTemp=data.mardiTemp.length,
           this.semaineCount.mercrediTemp=data.mercrediTemp.length,
           this.semaineCount.jeudiTemp=data.jeudiTemp.length,
           this.semaineCount.vendrediTemp=data.vendrediTemp.length,

           this.semaineCount.samedi=data.samedi.length,
           this.semaineCount.dimanche=data.dimanche.length,
           this.semaineCount.samedi1=data.samedi1.length,
           this.semaineCount.dimanche1=data.dimanche1.length,
            this.dateAffectation.date_debut= this.$options.filters.DateTrans(data.date_debut),
           this.dateAffectation.date_fin= this.$options.filters.DateTrans(data.date_fin),
           console.log("lundi" +this.semaineCount.lundi)));
           
           this.backSem++;
           
           
      },
 
  
       loadAffectation(){
                axios.get('api/affectationBrancardier').then(({data})=>(
           this.semaine.lundi=data.lundi,
           this.semaine.mardi=data.mardi,
           this.semaine.mercredi=data.mercredi,
           this.semaine.jeudi=data.jeudi,
           this.semaine.vendredi=data.vendredi,
           this.semaine.samedi=data.samedi,
           this.semaine.dimanche=data.dimanche,

            this.semaine.lundi1=data.lundi1,
            this.semaine.lundi2=data.lundi2,
           this.semaine.mardi1=data.mardi1,
           this.semaine.mercredi1=data.mercredi1,
           this.semaine.jeudi1=data.jeudi1,
           this.semaine.vendredi1=data.vendredi1,
           this.semaine.samedi1=data.samedi1,
           this.semaine.dimanche1=data.dimanche1,


           this.semaine.lundiTemp=data.lundiTemp,
           this.semaine.mardiTemp=data.mardiTemp,
           this.semaine.mercrediTemp=data.mercrediTemp,
           this.semaine.jeudiTemp=data.jeudiTemp,
           this.semaine.vendrediTemp=data.vendrediTemp,

           this.semaineCount.lundi=data.lundi.length,
           this.semaineCount.mardi=data.mardi.length,
           this.semaineCount.mercredi=data.mercredi.length,
           this.semaineCount.jeudi=data.jeudi.length,
           this.semaineCount.vendredi=data.vendredi.length,


           this.semaineCount.lundi1=data.lundi1.length,
           this.semaineCount.lundi2=data.lundi2.length,
           this.semaineCount.mardi1=data.mardi1.length,
           this.semaineCount.mercredi1=data.mercredi1.length,
           this.semaineCount.jeudi1=data.jeudi1.length,
           this.semaineCount.vendredi1=data.vendredi1.length,
           
           this.semaineCount.lundiTemp=data.lundiTemp.length,
           this.semaineCount.mardiTemp=data.mardiTemp.length,
           this.semaineCount.mercrediTemp=data.mercrediTemp.length,
           this.semaineCount.jeudiTemp=data.jeudiTemp.length,
           this.semaineCount.vendrediTemp=data.vendrediTemp.length,

           this.semaineCount.samedi=data.samedi.length,
           this.semaineCount.dimanche=data.dimanche.length,
           this.semaineCount.samedi1=data.samedi1.length,
           this.semaineCount.dimanche1=data.dimanche1.length,
            this.dateAffectation.date_debut= this.$options.filters.DateTrans(data.date_debut),
           this.dateAffectation.date_fin= this.$options.filters.DateTrans(data.date_fin),
            this.loaded=true,
           console.log("lundi" +this.semaineCount.lundi)
            ));   
            
      },
       
        
        },
        mounted() {

            this.loadAffectation();
            console.log('Component mounted.')
        }
    }
</script>


<style>

table.calendar {
    margin-bottom: 0;
}

table.calendar > thead > tr > th {
    text-align: center;
}

table.calendar > tbody > tr > td {
    height: 20px;
}

table.calendar > tbody > tr > td > div {
    //padding: 8px;
    height: 40px;
    overflow: hidden;
    display: inline-block;
    vertical-align: middle;
    float: left;
}

table.calendar > tbody > tr > td.has-events {
    color: white;
    cursor: pointer;
    padding: 0;
    border-radius: 4px;
}

table.calendar > tbody > tr > td.has-events > div {
    
    border-left: 1px solid white;
}

table.calendar > tbody > tr > td.has-events > div:first-child {
    border-left: 0;
    margin-left: 1px;
}

table.calendar > tbody > tr > td.has-events > div.practice {
    opacity: 0.7;
}
table.calendar > tbody > tr > td.conflicts > div > span.title {
    //color: red;
}
table.calendar > tbody > tr > td.max-conflicts > div {
    background-color: red;
    color: white;
}

table.calendar > tbody > tr > td.has-events > div > span {
    display: block;
    text-align: center;
}
table.calendar > tbody > tr > td.has-events > div > span a {
    color: white;
}

table.calendar > tbody > tr > td.has-events > div > span.title {
    font-weight: bold;
}

table.table-borderless > thead > tr > th, table.table-borderless > tbody > tr > td {
    border: 0;
}

.table tbody tr.hover td, .table tbody tr.hover th {
    background-color: whiteSmoke;
}





a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
}

a:hover {
  background-color: #1DA1F2;
  color: black;
}

.previous {
  background-color: rgb(139, 205, 247);
  color: black;
}

.next {
  background-color: rgb(139, 205, 247);
  color: white;
}

.round {
  border-radius: 50%;
}

html,body{
	background:#f4f6f9;
	margin:0;
}
.centered{
	width:400px;
	height:100%;
 position:absolute;
    top:0;
    bottom:0;
	left:50%;
	transform:translate(-50%,-50%);
	background:#f4f6f9;
}
.blob-1,.blob-2{
	width:70px;
	height:70px;
	position:absolute;
	background:#f4f6f9;
	border-radius:50%;
	top:50%;left:50%;
	transform:translate(-50%,-50%);
}
.blob-1{
	left:20%;
	animation:osc-l 2.5s ease infinite;
	background:#343a40;
}
.blob-2{
	left:80%;
	animation:osc-r 2.5s ease infinite;
	background:rgb(0,121,173);
}
@keyframes osc-l{
	0%{left:20%;}
	50%{left:50%;}
	100%{left:20%;}
}
@keyframes osc-r{
	0%{left:80%;}
	50%{left:50%;}
	100%{left:80%;}
}
</style>