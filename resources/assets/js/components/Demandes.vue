<template><div>
<div class="mt-5 mb-5" v-show="!loaded"  style="min-height:100%;width:100%">
        <div class="row" style="min-height:100%;width:100%">
          <div class="col-md-12"><div class = "centered">
	<div class = "blob-1"></div>
	<div class = "blob-2"></div>
</div>

          </div>
          </div>
</div>

    <div class="container" v-show="loaded" >
       <section class="content">
         <div class="row">
          
         <div class="col-md-12">

            <div class="card ">
              <div class="card-header header" >
                <h3 class="card-title" style="color:white" >Les états</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i> </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                

                  <div class="row justify-content-center"> 
                    <div class="col-md-2">
<span class="badge " style="width:17px;height:17px;    background-color: orange;">&nbsp;</span>
                    <span class="ml-1 font-legend"  >En attente</span>
                    </div>
                    <div class="col-md-2">
 <span class="badge " style="width:17px;height:17px;    background-color: aqua;">&nbsp;</span>
                    <span class="ml-1 font-legend"  >En traitement</span>
                      
                    </div>
                    <div class="col-md-2">
     <span class="badge " style="width:17px;height:17px;    background-color: red;">&nbsp;</span>
                    <span class="ml-1 font-legend" >Problème</span>
                      
                    </div>
                    <div class="col-md-3">
   <span class="badge " style="width:17px;height:17px;  background-color: blue;">&nbsp;</span>
                    <span class="ml-1 font-legend" >Terminée Avec réserve</span>
                      
                    </div> 
                    <div class="col-md-2">
          <span class="badge " style="width:17px;height:17px;    background-color: green;">&nbsp;</span>
                    <span class="ml-1 font-legend" >Terminée</span>
                      
                    </div> 

                  </div>

              </div>
              <!-- /.card-body -->
            </div>

         </div>
              
              <!-- /.card-body -->
            </div>
         
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Les demandes</h3>

              <div class="card-tools">
              
                          <router-link style="background-color: #0079ad;" to="declarerdemande" class="btn btn-primary btn-block mb-3">Ajouter une demande</router-link>

              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <div class="btn-group">
                   <div class="row">  <div class="col-md-1 " style="float:left;margin:5px;" >
                                         <button type="button" @click='refresh2' class="btn btn-default btn-sm"><i class="fas fa-sync" style="color:black;"></i></button>
                </div>
                        <div class="col-md-4">
                 <select  v-model="id_etat" type="text" name="hopital" class="browser-default custom-select tools"  style="width: 200px; height: 30px;" @change="onChange">
                     <option value="" hidden>Etat ...</option>
                    <option v-for="etat in etats" :key="etat.id" :value="etat.id"> {{etat.libelle | upText  }}</option>
                </select>
                     </div>
                      
                         <div class="col-md-4">
                         <input placeholder="Nombre de lignes / page" style="width: 200px; height: 30px;" v-model="nombre_lignes" type="number" name="nombre_lignes"
                class="form-control tools" v-on:input='nombre_ligne'>
                </div>
              
                      </div>
                </div>
                <!-- /.float-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  <tr v-for="demande in demande_part" :key="demande.etat.pivot.demande_id" >
<div v-if="demande.etat.libelle==='En attente'">
   <td class="col0"><span class="badge mt-2" style="width:20px;height:20px;    background-color: orange;">&nbsp;&nbsp;&nbsp;</span></td>                    
                    <td class="col1"><p class="text-primary" > <span style="color:gray;">Du</span> &nbsp;{{demande.serviceDestination[0].intitule}}&nbsp;<span style="color:gray;">Vers</span>&nbsp;{{demande.serviceSource[0].intitule}}</p></td>
                    <td class=" col2"><p >Patient&nbsp;:&nbsp;<span class="text-primary" > {{demande.Patient.nom}}&nbsp;{{demande.Patient.prenom}}</span></p></td>
                   
                     <td class="col3"> </td>
                   <td class="col4">
 <div class="row">
                      <div class="col-md-6">
<button type="button" @click="affecter(demande)"  class="btn btn-block btn-outline-info btn-sm btn_style ">Affecter</button>

                      </div>
                     
                       <div class="col-md-6">
                      <button type="button" @click='annulerDemande(demande.etat.pivot.demande_id)' class="btn btn-block btn-outline-danger btn-sm btn_style ">Annuler</button>
  
                      </div>
                    </div>
