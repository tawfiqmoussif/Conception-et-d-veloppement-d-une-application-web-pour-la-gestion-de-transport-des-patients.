<style>
.widget-user-header{
    background-position: center center;
    background-size: cover;
    height: 250px !important;
}
.widget-user .card-footer{
    padding: 0;
}

</style>


<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header text-white" style="background-image:url('./img/user-cover.jpg')">
                    <div class="row">
                        <div class="col-md-2 ml-2 mt-4">
  <div class="widget-user-image ml-0 mt-6 mr-0" >
                    <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar" style="    width: 130px;">
                </div>
                </div>
                    <div class="col-md-4 ml-1 mt-5">
                         <h3 class="widget-user-username">{{this.form.name}}</h3>
                    <h5 class="widget-user-desc"></h5>
                    </div>
                    
                    
                </div>
                </div>
              
               
                </div>
            </div>

            <!-- tab -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                        
                        <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Informations Peronnels</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            
                            <!-- Setting Tab -->
                            <div class="tab-pane active show" id="settings">
                                <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-12">
                                    <input type="" v-model="form.name" class="form-control" id="inputName" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                                     <has-error :form="form" field="name"></has-error>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Nom</label>

                                    <div class="col-sm-12">
                                    <input type="" v-model="form.nom" class="form-control" id="inputName" placeholder="Nom" :class="{ 'is-invalid': form.errors.has('nom') }">
                                     <has-error :form="form" field="nom"></has-error>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Prénom</label>

                                    <div class="col-sm-12">
                                    <input type="" v-model="form.prenom" class="form-control" id="inputName" placeholder="Prénom" :class="{ 'is-invalid': form.errors.has('prenom') }">
                                     <has-error :form="form" field="prenom"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-12">
                                    <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email"  :class="{ 'is-invalid': form.errors.has('email') }">
                                     <has-error :form="form" field="email"></has-error>
                                    </div>
                                </div>
              <div class="form-group"> 
                  <label class="col-sm-2 control-label">Choisir le sexe</label>  
                  <div class="col-sm-12">
                <select v-model="form.sexe" type="text" name="sexe" class="browser-default custom-select">
                    <option v-for="option in options" :key="option.id" :selected="option.value== form.sexe"> {{ option.value}}</option>
                </select>
                </div>
             </div>
                                  <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">PPR</label>

                                    <div class="col-sm-12">
                                    <input type="email" v-model="form.ppr" class="form-control" id="inputEmail" placeholder="PPR"  :class="{ 'is-invalid': form.errors.has('ppr') }">
                                     <has-error :form="form" field="ppr"></has-error>
                                    </div>
                                </div>

                                  <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Age</label>

                                    <div class="col-sm-12">
                                    <input type="email" v-model="form.age" class="form-control" id="inputEmail" placeholder="Age"  :class="{ 'is-invalid': form.errors.has('age') }">
                                     <has-error :form="form" field="age"></has-error>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Téléphone</label>

                                    <div class="col-sm-12">
                                    <input type="email" v-model="form.tel" class="form-control" id="inputEmail" placeholder="Téléphone"  :class="{ 'is-invalid': form.errors.has('tel') }">
                                     <has-error :form="form" field="tel"></has-error>
                                    </div>
                                </div>
                                

                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Photo de profile</label>
                                    <div class="col-sm-12">
                      <div class="custom-file">
                        <input type="file"   @change="updateProfile" name="photo" id="photo" class="custom-file-input" style="margin: 0px 0px 0px 140px;" >
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-12">
                                    <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Modifier</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
          </div>
          <!-- end tabs -->
        </div>
    </div>
</template>



<script>
    export default {
        data(){
            return {
                 form: new Form({
                    id:'',
                    name: '',
                    nom: '',
                    prenom: '',
                    tel: '',
                    email: '',
                    password: '',
                    photo:'',
                    cin:'',
                    age:'',
                    sexe:'',
                    metier:'',
                    ppr:'',
                    poste_en_interne:'',
                    
                }),
                    options: [
          { id: 1, value: 'Homme' },
          { id: 2, value: 'Femme' },
        
        ],
            }
        },
        mounted() {

            console.log('Component mounted.')
        },

        methods:{

            getProfilePhoto(){

                let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo ;
                return photo;
            },
 loadAuth(){
        axios.get('api/profileAuth').then(({data})=>(this.form.fill(data)));  
      },
            updateInfo(){
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }
                this.form.put('api/profile')
                .then(()=>{
                     Fire.$emit('AfterCreateBran');
                     
                     
                     swal.fire(
                                    'Updated !',
                    'Vos informations sont bien modifiées.',
                    'success'
                  )
                  this.$Progress.finish();
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
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
            }
        },

        created() {
                  this.loadAuth();
         //   setInterval(()=>this.loadAuth(),3000);
         Fire.$on('AfterCreateBran',()=>this.loadAuth());
        }
    }
</script>
