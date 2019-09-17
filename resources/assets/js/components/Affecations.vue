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
    <div class="mt-5 mb-5" v-show="loaded">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <div class="row justify-content-between mb-5">
                             <div class="col-md-4">
                      <h3>Les affectations</h3>
                     </div>
                     <div class="col-md-4">
                         
                <select v-model="id_service" type="text" name="hopital" class="browser-default custom-select" @change="onChange">
                     <option value="" hidden>Service ...</option>
                    <option v-for="service in services" :key="service.id" :value="service.id"> {{service.intitule | upText  }}</option>
                </select>
                        </div>
                        

                        
                
</div>
 
              
                    <div class="card-body">
<div class="row justify-content-center">
<div class="col-center">
  <h3> Affectations du <span class="badge badge-secondary mr-2"> {{dateAffectation.date_debut}}</span> jusqu'au <span class="badge badge-secondary mr-2">{{dateAffectation.date_fin}}</span></h3>
</div>

</div>

<br/>
<div style="overflow-x:auto;" class="mb-4 mt-4">
<table class="calendar table table-bordered " v-show="mode_active===0">
    <thead>
        <tr>
            <th width="9%">&nbsp;</th>
            <th width="13%">Lundi</th>
            <th width="13%">Mardi</th>
            <th width="13%">Mercredi</th>
            <th width="13%">Jeudi</th>
            <th width="13%">Vendredi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td> 08:00 -> 16:30 </td>


            <td class=" has-events" rowspan="1"  v-show="semaineCount.lundi!==0" style="background-color: #0079ad;" @click="openModal(1)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.lundi}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>

            <td class=" has-events" rowspan="1"  v-show="semaineCount.lundi===0"  @click="openModal(1)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   
                </div></td>
                
            <td class=" has-events" rowspan="1"  v-show="semaineCount.mardi!==0" style="background-color: #0079ad;" @click="openModal(2)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.mardi}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>

   <td class=" has-events" rowspan="1"  v-show="semaineCount.mardi===0"  @click="openModal(2)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


            
                </div></td>


            <td class=" has-events" rowspan="1"  v-show="semaineCount.mercredi!==0" style="background-color: #0079ad;" @click="openModal(3)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.mercredi}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>
  <td class=" has-events" rowspan="1"  v-show="semaineCount.mercredi===0"  @click="openModal(3)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


    
                </div></td>

         <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudi!==0" style="background-color: #0079ad;" @click="openModal(4)"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.jeudi}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>
 <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudi===0"  @click="openModal(4)"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                
                </div></td>

<td class="has-events" rowspan="1" v-show="semaineCount.vendredi!==0" style="background-color: #0079ad;"  @click="openModal(5)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.vendredi}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.vendredi===0" @click="openModal(5)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td>
        </tr>
  
        
    </tbody>
</table>
</div>
<div style="overflow-x:auto;" class="mb-4 mt-4">
<table class="calendar table table-bordered " v-show="mode_active===1">
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


            <td class="has-events" rowspan="1" v-show="semaineCount.lundi2!==0" style="background-color: #0079ad;"  @click="openModal(70)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.lundi2}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.lundi2===0" @click="openModal(700)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
</td>

          <td class=" has-events" rowspan="1"  v-show="semaineCount.lundi1!==0" style="background-color: #0079ad;" @click="openModal(10)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.lundi1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>

            <td class=" has-events" rowspan="1"  v-show="semaineCount.lundi1===0"  @click="openModal(10)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   
                </div></td>
                
            <td class=" has-events" rowspan="1"  v-show="semaineCount.mardi1!==0" style="background-color: #0079ad;" @click="openModal(20)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.mardi1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>

   <td class=" has-events" rowspan="1"  v-show="semaineCount.mardi1===0"  @click="openModal(20)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


            
                </div></td>


            <td class=" has-events" rowspan="1"  v-show="semaineCount.mercredi1!==0" style="background-color: #0079ad;" @click="openModal(30)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.mercredi1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>
  <td class=" has-events" rowspan="1"  v-show="semaineCount.mercredi1===0"  @click="openModal(30)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


    
                </div></td>

         <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudi1!==0" style="background-color: #0079ad;" @click="openModal(40)"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.jeudi1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>
 <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudi1===0"  @click="openModal(40)"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                
                </div></td>