</td>
                    <td class="col6"><a @click="openModal(demande)"><i class="fas fa-eye " style=" margin-left: 5px;"></i></a></td>
                    <td class="mailbox-date col7" ><span class="direct-chat-timestamp float-right" style="margin-top: 15px;" >{{demande.diff}}</span></td>
</div>


<div v-else-if="demande.etat.libelle==='En traitement'">
  <td class="col0"><span class="badge mt-2" style="width:20px;height:20px;    background-color: aqua;">&nbsp;&nbsp;&nbsp;</span></td>                    
                    <td class="col1"><p class="text-primary" > <span style="color:gray;">Du</span> &nbsp;{{demande.serviceSource[0].intitule}}&nbsp;<span style="color:gray;">Vers</span>&nbsp;{{demande.serviceDestination[0].intitule}}</p></td>
                    <td class=" col2"><p >Patient&nbsp;:&nbsp;<span class="text-primary" > {{demande.Patient.nom}}&nbsp;{{demande.Patient.prenom}}</span></p></td>
                    <td class="col3">
                     <i class="fas fa-sync" style="color:aqua;"></i>
                      
                    </td>
                     <td class="col4">
 <div class="row">
                      <div class="col-md-6">

                      </div>
                    
                       <div class="col-md-6">
                        
                      </div>
                    </div>
</td>
                    <td class="col6"><a  @click="openModal(demande)"><i class="fas fa-eye " style=" margin-left: 5px;"></i></a></td>
                    <td class="mailbox-date col7" ><span class="direct-chat-timestamp float-right" style="margin-top: 15px;">{{demande.diff}}</span></td>
</div>

<div v-else-if="demande.etat.libelle==='Problème'">
  <td class="col0"><span class="badge mt-2" style="width:20px;height:20px;    background-color: red;">&nbsp;&nbsp;&nbsp;</span></td>                    
                    <td class="col1"><p class="text-primary" > <span style="color:gray;">Du</span> &nbsp;{{demande.serviceSource[0].intitule}}&nbsp;<span style="color:gray;">Vers</span>&nbsp;{{demande.serviceDestination[0].intitule}}</p></td>
                    <td class=" col2"><p >Patient&nbsp;:&nbsp;<span class="text-primary" > {{demande.Patient.nom}}&nbsp;{{demande.Patient.prenom}}</span></p></td>
                    <td class="col3">
                     <i class="fa fa-exclamation-circle" style="color:red;" aria-hidden="true"></i>
                      
                    </td>
                   <td class="col4">
 <div class="row">
                      <div class="col-md-6">

                      </div>
                      
                       <div class="col-md-6">
                        
                      </div>
                    </div>
</td>
                    <td class="col6"><a  @click="openModal(demande)"><i class="fas fa-eye " style=" margin-left: 5px;"></i></a></td>
                    <td class="mailbox-date col7" ><span class="direct-chat-timestamp float-right" style="margin-top: 15px;">{{demande.diff}}</span></td>
</div>




<div v-else-if="demande.etat.libelle==='Terminée Avec réserve'">
  <td class="col0"><span class="badge mt-2" style="width:20px;height:20px;    background-color: blue;">&nbsp;&nbsp;&nbsp;</span></td>                    
                    <td class="col1"><p class="text-primary" > <span style="color:gray;">Du</span> &nbsp;{{demande.serviceSource[0].intitule}}&nbsp;<span style="color:gray;">Vers</span>&nbsp;{{demande.serviceDestination[0].intitule}}</p></td>
                    <td class=" col2"><p >Patient&nbsp;:&nbsp;<span class="text-primary" > {{demande.Patient.nom}}&nbsp;{{demande.Patient.prenom}}</span></p></td>
                    <td class="col3">
            
                    </td>
                   <td class="col4">
 <div class="row">
                      <div class="col-md-6">
   <button type="button" class="btn btn-block btn-outline-success btn-sm btn_style" @click='terminerDemande(demande.etat.pivot.demande_id)' style="width: 90px;">Terminée</button>
                      </div>
                    
                       <div class="col-md-6">
                        
                      </div>
                    </div>
</td>
                    <td class="col6"><a @click="openModal(demande)"><i class="fas fa-eye " style=" margin-left: 5px;"></i></a></td>
                    <td class="mailbox-date col7" ><span class="direct-chat-timestamp float-right" style="margin-top: 15px;">{{demande.diff}}</span></td>
