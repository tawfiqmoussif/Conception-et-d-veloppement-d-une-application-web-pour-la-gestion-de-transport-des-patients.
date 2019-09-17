<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
        
     
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Utilisateurs Validés</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Utilisateurs Non Validés</a>
  </li>

</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <div class="card">
              <div class="card-header">

                  <div class="row justify-content-center ">
        <div class="col-md-4" >
<h3 style="float:left;" class="card-title">Liste des Utilisateurs Validés</h3>
        </div>
        <div class="col-md-4">
 <form class="form-inline">
      <div class="input-group input-group-sm">
        <input  @keyup="searchitv" v-model="searchv" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <a class="btn btn-navbar" @click="searchitv" style="background-color: #eef0fa;">
            <i class="fas fa-search"></i>
          </a>
        </div>
      </div>
    </form>
        </div>
        <div class="col-md-4" >
<button class="btn btn-success" style="float:right;" @click='newModal()'>Ajouter un utilisateur
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
                      <th v-show="false">ID</th>
                      <th>Nom d'utilisateur</th>
                      <th>Nom</th>
                      <th>Prénom</th>
                      <th>Mail</th>
                      <th>Métier</th>
                      <th>Date de création</th>
                      <th>Gérer</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user_v in users_v.data" :key="user_v.id">
                      <td v-show="false">{{user_v.id}}</td>
                      <td>{{user_v.name | upText }}</td>
                      <td>{{user_v.nom | upText }}</td>
                      <td>{{user_v.prenom | upText }}</td>
                      <td>{{user_v.email}}</td>
                      <td>{{user_v.metier | upText }}</td>
                      <td>{{user_v.created_at | myDate }}</td>
                     
                      <td>
<a @click='editModal(user_v)'>
    <i class="fa fa-edit green" ></i>
</a>

/

<a @click="deleteBran(user_v.id)">
    <i class="fa fa-trash red"></i>
</a>
                      </td>
                     
                    </tr>
                                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
               <div class="card-footer">
                  <pagination :data="users_v" @pagination-change-page="getResults1"></pagination>
              </div>
            </div>


  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

      <div class="card">
              <div class="card-header">


                   <div class="row justify-content-center ">
        <div class="col-md-4" >
<h3 style="float:left;" class="card-title">Liste des Utilisateurs Non Validés</h3>
        </div>
        <div class="col-md-4">
 <form class="form-inline">
      <div class="input-group input-group-sm">
        <input  @keyup="searchitnv" v-model="searchnv" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <a class="btn btn-navbar" @click="searchitnv" style="background-color: #eef0fa;">
            <i class="fas fa-search"></i>
          </a>
        </div>
      </div>
    </form>
        </div>
        <div class="col-md-4" >
<button class="btn btn-success" style="float:right;" @click='newModal()'>Ajouter un utilisateur
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
                      <th>ID</th>
                      <th>Nom d'utilisateur</th>
                   <th>Nom</th>
                   <th>Prénom</th>
                      <th>Mail</th>
                      <th>Date de création</th>
                      <th>Gérer</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user_nv in users_nv.data" :key="user_nv.id">
                      <td>{{user_nv.id}}</td>
                      <td>{{user_nv.name | upText }}</td>
                       <td>{{user_nv.nom | upText }}</td>
                        <td>{{user_nv.prenom | upText }}</td>
                      <td>{{user_nv.email}}</td>
                      <td>{{user_nv.created_at | myDate }}</td>
                     
                      <td>
<a @click='editModal(user_nv)'>
    <i class="fa fa-edit green" ></i>
</a>

/

<a @click="deleteBran(user_nv.id)">
    <i class="fa fa-trash red"></i>
</a>
                      </td>
                     
                    </tr>
                                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="users_nv" @pagination-change-page="getResults2"></pagination>
              </div>
            </div>

  </div>