<td class="has-events" rowspan="1" v-show="semaineCount.vendredi1!==0" style="background-color: #0079ad;"  @click="openModal(50)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.vendredi1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.vendredi1===0" @click="openModal(50)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 

            <td class="has-events" rowspan="1" v-show="semaineCount.samedi1!==0" style="background-color: #0079ad;"  @click="openModal(60)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.samedi1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.samedi1===0" @click="openModal(60)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 


        </tr>
        <tr>
            <td>08:00 -> 16:30</td>
 <td class=" has-events" rowspan="2"  v-show="semaineCount.lundi!==0" style="background-color: #0079ad;" @click="openModal(1)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.lundi}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>

            <td class=" has-events" rowspan="2"  v-show="semaineCount.lundi===0"  @click="openModal(1)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   
                </div></td>
                
            <td class=" has-events" rowspan="2"  v-show="semaineCount.mardi!==0" style="background-color: #0079ad;" @click="openModal(2)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.mardi}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>

   <td class=" has-events" rowspan="2"  v-show="semaineCount.mardi===0"  @click="openModal(2)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


            
                </div></td>


            <td class=" has-events" rowspan="2"  v-show="semaineCount.mercredi!==0" style="background-color: #0079ad;" @click="openModal(3)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.mercredi}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>
  <td class=" has-events" rowspan="2"  v-show="semaineCount.mercredi===0"  @click="openModal(3)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


    
                </div></td>

         <td class=" has-events" rowspan="2"  v-show="semaineCount.jeudi!==0" style="background-color: #0079ad;" @click="openModal(4)"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.jeudi}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>
 <td class=" has-events" rowspan="2"  v-show="semaineCount.jeudi===0"  @click="openModal(4)"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                
                </div></td>

<td class="has-events" rowspan="2" v-show="semaineCount.vendredi!==0" style="background-color: #0079ad;"  @click="openModal(5)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.vendredi}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div>
            </td>
 <td class="has-events" rowspan="2" v-show="semaineCount.vendredi===0" @click="openModal(5)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 

            <td class="has-events" rowspan="2" v-show="semaineCount.samedi!==0" style="background-color: #0079ad;"  @click="openModal(6)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.samedi}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div>
            </td>
 <td class="has-events" rowspan="2" v-show="semaineCount.samedi===0" @click="openModal(6)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 

            <td class="has-events" rowspan="2" v-show="semaineCount.dimanche!==0" style="background-color: #0079ad;"  @click="openModal(7)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.dimanche}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div>
            </td>
 <td class="has-events" rowspan="2" v-show="semaineCount.dimanche===0" @click="openModal(7)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 


        </tr>
        <tr><td rowspan="2">16:30 -> 18:00 </td></tr>
          <tr>  
            

                <td class=" has-events" rowspan="1"  v-show="semaineCount.lundiTemp!==0" style="background-color: #32CD32;" @click="openModal(11)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.lundiTemp}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>

            <td class=" has-events" rowspan="1"  v-show="semaineCount.lundiTemp===0"  @click="openModal(11)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   
                </div></td>
                
            <td class=" has-events" rowspan="1"  v-show="semaineCount.mardiTemp!==0" style="background-color: #32CD32;" @click="openModal(21)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.mardiTemp}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>

   <td class=" has-events" rowspan="1"  v-show="semaineCount.mardiTemp===0"  @click="openModal(21)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


            
                </div></td>


            <td class=" has-events" rowspan="1"  v-show="semaineCount.mercrediTemp!==0" style="background-color: #32CD32;" @click="openModal(31)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.mercrediTemp}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>
  <td class=" has-events" rowspan="1"  v-show="semaineCount.mercrediTemp===0"  @click="openModal(31)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


    
                </div></td>

         <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudiTemp!==0" style="background-color: #32CD32;" @click="openModal(41)"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.jeudiTemp}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>
 <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudiTemp===0"  @click="openModal(41)"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                
                </div></td>

