<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-center ">
        <div class="col-md-4" >
<h3 style="float:left;" class="card-title">Liste des brancardiers</h3>
        </div>
        <div class="col-md-4">
 <form class="form-inline">
      <div class="input-group input-group-sm">
        <input  @keyup="searchit" v-model="search" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <a class="btn btn-navbar" @click="searchit" style="background-color: #eef0fa;">
            <i class="fas fa-search"></i>
          </a>
        </div>
      </div>
    </form>
        </div>
        <div class="col-md-4" >
<button class="btn btn-success" style="float:right;" @click='newModal()'>Ajouter un brancardier
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
                      <th></th>
                      <th>Nom d'utilisateur</th>
                      <th>Nom</th>
                      <th>Prénom</th>
                      <th>Mail</th>
                      <th>Date de création</th>
                      <th>Gérer</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="brancardier in brancardiers.data" :key="brancardier.id">
                      <td v-show="false">{{brancardier.id}}</td>
                       <td>    <img class="profile-user-img img-fluid img-circle" :src="'img/profile/' + brancardier.photo" alt="User Avatar" style="width: 50px;height: 50px;border-radius: 50%; margin-left: 10px;"> </td>
                      <td>{{brancardier.name | upText }}</td>
                      <td>{{brancardier.nom | upText }}</td>
                      <td>{{brancardier.prenom | upText }}</td>
                      <td>{{brancardier.email}}</td>
                      <td>{{brancardier.created_at | myDate }}</td>
                     
                      <td>
<a @click='editModal(brancardier)'>
    <i class="fa fa-edit green" ></i>
</a>

/

<a @click="deleteBran(brancardier.id)">
    <i class="fa fa-trash red"></i>
</a>

/

<a @click='details(brancardier)'>
<i class="fa fa-arrow-right text-muted "></i>
</a>
                      </td>
                     
                    </tr>
                                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="brancardiers" @pagination-change-page="getResults"></pagination>
              </div>

            </div>
            <!-- /.card -->
          </div>
        </div>



        <!-- Modal -->
 <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">            
                <h5  class="modal-title" id="exampleModalCenterTitle">Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
