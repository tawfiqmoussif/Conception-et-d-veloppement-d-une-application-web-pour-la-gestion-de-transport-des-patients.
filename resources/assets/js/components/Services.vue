<template>
    <div class="container">
      
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
 
              <div class="card-header">
  <div class="row justify-content-center ">
        <div class="col-md-4" >
<h3 style="float:left;" class="card-title">Liste des services</h3>
        </div>
        <div class="col-md-4">
 <form class="form-inline">
      <div class="input-group input-group-sm">
        <input  @keyup="searchit" v-model="searchServ" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <a class="btn btn-navbar" @click="searchit" style="background-color: #eef0fa;">
            <i class="fas fa-search"></i>
          </a>
        </div>
      </div>
    </form>
        </div>
        <div class="col-md-4" >
<button style="float:right;" class="btn btn-success" @click='newModal()'>Ajouter un Service
                     <i class="fas fa-user-plus fa-fw"></i>
                     </button> 
                </div> 
        </div>
      </div>
                

                
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th><center>ID</center></th>
                      <th><center>intitulé</center></th>
                      <th><center>Nombre de brancardiers</center></th>
                   
                      <th><center>Service fixe</center></th>
                      <th><center>Service d'urgence</center></th>
                      <th><center>Date de création</center></th>
                      <th>Gérer</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="service in services.data" :key="service.id">
                      <td><center>{{service.id}}</center></td>
                      <td><center>{{service.intitule | upText }}</center></td>
                      <td><center>{{service.nbr_bc}}</center></td>
                      <td v-if="service.fixe==1"><center>Oui</center></td>
                      <td v-else-if="service.fixe==0"><center>Non</center></td>
                      <td v-if="service.urgence==1"><center>Oui</center></td>
                      <td v-else-if="service.urgence==0"><center>Non</center></td>
                      <td><center>{{service.created_at | myDate }}</center></td>
                     
                      <td>
<a @click='editModal(service)'>
    <i class="fa fa-edit green" ></i>
</a>

/

<a @click="deleteServ(service.id)">
    <i class="fa fa-trash red"></i>
</a>
                      </td>
                   
                    </tr>                 
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
               <div class="card-footer">
                  <pagination :data="services" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 v-show='editMode' class="modal-title" id="exampleModalCenterTitle">Modifier Un Service</h5>               
                <h5 v-show='!editMode' class="modal-title" id="exampleModalCenterTitle">Ajouter Un Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent=" editMode ? updateService() : createService()">
            <div class="modal-body">

                 <div class="form-group">
            <input v-model="form.intitule" type="text" name="intitule"
            placeholder="Intitulé"
                class="form-control" :class="{ 'is-invalid': form.errors.has('intitule') }">
            <has-error :form="form" field="intitule"></has-error>
                </div>

                 <div class="form-group">
            <input v-model="form.nbr_bc" type="number" name="nbr_bc"
            placeholder="nombre de brancardiers"
                class="form-control" :class="{ 'is-invalid': form.errors.has('nbr_bc') }">
                </div>


                 <div class="form-group"> 
                  <label>Choisir un hospital :&nbsp;</label>  
                <select v-model="form.hopital" type="text" name="hopital" class="browser-default custom-select">
                    <option v-for="hopital in hopitals" :key="hopital.id" :value="hopital.intitulé"> {{hopital.intitulé |upText  }}</option>
                </select>
             </div>   