<td class="has-events" rowspan="1" v-show="semaineCount.vendrediTemp!==0" style="background-color: #32CD32;"  @click="openModal(51)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.vendrediTemp}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.vendrediTemp===0" @click="openModal(51)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            <td></td> <td></td> 

        <tr>
            <td>18:00 -> 00:00</td>

          <td class=" has-events" rowspan="1"  v-show="semaineCount.lundi1!==0" style="background-color: #0079ad;" @click="openModal(10)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.lundi1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>

            <td class=" has-events" rowspan="1"  v-show="semaineCount.lundi1===0"  @click="openModal(10)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                   
                </div></td>
                
            <td class=" has-events" rowspan="1"  v-show="semaineCount.mardi1!==0" style="background-color: #0079ad;" @click="openModal(20)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.mardi1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>

   <td class=" has-events" rowspan="1"  v-show="semaineCount.mardi1===0"  @click="openModal(20)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


            
                </div></td>


            <td class=" has-events" rowspan="1"  v-show="semaineCount.mercredi1!==0" style="background-color: #0079ad;" @click="openModal(30)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.mercredi1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>
  <td class=" has-events" rowspan="1"  v-show="semaineCount.mercredi1===0"  @click="openModal(30)"><div class="row-fluid lecture" style="width: 99%; height: 100%;">


    
                </div></td>

         <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudi1!==0" style="background-color: #0079ad;" @click="openModal(40)"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.jeudi1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div></td>
 <td class=" has-events" rowspan="1"  v-show="semaineCount.jeudi1===0"  @click="openModal(40)"> <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                
                </div></td>

<td class="has-events" rowspan="1" v-show="semaineCount.vendredi1!==0" style="background-color: #0079ad;"  @click="openModal(50)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.vendredi1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.vendredi1===0" @click="openModal(50)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 

            <td class="has-events" rowspan="1" v-show="semaineCount.samedi1!==0" style="background-color: #0079ad;"  @click="openModal(60)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.samedi1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.samedi1===0" @click="openModal(60)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                </div>
            </td> 
        <td class="has-events" rowspan="1" v-show="semaineCount.dimanche1!==0" style="background-color: #0079ad;"  @click="openModal(70)">
                <div class="row-fluid lecture" style="width: 99%; height: 100%;">


                    <span class="title">{{semaineCount.dimanche1}}</span> <span class="lecturer"><a href="#result">Affectations
                            </a></span>
                </div>
            </td>
 <td class="has-events" rowspan="1" v-show="semaineCount.dimanche1===0" @click="openModal(70)">
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

                   

                </div>
            </div>




         

</div>

<div  v-show="listShow">
<div class="row" >

          <div class="col-md-12">
           

     <div class="row">
          
         <div class="col-md-12">

            <div class="card ">
              <div class="card-header header" >
                <h3 class="card-title" style="color:white" >La liste des brancardiers affectés</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i> </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                
 <div v-if="indexDay===1">
       <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.lundi"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>

        
         <div v-if="indexDay===2">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.mardi"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>
      
    


        
         <div v-if="indexDay===3">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.mercredi"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>



      
         <div v-if="indexDay===4">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.jeudi"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>





        
         <div v-if="indexDay===5">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.vendredi"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>




        
         <div v-if="indexDay===6">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.samedi"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #0079ad"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>





        
         <div v-if="indexDay===7">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.dimanche"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier)"
              style=" background-color: #0079ad"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
        </div>
</div>

  <div v-if="indexDay===10">
       <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.lundi1"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)" 
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>

        
         <div v-if="indexDay===20">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.mardi1"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>
      
    


        
         <div v-if="indexDay===30">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.mercredi1"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>



      
         <div v-if="indexDay===40">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.jeudi1"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>





        
         <div v-if="indexDay===50">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.vendredi1"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>




        
         <div v-if="indexDay===60">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.samedi1"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #0079ad"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>





        
         <div v-if="indexDay===70">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.dimanche1"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier)"
              style=" background-color: #0079ad"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
        </div>
</div>