<div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" :src="'img/profile/' + form.photo" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{form.name |upText}}</h3>

                <p class="text-muted text-center">{{form.metier |upText}}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>E-mail</b> <a class="float-right">{{form.email}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>PPR</b> <a class="float-right">{{form.ppr}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Sexe</b> <a class="float-right">{{form.sexe}}</a>
                  </li>
                   <li class="list-group-item">
                    <b>Temporaire</b> <a class="float-right">{{form.temporaire |changeTemp}}</a>
                  </li>
                </ul>

                <a @click='editModal(detailsBran)' class="btn btn-primary btn-block"><b>Modifier</b></a>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
            </div>
        </div>
        </div>





        <!-- Modal -->
        <div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 v-show='editMode' class="modal-title" id="exampleModalCenterTitle">Modifier Un Brancardie</h5>               
                <h5 v-show='!editMode' class="modal-title" id="exampleModalCenterTitle">Ajouter Un Brancardie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent=" editMode ? updateBrancardier() : createBrancardier()">
            <div class="modal-body">

     <div class="widget-user-image">
                  
                    </div>  
                     <div class="form-group">
                                    
                                    <div class="col-sm-12">
                                        <img class="profile-user-img img-fluid img-circle" :src="getProfilePhoto()" alt="User Avatar" style="width: 70px;height: 70px;border-radius: 50%; margin-left: 170px;">
                                      <label style="font-size: 10px;margin: 0px 0px 0px 140px;" id="photo">Changer l'image de profil</label>
                                      <div class="input-group">
                      <div class="custom-file">
                        <input type="file"   @change="updateProfile" name="photo" id="photo" class="custom-file-input" style="margin: 0px 0px 0px 140px;" >
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                                    </div>
                     </div>
                                   

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
            <input v-model="form.tel" type="text" name="tel"
            placeholder="Téléphon"
                class="form-control" :class="{ 'is-invalid': form.errors.has('tel') }">
            <has-error :form="form" field="tel"></has-error>
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
            <input v-model="form.age" type="text" name="age"
            placeholder="Age"
                class="form-control" :class="{ 'is-invalid': form.errors.has('age') }">
            <has-error :form="form" field="name"></has-error>
                </div>

                 <div class="form-group"> 
                  <label>Choisir le sexe</label>  
                <select v-model="form.sexe" type="text" name="sexe" class="browser-default custom-select">
                    <option v-for="option in options" :key="option.id" :selected="option.value== form.sexe"> {{ option.value}}</option>
                </select>
             </div>

                     <div class="form-group"> 
                  <label> Poste en interne</label>  
                <select v-model="form.poste_en_interne" type="text" name="poste_en_interne" class="browser-default custom-select">
                    <option v-for="poste in postes" :key="poste.id" :selected="poste.value=== form.poste_en_interne"> {{ poste.value}}</option>
                </select>
             </div>

             <div class="form-group"> 
                  <label>Temporaire</label>  
                <select v-model="form.temporaire" type="text" name="temporaire" class="browser-default custom-select">
                    <option v-for="temp in tempo" :key="temp.id" :selected="form.temporaire == temp.id" :value="temp.id"> {{ temp.id  |changeTemp   }}</option>
                </select>
             </div>

               <div class="form-group" v-show="editMode"> 
                  <label>Choisir la métier</label>  
                <select v-model="form.metier" type="text" name="metier" class="browser-default custom-select">
                    <option v-for="metier in metiers" :key="metier.id" :selected="metier.value== form.metier" :value="metier.value"> {{ metier.value | upText}}</option>
                </select>
             </div>

              <div class="form-group">
                <label>Choisir le PPR</label> 
            <input v-model="form.ppr" type="text" name="ppr"
            placeholder="PPR"
                class="form-control" :class="{ 'is-invalid': form.errors.has('ppr') }">
            <has-error :form="form" field="password"></has-error>
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
          search:'',
         editMode:false,
         detailsBran: {},
        brancardiers: {},
        form: new Form({
            id:'',
            name: '',
            nom:'',
            prenom:'',
            email: '',
            password: '',
            photo:'',
            cin:'',
            age:'',
            sexe:'',
            metier:'',
            ppr:'',
            poste_en_interne:'',
            temporaire:''
            //remember: false
        }),
         options: [
          { id: 1, value: 'Homme' },
          { id: 2, value: 'Femme' },
        
        ],
           metiers: [
          { id: 1, value: 'brancardier' },
          { id: 2, value: 'major' },
          { id: 3, value: 'demandeur' },
          { id: 4, value: 'coordinateur' },
          { id: 5, value: 'admin' },
        
        ],
            tempo: [
          { id: 0, value: 'Non' },
          { id: 1, value: 'Oui' },
        
        ],
            postes: [
          { id: 1, value: 'Oui' },
          { id: 2, value: 'Non' },
        
        ]
        }
    },
    methods: {
        searchit: _.debounce(() => {
      Fire.$emit("searching");
      console.log("shearchit !");
    }, 1000),
        getResults(page = 1) {
                        axios.get('api/brancardier?page=' + page)
                            .then(response => {
                                this.brancardiers = response.data;
                            });
                },
      details(brancardier){
            this.form.reset();
            this.detailsBran=brancardier;
           this.form.fill(brancardier);
 $('#detailsModal').modal('show');
      },
        getProfilePhoto(){
                let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo ;
                return photo;
            },
              updateProfile(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    })
                    return false;
                }
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            },
updateBrancardier(){
  this.$Progress.start();
//console.log('updating data');
this.form.put('api/brancardier/'+this.form.id)
.then(()=>{
  Fire.$emit('AfterCreateBran');
     $('#addnew').modal('hide');
          swal.fire(
                    'Updated !',
                    'Les informations du brancardier est bien modifié.',
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
        this.form.photo='profile.png';
        $('#addnew').modal('show');
},
editModal(brancardier){
  this.editMode=true;
  $('#detailsModal').modal('hide');
           this.form.reset();
            $('#addnew').modal('show');
           this.form.fill(brancardier);
},
      loadBrancardier(){
        axios.get('api/brancardier').then(({data})=>(this.brancardiers = data));  
      },
      createBrancardier(){
           this.$Progress.start();
           this.form.post('api/brancardier')
           .then(()=>{
            Fire.$emit('AfterCreateBran');
           Toast.fire({
            type: 'success',
            title: 'Brancardier crée avec succès'
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
             Fire.$on("searching", () => {
      let query = this.search;
      axios
        .get("api/findBran?q=" + query)
        .then(data => {
          this.brancardiers = data.data;
        })
        .catch(() => {});
    });
            this.loadBrancardier();
         //   setInterval(()=>this.loadBrancardier(),3000);
         Fire.$on('AfterCreateBran',()=>this.loadBrancardier());
           
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>