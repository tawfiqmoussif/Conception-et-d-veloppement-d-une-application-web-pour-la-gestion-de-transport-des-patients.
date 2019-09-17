<template>
    <div class="container">
       <section class="content">
      <div class="row">
        <div class="col-md-3">
          <router-link to="declarerdemande" class="btn btn-primary btn-block mb-3">Ajouter une demande</router-link>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Les états</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                  <li class="nav-item active">
                  <span  class="nav-link">
                    <span class="badge mr-5" style="width:20px;height:20px;    background-color: orange;">&nbsp;&nbsp;&nbsp;</span>
                    <span class="" >En attente</span>
                  </span>
                </li>
                <li class="nav-item active">
                  <span  class="nav-link">
                    <span class="badge mr-5" style="width:20px;height:20px;    background-color: aqua;">&nbsp;&nbsp;&nbsp;</span>
                    <span class="" >En traitement</span>
                  </span>
                </li>
                 <li class="nav-item active">
                  <span  class="nav-link">
                    <span class="badge mr-5" style="width:20px;height:20px;    background-color: red;">&nbsp;&nbsp;&nbsp;</span>
                    <span class="" >Problème</span>
                  </span>
                </li>
                <li class="nav-item">
                  <span  class="nav-link">
                    <span class="badge " style="width:20px;height:20px;    background-color: blue;">&nbsp;&nbsp;&nbsp;</span>
                    <span class="ml-3" >Terminée Avec réserve</span>
                  </span>
                </li>
                <li class="nav-item">
                  <span  class="nav-link">
                    <span class="badge mr-5" style="width:20px;height:20px;    background-color: green;">&nbsp;&nbsp;&nbsp;</span>
                    <span class="" >Terminée</span>
                  </span>
                </li>

              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /. box -->
        
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Les demandes</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" placeholder="Search Mail">
                  <div class="input-group-append">
                    <div class="btn btn-primary">
                      <i class="fa fa-search"></i>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <div class="btn-group">
                    Etats :&nbsp;&nbsp;
                 <select v-model="id_etat" type="text" name="hopital" class="browser-default custom-select" style="width: 200px; height: 30px;" @change="onChange">
                     <option hidden>Etat ...</option>
                    <option v-for="etat in etats" :key="etat.id" :value="etat.id"> {{etat.libelle | upText  }}</option>
                </select>
                </div>
                <!-- /.float-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  <tr v-for="demande in demandes" :key="demande.etat.pivot.demande_id" >
<div v-if="demande.etat.libelle==='En attente'">
  <td><span class="badge mt-2" style="width:20px;height:20px;    background-color: orange;">&nbsp;&nbsp;&nbsp;</span></td>                    
                    <td class="mailbox-name"><a href="read-mail.html"></a></td>
                    <td><p class="text-primary" style="width: max-content"> <span style="color:gray;">Du</span> &nbsp;{{demande.serviceSource[0].intitule}}&nbsp;<span style="color:gray;">Vers</span>&nbsp;{{demande.serviceDestination[0].intitule}}</p></td>
                    <td class="mailbox-subject"><p style="width: max-content">Patient&nbsp;:&nbsp;<span class="text-primary" > {{demande.Patient.nom}}&nbsp;{{demande.Patient.prenom}}</span></p></td>
                    <td style="width: 00px">
                      <div class="row">
                        <div class="col-md-12 mr-5">
<button type="button" class="btn btn-block btn-outline-info btn-sm" style="width: auto;" @click="affecter(demande)">Affecter</button>
                        </div>
                      </div>
                      
                    </td>
                    <td><a @click="openModal(demande)"><i class="fas fa-eye"></i></a></td>
                    <td class="mailbox-date" style="width:150px;"><span class="direct-chat-timestamp float-right" style="margin-top: 15px;">{{demande.diff}}</span></td>
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
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                <div class="float-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
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


     <!-- Modal1 -->
 <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Patient</b> <a class="float-right">{{demande.Patient.nom}}&nbsp;{{demande.Patient.prenom}}</a>
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
</template>

<script>
    export default {
          data () {
        return {
            id_etat:'',
            id_service_source:'',
            id_demande:'',
            created_at:'',
            updated_at:'',
            deleted_at:'',
            branAff:{},
            etats :{},
            demande:{},
            demandes:{},
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
          sendidbrandemande(){
            this.id_demande=this.demande.demande.id;
            this.accomp=this.demande.demande.accompagnant;
            this.doss=this.demande.demande.dossier_medical;
            this.bill=this.demande.demande.billet_rose;
            this.demendeur=this.demande.demande.user_id_demandeur;
            this.id_service_source=this.demande.demande.id_service_source;
            this.id_service_destination=this.demande.demande.id_service_destination;
            this.id_hospitalier=this.demande.demande.hospitalisation_id;
            this.created_at=this.demande.demande.created_at;
            this.updated_at=this.demande.demande.updated_at;            
            this.deleted_at=this.demande.demande.deleted_at;

              axios.post('api/sendbran',{
                selectedItem: this.selectedItem,
                id_demande:this.id_demande,
                accomp:this.accomp,
                doss:this.doss,
                bill:this.bill,
                demendeur:this.demendeur,
                id_service_source:this.id_service_source,
                id_service_destination:this.id_service_destination,
                id_hospitalier:this.id_hospitalier,
                created_at:this.created_at,
                updated_at:this.updated_at,
                deleted_at:this.updated_at,
               
            }).then(resp =>{
              console.log('succées2');
           this.loadDemandes();
           this.sendidbrandemande();
            }).catch(error => {
              console.log('failed2')
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
         
 
            console.log('date', this.created_at);
             axios.post('api/sendidservicesource',{
                id_service_source: this.id_service_source,
                created_at:this.created_at,
                
            
            }).then((data) => {
                  this.branAff = data.data;                  
                   $('#branAffModel').modal('show');
                   
              })
             .catch(() => {
           })
            
            
            
            
            
            
            
            
           // then(({ data }) => (this.branAff = data))
            // $('#branAffModel').modal('show');
              
             
          },




            onChange(){

            },
            openModal(demande){
this.demande=demande;
$('#detailsModal').modal('show');
            },
            loadDemandes(){
              var i=0;
               axios.get('api/demandes').then(({data})=>(
                 this.demandes=data,
                 this.demande=data[0]
                
               )); 
               
            },
            loadEtats(){
                 axios.get('api/etat').then(({data})=>(this.etats = data));     
            }
        },
        mounted() {
          
          this.loadDemandes();
            this.loadEtats();
            
            console.log('Component mounted.')
        }
    }
</script>