<div v-if="indexDay===11">
       <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.lundiTemp"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>

        
         <div v-if="indexDay===21">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.mardiTemp"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>
      
    


        
         <div v-if="indexDay===31">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.mercrediTemp"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>



      
         <div v-if="indexDay===41">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.jeudiTemp"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>





        
         <div v-if="indexDay===51">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.vendrediTemp"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>

        
          
         <div v-if="indexDay===700">
           <div class="row">
        <div
            class="input-group mb-1 col-md-6"
            v-for="brancardier in semaine.lundi2"
            :key="brancardier.user_id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checked(brancardier)"
                  :checked="isChecked(brancardier.user_id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="isChecked(brancardier.user_id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(brancardier)"
              v-show="!isChecked(brancardier.user_id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
          </div>
        </div>
                
              </div>
              <!-- /.card-body -->
            </div>

         </div>
              
              <!-- /.card-body -->
            </div>
         

</div>
   


        </div>
    
    </div>
      <a name="result"></a> 
     <div class="modal fade" id="TousBrancardiers" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">     
             
                 <h3>La liste des brancardiers</h3>
                

            </div>
            <br/>
            <div class="modal-body">
<div class="row">
        <div
            class="input-group mb-1 col-12"
            v-for="brancardier in brancardiers.data"
            :key="brancardier.id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                  @click="checkedChange(brancardier.id)"
                  :checked="isCheckedChange(brancardier.id)   === true"
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checkedChange(brancardier.id)"
              v-show="isCheckedChange(brancardier.id)"
              style=" background-color: #90EE90"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checkedChange(brancardier.id)"
              v-show="!isCheckedChange(brancardier.id)"
            >{{brancardier.nom | upText }} {{brancardier.prenom | upText }}</label>
          </div>
      

 


         
          </div>

          <div class="row justify-content-md-center">
          <div class="mt-5 mb-5">
            <pagination :data="brancardiers" @pagination-change-page="getResults"></pagination>
          </div>
        </div>

            </div>

            <div class="modal-footer">   
               
                <button type="submit" class="btn btn-success" @click="UpdateAffectation">Modifier</button>                
               
            </div>

        </div>
        </div>
    </div>
    
  </div>
    </div>
    </div>
</template>

<script>
    export default {
    data () {
        return {
          nextSem:1,  
           backSem:1,
brancardierSelcted :{},
AffectationSelcted :'',
brancardiers:{},
selectedItem: '',
selectedItemChange: '',
indexDay:'',
loaded:false,
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
            mode_active: 1,
             services: {},
            id_service : 4,
             listShow:false,
            dates: new Form({
        DateDebut: "",
        DateFin: "",
       
      }),
        

       
        }
    },
        methods: {
            onChange(){
              this.ViderAffectation();
              this.nextSem=1;
              this.backSem=1;
              this.loaded=false;
                for(var i=0;i<this.services.length;i++){
                    console.log("Id :"+this.services[i].id+" - vue"+this.id_service+" urg :"+this.services[i].urgence);
                    if(this.services[i].id===this.id_service && this.services[i].urgence===1){
                        this.mode_active=1;this.loadAffectation(); return true;
                    } 
                   
                }
                 this.mode_active=0;this.loadAffectation(); return true; 
            },
        loadService(){
        axios.get('api/service').then(({data})=>(this.services = data));  
      },
      openModal(d){
        this.listShow=true;
        this.nextSem=1;
        this.backSem=1;
        this.selectedItem='';
        this.brancardierSelcted='';
          this.indexDay=d;
         
      },

      nextWeek(){

if(this.mode_active===0){
        axios.get('api/affectationNonUrgenceNextWeek/'+this.id_service+'/'+this.nextSem+'/'+this.backSem).then(({data})=>(
           this.semaine.lundi=data.lundi,
           this.semaine.mardi=data.mardi,
           this.semaine.mercredi=data.mercredi,
           this.semaine.jeudi=data.jeudi,
           this.semaine.vendredi=data.vendredi,
         

           this.semaineCount.lundi=data.lundi.length,
           this.semaineCount.mardi=data.mardi.length,
           this.semaineCount.mercredi=data.mercredi.length,
           this.semaineCount.jeudi=data.jeudi.length,
           this.semaineCount.vendredi=data.vendredi.length,
           this.dateAffectation.date_debut= this.$options.filters.DateTrans(data.date_debut),
           this.dateAffectation.date_fin= this.$options.filters.DateTrans(data.date_fin),
           
           console.log("lundi" +this.dateAffectation.date_debut +"------->"+data.date_debut)
           
            ));
            this.nextSem++;
          
            }
            else{
                axios.get('api/affectationUrgenceNextWeek/'+this.id_service+'/'+this.nextSem+'/'+this.backSem).then(({data})=>(
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
           
           
           
           }
      },
      backWeek(){
           if(this.mode_active===0){
        axios.get('api/affectationNonUrgenceBackWeek/'+this.id_service+'/'+this.backSem+'/'+this.nextSem).then(({data})=>(
           this.semaine.lundi=data.lundi,
           this.semaine.mardi=data.mardi,
           this.semaine.mercredi=data.mercredi,
           this.semaine.jeudi=data.jeudi,
           this.semaine.vendredi=data.vendredi,
         

           this.semaineCount.lundi=data.lundi.length,
           this.semaineCount.mardi=data.mardi.length,
           this.semaineCount.mercredi=data.mercredi.length,
           this.semaineCount.jeudi=data.jeudi.length,
           this.semaineCount.vendredi=data.vendredi.length,
           this.dateAffectation.date_debut= this.$options.filters.DateTrans(data.date_debut),
           this.dateAffectation.date_fin= this.$options.filters.DateTrans(data.date_fin),
          
           console.log("lundi" +this.dateAffectation.date_debut +"------->"+data.date_debut)
           
            ));
             this.backSem++;
            
            }
            else{
                axios.get('api/affectationUrgenceBackWeek/'+this.id_service+'/'+this.backSem+'/'+this.nextSem).then(({data})=>(
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
           
           }
      },
 loadBrancardier() {
      axios
        .get("api/brancardier")
        .then(({ data }) => (this.brancardiers = data));
    },
     getResults(page = 1) {
      axios.get("api/brancardier?page=" + page).then(response => {
        this.brancardiers = response.data;
      });
    },
     checkedChange(id) {
      
   this.selectedItemChange=id;
   this.brancardierSelcted=id;
    },
    isCheckedChange(id) {

      if (this.selectedItemChange===id) return true;
      return false;
    },
    ifSelected(){
      var daySelected ;
      if(this.indexDay===1){
daySelected=this.semaine.lundi;
      }
      else if(this.indexDay===2){
daySelected=this.semaine.mardi;
      }
       else if(this.indexDay===3){
daySelected=this.semaine.mercredi;
      }
       else if(this.indexDay===4){
daySelected=this.semaine.jeudi;
      } else if(this.indexDay===5){
daySelected=this.semaine.vendredi;
      }
       else if(this.indexDay===6){
daySelected=this.semaine.samedi;
      } else if(this.indexDay===7){
    daySelected=this.semaine.dimanche;    
      }
     else if(this.indexDay===10){
daySelected=this.semaine.lundi1;
      }
      else if(this.indexDay===20){
daySelected=this.semaine.mardi1;
      }
       else if(this.indexDay===30){
daySelected=this.semaine.mercredi1;
      }
       else if(this.indexDay===40){
daySelected=this.semaine.jeudi1;
      } else if(this.indexDay===50){
daySelected=this.semaine.vendredi1;
      }
       else if(this.indexDay===60){
daySelected=this.semaine.samedi1;
      } else if(this.indexDay===70){
    daySelected=this.semaine.dimanche1;    
      }
      else if(this.indexDay===11){
daySelected=this.semaine.lundiTemp;
      }
      else if(this.indexDay===21){
daySelected=this.semaine.mardiTemp;
      }
       else if(this.indexDay===31){
daySelected=this.semaine.mercrediTemp;
      }
       else if(this.indexDay===41){
daySelected=this.semaine.jeudiTemp;
      } else if(this.indexDay===51){
daySelected=this.semaine.vendrediTemp;
      }
console.log('day '+daySelected.length+' '+daySelected[0].id+' selected'+this.brancardierSelcted);
for(var i=0;i<daySelected.length;i++){
  if(this.brancardierSelcted===daySelected[i].user_id) {
                    return false;
  }
}
return true;
    },
    loadId(){
       axios.get('api/UrgenceId/').then(({data})=>(
         this.id_service=data[0 ].id,
          this.loadService(),
            this.loadBrancardier(),
            this.loadAffectation()


       ));
    },
    UpdateAffectation(){
      if(!this.ifSelected()) { 
        
         swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Le brancardier sélectionné est déja affecté !',
                    })
        
        
        return false; }
        var request={
        'id_service' : this.AffectationSelcted.id,
        'id_oldBrancardier': this.AffectationSelcted.user_id,
        'id_newBrancardier': this.brancardierSelcted,
        'date_debut': this.AffectationSelcted.date_debut,
        'date_fin': this.AffectationSelcted.date_fin
      } 

       axios
        .post("/api/UpdateAffectation/", request)
        .then(data => {
          this.loadAffectation();
        })
        .catch(() => {});
    
    
     console.log(request);
 $('#TousBrancardiers').modal('hide');
    },
    checked(brancardier) {
      Fire.$emit("selectedItem");
   this.selectedItem=brancardier.user_id; 
   this.AffectationSelcted=brancardier;
   $('#TousBrancardiers').modal('show');
    },
    isChecked(id) {

      if (this.selectedItem===id) return true;
      return false;
    },
       loadAffectation(){
           if(this.mode_active===0){
        axios.get('api/affectationNonUrgence/'+this.id_service).then(({data})=>(
           this.semaine.lundi=data.lundi,
           this.semaine.mardi=data.mardi,
           this.semaine.mercredi=data.mercredi,
           this.semaine.jeudi=data.jeudi,
           this.semaine.vendredi=data.vendredi,
         

           this.semaineCount.lundi=data.lundi.length,
           this.semaineCount.mardi=data.mardi.length,
           this.semaineCount.mercredi=data.mercredi.length,
           this.semaineCount.jeudi=data.jeudi.length,
           this.semaineCount.vendredi=data.vendredi.length,
           this.dateAffectation.date_debut= this.$options.filters.DateTrans(data.date_debut),
           this.dateAffectation.date_fin= this.$options.filters.DateTrans(data.date_fin),
           this.loaded=true,
           console.log("lundi" +this.semaineCount.lundi)
            ));
            }
            else{
                axios.get('api/affectationUrgence/'+this.id_service).then(({data})=>(
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
            }
      },
        
         ViderAffectation(){
           if(this.mode_active===0){
           this.semaine.lundi='';
           this.semaine.mardi='';
           this.semaine.mercredi='';
           this.semaine.jeudi='';
           this.semaine.vendredi='';
        
           this.semaineCount.lundi='';
           this.semaineCount.mardi='';
           this.semaineCount.mercredi='';
           this.semaineCount.jeudi='';
           this.semaineCount.vendredi='';
        
            }
            else{
                
           this.semaine.lundi='';
           this.semaine.mardi='';
           this.semaine.mercredi='';
           this.semaine.jeudi='';
           this.semaine.vendredi='';
           this.semaine.samedi='';
           this.semaine.dimanche='';
           this.semaine.lundi1='';
           this.semaine.lundi2='';
           this.semaine.mardi1='';
           this.semaine.mercredi1='';
           this.semaine.jeudi1='';
           this.semaine.vendredi1='';
           this.semaine.samedi1='';
           this.semaine.dimanche1='';
           this.semaine.lundiTemp='';
           this.semaine.mardiTemp='';
           this.semaine.mercrediTemp='';
           this.semaine.jeudiTemp='';
           this.semaine.vendrediTemp='';
           this.semaineCount.lundi='';
           this.semaineCount.mardi='';
           this.semaineCount.mercredi='';
           this.semaineCount.jeudi='';
           this.semaineCount.vendredi='';
           this.semaineCount.lundi1='';
           this.semaineCount.lundi2='';
           this.semaineCount.mardi1='';
           this.semaineCount.mercredi1='';
           this.semaineCount.jeudi1='';
           this.semaineCount.vendredi1='';
          
           this.semaineCount.lundiTemp='';
           this.semaineCount.mardiTemp='';
           this.semaineCount.mercrediTemp='';
           this.semaineCount.jeudiTemp='';
           this.semaineCount.vendrediTemp='';

           this.semaineCount.samedi='';
           this.semaineCount.dimanche='';
             this.semaineCount.samedi1='';
           this.semaineCount.dimanche1='';
            }
      },
        
        },
         mounted() {
           this.loadId();
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
  background-color: #0079ad;
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

.header{
      background-color: #0079ad;
    height: 50px;
}
</style>