</div>



<div v-else>
  <td class="col0"><span class="badge mt-2" style="width:20px;height:20px; background-color: green;" >&nbsp;&nbsp;&nbsp;</span></td>                    
                    <td class="col1"><p class="text-primary" > <span style="color:gray;">Du</span> &nbsp;{{demande.serviceSource[0].intitule}}&nbsp;<span style="color:gray;">Vers</span>&nbsp;{{demande.serviceDestination[0].intitule}}</p></td>
                    <td  class=" col2"><p style="">Patient&nbsp;:&nbsp;<span class="text-primary" > {{demande.Patient.nom}}&nbsp;{{demande.Patient.prenom}}</span></p></td>
                    <td class="col3">
                      <i class="fa fa-check" style="color:green;" aria-hidden="true"></i>
                    </td>
                    

                      <td class="col4">
 <div class="row">
                      <div class="col-md-6">

                      </div>
                     
                       <div class="col-md-6">
                        
                      </div>
                    </div>
</td>
                    <td class="col6"><a  @click="openModal(demande)"><i class="fas fa-eye " style=" margin-left: 5px;"></i></a></td>
                    <td class="mailbox-date col7" ><span class="direct-chat-timestamp float-right" style="margin-top: 15px;">{{demande.diff}}</span></td>
</div>



                  </tr>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              <div class="mailbox-controls">
                <div class="float-right">
                  {{current_page}}/{{total_page}}
                  <div class="btn-group">
                    <button type="button" @click='backPage' class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" @click='nextPage'  class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
            </div>
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>


     <!-- Modal -->
 <div v-if="open" class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">            
                <h5  class="modal-title" id="exampleModalCenterTitle">La demande</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
<div class="card card-primary card-outline">
              <div class="card-body box-profile">
