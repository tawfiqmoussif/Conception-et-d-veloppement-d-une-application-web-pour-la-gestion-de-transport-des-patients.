<template>
    <div class="content">
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Déclaration d'une demande</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form">
                <div class="card-body">
                    <div class="form-group">
                      <br>

                  <label>Hospitaliers</label>
                  <select v-model="id_hospitalier"  class="form-control"   style="width: 100%;" tabindex="-1" aria-hidden="true" >
                    
                    <option v-for="hospitalier in hospitaliers" :key="hospitalier.id" :value="hospitalier.id" > {{hospitalier.nom }}</option>
                  </select>
                </div>
<br>
<br>



<div class="row">
 
    <div class="col-md-6">
     
          <label >Services Source </label>
       
       
          <select v-model="id_service_source" type="text" name="hopital" class="browser-default custom-select" >
                    
                    <option v-for="service in services" :key="service.id" :value="service.id"> {{service.intitule | upText  }}</option>
                </select>
        </div> 
    
               
  
      <div class="col-md-6">
          <label >Services Destination </label>
      
          <select v-model="id_service_destination" type="text" name="hopital" class="browser-default custom-select" >
                  
                    <option v-for="service in services" :key="service.id" :value="service.id"> {{service.intitule | upText  }}</option>
                </select>
      
    </div> 
    </div>          
<br>
<br>
<br>


<div class="row">
  <div class="row col-md-4">
  <div class="col-md-8">
    <label>Accompagnant</label>
    </div>
     <div class="col-md-4">
    <div class="center">
      <input type="checkbox" name="" value="" @change="has_accompagnant()">
    </div>
  </div>
  </div>
  <div class="row col-md-5">
  <div class="col-md-8">
   &nbsp;&nbsp;<label>Dossier-Médical</label>
    </div>
     <div class="col-md-0">
    <div class="center">
      <input type="checkbox" name="" value="" @change="has_dossier()">
    </div>
  </div>
  </div>

  <div class="row col-md-3">
  <div class="col-md-10">
    <label>Billet-Rose</label>
    </div>
     <div class="col-md-0">
    <div class="center">
      <input type="checkbox" name="" value="" @change="has_billet()">
    </div>
  </div>
  </div> 

</div>
                 
                 </div>
                
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="button" class="btn btn-primary" @click="sendDemande()" value="Submit"/>
                </div>
              </form>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default{
  data(){
    return {
      accompagnant: false,
      dossier: false,
      billet: false,
      accomp : '',
      doss : '',
      bill : '',
      services: {},
      hospitaliers: {},
      id_service_source : '',
      id_service_destination : '',  
      id_hospitalier : '',
       }},
        methods:{
          
          has_accompagnant(){
            
            this.accompagnant? this.accompagnant=false:this.accompagnant=true;
          },
          has_dossier(){
            this.dossier? this.dossier=false:this.dossier=true;
          },
          has_billet(){
           this.billet? this.billet=false:this.billet=true;
          },
                loadService(){
                    axios.get('api/service').then(({data})=>(this.services = data));  
                  },
                loadHospitaliers(){
                    axios.get('api/declarerdemande').then(({data})=>(this.hospitaliers = data));  
                  },



                  sendDemande(){   
                    this.$Progress.start();
                      if(this.accompagnant==true){
                        this.accomp=1;
                      }
                      else{
                        this.accomp=0;
                      }
                      if(this.dossier==true){
                        this.doss=1;
                      }
                      else{
                        this.doss=0;
                      }
                      if(this.billet==true){
                        this.bill=1;
                      }
                      else{
                        this.bill=0;
                      }
                    
                     if(this.id_service_source==this.id_service_destination){
                            this.$Progress.fail();
                            swal.fire("Failed!", "There was something worng.", "warning");
                                      return false;
                                    
                        }
                       
            axios.post('api/senddemande',{
                id_hospitalier: this.id_hospitalier,
                id_service_source: this.id_service_source,
                id_service_destination: this.id_service_destination,                
                accomp: this.accomp,
                doss: this.doss,
                bill: this.bill,                
                
            }).then(resp =>{
              console.log('succées');
              this.$Progress.finish();
               Toast.fire({
                type: "success",
                title: "Déclaration réussite"
              })
            }).catch(error => {
               this.$Progress.fail();
              console.log('failed');
             
            },
            )
    },



    

                 
    },
      mounted() {
            this.loadService();
            this.loadHospitaliers();
        }
    

 
}
</script>



<style >
body{
    margin: 0;
    padding: 0;
    background: #f3f3f3;}

  .center{
    position: absolute;
   }
  .btn-primary {
    color: #fff;
    background-color: #0eaf52;
    border-color: #0eaf52;
    float: right;
    width: 100px;
}
.btn-primary:hover {
    color: #ffffff;
    background-color: #0eaf52;
    border-color: #0eaf52;
}
.btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active, .show > .btn-primary.dropdown-toggle {
    color: #ffffff;
    background-color: #0eaf52;
    border-color: #0eaf52;
}
.btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active, .show > .btn-primary.dropdown-toggle {
    color: #fff;
    background-color: #0eaf52;
    border-color: #0eaf52;
}
.btn-primary {
    color: #ffffff;
    background-color: #0eaf52;
    border-color: #0eaf52;
    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075);
}

  .card-primary:not(.card-outline) .card-header {
    background-color: #343a40;
    border-bottom: 0;
}

input[type="checkbox"]{
    position: relative;
    width: 40px;
    height: 20px;
    -webkit-appearance: none;
    background: #c6c6c6;
    outline: none;
    border-radius: 20px;
    box-shadow: inset 0 0 5px rgba(255, 0, 0, 0.2);
    transition: .5s;
}
input:checked[type="checkbox"]
{
  background: #03a9f4;
}
input[type="checkbox"]:before
{
  content: '';
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 20px;
  top: 0;
  left: 0;
  background: #ffffff;
  transform: scale(1.1);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  transition: .5s;
}
input:checked[type="checkbox"]:before
{
  left: 20px;
}
</style>