<div class="form-group"> 
                  <label>Major :&nbsp;</label>  
                <select v-model="form.major" type="text" name="major" class="browser-default custom-select">
                    <option v-for="major in majors" :key="major.id" :value="major.id">{{major.nom |upText  }} {{major.prenom |upText  }}</option>
                </select>
             </div>
          

                <div class="form-group"> 
                  <label>Service fixe ou non</label>  
                <select v-model="form.fixe" type="text" name="fixe" class="browser-default custom-select">
                    <option v-for="f in fixe" :key="f.id" :selected="form.fixe == f.id" :value="f.id"> {{ f.id  |changeTemp   }}</option>
                </select>
             </div>

              <div class="form-group"> 
                  <label>Service d'urgence ou non :</label>  
                <select v-model="form.urgence" type="text" name="urgence" class="browser-default custom-select">
                    <option v-for="u in urgence" :key="u.id" :selected="form.urgence == u.id" :value="u.id"> {{ u.id  |changeTemp   }}</option>
                </select>
             </div>

            </div>
            
            <div class="modal-footer">   
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                <button v-show='editMode' type="submit" class="btn btn-success">Modifier</button>                
                <button v-show='!editMode' type="submit" class="btn btn-primary">Créer</button>
            </div>

            </form>
            </div>
        </div>
        </div>


    </div>
</template>

<script>
        export default {
        data () {
        return {
          searchServ: '',
         editMode:false,
         services: {},
        hopitals: {},
        majors:{},
            urgence: [
          { id: 0, value: 'Non' },
          { id: 1, value: 'Oui' },
        
        ],
            fixe: [
          { id: 0, value: 'Non' },
          { id: 1, value: 'Oui' },
        
        ],
        form: new Form({
            id:'',
            intitule: '',
            nbr_bc: '',
            fixe: '',
            urgence: '',
            hopital: '',
            major:'',
            //remember: false
        })
        }
    },

    methods: {
   searchit: _.debounce(() => {
      Fire.$emit("searchingService");
      console.log("shearchit !");
    }, 1000),
       getResults(page = 1) {
                        axios.get('api/serviceP?page=' + page)
                            .then(response => {
                                this.services = response.data;
                            });
                },
updateService(){
  this.$Progress.start();
//console.log('updating data');
this.form.put('api/service/'+this.form.id)
.then(()=>{
  Fire.$emit('AfterCreateServ');
     $('#addnew').modal('hide');
          swal.fire(
                    'Updated !',
                    'Les informations du service sont bien modifiées.',
                    'success'
                  )
                  this.$Progress.finish();
})
.catch(()=>{
this.$Progress.fail();
})
},
newModal(){
   this.editMode=false;
        this.form.reset();
        $('#addnew').modal('show');

},
editModal(service){
  this.editMode=true;
           this.form.reset();
            $('#addnew').modal('show');
           this.form.fill(service);
},
     loadService(){
        axios.get('api/serviceP').then(({data})=>(this.services = data));  
      },

       loadHopital(){
        axios.get('api/hopital').then(({data})=>(this.hopitals = data));  
      },
     loadMajor(){
        axios.get('api/majorP').then(({data})=>(this.majors = data));  
      },



      createService(){
           this.$Progress.start();
           this.form.post('api/service')
           .then(()=>{
            Fire.$emit('AfterCreateServ');
           Toast.fire({
            type: 'success',
            title: 'Service crée avec succès'
          });
          $('#addnew').modal('hide');
           this.$Progress.finish();
           })
           .catch(()=>{})
      },

          deleteServ(id){
          
    swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {

          this.form.delete('api/service/'+id)
          .then(()=>{
          Fire.$emit('AfterCreateServ');
          swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
          })
          .catch(()=>{
          swal.fire(
                    'Failed!',
                    'There was something worng.',
                    'warning'
                  )
          })   
      }
    })
        }
    },

     created() {
             Fire.$on("searchingService", () => {
      let query = this.searchServ;
      axios
        .get("api/findService?q=" + query)
        .then(data => {
          this.services = data.data;
        })
        .catch(() => {});
    });
            this.loadService();
            
         //   setInterval(()=>this.loadBrancardier(),3000);
         Fire.$on('AfterCreateServ',()=>this.loadService());
         this.loadHopital();
         this.loadMajor();
           
        },
        mounted() {
            
            console.log('Component mounted.');
            this.loadHopital();this.loadMajor();
        }
    }
</script>