<div class="text-center" style="font-size: 25px;">
 Etat : {{demande.etat.libelle}}
                </div>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Code du Patient</b> <a class="float-right">{{demande.Patient.ppr}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Nom Complet du Patient</b> <a class="float-right">{{demande.Patient.nom}}&nbsp;{{demande.Patient.prenom}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Sexe du Patient</b> <a class="float-right">{{demande.Patient.ppr}}&nbsp;{{demande.Patient.sexe}}</a>
                  </li>
                   
                  <li class="list-group-item">
                    <b>Service Source</b> <a class="float-right">{{demande.serviceSource[0].intitule}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Salle</b> <a class="float-right">{{demande.lit.numero_salle}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Service Destination : </b> <a class="float-right">{{demande.serviceDestination[0].intitule}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Demandeur  : </b> <a class="float-right">{{demande.demandeur[0].nom}}&nbsp;{{demande.demandeur[0].prenom}}</a>
                 </li> 
                 <li class="list-group-item">
                   <div class="row justify-content-md-center">
                     <div class="col-md-4" v-if="demande.demande.accompagnant===1">Accompagnant&nbsp;&nbsp;<i class="fa fa-check" style="color:green;    margin-left: -2px;"></i></div>
                     <div class="col-md-4" v-if="demande.demande.accompagnant===0">Accompagnant&nbsp;&nbsp;<i class="fa fa-exclamation-circle" style="color:red;    margin-left: -2px;" aria-hidden="true"></i></div>
                      
                       <div class="col-md-5" v-if="demande.demande.dossier_medical===1">Dossier-Médical&nbsp;&nbsp;<i class="fa fa-check" style="color:green;    margin-left: -2px;"></i></div>
                     <div class="col-md-5" v-if="demande.demande.dossier_medical===0">Dossier-Médical&nbsp;&nbsp;<i class="fa fa-exclamation-circle" style="color:red;    margin-left: -2px;" aria-hidden="true"></i></div>

                      <div class="col-md-4" v-if="demande.demande.billet_rose===1">Billet-Rose&nbsp;&nbsp;<i class="fa fa-check" style="color:green;    margin-left: -2px;"></i></div>
                     <div class="col-md-4" v-if="demande.demande.billet_rose===0">Billet-Rose&nbsp;&nbsp;<i class="fa fa-exclamation-circle" style="color:red;    margin-left: -2px;" aria-hidden="true"></i></div>
                      
                   </div>
                 </li> 
                 
<div v-if="demande.etat.libelle!=='En attente'">
  <li class="list-group-item">
                    <b>Branacrdier  : </b> <a class="float-right">{{demande.brancardier[0].nom}}&nbsp;{{demande.brancardier[0].prenom}}</a>
   </li>
</div>
     </ul>           

                
              </div>
              <!-- /.card-body -->
            </div>
          </div>
            </div>
        </div>
        </div>


        <!-- Modal2 -->
 <div class="modal fade" id="branAffModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">            
                <h5  class="modal-title" id="exampleModalCenterTitle">Liste des Brancardiers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
       
            <div class="modal-body">
<div class="card card-primary card-outline">
       <div class="card-body box-profile"> 
        
          <div
            class="input-group mb-1 col-md-12"
            v-for="bran in branAff"
            :key="bran.id"
          >
            <div class="input-group-prepend panel">
              <div class="input-group-text">
                <input
                  type="checkbox"
                  aria-label="Checkbox for following text input"
                   @click="checked(bran)"
                  :checked="isChecked(bran.id)=== true"

                
                />
              </div>
            </div>
            <label
              class="form-control"
              aria-label="Text input with checkbox"
               @click="checked(bran)"
              v-show="isChecked(bran.id)"
              style=" background-color: #90EE90"
            >{{bran.nom}} {{bran.prenom}}</label>
            
                <label
              class="form-control"
              aria-label="Text input with checkbox"
              @click="checked(bran)"
              v-show="!isChecked(bran.id)"
            >{{bran.nom}} {{bran.prenom}}</label>
            
          
          
          </div> 
         
        <div class="modal-footer" >   
               <div >
                <button type="submit" class="btn btn-success" @click="sendidbrandemande()" >Affecter</button>   
                </div>         
               
            </div>
                
        </div>      
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
            id_etat:'',
            etats :{},
            demande:{},
            demandes:{},
            demande_part:[],
            end:0,
            start:-1,
            nbr_demandes:'',
            pagination:'12',
            current_page:'1',
            total_page:'',
            open:false,
            nombre_lignes:'',
            mode:0,
            loaded:false,

            
            id_service_source:'',
            id_demande:'',
            created_at:'',
            updated_at:'',
            deleted_at:'',
            branAff:{},
            
            
            selectedItem: '',  
            id_hospitalier: '',
            id_service_source: '',
            id_service_destination: '',
            accomp: '',
            doss: '',
            bill: '',
            demendeur:'',



        }},
        methods: {
           refresh2(){
            this.pagination=12;
            this.mode=0;
            this.nombre_lignes=12;
            this.loadDemandes();
          },
          sendidbrandemande(){
           this.$Progress.start();
              axios.post('api/sendbran',{
                selectedItem: this.selectedItem,
                id_demande:this.id_demande,              
               
            }).then(resp =>{
              console.log('succées2');
             
           this.refresh();
           $('#branAffModel').modal('hide');
           this.$Progress.finish();
               Toast.fire({
                type: "success",
                title: "Affectation réussite"
              })
           
            }).catch(error => {
              console.log('failed2');
              this.$Progress.fail();

            },
            )
          },
       checked(bran) {
         
          this.selectedItem=bran.id; 
          
          
            },
        isChecked(id) {

          if (this.selectedItem===id) return true;
          return false;
        },
        
     affecter(demande){
            this.id_service_source=demande.demande.id_service_source;          
            this.created_at=demande.demande.created_at;
            this.updated_at=demande.demande.updated_at;
            this.id_demande=demande.etat.pivot.demande_id;
         
 
            console.log('source',this.id_service_source);
             axios.post('api/sendidservicesource',{
                id_service_source: this.id_service_source,
                created_at:this.created_at,
                
            
            }).then((data) => {
              if(data.data){
                  this.branAff = data.data;
                  $('#branAffModel').modal('show'); 
                }  
                else if(data.data==0){
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: "Il n'y a aucun brancardier disponible",
                    })
                
                }               
                   
                   
              })
             .catch(() => {
               
           })           
              
          },

          refresh(){
            this.$Progress.start();
            this.mode ===0 ? this.loadDemandes(): this.onChange();
            this.$Progress.finish();
          },
          nombre_ligne(){
           if(this.nombre_lignes>0){
              this.pagination=this.nombre_lignes;
            this.mode ===0 ? this.loadDemandes(): this.onChange();
           }
          },
          affecterDemande($id){

          },
           annulerDemande($id){

              var request={
        'id_demande' : $id
      }
           axios
        .post("/api/annulerDemande/", request)
        .then(data => {
          this.loadDemandes();
                       Fire.$emit('ChangeDemandes');

           swal.fire(
                    'Demande Annulée!',
                    "Vous avez annulé la demande avec succès !",
                    'success'
                  )
        })
        .catch(() => {}); 
          },
          terminerDemande($id){

              var request={
        'id_demande' : $id
      }
           axios
        .post("/api/terminerDemande/", request)
        .then(data => {
          this.loadDemandes();         Fire.$emit('ChangeDemandes');


           swal.fire(
                    'Transport réussi !',
                    'La réception du patient est réussie ! ',
                    'success'
                  )
        })
        .catch(() => {}); 
          },
          nextPage(){
            if((this.end*this.pagination)<this.nbr_demandes){
this.demande_part=[];
 this.start+=1;
this.end+=1;
this.current_page=this.start+1;
for(var i=this.start*this.pagination;i<this.end*this.pagination;i++){
  if(i<this.nbr_demandes) {this.demande_part[i-(this.start*this.pagination)]=this.demandes[i];}
}
          }

          },
          backPage(){
           if(this.end>1&&this.start>0){
              this.demande_part=[];
              this.start-=1;this.end-=1;this.current_page=this.start+1;
for(var i=this.start*this.pagination;i<this.end*this.pagination;i++){
  this.demande_part[i-(this.start*this.pagination)]=this.demandes[i];
           }
}
          },
          
            onChange(){
               this.$Progress.start();
 axios.get('api/filtreEtat/'+this.id_etat).then(({data})=>(
                 this.demandes=data,
                 this.nextStep(),
                  this.mode=1,
                  this.open=false,
                   this.$Progress.finish()
                 
               ));
            },
             nextStep(){
                 if(this.demandes!==0){
                 console.log(this.demandes);
                 this.nbr_demandes=this.demandes[0].len;
                  this.nbr_demandes%this.pagination==0 ? this.total_page=this.nbr_demandes/this.pagination : this.total_page=parseInt(this.nbr_demandes/this.pagination)+1;
                  this.start=-1;
                  this.end=0;
                 this.nextPage();
               }else if(this.demandes===0){
                 this.demandes={};
                 this.total_page=0;
                
                 this.start=-1;
                 this.end=0;
                 this.nbr_demandes=0;
                 this.current_page=0;
                 this.demande_part=[];

                 
               }
            },
            openModal(demande){
this.demande=demande;
this.open=true;
$('#detailsModal').modal('show');
            },
            loadDemandes(){
                // this.$Progress.start();
               axios.get('api/demandes').then(({data})=>(
                 this.demandes=data,
                   this.nextStep(),
                    this.mode=0,
                    this.open=false,
                    this.loaded=true
                  // this.$Progress.finish()


                
               )); 
            },
            loadEtats(){
                 axios.get('api/etat').then(({data})=>(this.etats = data));     
            }
        },
        mounted() {
         
      //     this.interval = setInterval(() => this.refresh(), 1000);
         this.loadDemandes();
            this.loadEtats();
             Fire.$on('ChangeDemandes',()=>this.refresh());
    
            console.log('Component mounted.');
        }
        
    }
</script>
<style>
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

.font-legend{
  font-size: 14px;
    font-weight: 300;
    color: #343a40;
}
.header{
      background-color: #0079ad;
    height: 50px;
}
.col0{
      max-width: 50px !important;
      width: 50px !important;
}
.col1{
      max-width: 420px !important; 
      width: 320px !important;
}
.col2{
      max-width: 270px !important;
       width: 220px !important;
}
.col3{
      max-width: 20px !important;
       width: 30px !important;
}
.col4{
      max-width: 220px !important;
       width: 220px !important;
          padding-right: 0px !important ;
    padding-left: 0px;
}
.col6{
      max-width: 40px !important;
       width: 40px !important;
}
.col7{
      max-width: 140px !important;
       width: 140px !important;
}
.btn_style{
      padding-left: 10px;
    padding-right: 10px;
    width: 80px;
    margin-top: 5px;
}
.tools{
      margin: 5px;
      margin-left: 50px;
}
</style>