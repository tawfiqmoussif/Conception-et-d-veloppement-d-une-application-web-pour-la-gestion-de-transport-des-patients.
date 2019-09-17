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
        <div class="row justify-content-center">
          

            <!-- tab -->

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header p-2" style="background-color: #0079ad; color: #fff">
                        <ul class="nav nav-pills">
                      <b> <h3>Les informations du Service</h3></b>
                        
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                         
                            <!-- Setting Tab -->
                            <div class="tab-pane active show" id="settings">
                                <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Intitulé</label>

                                    <div class="col-sm-12">
                                    <input type=""  :value='form.intitule' class="form-control" disabled >
                                   
                                   
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="inputName" class="col-sm-5 control-label">Nombre de brancardiers</label>

                                   <div class="col-sm-12">
                                    <input type="number"  :value='form.nbr_bc' class="form-control"  disabled>
                                   
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Fixe</label>

                                    <div class="col-sm-12">
                                    <input type=""  :value='form.fixe' class="form-control"  disabled>
                                   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  for="inputName" class="col-sm-2 control-label">Urgence</label>

                                   <div class="col-sm-12">
                                    <input type=""  :value='form.urgence' class="form-control" disabled >
                                   
                                    </div>
                                </div>
             
                                  <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Major</label>

                                   <div class="col-sm-12">
                                    <input type=""  :value='form.major' class="form-control" disabled >
                                   
                                    </div>
                                </div>

                                  <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Hospital</label>

                                    <div class="col-sm-12">
                                    <input type=""  :value='form.hopital' class="form-control" disabled >
                                   
                                    </div>
                                </div>

                               
                                

                               


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-12">
                                    <button @click="lancerModal()" type="submit" class="btn btn-success">Modifier</button>
                                    
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
        <!-- Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">            
                <h5  class="modal-title" id="exampleModalCenterTitle">Les informations du Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
    <div class="card card-primary card-outline">
        <div class="card-body box-profile"> 
                 <div class="form-group">
                     <label>Intitulé :</label>  
            <input v-model="form.intitule" type="text" name="intitule"
            
                class="form-control" >
          
                </div>

                 <div class="form-group">
                     <label>Nombre des brancardiers :</label>  
            <input v-model="form.nbr_bc" type="number" name="nbr_bc"
           
                class="form-control" >
                </div>


                 <div class="form-group"> 
                  <label>Choisir un hospital :&nbsp;</label>  
                <select v-model="form.hopital" type="text" name="hopital" class="browser-default custom-select">
                    <option v-for="hopital in hopitals" :key="hopital.id" :value="hopital.intitulé"> {{hopital.intitulé |upText  }}</option>
                </select>
             </div>   

          

                <div class="form-group"> 
                  <label>Service fixe ou non</label>  
                  <select v-model="form.fixe" type="text" name="fixe" class="browser-default custom-select">
                      <option v-for="f in fi" :key="f.id" :selected="form.fixe == f.id" :value="f.id"> {{ f.id  |changeTemp   }}</option>
                </select>
                
             </div>

              <div class="form-group"> 
                  <label>Service d'urgence ou non :</label>  
                <select v-model="form.urgence" type="text" name="urgence" class="browser-default custom-select">
                    <option v-for="u in ur" :key="u.id" :selected="form.urgence == u.id" :value="u.id"> {{ u.id  |changeTemp   }}</option>
                </select>
             </div>

            </div>
            
            <div class="modal-footer">   
              
                <button  type="submit" class="btn btn-success" @click="updateService()">Modifier</button>                
                
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
        data(){
            return {
                    fixe:'',
                    urgence:'',
                   
                    hopitals: {},
                    ur: [
          { id: 0, value: 'Non' },
          { id: 1, value: 'Oui' },
        
        ],
            fi: [
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
                    
                }),
                  
            }
        },
        mounted() {
            this.loadMonService();
            this.loadHopital();
            console.log('Component mounted.')
        },

        methods:{
            fixe_urgence(){
                     if(this.form.fixe!=0){this.fixe="Oui"}
                     else (this.fixe="non")
                     if(this.form.urgence!=0){this.urgence="Oui"}
                     else(this.urgence="non")
            },
           
                loadHopital(){
        axios.get('api/hopital').then(({data})=>(this.hopitals = data));  
      },        
                loadMonService(){
                    
                   // axios.get('api/MonService'').then(({data})=>(this.form.service = data));
                        axios.get('api/MonService').then(({data})=>(this.form.id=data[0].id,this.form.intitule=data[0].intitule,
                        this.form.nbr_bc=data[0].nbr_bc,
                        this.form.fixe=data[0].fixe,
                        this.form.urgence=data[0].urgence,
                        this.form.hopital=data[0].hopital,
                        this.form.major=data[0].major,
                        this.fixe_urgence()));  

                    },

                    lancerModal(){$('#updateModal').modal('show');},
                    updateService(){
                        
                        
                    this.$Progress.start();
                    //console.log('updating data');
                    axios.put('api/service2/'+this.form.id,{
                        intitule: this.form.intitule,
                        nbr_bc: this.form.nbr_bc,
                        fixe: this.form.fixe,
                        urgence: this.form.urgence,
                        hopital: this.form.hopital,
                    })
                    .then(()=>{
                        this.loadMonService();
                        $('#addnew').modal('hide');
                            swal.fire(
                                        'Modifié !',
                                        'Les informations du service ont été bien modifiées.',
                                        'succès'
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
           
           
        },

        created() {
                  this.loadMonService();
         
        }
    }
</script>