</div>



             <!-- Modal -->
        <div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 v-show='editMode' class="modal-title" id="exampleModalCenterTitle">Modifier Un Utilisateur</h5>               
                <h5 v-show='!editMode' class="modal-title" id="exampleModalCenterTitle">Ajouter Un Utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent=" editMode ? updateBrancardier() : createBrancardier()">
            <div class="modal-body">

                <div class="form-group">
            <input v-model="form.name" type="text" name="name"
            placeholder="Nom d'utilisateur"
                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
            <has-error :form="form" field="name"></has-error>
                </div>

                 <div class="form-group">
            <input v-model="form.nom" type="text" name="nom"
            placeholder="Nom"
                class="form-control" :class="{ 'is-invalid': form.errors.has('nom') }">
            <has-error :form="form" field="nom"></has-error>
                </div>

                 <div class="form-group">
            <input v-model="form.prenom" type="text" name="prenom"
            placeholder="Prénom"
                class="form-control" :class="{ 'is-invalid': form.errors.has('prenom') }">
            <has-error :form="form" field="prenom"></has-error>
                </div>

                <div class="form-group">
            <input v-model="form.email" type="text" name="email"
            placeholder="Email"
                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
            <has-error :form="form" field="email"></has-error>
                </div>

                <div class="form-group">
            <input v-model="form.password" type="password" name="password"
            placeholder="Password"
                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
            <has-error :form="form" field="password"></has-error>
                </div>

                   <div class="form-group"> 
                  <label>Choisir la métier</label>  
                <select v-model="form.metier" type="text" name="metier" class="browser-default custom-select">
                    <option v-for="metier in metiers" :key="metier.id" :selected="metier.value== form.metier" :value="metier.value"> {{ metier.value | upText }}</option>
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
        </div>
    </div>
</template>

<script>
        export default {
        data () {
        return {
          searchv:'',
          searchnv:'',
         editMode:false,
         
        users_v: {},
        users_nv: {},
        form: new Form({
            id:'',
            name: '',
            nom: '',
            prenom: '',
            email: '',
            password: '',
            metier:'',
            //remember: false
        })
        , metiers: [
          { id: 1, value: 'brancardier' },
          { id: 2, value: 'major' },
          { id: 3, value: 'demandeur' },
          { id: 4, value: 'coordinateur' },
          { id: 5, value: 'admin' },
          { id: 6, value: 'Sans' },
        
        ],
        }
    },

    methods: {
       searchitv: _.debounce(() => {
      Fire.$emit("searchingv");
      console.log("shearchitv !");
    }, 1000),
     searchitnv: _.debounce(() => {
      Fire.$emit("searchingnv");
      console.log("shearchitnv !");
    }, 1000),
         getResults1(page = 1) {
                        axios.get('api/users_v?page=' + page)
                            .then(response => {
                                this.users_v = response.data;
                            });
                },
                  getResults2(page = 1) {
                        axios.get('api/users_nv?page=' + page)
                            .then(response => {
                                this.users_nv = response.data;
                            });
                },
updateBrancardier(){
  this.$Progress.start();
//console.log('updating data');
this.form.put('api/updateUser/'+this.form.id)
.then(()=>{
  Fire.$emit('AfterCreateBran');
     $('#addnew').modal('hide');
          swal.fire(
                    'Updated !',
                    'Les informations d\'utilisateur sont bien modifiées.',
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
editModal(brancardier){
  this.editMode=true;
           this.form.reset();
            $('#addnew').modal('show');
           this.form.fill(brancardier);
},
      loadUsers_v(){
        axios.get('api/users_v').then(({data})=>(this.users_v = data));  
      },
      loadUsers_nv(){
        axios.get('api/users_nv').then(({data})=>(this.users_nv = data));  
      },
      createBrancardier(){
           this.$Progress.start();
           this.form.post('api/CreateUser')
           .then(()=>{
            Fire.$emit('AfterCreateBran');
           Toast.fire({
            type: 'success',
            title: 'Utilisateur crée avec succès'
          });
          $('#addnew').modal('hide');
           this.$Progress.finish();
           })
           .catch(()=>{})
      },

          deleteBran(id){
          
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

          this.form.delete('api/brancardier/'+id)
          .then(()=>{
          Fire.$emit('AfterCreateBran');
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
              Fire.$on("searchingv", () => {
      let query = this.searchv;
      axios
        .get("api/findusers_v?q=" + query)
        .then(data => {
          this.users_v = data.data;
        })
        .catch(() => {});
    });
      Fire.$on("searchingnv", () => {
      let query = this.searchnv;
      axios
        .get("api/findusers_nv?q=" + query)
        .then(data => {
          this.users_nv = data.data;
        })
        .catch(() => {});
    });
             this.loadUsers_v();
            this.loadUsers_nv();
         //   setInterval(()=>this.loadBrancardier(),3000);
         Fire.$on('AfterCreateBran',()=>this.loadUsers_v());
         Fire.$on('AfterCreateBran',()=>this.loadUsers_nv());
           
        },
        mounted() {
        
            this.loadUsers_v();
            this.loadUsers_nv();
            console.log('Component mounted.')
        }
    }
</script>
