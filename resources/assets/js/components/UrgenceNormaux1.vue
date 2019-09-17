<!--<template>
  <div>
    <vue-good-wizard 
      :steps="steps"
      :onNext="nextClicked" 
      :onBack="backClicked">
      <div slot="page1">
        <h4>Step 1</h4>
   <div class="input-group mb-3">
                       <labale>Date début</labale>
             <datetime input-class="form-control" type="datetime" v-model="form.DateDebut" use24-hour></datetime> 
<div class="input-group-append" >
 
    <i class="fa fa-calendar-alt input-group-text mt-1" aria-hidden="true"></i>
    
    {{ form.DateDebut | formatDate }}
  </div>
  <br>

       <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" @click="urgence()">
  <label class="form-check-label" for="inlineRadio1"  >Service d'urgence</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" @click="autresservices()">
  <label class="form-check-label" for="inlineRadio2">Autres Services</label>
</div>


<div v-show="isurgence">
    <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"  @click="automatique()">
  <label class="form-check-label" for="inlineRadio1" >Automatique</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"  @click="manuelle()">
  <label class="form-check-label" for="inlineRadio2">Manuelle</label>
</div>

</div>

</div>

      </div>



<div slot="page2">
  <div  v-show="isautomatique">
        <h4>Selctionner les brancardiers</h4>
         <div class="input-group input-group-sm mb-5">
        <input class="form-control form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="searchit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
         <div class="row" >
        <div class="input-group mb-1 col-4 " v-for="brancardier in brancardiers.data" :key="brancardier.id" >
  <div class="input-group-prepend panel" >
    <div class="input-group-text">
      <input type="checkbox" aria-label="Checkbox for following text input" @click='checked(brancardier.id)'>
    </div>
  </div>
  <label  class="form-control" aria-label="Text input with checkbox" v-show='isChecked(brancardier.id)' style=" background-color: #90EE90">{{brancardier.nom | upText }} {{brancardier.prenom | upText }} </label>
  <label  class="form-control" aria-label="Text input with checkbox" v-show='!isChecked(brancardier.id)' >{{brancardier.nom | upText }} {{brancardier.prenom | upText }} </label>

</div>

</div>
<div class="card-footer mt-5">
                  <pagination :data="brancardiers" @pagination-change-page="getResults"></pagination>
              </div>
      </div>
</div>

     
      <div slot="page3">
        <h4>Step 3</h4>
        <p>This is step 3</p>
      </div>
      <div slot="page4">
        <h4>Step 4</h4>
        
      </div>
    </vue-good-wizard>
  </div>
</template>

<script>
export default {
  name: 'demo',
  data(){
    return {
      
    isurgence:false,
    isautomatique:false,
    search :'',
    selectedItem:[],
    brancardiers: {},
    services: {},


		    form: new Form({
            DateDebut:'',
           
              

        }),
      steps: [
        {
          label: 'Select Items',
          slot: 'page1',
        },
        {
          label: 'Add Constraints',
          slot: 'page2',
        },
        {
          label: 'Review',
          slot: 'page3',
        },
        {
          label: 'Apply',
          slot: 'page4',
        }
      ],
    };
  },
 
  methods: {
    nextClicked(currentPage) {
      console.log('next clicked', currentPage);   
      //let  formatDate=Vue.filter('formatDate')  
      //console.log(this.form.DateDebut|formatDate);
       console.log( this.$options.filters.formatDate(this.form.DateDebut));
      
     
      return true; //return false if you want to prevent moving to next page
      
    },
    backClicked(currentPage) {
      console.log('back clicked', currentPage);
      return true; //return false if you want to prevent moving to previous page
    },
     urgence(){
       this.isurgence= true;
  },
  autresservices(){
    this.isurgence= false;
      this.isautomatique=false;
  },
  automatique(){
    this.isautomatique=true;

  },
  manuelle(){
    
      this.isautomatique=false;
  },





  searchit: _.debounce(() => {
            Fire.$emit('searching');
        },1000),

        printme() {
            window.print();
        },
    getResults(page = 1) {
                        axios.get('api/brancardier?page=' + page)
                            .then(response => {
                                this.brancardiers = response.data;
                            });
                },
    nextClicked(currentPage) {
      console.log('next clicked', currentPage);
      if(currentPage===3 )
       console.log(this.form.DateDebut);
      return true; //return false if you want to prevent moving to next page
    },
    backClicked(currentPage) {
      console.log('back clicked', currentPage);
      return true; //return false if you want to prevent moving to previous page
    },
  loadService(){
        axios.get('api/service').then(({data})=>(this.services = data));  
      },

        loadBrancardier(){
        axios.get('api/brancardier').then(({data})=>(this.brancardiers = data));  
      },
      checked(id){var t=0;

        for(var i=0; i < this.selectedItem.length; i++){
          if( this.selectedItem[i]===id) {this.selectedItem.splice(i, 1); t++;}        
        }
        if(t===0) this.selectedItem.push(id);
      },
      isChecked(id){
        var t=0;
        for(var i=0; i < this.selectedItem.length; i++){
          if( this.selectedItem[i]===id) t++;    
        }
        if(t===0) return false;
        return true;
      }

  },
    
    
    created() {

             Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('api/findBran?q=' + query)
                .then((data) => {
                    this.brancardiers = data.data
                })
                .catch(() => {
                })
            })
           
            this.loadBrancardier();
            this.loadService();

Fire.$on('searching',() => {
                let query = this.search;
                axios.get('api/findBran?q=' + query)
                .then((data) => {
                    this.brancardiers = data.data
                })
                .catch(() => {
                })
            })
           
            

         //   setInterval(()=>this.loadBrancardier(),3000);
        // Fire.$on('AfterCreateBran',()=>this.loadBrancardier());
           
        },

        



     

  /*
  createAffectation(){
           this.$Progress.start();
           this.form.post('api/urgencenormaux')
           .then(()=>{
            
           Toast.fire({
            type: 'success',
            title: 'affectation crée avec succès'
          });
          $('#addnew').modal('hide');
           this.$Progress.finish();
           })
           .catch(()=>{})
      },*/
 

};
 
 

</script>
-->






<template>
  <form >
    <vue-good-wizard 
      :steps="steps"
      :onNext="nextClicked" 
      :onBack="backClicked">
      <div slot="page1">
        <h4>Les Dates d'affectation</h4>

<div id='wrapper' style='text-align: center;'>
    <div style='display: inline-block; vertical-align: top;'>
<div class="card-body">

                       <div class="row">

                  <div class="col-md-4">
                  <label class="mt-3" style="float: left;" >Date début</label>
                   </div>
                   <div class="col-md-12">
                 
                  <div class="input-group">
                   <datetime v-model="form.DateDebut" ></datetime> 
                    <div class="input-group-append">
                      <i class="fa fa-calendar-alt input-group-text" aria-hidden="true"></i>
                    </div>
                  </div>
                 
                       </div>
                        </div>
                          <div class="row">
                             <div class="col-md-4">
                  <label class="mt-3" style="float: left;" >Date fin</label>
                   </div>
                       <div class="col-md-12">

                    <div class="input-group">
                      <datetime v-model="form.DateFin"></datetime> 
                      <div class="input-group-append">
                        <i class="fa fa-calendar-alt input-group-text" aria-hidden="true"></i>
                      </div>
                    </div>

                       </div>
                </div>


  </div>
      </div>
       </div>
      </div>
      <div slot="page2">
          <div  v-show="isautomatique">
     <div class="row justify-content-between mb-5">
            <div class="col-4">
              <h4>Selctionner les brancardiers</h4>
            </div>
          <div class="col-4">
            <div class="input-group">
              <input
                type="search"
                class="form-control"
                placeholder="Search..."
                @keyup="searchit"
                v-model="search"
              />
              <div class="input-group-append">
                <button type="button" class="btn btn-secondary" @click="searchit">
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
         <div class="row" >
        <div class="input-group mb-1 col-4 " v-for="brancardier in brancardiers.data" :key="brancardier.id" >
  <div class="input-group-prepend panel" >
    <div class="input-group-text">
      <input type="checkbox" aria-label="Checkbox for following text input" @click='checked(brancardier.id)'>
    </div>
  </div>
  <label  class="form-control" aria-label="Text input with checkbox" v-show='isChecked(brancardier.id)' style=" background-color: #90EE90">{{brancardier.nom | upText }} {{brancardier.prenom | upText }} </label>
  <label  class="form-control" aria-label="Text input with checkbox" v-show='!isChecked(brancardier.id)' >{{brancardier.nom | upText }} {{brancardier.prenom | upText }} </label>

</div>

</div>
<div class="card-footer mt-5">
                  <pagination :data="brancardiers" @pagination-change-page="getResults"></pagination>
              </div>
      </div>
      </div>



      
      <div slot="page3">
        <h4>Step 3</h4>
          <table  id="basic-table" style="display: none;">
   <thead>
    <tr>
      <th :colspan="4">Service d'urgence</th>
    </tr>
  </thead>
  <tbody>
    <tr><td :colspan="4">Lundi</td></tr>
    <tr v-for="item in lundi">
      <td :rowspan="lundiSize" v-if="lundi.indexOf(item) == 0">8:00-18:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
     <tr v-for="item in lundi1">
      <td :rowspan="lundi1Size" v-if="lundi1.indexOf(item) == 0">18:00-8:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
    <tr v-for="item in lundiTemp">
      <td :rowspan="lundiTempSize" v-if="lundiTemp.indexOf(item) == 0">16:30-18:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
    <tr ><td :colspan="4">Mardi</td></tr>
    <tr v-for="item in mardi">
      <td :rowspan="mardiSize" v-if="mardi.indexOf(item) == 0">8:00-18:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
     <tr v-for="item in mardi1">
      <td :rowspan="mardi1Size" v-if="mardi1.indexOf(item) == 0">18:00-8:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
    <tr v-for="item in mardiTemp">
      <td :rowspan="mardiTempSize" v-if="mardiTemp.indexOf(item) == 0">16:30-18:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
     <tr ><td :colspan="4">Mercredi</td></tr>
    <tr v-for="item in mercredi">
      <td :rowspan="mercrediSize" v-if="mercredi.indexOf(item) == 0">8:00-18:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
     <tr v-for="item in mercredi1">
      <td :rowspan="mercredi1Size" v-if="mercredi1.indexOf(item) == 0">18:00-8:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
    <tr v-for="item in mercrediTemp">
      <td :rowspan="mercrediTempSize" v-if="mercrediTemp.indexOf(item) == 0">16:30-18:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
     <tr ><td :colspan="4">Jeudi</td></tr>
    <tr v-for="item in jeudi">
      <td :rowspan="jeudiSize" v-if="jeudi.indexOf(item) == 0">8:00-18:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
     <tr v-for="item in jeudi1">
      <td :rowspan="jeudi1Size" v-if="jeudi1.indexOf(item) == 0">18:00-8:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
    <tr v-for="item in jeudiTemp">
      <td :rowspan="jeudiTempSize" v-if="jeudiTemp.indexOf(item) == 0">16:30-18:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
     <tr ><td :colspan="4">Vendredi</td></tr>
    <tr v-for="item in vendredi">
      <td :rowspan="vendrediSize" v-if="vendredi.indexOf(item) == 0">8:00-18:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
     <tr v-for="item in vendredi1">
      <td :rowspan="vendredi1Size" v-if="vendredi1.indexOf(item) == 0">18:00-8:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
    <tr v-for="item in vendrediTemp">
      <td :rowspan="vendrediTempSize" v-if="vendrediTemp.indexOf(item) == 0">16:30-18:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
     <tr ><td :colspan="4">Samedi</td></tr>
    <tr v-for="item in samedi">
      <td :rowspan="samediSize" v-if="samedi.indexOf(item) == 0">8:00-18:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
     <tr v-for="item in samedi1">
      <td :rowspan="samedi1Size" v-if="samedi1.indexOf(item) == 0">18:00-8:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
     <tr ><td :colspan="4">Dimanche</td></tr>
    <tr v-for="item in dimanche">
      <td :rowspan="dimancheSize" v-if="dimanche.indexOf(item) == 0">8:00-18:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
     <tr v-for="item in dimanche1">
      <td :rowspan="dimanche1Size" v-if="dimanche1.indexOf(item) == 0">18:00-8:00 ( {{ $options.filters.DateTest(item.date_debut)}} )</td>
      <td>{{item.name}}</td>
      <td>{{item.email}}</td>
      <td>{{item.tel}}</td>
    </tr>
  </tbody>
</table>
    <div class="d-flex justify-content-center mt-2">
      <button v-show="selectedItemService!=0" class="btn btn-primary pl-5 pr-5 mr-1" @click="generate">Generate PDF</button>
      <button v-show="selectedItemService!=0" class="btn btn-primary pl-5 pr-5" @click="download">Download PDF</button>
    </div>
        <div class="row justify-content-md-center mt-3" v-show="generateShow!=0">
           
          <iframe
            v-bind:src="srcpdf"
            width="760"
            height="600"
            align="middle"
          ></iframe>
        </div>
         
        
       
      </div>
     
    </vue-good-wizard>
  </form>
</template>

<script>
import jsPDF from 'jspdf';
import 'jspdf-autotable';
export default {
  name: 'demo',
  data(){
    return {
      generateShow:0 ,
      srcpdf:'',
      selectedItemService: 4,
      diffDays:'',
      isurgence:false,
      isautomatique:false,
      search :'',
      selectedItem:[],
      branurgence:[],
      brancardiers: {},
      services: {},
		    form: new Form({
            DateDebut:'',
            DateFin:'',

        }),
          lLundi:{},
          lMardi:{},
          lMercredi:{},
          lJeudi:{},
          lVendredi:{},
          lSamedi:{},
          lDimanche:{},
          lundi:{},
          mardi:{},
          mercredi:{},
          jeudi:{},
          vendredi:{},
          samedi:{},
          dimanche:{},

          lundi1:{},
          mardi1:{},
          mercredi1:{},
          jeudi1:{},
          vendredi1:{},
          samedi1:{},
          dimanche1:{},

          llundi1:{},
          lmardi1:{},
          lmercredi1:{},
          ljeudi1:{},
          lvendredi1:{},
          lsamedi1:{},
          ldimanche1:{},

          lundiTemp:{},
          mardiTemp:{},
          mercrediTemp:{},
          jeudiTemp:{},
          vendrediTemp:{},
        
          
          llundiTemp:{},
          lmardiTemp:{},
          lmercrediTemp:{},
          ljeudiTemp:{},
          lvendrediTemp:{},
          

         //size of objects
          lLundiSize: 0,
          lMardiSize: 0,
          lMercrediSize: 0,
          lJeudiSize: 0,
          lVendrediSize: 0,
          lSamediSize: 0,
          lDimancheSize: 0,
          lundiSize: 0,
          mardiSize: 0,
          mercrediSize: 0,
          jeudiSize: 0,
          vendrediSize: 0,
          samediSize: 0,
          dimancheSize: 0,

           lLundi1Size: 0,
          lMardi1Size: 0,
          lMercredi1Size: 0,
          lJeudi1Size: 0,
          lVendredi1Size: 0,
          lSamedi1Size: 0,
          lDimanche1Size: 0,
          lundi1Size: 0,
          mardi1Size: 0,
          mercredi1Size: 0,
          jeudi1Size: 0,
          vendredi1Size: 0,
          samedi1Size: 0,
          dimanche1Size: 0,

           lLundiTempSize: 0,
          lMardiTempSize: 0,
          lMercrediTempSize: 0,
          lJeudiTempSize: 0,
          lVendrediTempSize: 0,
          lundiTempSize: 0,
          mardiTempSize: 0,
          mercrediTempSize: 0,
          jeudiTempSize: 0,
          vendrediTempSize: 0,
      steps: [
        {
          label: 'Dates',
          slot: 'page1',
        },
        {
          label: 'Brancardiers',
          slot: 'page2',
        },
        {
          label: 'Résultat',
          slot: 'page3',
        }
      ],
    };
  },
  methods: {
    download(){
       var imgData='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA0oAAAGVCAYAAADALQE+AAAgAElEQVR4Aey9e5Mkx3ne+2bN7C4gSqGBL7JsHQcGlvXnCQ7OF8DMJ8AsIVIEKXpnJJlBUaR2ViCB3bWtnZVtYAUQ3NkjU+JF5DTMO4HFDsIfYBefAI04/ziOLWJoiRKPZBItWxR2dqYzTzzVnTPVNVXdVdVZVVlVT0V0VHdVXt78ZXZ3PvXmRYQHCZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACbSYwNXb27J9Z6nFJWTRSIAESIAESIAESKCVBIJWloqFIgEfCFy+vStGXZMDc5diyYcKoQ0kQAIkQAIkQAIkkJ2Ayh6UIUmABDIRgAfpQO+KqPVI+L6cU2uyfX4Quca3JEACJEACJEACJEACnhKgUPK0YmhWQwmEIsncFZGVhBJQLCVA4SUSIAESIAESIAES8JEAhZKPtUKbmklgukiyZaJYsiR4JgESIAESIAESIAGPCVAoeVw5NK1BBLKJJFsgiiVLgmcSIAESIAESIAES8JQAhZKnFUOzGkQgn0iyBaNYsiR4JgESIAESIAESIAEPCVAoeVgpNKlBBIqJJFtAiiVLgmcSIAESIAESIAES8IwAhZJnFUJzGkRgPpFkC0qxZEnwTAIkQAIkQAIkQAIeEaBQ8qgyaEqDCLgRSbbAFEuWBM8kQAIkQAIkQAIk4AkBCiVPKoJmNIiAW5FkC06xZEnwTAIkQAIkQAIkQAIeEKBQ8qASaEKDCJQjkiwAiiVLgmcSIAESIAESIAESqJkAhVLNFcDsG0SgXJFkQVAsWRI8kwAJkAAJkAAJkECNBCiUaoTPrBtEoBqRZIFQLFkSPJMACZAACZAACZBATQQolGoCz2wbRKBakWTBUCxZEjyTAAmQAAmQAAmQQA0EKJRqgM4sG0SgHpFkAVEsWRI8kwAJkAAJkAAJkEDFBCiUKgbO7BpEoF6RZEFRLFkSPJMACZAACZAACZBAhQQolCqEzawaRMAPkWSBUSxZEjyTAAmQAAmQAAmQQEUEKJQqAs1sGkTAL5FkwVEsWRI8kwAJkAAJkAAJkEAFBCiUKoDMLBpEwE+RZAFSLFkSPJMACZAACZAACZBAyQQolEoGzOQbRMBvkWRBUixZEjyTAAmQAAmQAAmQQIkEKJRKhMukG0SgGSLJAqVYsiR4JgESIAESIAESIIGSCFAolQSWyTaIQLNEkgVLsWRJ8EwCJEACJEACJEACJRCgUCoBKpNsEIFmiiQLmGLJkuCZBEiABEiABEiABBwToFByDJTJNYhAs0WSBU2xZEnwTAIkQAIkQAIkQAIOCVAoOYTJpBpEoB0iyQKnWLIkeCYBEiABEiABEiABRwQCR+kwGRJoDoF2iSRwX5ED85ZcvbPSnEqgpSRAAiRAAiRAAiTgNwF6lPyuH1rnmkD7RFKU0ECUWpPnz/ejF/meBEiABEiABEiABEggPwEKpfzMGKOpBNotkmytUCxZEjyTAAmQAAmQAAmQwBwEFueIy6gk0CwCB3pXRLV9eNqSGHNXRB5pSOWgPpbD4YMij47fw3Rcw8se+yKCFw6cfyAi8JzhZa+Pb/NEAiRAAiRAAiRAAvMToFCanyFTaAwBtdQYU+cz1OdyQvysi8gTIrIqIlltjQunKKGBiNwTkTdFZI/CKYqG70mABEiABEiABIoSoFAqSo7xSIAEshKAGNoQkQtjz1HWeFnDIX2IL7xujr1Mr4hIT0QgoniQAAmQAAmQAAmQQG4CXPUuNzJGIAESyEgAXqBdEXl3LGCqGvaIfCCYkC/yjw7hy2g6g5EACZAACZAACXSdAIVS11sAy08C7glYgfTO2JPkPofsKcKTBTswb6sqoZbdOoYkARIgARIgARLwlgCFkrdVQ8NIoHEEMAQOHhwfBFIcHuZDvUUPUxwLP5MACZAACZAACaQRoFBKI8PrJEACeQhgfpCPAileBniYIJi24jf4mQRIgARIgARIgASiBCiUojT4ngRIIC8BeJHujF9434QDdmIOE4bjcf5SE2qMNpIACZAACZBADQQolGqAzixJoCUEMOcH3hl4k5p42OF4TbW/icxpMwmQAAmQAAk0hgCFUmOqioaSgFcEMIStDR4Z6xGDh4kHCZAACZAACZAACRwToFA6RsE3JEACGQlAJGHRhqYMtctSLMxZwhDCNpUpS7kZhgRIgARIgARIIIUAhVIKGF4mARJIJGBFUuLNhl+kSGp4BdJ8EiABEiABEnBJgELJJU2mRQLtJtBmkdQTkTURGbS7Clk6EiABEiABEiCBrAQolLKSYjgS6DaBNouk6yKy2e3qZelJgARIgARIgATiBBbjF/iZBEiABGIEsLod5iS18YBAgjeJBwmQAAmQAAmQAAlMEKBQmsDBDyRAAjEC2GcIq9u17cAQu/Micq9tBWN5SIAESIAESIAE3BCgUHLDkak0hoBpjKWeGNq21e2AFSIJ85H6njCmGSRAAiRAAiRAAh4S4BwlDyuFJpGAJwS2RQSbsrbpgDh6jCKpTVXKspAACZAACZBAOQToUSqHq7tUr7xe1bAnLI2MuShFjr6cU2uyfZ4rhhWh52cctIVrfppW2CoMs8NwO7bTwggZkQRIgARIgAS6Q4BCyf+6bsIT/RU5MHdl+47fYomj7vK09pt5AjcgLBZs4Mp2DagomkgCJEACJEACvhDg0DtfaqL5dlixxE07m1+XWAq8boEOrw88QPa1PwdWLv89BzxGJQESIAESIIGuEqBQ6mrNl1NuiqVyuFadah1D7jB3CIIGiywoEXlk/B6f8cK8IlzH+0s55hjBi4S5VjxIgARIgARIgARIIBcBCqVcuBg4AwGKpQyQPA4CbxKWBK/qwJC4x8cvCJpZy3Xj/s44PMQTxFXSnCNcg6jiHklV1STzIQESIAESIIGWEaBQalmFelIciiVPKqKAGVV5kyB4IJDg8Sm6TDeG40FcQTBBPNnDiqRZosuG55kESIAESIAESIAEThGgUDqFhBccERiJpct3qvROODK9s8lU5U2yQ+yKCqR4BUEYYTgehBc8SFz+O06In0mABEiABEiABHIToFDKjYwRchBYEWXekqt3ii47niMrBnVA4IKDNKYlAUGD5bnLmjME4QUPFfLhQQIkQAIkQAIkQAJzEaBQmgsfI2cgsCTG3KVYykCq3iDw/JW90h3mDO3VW0zmTgIkQAIkQAIkQALZCFAoZePEUPMR8EQsaRHBZkpdeOWusPXcMfJFmGcuUr6cGJoESIAESIAESIAEHBCgUHIAkUlkIuCJWMpkaxcDlTnsDgstcPW5LrYqlpkESIAESIAEGkyAQqnBlddA0ymW/Kw0DLsrax4ZVqbD4g08SIAESIAESIAESKBRBCiUGlVdrTCWYsm/aixzbhIXV/CvvmkRCZAACZAACZBABgIUShkgMYhzAvWIpS5MTbJlzFdlT+QLnjk09jHiXkaZcTEgCZAACZAACZCATwQolHyqjW7ZUo9Y6hbjrKUta9jdrawGMBwJkAAJkAAJkAAJ+EaAQsm3GumWPRWLJetu6cI5V0MqQyhhbhKXAs9VDQxMAiRAAiRAAiTgEwEKJZ9qo5u2VCyWugl5SqnLEEnIjiJpCnTeIgESIAESIAES8J8AhZL/ddQFCymW6qvlpZKyfqOkdJksCZAACZAACZAACVRCgEKpEszMJAMBiqUMkEoIgqXByzi4iEMZVJkmCZAACZAACZBAZQQolCpDzYwyEChZLHVhbpItYwbaoyBlCCXMT+JBAiRAAiRAAiRAAo0mQKHU6OprpfHliSUtIlZHtP1cb9OgUKqXP3MnARIgARIgARJwQIBCyQFEJuGcQHliybmpTJAESIAESIAESIAESKCNBCiU2lir7ShTSWKp7a4kW752NAKWggRIgARIgARIgATqIkChVBd55puFQEliKUvWDEMCJEACJEACJEACJNBlAhRKXa79ZpTdrViyDpe2n5tRt7SSBEiABEiABEiABLwlQKHkbdXQsAgBR2KJqzlEmJb5drXMxJk2CZAACZAACZAACVRBgEKpCsrMwwUBR2LJhSmtSqOs/Y7KWHa8VeBZGBIgARIgARIgAb8JUCj5XT+0bpIAxdIkD58/0avkc+3QNhIgARIgARIggZkEKJRmImIAzwgUF0vGiHTllb3S+tmD5gr5ZK7QDEwCJEACJEACJEACnhGgUPKsQmhOJgIQS2/J1TsbmUIz0DQCAxHBy/WxLiJLrhNleiRAAiRAAiRAAiRQFQEKpapIMx/3BIzZzSOWlBjpyisn7LK8Sls57WBwEiABEiABEiABEvCGAIWSN1VBQwoRyCOW2r4keLR8+WC+mS945tAX6VXKzIoBSYAESIAESIAEPCNAoeRZhZw2J9r75XuRBAZG78rV27OH4SkRUaYbr9MNadqVsla+w9A7epWmkec9EiABEiABEiABbwlQKHlbNTQsFwEjs8XSUIvSphOvXOxEIJTKmKcEM66JyEpOe1wG5+p7LmkyLRIgARIgARLoEAEKJd8rO8GBkuRU4TUR0bIrlzN4lnyv83rs2ysx2zs1DcHbFZG7InKzxLIxaRIgARIgARIggZYSoFBqacV2uFipYikIjCjVjVeB+n+jQJysUbD5LMRSlQeGYtrhmBj+V5dYq7LMzIsESIAESIAESMAhAQolhzCZlDcEksWSlsQpTq30xuWvCniUyhp+B2swBA4enioOCKN4XliuHN6lOocBVlF25kECJEACJEACJOCIAIWSI5BMxjsCCWKpS+MYC9XHrUKxskeCh+etEofhYfEICKS0oXYQSRBLEE08SIAESIAESIAESGAqAQqlqXh4s+EEJsTSaNE7I8q0/1Ww3noF4+WJBrHyztjDlCferLBWBNnhdmnhIaYw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QAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQGJvB/nmm4r6KURx8AAAAASUVORK5CYII='
               var doc = new jsPDF({
              orientation: 'landscape',
            });
            var width = doc.internal.pageSize.getWidth()/2-12;
            var height = doc.internal.pageSize.getHeight()/2-6;
            doc.setFont("helvetica");
            doc.setFontType("bold");
            doc.setFontSize(13);
            doc.text(width-50, 20, 'PROGRAMME DES BRANCARDIERS DES URGENCES');
            doc.addImage(imgData, 'PNG', width, 1, 24, 12);
            doc.autoTable({html: '#basic-table', startY: 25, styles: {
                halign: 'center',
                valign: 'middle',
            },
            });
            doc.save("table.pdf");

    },
     generate() {
       this.generateShow=1;
       var imgData='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA0oAAAGVCAYAAADALQE+AAAgAElEQVR4Aey9e5Mkx3ne+2bN7C4gSqGBL7JsHQcGlvXnCQ7OF8DMJ8AsIVIEKXpnJJlBUaR2ViCB3bWtnZVtYAUQ3NkjU+JF5DTMO4HFDsIfYBefAI04/ziOLWJoiRKPZBItWxR2dqYzTzzVnTPVNVXdVdVZVVlVT0V0VHdVXt78ZXZ3PvXmRYQHCZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACZAACbSYwNXb27J9Z6nFJWTRSIAESIAESIAESKCVBIJWloqFIgEfCFy+vStGXZMDc5diyYcKoQ0kQAIkQAIkQAIkkJ2Ayh6UIUmABDIRgAfpQO+KqPVI+L6cU2uyfX4Quca3JEACJEACJEACJEACnhKgUPK0YmhWQwmEIsncFZGVhBJQLCVA4SUSIAESIAESIAES8JEAhZKPtUKbmklgukiyZaJYsiR4JgESIAESIAESIAGPCVAoeVw5NK1BBLKJJFsgiiVLgmcSIAESIAESIAES8JQAhZKnFUOzGkQgn0iyBaNYsiR4JgESIAESIAESIAEPCVAoeVgpNKlBBIqJJFtAiiVLgmcSIAESIAESIAES8IwAhZJnFUJzGkRgPpFkC0qxZEnwTAIkQAIkQAIkQAIeEaBQ8qgyaEqDCLgRSbbAFEuWBM8kQAIkQAIkQAIk4AkBCiVPKoJmNIiAW5FkC06xZEnwTAIkQAIkQAIkQAIeEKBQ8qASaEKDCJQjkiwAiiVLgmcSIAESIAESIAESqJkAhVLNFcDsG0SgXJFkQVAsWRI8kwAJkAAJkAAJkECNBCiUaoTPrBtEoBqRZIFQLFkSPJMACZAACZAACZBATQQolGoCz2wbRKBakWTBUCxZEjyTAAmQAAmQAAmQQA0EKJRqgM4sG0SgHpFkAVEsWRI8kwAJkAAJkAAJkEDFBCiUKgbO7BpEoF6RZEFRLFkSPJMACZAACZAACZBAhQQolCqEzawaRMAPkWSBUSxZEjyTAAmQAAmQAAmQQEUEKJQqAs1sGkTAL5FkwVEsWRI8kwAJkAAJkAAJkEAFBCiUKoDMLBpEwE+RZAFSLFkSPJMACZAACZAACZBAyQQolEoGzOQbRMBvkWRBUixZEjyTAAmQAAmQAAmQQIkEKJRKhMukG0SgGSLJAqVYsiR4JgESIAESIAESIIGSCFAolQSWyTaIQLNEkgVLsWRJ8EwCJEACJEACJEACJRCgUCoBKpNsEIFmiiQLmGLJkuCZBEiABEiABEiABBwToFByDJTJNYhAs0WSBU2xZEnwTAIkQAIkQAIkQAIOCVAoOYTJpBpEoB0iyQKnWLIkeCYBEiABEiABEiABRwQCR+kwGRJoDoF2iSRwX5ED85ZcvbPSnEqgpSRAAiRAAiRAAiTgNwF6lPyuH1rnmkD7RFKU0ECUWpPnz/ejF/meBEiABEiABEiABEggPwEKpfzMGKOpBNotkmytUCxZEjyTAAmQAAmQAAmQwBwEFueIy6gk0CwCB3pXRLV9eNqSGHNXRB5pSOWgPpbD4YMij47fw3Rcw8se+yKCFw6cfyAi8JzhZa+Pb/NEAiRAAiRAAiRAAvMToFCanyFTaAwBtdQYU+cz1OdyQvysi8gTIrIqIlltjQunKKGBiNwTkTdFZI/CKYqG70mABEiABEiABIoSoFAqSo7xSIAEshKAGNoQkQtjz1HWeFnDIX2IL7xujr1Mr4hIT0QgoniQAAmQAAmQAAmQQG4CXPUuNzJGIAESyEgAXqBdEXl3LGCqGvaIfCCYkC/yjw7hy2g6g5EACZAACZAACXSdAIVS11sAy08C7glYgfTO2JPkPofsKcKTBTswb6sqoZbdOoYkARIgARIgARLwlgCFkrdVQ8NIoHEEMAQOHhwfBFIcHuZDvUUPUxwLP5MACZAACZAACaQRoFBKI8PrJEACeQhgfpCPAileBniYIJi24jf4mQRIgARIgARIgASiBCiUojT4ngRIIC8BeJHujF9434QDdmIOE4bjcf5SE2qMNpIACZAACZBADQQolGqAzixJoCUEMOcH3hl4k5p42OF4TbW/icxpMwmQAAmQAAk0hgCFUmOqioaSgFcEMIStDR4Z6xGDh4kHCZAACZAACZAACRwToFA6RsE3JEACGQlAJGHRhqYMtctSLMxZwhDCNpUpS7kZhgRIgARIgARIIIUAhVIKGF4mARJIJGBFUuLNhl+kSGp4BdJ8EiABEiABEnBJgELJJU2mRQLtJtBmkdQTkTURGbS7Clk6EiABEiABEiCBrAQolLKSYjgS6DaBNouk6yKy2e3qZelJgARIgARIgATiBBbjF/iZBEiABGIEsLod5iS18YBAgjeJBwmQAAmQAAmQAAlMEKBQmsDBDyRAAjEC2GcIq9u17cAQu/Micq9tBWN5SIAESIAESIAE3BCgUHLDkak0hoBpjKWeGNq21e2AFSIJ85H6njCmGSRAAiRAAiRAAh4S4BwlDyuFJpGAJwS2RQSbsrbpgDh6jCKpTVXKspAACZAACZBAOQToUSqHq7tUr7xe1bAnLI2MuShFjr6cU2uyfZ4rhhWh52cctIVrfppW2CoMs8NwO7bTwggZkQRIgARIgAS6Q4BCyf+6bsIT/RU5MHdl+47fYomj7vK09pt5AjcgLBZs4Mp2DagomkgCJEACJEACvhDg0DtfaqL5dlixxE07m1+XWAq8boEOrw88QPa1PwdWLv89BzxGJQESIAESIIGuEqBQ6mrNl1NuiqVyuFadah1D7jB3CIIGiywoEXlk/B6f8cK8IlzH+0s55hjBi4S5VjxIgARIgARIgARIIBcBCqVcuBg4AwGKpQyQPA4CbxKWBK/qwJC4x8cvCJpZy3Xj/s44PMQTxFXSnCNcg6jiHklV1STzIQESIAESIIGWEaBQalmFelIciiVPKqKAGVV5kyB4IJDg8Sm6TDeG40FcQTBBPNnDiqRZosuG55kESIAESIAESIAEThGgUDqFhBccERiJpct3qvROODK9s8lU5U2yQ+yKCqR4BUEYYTgehBc8SFz+O06In0mABEiABEiABHIToFDKjYwRchBYEWXekqt3ii47niMrBnVA4IKDNKYlAUGD5bnLmjME4QUPFfLhQQIkQAIkQAIkQAJzEaBQmgsfI2cgsCTG3KVYykCq3iDw/JW90h3mDO3VW0zmTgIkQAIkQAIkQALZCFAoZePEUPMR8EQsaRHBZkpdeOWusPXcMfJFmGcuUr6cGJoESIAESIAESIAEHBCgUHIAkUlkIuCJWMpkaxcDlTnsDgstcPW5LrYqlpkESIAESIAEGkyAQqnBlddA0ymW/Kw0DLsrax4ZVqbD4g08SIAESIAESIAESKBRBCiUGlVdrTCWYsm/aixzbhIXV/CvvmkRCZAACZAACZBABgIUShkgMYhzAvWIpS5MTbJlzFdlT+QLnjk09jHiXkaZcTEgCZAACZAACZCATwQolHyqjW7ZUo9Y6hbjrKUta9jdrawGMBwJkAAJkAAJkAAJ+EaAQsm3GumWPRWLJetu6cI5V0MqQyhhbhKXAs9VDQxMAiRAAiRAAiTgEwEKJZ9qo5u2VCyWugl5SqnLEEnIjiJpCnTeIgESIAESIAES8J8AhZL/ddQFCymW6qvlpZKyfqOkdJksCZAACZAACZAACVRCgEKpEszMJAMBiqUMkEoIgqXByzi4iEMZVJkmCZAACZAACZBAZQQolCpDzYwyEChZLHVhbpItYwbaoyBlCCXMT+JBAiRAAiRAAiRAAo0mQKHU6OprpfHliSUtIlZHtP1cb9OgUKqXP3MnARIgARIgARJwQIBCyQFEJuGcQHliybmpTJAESIAESIAESIAESKCNBCiU2lir7ShTSWKp7a4kW752NAKWggRIgARIgARIgATqIkChVBd55puFQEliKUvWDEMCJEACJEACJEACJNBlAhRKXa79ZpTdrViyDpe2n5tRt7SSBEiABEiABEiABLwlQKHkbdXQsAgBR2KJqzlEmJb5drXMxJk2CZAACZAACZAACVRBgEKpCsrMwwUBR2LJhSmtSqOs/Y7KWHa8VeBZGBIgARIgARIgAb8JUCj5XT+0bpIAxdIkD58/0avkc+3QNhIgARIgARIggZkEKJRmImIAzwgUF0vGiHTllb3S+tmD5gr5ZK7QDEwCJEACJEACJEACnhGgUPKsQmhOJgIQS2/J1TsbmUIz0DQCAxHBy/WxLiJLrhNleiRAAiRAAiRAAiRQFQEKpapIMx/3BIzZzSOWlBjpyisn7LK8Sls57WBwEiABEiABEiABEvCGAIWSN1VBQwoRyCOW2r4keLR8+WC+mS945tAX6VXKzIoBSYAESIAESIAEPCNAoeRZhZw2J9r75XuRBAZG78rV27OH4SkRUaYbr9MNadqVsla+w9A7epWmkec9EiABEiABEiABbwlQKHlbNTQsFwEjs8XSUIvSphOvXOxEIJTKmKcEM66JyEpOe1wG5+p7LmkyLRIgARIgARLoEAEKJd8rO8GBkuRU4TUR0bIrlzN4lnyv83rs2ysx2zs1DcHbFZG7InKzxLIxaRIgARIgARIggZYSoFBqacV2uFipYikIjCjVjVeB+n+jQJysUbD5LMRSlQeGYtrhmBj+V5dYq7LMzIsESIAESIAESMAhAQolhzCZlDcEksWSlsQpTq30xuWvCniUyhp+B2swBA4enioOCKN4XliuHN6lOocBVlF25kECJEACJEACJOCIAIWSI5BMxjsCCWKpS+MYC9XHrUKxskeCh+etEofhYfEICKS0oXYQSRBLEE08SIAESIAESIAESGAqAQqlqXh4s+EEJsTSaNE7I8q0/1Ww3noF4+WJBrHyztjDlCferLBWBNnhdmnhIaYwDI+r8aUR4nUSIAESIAESIIGQAIWS9w2hS16QUsoaEUscezejue+LSBViCWIFnh0IFsxfmuewXiR4qvIMq4PXCd4nxOdBAiRAAiRAAiRAAqcIUCidQsIL7SNgQrHUlS2UUM45jutzxM0bFUPg4F2CYMk7HA6iCPHejSzakDd/eJ8g2OYVa3nzZXgSIAESIAESIIEGEFhsgI00kQQcEDC7WgX3AjN0kJb3SfTnsNB6lWYNYZsji1NRkRdeWEwCezq9LSIoQ3RxCXh+II7ePx6258oThDThjVob53nKOF4gARIgARIgARLoJgEKJe/rXW2KMXhyzmNOAsNzD18P3vu7fSWmShEwp9X5ohuR/qFS6PTPc1wae3hciZGstiA/eJbyepeypp8WDvlCLG1WNPQwzQ5eJwESIAESIAES8IgAh955VBmJptx4qidKbXZnXetS5imN1wUXOby1CZY9MUba99IjkbSzGfXEJDarGRcRv8oheDPMqew2HkjwoURluJkRCZAACZAACfhNgELJ7/oZWReKJYOn3TwcEHhw6zc3A2V6gRhpy0uJ6f9MsLAm84skS3ino0PR4G0scwlzy5dnEiABEiABEiABzwlQKHleQcfm3fhQTxTF0jGPOd/cv/Vbm2KkFZ4lo03/4WBhbeBOJFm652PzhOz1tp/tvCWceZAACZAACZAACXSUAIVSkyqeYslpbd3/o9/aDLTpNXxfpf7Di4tliCSwxsIOmK/UxQMr4XFz2i7WPMtMAiRAAiRAAmMCFEpNawoQS0afF2MG7ZtjU/K8oYS6/vsvfHwzMLqpw/D65xbPlCWSLC3sq1TF3ko2P9/OWIWPBwmQAAmQAAmQQAcJUCg1sdJf/LU9MeFyxvNO2m9i6Z3b/NMvfAIrCzZtGF7/zOLZskWSZY35cV0TDPhuYfVAfsdsK+CZBEiABEiABDpGgEKpqRX+0of6I7FkBlwRL+tKeUeptW3FkjJaGvDqnznzXlUiyTLDfKV59mey6TThbEVSV8rbhDqhjSRAAiRAAiRQOQEKpcqRO8wwFEtqTYwMJKtW6HK4dJ0UVspP//i3N5Xnc5YCY/qLZw/WBjuXqvZ0dEU8dKWcDn+ImBQJkAAJkAAJtJMAhVLT6xViSbDBKD1Lsz1rsyv7f3/xdzaV8XSBB236wbkHdYgkC67tIqLt5bP1yDMJkAAJkAAJkEAGAhRKGSB5HyQUSwHnUziqqP/1xU+FS4f7tBqeGNMPDg7rFEmWblvFBFb4w3eIw+1sTfNMAiRAAiRAAh0nQKHUlgYQiqXheBheyavHmYamn6Ou/9eXPrWpZNjzZL5SPzg4Whv0Kh9ul0YMYunxFq2Gh4UqUB6KpLQa53USIAESIAES6CABCqU2VfpLH+2LGobD8JQY4WuSQd6qHnxpazOofxheXx5on0RSFCNWw8MLwqmpx3WubtfUqqPdJEACJEACJFAuAQqlcvlWn3oolgznLCWubjFjNYeE2vrJV7bGCzzUshpe3xwaX0WSpYU9lpo4ZM0Otdu2BeGZBEiABEiABEiABKIEKJSiNNry/qWP9o2SNSUyUCLC14jBYsH6/clXL20qoysdhidG9/WR8l0kWaIYsoaha/DONMG7BDthb9f2hrL1xTMJkAAJkAAJkEAGAhRKGSA1MshLH+3rI1kTbQaijfCFddGLHz/+6meqW+BBTF8PF5oikqJQ4Z3xee4SvF+PiQjsbIKgi7LlexIgARIgARIggYoJUChVDLzS7HY+2tcLak2JGXC+0nxCCfX24699ZlPp0hd46B8NF5sokmzTxpA2zFuCIIEw8eGwwwNhF+zjQQIkQAIkQAIkQAIzCVAozUTU8AAvfbQf6CPOWQrnLM1fl3/Tu1zmPkv9Q3O2ySIpCjgqmDDUrWqBAo/RzliwQSBxmF20dvieBEiABEiABEhgJgFMX+HRAQJntnZXjAruishSB4qbXESj1452Np10mH/hwn/cVUY2kjMqdLV/EByuDXrbbR4Sti4iT4rIqogsF6I0PRLEGOr3DRHZmx6Ud0mABEiABEiABEhgOgEKpel8WnU3FEui7qqOiiUjxplQQsP4Zx/7D7tGzPxiyUj/3OJwbb/dIin+XVoZC6b3j0UTxFPeA6II4ujtsUDiPkh5CTI8CZAACZAACZBAKgEKpVQ07bwBsSQinfQsGRGnQgkt5J999A92RebxLKn+2TOdE0lpXy54O9E+Zx0QRG32vM0qP++TAAmQAAmQAAlUQIBCqQLIvmUBsaSM6ZxYCpRau+9o6F20Tn/pI9u7qphY6i+ela55kqLo+J4ESIAESIAESIAEvCXAxRy8rZryDDvc2ewbpdaU0YPAaOnKSyT/hrNZauGH39rOvSltYDRFUha4DEMCJEACJEACJEACNRGgUKoJfN3ZQiwtBnrNGDNQxkgXXiXppLAq//w718OlwwM9lFkvpYf94L2AnqS6vwTMnwRIgARIgARIgASmEODQuylwunDrfZ/88ooOzN2gAws8KNFrf/efftvJqndpbWP5g5dnzFkyfTl8eG1/r9Wr26Xh4XUSIAESIAESIAESaAwBepQaU1XlGPrTP/54P9BqTYwZiDHS6lc5CCdS3X/1xmagTU8ZLQmvvhweUCRNEOMHEiABEiABEiABEvCTAIWSn/VSqVUQS2KG4ZylhM59Uoe/kdeqgvr92384HoanJdCjlzK6b44erO3v7XC1tqoqgvmQAAmQAAmQAAmQwBwEKJTmgNemqD/949/pY5+hYKj7tnPftvPiUTmLOSS1g++//vKmyFEvMENRZtjXwyOKpCRQvEYCJEACJEACJEACnhKgUPK0YuowC2IpODhcC4zpt3ElvKqZ/tnrO5vKmOtHxlAkVQ2f+ZEACZAACZAACZDAnAS4mMOcANsYfWnj5pI6o7DPUpbNPxuDwBhzafCnl3YaYzANJQESKE7g6p0V0YJNjNOPQAby/HlsYNzeIwsHlP7G+VIXumkvYJaMBEigzQQolNpcu3OUDWIpWAw3pW2RWDLXf/Knz2zPgaXNUcvgUkaaSXWwLMU2/E1KK3qtKvujefJ9HgKX76yK0isiwaMiBr9VaAt4FTkgmAYiqi+ifyAm6DdGPJzmAIFY9Ld7X0T2Jzg8JH3ZPs/5lUVaFeOQAAk0mgCFUqOrr1zjQ7G0MLwbmMJ/uOUamDt1c/1/fu2z7PwmczPJl+e6WtXvy6qIwAPq+qjK/ul2Z/UITE8Fd/flxnl0gpt7gIXodTHqCRFBvVdx9EUUvC1vyjm554VguHxnWZReF1FPVsrBmL4EwZui5V5j2tL2nSW57+A/zBfvI+q++MOA09+Xqsrlqh6iJWiSgMfDDJdH3norg38b/lMy1MlihjAM0lECg96lwdLGzbUF9aAVw/CUH93ejrYmFrswAWPuiCrsJYlka/ZE5HzkQjPeomMY6A0x6oIYsyxS+Rd5Zeyt2pIDEbnyel/EvCIm2KtULKCjc6A3RNSFkT01cFBqRYzZCKugLg55W+19fVOU2sgb7VR4A2+jPHLqetUXRt+Fa86yxSOyq3ceL30IKsSqCkepODNd7qs1EWnGkFHXZTdhuVH+bEcZ/JW5LiKtf/jMxRyyNbHOhoJYOjRn15Q2rVgNr7MVyYI3k8DoKWTRoWSxMqt1QWe7KQcE0uXbu6LMO2IUOoaOOMwNYEVE3QztunL7jly5sz53itMSsBwOzDthvsWH1E3Lpci9CIfX78rVO/OLkSJWzIqjlKv6WfK2jLMYzLpvDDZK50ECJJBAgB6lBCi8NElg5FnaXjt3tHhXKQdDGCaTr+6TKmN0WXXmM6cuEtAXnHpQHgg6jT2vSYaeE7kmYraclr2UQqMTbtblyuv7IuaWnAt6zobmgcMDvSXGXPOfg6yKMaty5XUIyFtyNthxxmGeeoN4M8bdwwGjMdTR7+9PMV4rcvX2tjz/VOu9A8XwMFaXCdCj1OXaz1H2QW978PDi0dqCHvYX9FCa+FrUOkeJGZQEaiaAjrK7p+GjwhhzseZSTc8e3pnQcwKR1KgDQwJvhrajwzmv5w6exAPz1tiT1iQQS6HNqEMXHOYt+UjYzJtKJH7DvLIRy2e+hdd2NP9pZlAGIIEuEaBQ6lJtz1nW/d724MwZs6Z0UzelpUdpzibA6FUSGHl/3D0NH9m+4m1n6MqdmyLmjsiMJb2rrIP8eVmh8FbhYVoQGKP5DL4MNcxPAXWIjjcE05Xb9YjeUKw6G3Z3wiCcJ3bysVXvFIfgtao+WRgnBCiUnGDsTiIQS4vvqTWlj/qBPpKmvbpTUyxp4wk4fxo+JqLEL68SOrRXXr87GmrX+FqzBVgWzPvAHKs8B8KP5mPlieVz2KXQ0xbWb8VmliZosJhGa4/V2oRta5GyYE0nQKHU9Bqswf79ve1BcHAmFEtKH0lTXqKPaqDFLEmgAIFwCEwJT8NDU4yrye0FChaLApF0EK6E5Xbp3Fg2tX1UwRuZ8w4XrnCwOlvmDKsMaLJzcGZWaYJmRcJl6p0Z6llCHILnWYXQnJoJUCjVXAFNzR5iSQ4P1gI97AfDoTTidUSh1NT21jm7wz1ySiv1srje06OoqSORVHRj1KK5VhXvnrxwHkuyzz5aLZJkX154amc2BIchRkKmvHZlpM1epSXhEDyHjZFJNZ0AhVLTa7BG+/f3dgZ6iAUejvoL+kh8fy3So1Rja2HW+QiokofHYTW9mo9wTlKDV9Gchc+ozVlBwvuYw+Nin59MmdUQKCsHl6aVLmQ88sq65HaS1mrpy96f5MV3JOA1AS4PXkb14GmWCYeTuJ6IXYa1c6W5j9jDw/1/vv//nH/fg7/DhnyJx3/d22nGpnCJ1vMiCVRIYPT7Ue5Efqymt33nUm1LOId7DzVuZbscjUDtZNqMdlTXN3Mk3LCgZk9ufKCG335T9p5Oy6GQyOoxbFitjcw1u7J9515tvxGNZEaj20iAQsl1rXZIJB2jWziz/EQvOVwAACAASURBVOe//H9dk3NqjT+qx1T4hgSKEdD6oihVLG72WEtS155Ko3lJLRYHMpBzgh3rZx9t3+jTBJdmQ3AcYiTCy39IOVpsJdvQSsdFrCi5JTnQWIzkfEX5MRsS8JIAh965rJYuiqQTfivhpOxwSdaTi3xHAiSQk4DrvZPSsjemnuF32ERVpFyPWVqZq7iuVDZPHTZDlRYPPVTmeiavmus6KWu1yLidGC7Z+v87te7NfMY4f34mgYoIUCi5At1tkWQpUixZEjyTQBEC4dPwyvYRWq18TyV0LE3Z86+KgHcWpy/Pn+9lSs2Ya5nCNTPQvpwNql3AAZzQvqqc7zXyyjazhrJajYUdWi8Is8JguC4SoFByUesUSVGKFEtRGnxPArkIVLzIQrmr650u+cibVP6wqNM5V3PFqGxDzUbepDZ71a7XMgy7auFiTMmLrlTTbGfksiwH0mZRP6P4vN11AhRK87YAiqQkghRLSVR4jQSmEQif2pa1d1JaxhV7d0xpe9ukFbDC61i44Hy2hQvqGvZYDY17mb1qru2pXrisVO6Vdc0sU3pmi0PwMoFioBYS4GIO81QqRdI0elYscYGHaZR4jwQsgQO9IVL6Ig42N3teDjfPfP58314o7Tz6vazCizIWK6ovSv/tcXmMemL8Hh4t13vsDCTrwgXhZsKmig12RxyM2ZdAfpDAAZfc22FUtoUsjg1y9GbE1XW9zjYuwPdWtmcHbHiI0d5KjzW8FDSfBHIToFDKjWwcgSIpCzmKpSyUGIYEQgI1eVuwyp5Itj1/5qopvV6iELwnom5l3uAV5UDHWoWC6QmRULgU72Qrc0te+EC4W8JMRIGsipkZqmiA4hyUXpGRmCwunozp1bMcuKBp1TMMbuQlbb9QwgIsV29vy/NPdaGsRb9/jNdCAhRKRSqVIikPNYqlPLQYtpsE6noaDtqjVfbKF0onHh23dazUZqGhXjfOQ9jgNVriGUMfMcdlNCwuj1jIt3CB1k+Usvx7KFKeyl+PqRz0kyK5hoIO5KEalgM/bk21bQK7HA5Lyzrs8tjeBr4x6ppcvbMnVXigG4iHJreTAOco5a1XiqS8xBDeiqX2TuIuQoVxSMASqOtp+Cj/JRktLmCtKetc3GOTapHaKSSSktLbPj8I03rhA2ti1GMiBgszzPYSKZVv4QKlSuCA+VEFRNJUDk+dl3PqkTGH2UMz4VUDwzqOy3cgbKsY1plSuooXYUmxopLLbd/7qxKIzKRJBCiU8tQWRVIeWvGwFEtxIvxMAscEansaPrKg7L1nRssLu39QYuTWMUKXb+BleeGpHXnhA4+JUWsCb03yUWThAvdCyQTlcIDwGXF4XJR6fAqH/XqHZNUsVKra+yy5DVZ9dSUcgld1rsyPBGoiQKGUFTxFUlZS08JRLE2jw3vdJDDaO6nGp+HArtZL3SvlvvPFE0ZtZTRsrNx2gyFV8NaEXiaFvYFOvCZ1LVwQL3EVw74w3Aoc4GXCZrJRDpJxWfS43S4+Q4TXL1Sq8sq6IDZ/GtgLLRwuPH9STIEEfCdAoZSlhiiSslDKGoZiKSsphusGgbK9OVkphqvuZQ3cwXChl+n8JTmnHguFAsRCXoGC/5KmH+EQxae25YUPPCKYHwZv2wvnR/O86ijbaO8k997KvGXx5Xuc1+5i4ZdktApesdiMRQINIkChNKuyKJJmESpyn2KpCDXGaR+B0dNwLC/swVHmqntHIuFSb1juzeGrDuFhhUKR1b/00ZLT8luWV15br6UBPX++52xuVNECeCNQ1HrHvCyrcuX2VtFqYzwSaAoBCqVpNUWRNI3OvPcoluYlyPjNJ/AAS2Y7FA7zpbUS7qnUJKpGX2uSuSXaeq3UoZMlGj5X0qPhX/58hxS+z1UcvvxmSI52V8bDEqTZlMN1neUtdxn889rQzPAUSmn1RpGURsbldYollzSZVvMIjPZg8cduU/Ok+Pwk1uXy63cb8yT/xgfHm+HmL+j0GGpF3hvelcuv5lnWfHqSTbhbmTDJDKOevZwym+c84JIc6F3nqTJBEvCIAIVSUmVQJCVRKesaxVJZZJmu3wTwNNyY0eajrh82Fk+vnCfiweJgPmfXlBF74Wax+h157vYdqWsIWp6WVrxupjsfw2XHg7sj4Xjbk+GcecAUCGvkYmntqlg9LZfuldVTvgvFbJ7ermanuZ75ezc7rXy2FGgytUVxXXakl/dwbQPaYgcOCqV4JVMkxYlU8ZliqQrKzMMzAtrHzuxy5k5PHppVbFCpsFmsuiPP3X5XLt/elcu3NxrjacrDcmZYA6/SbsghFI+3t1rJAf/Vte6dlFIRw8Z5ZVMKkuOyVrudHPqZAxGDNpfAYnNNL8FyiqQSoGZO0oqltdo2LcxsKgNmJLCdMdy8wR6dN4Ga4l+oKd/p2Rr1pIi4X8XMyECUlL862SgPiNANES1y+fa+GOlLIG+K0X0pbfjbdKwnd9U9Cb1gJ1dKeTfisC5G1kX0TXnuNpY1vydK3hbR9+rnMGeptfZ1mBvaHjYr7s6BtnZf3xSRze4UmiXtCgEKJVvTFEmWRJ1niqU66bvPmxPt05iO5pI43DvJaed7Q7bvXHL+wEKpfiUC4TTzZVGyPBIMAYSTiDF9ETUWDcE9qWI/pmO7zP7x2yrfWOEkEE7BtWMOYb3ImyJVc5iz8BCAas40jqM7/P6AM4aAvvCr7h82HNvr5ZsNufzqK40X4F6ipVF1EqBQAn2KpDrbYDxviqU4EX5uIYHAsTdJbYqYd5yBuh+u3tVzll6YkHlTRPxYbCCcz2M3wYXX6TWIl3si6k15KNhzLhInQYKDH8MuTziMvG/PvQav317IwWfhBCFiHHonlb4lRuHBhZuHFzpcar9rQklEAgzBe7zk78/kt4mfSKBkApyjRJFUchMrlLwVS+UP0ylkHiORwJwEjHG3pLExe6FHJPSSOJqta0wJw5o0hpx5NxN9ZFPYQd4QMbtyf/iuPPfaW3L51W25+r0SNogN/OUw8jqNOMjwnZDDc6/eLIfDHN8hLRectiV4f4zec5amMuvlzdnxbzWHCLdlee9oykgC19//OdpQ5VFdl73ISgo+2FA5+Lkz7LZQCkWSvitiytkE0NtOgesvSynprcjB8G55fzZzf3eYAAkUI4BFBkYd0mLx47GUemN0ybhbelrJivMFAEZzg+oZdhZnNuszyi/qmujgLbn82jviUixgmB/mTDXhAAeltkrhULT84SbNGD7o6DDj+XhKxt8jR+keeLlYi6PCTUkG7aVry9RPwcFbzSfQXaF0LJIcuu+b3x48K4GiWPKsRmiOAwLGYLEEhwc8FCLiuqMnRyUMDzOvOCx4VUktH4uF0NPkYOltpW5VZbzDfE44QDw+e3tLtu5U7/V3LUDsgwYIeSw44urQxvHwWleGVZCOUVjYgQcJtIJAN4USRNJQ3w3HOJfiDPF0dEkjyzreSBFPEXmQQNMJYO8kTKZ3913sHy9EYDt6ztIO51m4JX5/cSfsjDqzseLfWpEVMWZXnnvt3XBoXlGhcOOpnhiBZykyaqlR75dFmZtybvjOXByKtC4IEJfc7gfRuUR7ztJGWxl934uUcnocl+UvI62w7K+eXvXUdV7TKfl113XZkV7ew7UNefNvaPjuCSX8cEEkuRz60tDKb4zZmHCMXecplhpTZTQ0hYA+cjc3CT06ZeLDhdzNsxCz7HwIzc75gRhzvanqIGL3khi5JueO3pHL3yvmeTNYQtp1z6Xy9CIcEjrGKV+Dwpc/izljBi9XqrIvaJP2UPpNh2mLmKMS5vrBWGflLy8tfD/C+rJwy7A7mrbv78uos7xldm1D3vybGb5bQgkdbTO8Q5HUwMZKsdTASqPJpwgoTEJ3eAxN9Gm4SNjRc5i+KcGr9OIHd0YrzDm0s76klsSoXXnu1bty+dv5Vkx7EctHK8crC9YGYiSYnnv1rdOdY4c2BY7bo5HJoaD3z0x+n+Y2XbmbSzW3LakJnAjF1CAFbwQcgleQHKN5RKA7QgkiCV6J0XKoHlUBTclMgGIpMyoG9JDA6Omqw1XU1L689KHJRQGcd/TMeinzUA4Wz4uoZizskK0prYpZfCu3d+lgARuTTtZhtvx8DbUigXpLnn11qxwDHQsPE1sAZeRdcrcoCryyz77mu1hC+8PDizKO1fLaQhnmMk0SOE2gG0LpWCRhJSPXrkemVylTrMLEYXinv8m84j8BhbkVBpudunkJltuOHejoaXPPWR7GLMmZQ/cdvdBOfV6MwVA8NzzqT2dJtOzKs9/NPpEdHA4W18INcOu33109iLkpz31vN9Y65/v47HfXxehlh+3l9IMGWGjkDYd5wMvrdvEWrd3VE9qcNiIHi9fFmH2n5bbtWcy1Y2+rvebqPF+Lqja2qzLbdFBveQ8b19UZbbEDRzeE0v3hTQmXe+1AjXahiKjLg6EfG1d2gTfL6IiAKjaXJS13c2p+0iikXcUrLV7e60rcdvRs/vCGGVkTkTZ5lrD84FYukQCx9OAMOLTJswTBsZGLg20XaWelHLfD2LBVm2/cy2SvFz0bKccrW9SepHhogwE2rS7lWJLhglvRXIqZTJQEkgl0RCgtXAr3raDzp1LnT2nOO1Gbgg0CeZBAUwjgabjb/doG8uKvJX8HgiOXCzrgEfv68RNh17whlh6ceVyMnPaOuc6ryvQgEp79TvbhZydiKblOq7TdZV4hhxwetrS8sbqgMdgI1+HiA/JmYnbhcFaz7zCvEryyTjmMMGDVTKV7Dst9UlfKrIoZut0kOGwLR4lV6OdFl3WGtPIeYFW3DXlt9iN8N4RSOLxhYU3E9N03FNcNj+lNrSOlNwVL6/IggSYRMI4XcZApwuLG0/DQuPXSHDmeGxKtO/w+v/ShNRGNVeAGU7//zv/oy/y9VTdzLWwADi9+6LyIwatFHGRLwgcF0UrP+d798M/0Bw0j01wLVreLuOTElzn4wTnMmStncQfj2KOeuVAMSALzEeiGUAKjUCwttm94w3z136zYymzKjQ9RJDWr1mhtuNeOWXc7/l/HlwWPcTZ7TvNTUtIyxxGzX/zwjjw4+5gYgz2G2qGXROcfcgRPITiIXG/0nlMTdWh251sURLud3zd7eN2bTr8/olfdeWUdz1GSyDwT9JNENp2W3dV8mKR0GuVQcjwXM1pvkZ/R1LehQ6lmG1KN8/tGd4QS6sGKJWP6jfkhSPpx6OI1iiS/f0loXTqBM/fdL4Zw+ND0J946Zf5SupWz7izn8o7MSi3tPn6jX/rwpizox0Rp7LfUcM+KrMhnv51/bho4vPhr23J41nJwORSsBhUqS3L2fvahiNH2MVp23fGc1Bnfj9GwVreeFS3520GUQ1XvR2Wf/vtSlS3MhwQ8INAtoQTg+ANq48RZDxpTaSYYoSepNLhMuHQCRl10+2BGJjfJTCrA556+N/JGuHyCqKsbPoThgy8+vS0vffgRUeq8BKYnSgaiwk12sdFuc15ariVVUaZroWAKOcDTttZsDuqibO0uZSp3NNCRbLj9/hiRw/tZhIDL1SNFho6G38IB5PphaZQ33h++t+n+98Plb9E4rbjdPn92XWdIL+/h2oaIMzKvKU0K3z2hhNo5Fkucs+T9+BaIpJc43K5JPyq0NUIgfBpuHO6dhLT15CaZkewm3qop85gmAmb+UM8TcTzh/sOnN+XFDz8iQ3NehtITrQbhyBP8Ufv+UrIsz3xrfq8ixG+Ug1Y7MpR978tv6weLmZx5KD+HMub37Wxm8BbN8Dpl/tqMA6IdfPabjn8L8hqRMTz4KIP5SjxIoPMEuimUUO2hWDrbvv0rXD8xqDU9TZHU+Z+oZgMIHpiLyhhx+RIV2yQzDdFw+IbLfJXRS046/Gn2Zrn+8kf25OWnN+Vz8DTpx0XMJaXMnhIzUGLE11cgjpe2BofPffiSvPz0Y7Iojx1zMGbfVwZju/It8f2Zb68qMcsu27FIRgF0eH/PZb5IK9DB3HP9AtFOf09gV+Lx0tM9Zcw91wxcppdot6cXXZbbppW3qDaeqzPaYheOxS4UMrWMEEtbd9Zk8eCuiOunvqm58kYWAgqepKe5cEMWVv6GURWZhvkLdyvKK1c2Rpl1cUnByL689NFs++3oB3uyeDb/YgJTSqiUXDAiWYYtTUnF0a0Rh74R2QlT3Pr2sgR6NRD1fqMEbcKbp/cGk/nLOkarHO5McFgwK4GRJ8xo/8Dy8s5bJuwplOMIjL5gXH5/kPdikK39wqvymW/iu+asHRkstY/FEuY9MPTU2ZEO2JxRm+pIvyUi+YdMOrNvWkLDaTf9uue0zlC09HpLLviRiOqubySZSbar3RZKYBSKpd01WTx3Vzn8QcyGn6GSCBilKJKSwPBaowgsPPP1dWPMcriCmzvLl+TSNzKLQlVk9/bptq4bzDPJNHRpekLO7+6Ey6L3jp9xws7FxZVAglUj6onxw7C6OnzL4fycKriNOOzrqKD9zNdXQw5K3i9aVgTDwOo6PvP1Vfncx7Ltm2XMuvP+5cFwVy59I1PplTau28tS8Hvf3Bh+/qPFHwJqLSp3Jzm9uCbNo4QoN57eV7/3jesicjM9hfruLAQiTVn4zvVv8dR6S6gSdPa18/8Dl4I9wWhPLlEooSLw57UFsXQWHRBnT488qeNGmWG0bMrnP1L8T6RRpaWxbSZgXA+3GsFaUiNvSW3ogsUzG9p6cWqzIkPGI1FyT0f3nNraXVpYWFw1BsIp9G5UJhgWFhdXjqK2ZCiCsyCf+9gpDouLiytaqycF7clU978XKFnK4gdY+L3/vGFK8GTU/f3RSmP4YWP+4/Tnf31HXfrGk3Vzc/ZdYEIkkJMAhZIFtrM5MFu7a8HCmbtV/mnY7HmGI1ltzvWkjRBJwBcCW7tLyuj1/MMjfClAuh1mNLl+NNwtPZifd3Y2B8ORpwXDry7J1jdXggVzUcSsqxI65VEIxng0fGlnczAWbSPPzta3l4Pg8KIotVE2BzUaDphl+NuTmNfUtkMZWR9u7S7LzmahTaExLwSz8VwdSGmWcDXmcDNQC++4ytNdOu44uLMpOSXXbTlLvcUtKcOGYw9+PLMWfeaAxWhl7mwO9PBwTZTpjyeeejs5uG32odNCkRRtjHzfZAJngoV1pWUJwy3a9gqGZuUhdPTacOx8tK9f/vVNPTwab3RbwhLG4wVxlNH+jlbYeXpff/5fXQIHZbDRbXkcRM/uWqF9KS3rbfvu2PLg96Hw10eLKJevLFp0Z3NfaXPdab4OytCYcXeYUeT6v2DakMmkxoUpSo5tyPJdTjKladcolOI1FoqlozVjdF8ZrC7DV9kMRA97cO/Hq4KfSaCpBIzRFxq110/OfYmORM29epdXdQtP0+f/1Wa4Z5OWQRkdwkYsEAVP0+c/th3o4eNSEgejzaOz6n4YyHqbvz/h78MsCGn30WvL+X2dHj4to8nrRzsXtvEQeXpaFe9v1iil5JrNZP3M/gSl5NiGjiiIjhRzdhOaCAGxZHS4dLirZRSZTvISycaY3nBnY/5VgCYqkB9IoD4C4dNwI6ut/s6PVu+qD3JJOQ9f/tieiNp03qFAB6VB/7aHO5v9QIYYXeG8c6VUMNsbqcX5svp+fR9l5czWbiEPY4DFHJw+wJ018O7ky6aM3nSb93xlObHM/3fu299sz2ycimsb0Ba7cDTop7vi6gjHcJs1MbovRgtfZTCgSKq4VTO7CggY0es+dSbKscUsn93aLT58KKEefBnON9z52J4qYURB1k6FLxwglsRosKi0Yw4BoQz2TnKdr1/pSeGNdFGO5AePRa6HwywTvo9Jl9AmlOjrRfIpI06TJtm7bs9hnzSpklKugZVzGxrhJk8BkuNyk9pZjmI5CrqzOTjc2l07p4dcOtwR0uNklPTu3/otepKOgfBNWwgYLVgcoC3FmVIOg9W7skzKn5LGyS1tzN2zF78mRpnrhzu/We+qYAYb2Do+4J3JcAyN2T178WsrosytBxLs1LkUeyD6bTHKqSDWYgZTMWDYajZUU5Px/aYSsxEuKJLX0PAhvkNAOTeqerDzm9tnf/erF0RqXGLeMlPZvWE2Sm3nvHOKZhmas97ChdSNY9+Iw2Y4q7h13ndMrc6ilJT3zubg4WBhTWnOWXL1NCIwmiKppObKZOsl8L6tL68ExiwHxkjrX9psLGGvIgfH2d/96raEe04ZTOLfPfu7X33nzKe/io5kPQc6o64XNMgwSgVlVsasijFLouXaWa3fCdk44pwbppFHXXMIjLw9zY5Am43Wf3dGvw9LP/OpP80tQrHqnUs+CwW8AkGgN13aUDStJk1RKlrGtHi56+1InLab0K4CbWfad9/Xe/QoZaiZwc7mYGlrd+3w8ID7LGXgNSNI76df+AQ9STMg8XYzCZhDuaiCjjxmE5H7w0N09Oby/mComRkOL6pJF86yKNkNPv2nN5UytyQ46t3f+e1CyynnbUkQf+8NhyuT5uRNJSG8UVPtH+d7M5YvhOi1c8PhRfn0V3pq4ehWVRxQgkCbVYcrUY+hpH8/fuZTX1o34nyT14TK8OSSye+VxdNtU7PL7f7Ov7738Ke/ggWYtuokmd6S6rQqOW/XS3Mn5zL9qmsbYr9V0zNv8F0KpYyVNxJLN9eODs5yGF5GZvFg2gS9n37xtymS4mD4uTUEFPbjcT3Ewmc6RmEIzlxCSQ0PbypRS0l9v3BPHyPXZLh47eFPf3nPiLxx/48+Pld+s3A+0EdbAfZUctwLM8ZMFUoHw6NrafmO9zbakuHi1sOf/so9I+aVhxbO7OF/aVZ5it5/+NNf2RIxy845SDqHQMsFE2RwvRUtlG/xlMAreylPPWKum9ufmGLd3XMLi9cPDx/gQcnsxTlK4q6wPGVDjgBz3Z0e+eptUY7EOB56l3E0sdNS15EYhVIO6oOdS4OlrZtr+r3FuzLaNC9H7K4HVRRJXW8CLS//z33yTzaM0c472J5jW136xJ8sD75YzNvzs5/6k9WhMesZ53RhU9j1hz/1pZvKmD1lgjfPnHUrFt73O1/a0lpfK4X5ok4VSu/75JdXtNFZn86vKpHVg6MHuw9/6kt7gVZvDPXw3v2CdZBU1vd9+ssb2uibSffmv5bMYWnr5tLRA439xzp1DB/cz+eVxap3LgkVfCAAcfezn/qTTdGCkTb1HE5BlFsE5XqFuAL15tyGcpF5kzqFUs6qCMXSxs01dUZxGF5GdiaQ3uBLW/QkZeTFYA0lYMyTseFjDS1IPrN1EE5K384XaxTaGLUb5HdZYDjahii9cXh4sPu+3/liX0TuiTFvq0D2/+4//fa9PLagg3744KF1UfCOmdWSRk4Ofjpt6KDSNwvmi/2G1hcWlIw59MWYN+fmoPVqWROYf/qF5PoZPji77npoUJ52UFdYZbD4S3avLOYoGbdSqXDR8V372U/+8R4eYBROZI6IvnDIUgQf2rZrG1ynl4VjHWEolApQH/QuDZY2bq4FC1gNTxXaC6FAto2MYkR6737lGYqkRtYejc5KAJ3t4X2znr/PnzUHf8MZMRh+l1so/ewnvzBawGH+ouE3ePQ7rEV+9pN/glkcAzECAWUPbJT5t6MP6v1iJFyEwihZPnqglsMH027HM9l8x2eVKt5+7pNf2DBYwGH+w3LYwBzrEYdwUYpo3sccjASPYhluZFshh2idTJRYDc3F3At5TaTQzA9GZCWXVzb0KLlzpRRwTEyAXjx7sDl878yqUqPv1MTNkj8s6HmtL9nAaPLObc3ZBo6OMOswahHfZyRAoZQRVDyYFUuL6pBzluJwxp+1kd5Pes9SJKXw4eUWEfj7hY2FJi1V6xb98tK/vrky+Mql1E5wPDt0DIdDfVHKm48CIRQVH6snIvakczUaY3/yOW6ns89K3khKKxTY78lNVR4HZJvIQUVWrKqKgxLzSiKHT9xcFqNXTuooKVSbrw3hVbqUpYTwKEHZ+nJglM3PffyPNgMxdyq3qUEu/AVT71LmYWfftQ0dmaREoTTHN9uKpXMGq+FpepYiLI2o3o9fuUKRFGHCt+0loAR7v/jTeamatAoUOnqZv+9Dc7QbPoGuQKNUzeJUfkYGwcNHiftN6fcWrinVnXltgSwmcgi0ulj3Sm6n6q3SC5inl1EoQSe5VJQOfrf+95c/vbf08f97D4vZVInNNOjhlPNFfnLX25EoLuZQqHlSKBXCdhIJYml5Y3vtwdHCXRFDsQQ0Rnp/+c3fz9xpOqHJdyTQPALwpijd+Qcl6CBl+s4vfeIm9gmKeHiaV+c5Ld7DU/d4HLSbcHnlUof8xXOt9fPe4Espi34M9XqDnANlQFz+R791c/V//uml6DDJ5Hz0kSiHc5ScPat4MNxUi+EQ0nBYa7Lxbq8u6OY8nFLarUcpb70tHolocWtDxkV43FZ6DalRKDmAvt/bDsXS0YHp/DA8DLf74XeuZ+owOUDPJEigdgKLRl8w3enspvFe+oe/8fLGj7/2zMylu9VQ7eIvuyPHwCyY60llVaJuiuuVsJIy8uSaWTC3kkz5h7/5uXUR7XwZ8qS8fL5mRDDXb6ZQChdzyO1NSC+5K6mBh8b/4Ddevq6UKWm1xIQyNGjol3K8PHj+eoNHKX+sBOrHl1SD+B8bXeANhVIBaElRQrG0vr1mzj7o7Gp4Rknvh999niIpqYHwWnsJDIcbzp+GK+mLUpnmLBQCq8P5BK6f/D45a/Wuf/BbL2+L0bXtu1KI1VyRzK13v/jMqWXBIQ6M0dG5Q3Pl4n9ktfPuF1O8JUP9pCpjjnmg1krjMjTXRE3M/Zo/KyPrSxs3L0FwTE0Mizk47vBOzS/HzZ987Zmdf7T5In4HqmnbnnJIQuZaKBUZfenehrx+rSQy/l+jUHJYR/t724Pl9a21YOFMF8VS7/u3X6JIctiemJT/BH5h4w/XpYS9k4yYW3/TuzLz6XJRQr+wcQNzpyn+AwAAIABJREFURTaKxk+Jt/6LGy8s/6h35ZQwQPiljZtLgR5elI48hdQi/Z989TOnVgMEBzHDm+Gk/BSQbbpsRPaHw4VEr9rSxvbSgtHrJTgY9/76a5dL+/78440XlpVRrsXA0hmZvacSNpwVH4fejRvtohlualFv4StfdjsusLVA2Salpj+qt9TbuW/klSiLR0fieAeucJ5FbsMbGIFCyXGl7e/thGJpUWR3vJu64xz8S+7v37ckP3z0//yBXL19qlNQm7U6SPqT3Jcb5xM7cbXZyYybTcDoJ51P0hWRB8GDxEnvrmAFYl4xOtz/yFWSYTrGhPup7CQlekYOb4bLcuf9h09KzPNrRmRw1gzPJ5l5NniwZYzqxFAzcAiMnP9x7zOJXpKHhmfWTQmLWRgtiavrJdVHkWt/07vS+yf/6nkMMXMqBpQJh99NHb6KDrfL/YNcP7fAg5J/8rHnr4uS8ofgBW6HkhVpC1njuN7stUi9ObehiFsrKzCPwlEolVAZEEsikvgnWUJ29SZ59c6KGHNXTEWu9qylVebaqaAqnCvgj5g7ZSAvNInA8sb20sHwyLVXBhO1e4PedmLH0hWfH/Wu3PunH/sP+yKjfXRcpSujjt4pofSLGy+satEbHflfHYgEa0meNXjc9NBc7MrYfhFz6W96V1KXjVdGXyihqzv4q2/8u1IfNOD7smD0nhHnDxtWf3Fje/lHve3UB3p1eyay/Fb8f1+/uvNPf/3fP6lKHoJX7qr6WUqaPUzgemnu7FmPQh4diWtd6XzIed4yVRSeQqki0K3M5uqdDTHhxE2nT9VayYqFah2BwweyHij3ixIYZRL33HENcMEMXzFGTj9QmC+jlV/6yPbKD7+1PdE5NkODZbDnS7kZsQfKyKUfff3yRPmt6droawqb3XbAq6aMbP7o6/8m1Tuy/OHt5UPM03LOwqTmaevBxVkNj24ppZw/KBGd7pWF3aPFHFyUYJSGyxX0olYFenhJVDgEL3rZ7fsibhW3FmROzbXAzTv8clGGYhyvEkihlLn6GbCTBEYiabeTZWehSWD0RPmi68XutMj+X377D0p/Go4KXDwyvaHSroUS5k9g9a4JoRDIUV9p53M6vGqH4TCzxWDth71/M1H2qJELR+bttnuTwMEoc+lHX//9qYJFB3qjDI+AVkGpw+5sfeJhwC89/fv7gYjrxUmwJ9kpr6zNN9BDcfu741yphqaCz//xkd+/rtw/jLEoxDjeF+g44RLeoN7cHjnr7UgkcLzvVFeEUhlrzbhtC0zNPwIUSf7VCS2qlMDyhy8vix6uYG8Ml68FPaxEJAHW/ne290UP77m0f5TW6eGIf/X137+kj4aPBaKvK6MHWH2pZa++ORo+Pk0kgflfffPf7rSdQ6CHa7NEUvhlHQ4vuG97w37cm1nmD8OCHt4qoQzLyx+8mronIzwT6HS7e5Xn6f2Lb/3BttLDvjtbJ8u9KEdlVq/TtF23k7xbC4BV3TY4BVphYhx6VyHsVmRFkdSKamQh5iSgZaOUMecLkrjXzJzWpkZf0EM8fXe+etfyh66s73/vhQnR9yMIM5Ht5Y3tneEDwfLYF5VIaocw1WiPbsB7Iiq49Rff2s4899FyAIt//pHtDWOGF5Q039tmVHB98azsYKuMWVUUCgE9dO2JETGqEm+SLV+ghnsyLGXRAniVkleRxYazOZ0J1t46zoE2myIaq+C5PxrFwbVHKSfOEuYoOVx8MWdhqg1OoVQt72bnRpHU7Pqj9c4IBMPhhbxjxDNk3v/+qy+mTuLOED9/kMP7e8HCWeerd4kYDL+bEErWuHFHGsOyessfubqitbooo9XymjXXUUlvQc5c3/92+sR7W+a0859/a3vE4cPby9oML4rodXE/lCstezfXlfSCnBwCfXixhO+P6DNBYptzU9DTqex/58b+v3jqWeSJenN4GKSXKJTCuS4Ox96VrTX2X32+/y9+9dnrYhIWWJqTWNAgxeh6jpLJObkPnX3teoPrElZimbNJlBKdQqkUrC1MlCKphZU6UaTEfU4mQvj7AeKiMvv/5frWqpTwNFyZar1JqE6s0PnLH/i9PWXc76m0vL61NF4BNLXl7H/recznQYdwE14orcyTyqh1X7dWgAdJibolge6hk5xasJw3wmGQIthg+FJTOBhl9gIl14twCIbDdedPo5Xsff87n3dWJ1mrcGF49IZRroWSLP3y+jPrf7b38inhFxy5Hm5WtlQS0UcPdhYkwAqHjr2IzZk9Euia6y30KDkeZkmhlPVnguFaT4AiqfVVjGFADS4kOkeV2R/+2eth0j5dcyE8VOpUp2iuBDNGVlq/oozjZcJF5CGlMKwuM6fxUD0w2Fz+1curgegnzWjbgbqH50Ec7Wkxb/zg9oul19EEhw9+diUwC+vGDJ8QD4bnKZE9HQRvqMP7ez8YbYORsZWdBPuV9a0VMcN+zgfiJwmkvFOq2mF31oz/tvf53q88eREeVKdHMPr+JLQ3fc+lPMCGwE4NT0gMD0x+ZX3rvHLseQtEl257QnEKXVKu/zPM5II5s4xScjQQbTL/Hs9KL7yvVGP4ZypPSqCO6MGU0vPybAJtEknYR+n5pyrrUM+GyxAkQAKzCMAztbCwsKqMWjHGPCEiK2V6nMKOo5K+EvW2BHLvv7/2Obedi1kFnnL/X/7qZ1ZFy2pFHDDXqK+UetM3DlMQ8RYJkAAJOCVAoeQUZ8sSa5NIQtVQKLWsgbI4XSUA8bQYLgQRrAQiS9ro90fEEzxQ0+Y7YbjfaMEBI30VBH8LcWRE7x+J9GcNF/SJueWgJFiGp9MY/WhkjhOGOU0b6oSnwfaJ8L5SwQ+aysGnOqEtJEAC7SJAodSu+nRXmqu3N8RIu/ZJUlK9R+nynWW5cd52RtzVD1MiARIgARIgARIgARIolYDLoa6lGsrEKyTQRpFUIb7jrC7f3hVl3pKrd+qeY3FsEt+QAAmQAAmQAAmQAAlkI0ChlI1Td0Jdvr0hWnbDibZYDKdNL8cLvkxtFKFIUhvhECBj7lIsTaXFmyRAAiRAAiRAAiTgHQEKJe+qpEaDIJKkZcPt6sB5IpJs7ktCsWRZ8EwCJEACJEACJEACjSBAodSIaqrASIokN5BPiySbLsWSJcEzCZAACZAACZAACTSAAIVSAyqpdBMpktwgThdJNn2KJUuCZxIgARIgARIgARLwnACFkucVVLp5oUgyu+2ajJQ2sarESUqzRZKtSoolS4JnEiABEiABEiABEvCYAIWSx5VTumnHIqn0nNqdQXaRZDlALGE1PMwJ40ECJEACJEACJEACJOAhAQolDyulEpMoktxgzi+STvI1Zpdi6QQH35EACZAACZAACZCATwQolHyqjapsgUhCJz1thFpbr4vcc4p4HpFkDaFYsiR4JgESIAESIAESIAGvCFAoeVUdFRhz+dVtMbojc5Liis8hXxciyZpDsWRJ8EwCJEACJEACJEAC3hCgUPKmKiow5LnX4EW6VkFO7c7CpUiypCiWLAmeSYAESIAESIAESMALAhRKXlRDBUZAJInh4gHzoi5DJFmbKJYsCZ5JgARIgARIgARIoHYCFEq1V0EFBjz3vV0RvdGNJcDjw+2in+dkHYokKZcjhkVevU1BO2dVMToJkAAJkAAJkAAJzEuAQmlegr7Hh0gystG5hRui+si+n6eujkXSPIlkjGuEYikjKgYjARIgARIgARIggbIILJaVMNP1gIAVSR6Y0mgTqhRJFhTE0uXbIjee6tlLFZ6XRGTFcX77IoKXq2NZRPByefRFZOAyQaZFAiRAAiRAAiTQXAIUSs2tu+mWP/edXTGckzQJaTj5McsniCQZe+SyhHcbpi6xBJF0121R5LqIbDtME8MTXS9Msiaul5B3WGAmRQIkQAIkQAIkUC0BDr2rlnc1uX0WIklxnsu8tK1Imjed+eJDLLEu52PI2CRAAiRAAiRAAiSQmwCFUm5knkeASBLFOUl2XlL0fJSj7vwQSdZgiiVLgmcSIAESIAESIAESqIgAhVJFoCvJJhRJJa/K1uhVITLWgl8iyRpNsWRJ8EwCJEACJEACJEACFRCgUKoAciVZHIukSnJrbyZ+iiTLm2LJkuCZBEiABEiABEiABEomQKFUMuBKkn/m26OFG4wR4SudwazKuIxNeeGR8/qgWPK6enIZh0UzVsevXBEZmARIgARIgARIoHwCFErlMy43B4gk5X3nvlwGLlI/FknRSU3evqdYclHn9aQBcQRB/q6IvDVeXRArDKKx3WmAUK+HGnMlARIgARIggRoIUCjVAN1VlsEz395VymwoMcLXbAap3I9FUmoID28YiiUPa2WGSTfH4gheS+xVFT/WxyIKwinpfjw8P5MACZAACZAACZRIgPsolQi3zKSDZ765a5T2fZhYmQgKpJ2wj1IjRZIteiiW6tqU1hrBczYCeYZ12uF4e+Ok8TnrcW8ssqIbBmMTXWyma4/4Zr24n0eY2fSybEyctNEwbMua36xNgJPKEi1rko1gFD8gUp+MbGIMu98UkWkbPiNtxHsiEg/pIh5ssPWHa0l2RG2wTKPXkuLA9niZo3GS3kcZxuNG70XjxusoLZyNk2Yr7sfTsnGSzsgHR7T9ji9NnGbZMxE4wYZ4u5xmfzSteLhZdtj2ES0P4rw9bh+o9/iB//X3xxgktalovLhd8fLZsPG6iIeL359Vvni+yCepjSa1b2tTFeesv6HWzvj3ZJqNSQxtvdt4CIM6BBu859EgAhRKDaosaypEEobbKXuB50wEFkRkYoXw517bFdP0YYsUS5kqv95AWzmG1OGPejPWyc6z+S9+FtDZicd5PCKW0BGLbtaLP++sHQmQRHhszpuUTxLpHZFww2HbKYRnLWt+szYBTioL4tgjycboTyfuY8gjOkbxw6Z9KVYfCDctni0bOkSoS/BKsiOeH8Kfj9RTUhzYbu2Kx0/7HGUI9ujE2QNlQ/3Ej3gdRdOIh8XnNFtxL55WUnx7zdZdvP3a+9Ez7Ib9WY64DfENsKfZH00f6YC/PdJsgIBAGZBu/LDtA2nBDssfYdPaoo2D7xDKHBfwqFM8jLEHBA6+8/EjziEeLn6/aL3H26j9zYjbU9XnLO0Jtlg74/ZPs9O2JdQ56iD6/YrGs+0GdYffBR4NIcChdw2pKGtm8HvfGC3coI0IX/kYWIg4QyRN/uFF7zbrveEwPI8rDH+eUVFiTUWHBx0k/GHijxadZFxDxyTqibDh5z1HO1HzppU3PoRinfmn2YsODeaJJYkkGwf34nPHcA0dr2nxEH/WfZuHPSM87LGdYnvd1RltMd6Ju+gq8RrSQbtCx77KI87Pdn7jNqSJpGg41AdeOHBOE0njIMfhop/te3hDowdEV5b2h3DgyGN+Avidj7ePpFSz1EtSPF6riQCFUk3gi2QbiqS2dO6LAHAVJxRJZmM0f97bBRvG8/sz2mf0rlz+XtqftityTCc/AdSJ7QzZ2FYQ2SfD2yLy2PgJMJ7wlnGgQ4R86jrQgYANvhzorOQRbwhr7U+q06Ry4ek0XnmPPHblSTupEwcOtlx50vIlLDr5VXU8k+od3+0416xtHQ9HrDcJaWcpB9pT3JuEeHEbUD9ZRTA6+Fny9qXOfbQD7SCr4KQ3yccanGITh95NgePTrQV4khQ69zzmInAskuZKxc/IRkEsidz4UPyP1E97u2FV/EkvSh0dXhWlgI5TlsMOT8oSNhoGHae0tgGboh3muBcMXi97TBNzdlgbvCLx4S64lhQXgjHpOvJLu25tKXpG+eICFp3QW2PPHljFO5/wXoA95iRFj+hQGnQ48TuN+LM6RLYewT3qGUEa07xKcY/jhVhHF+XAfAh7WIZpHecsttq0XJxtuZPSgq3RdmjD2HaV5EUCr6zfHZtekXPSdxnp4Hq0TuL2wzY8CMFhhRXaH75TeGhir4/fhiekh+8kDpQPbRH1FP0ejm+faqfR61mGJsImiPNp9WLTbMs5iSPKltaO8B1/JaXwiBOvcwR9JFK/+E3A9xTtOy2PlOR5uW4CFEp118Cs/Ld2lxaChV0RvR4uIDwrPO+nEjhaOHdTxCT9oKXGadwNiiXfqgydnOiBP8kiXoZoGmnvbacr7b7tEEU70TYsOmbRzl5cKOX1RtnOuU0f51n2RcPa93njoIxRkZH2fY8/dIp2TJE36ghljnJAuvH6RFikhet2sjbiZeFl2wHOUaFky552Btso36TFJOL5w740FuiEzxJ1aba4vI66nlXf6LDmYZVm36MZ24mNbwWO/Rw9o/4hSNJsB3sMqUQ9o42graU9sLDpok4Q541xPHierPfJhrFndMCTDuSLNmvbWVIYew3h4g8G7L02nuPfj3nKmFbvqD/UNRbuQB3MqvN5bGDcEglQKJUI10XSgSzebX3n3gWoLGmoIK2jkCV2c8IYhT9O/ij7UWPorEQPF08T454amz7+jGc9FUaHCJ2+sg7bAUnqvKV12KZ1fK0nIau9+I6n8bFpgEH8SHryjo5pVCghDuoTndd4GviMF8Kj44QOEp5aT6tvywornJV9xIVhND8rAmBzFUda/Uxrv5ZVvF2BdVQ0ZrUfPKYxiaczKyxEhv3NBcd4u0G7xMsOz0IYeC/tdyKpndg4Ni2kH29TNkzcXvsZvGwe9lraGV6lJDvSwldx3X6v0vKy7SLtftp1jGlPOvD7mcRrWntBnKQ2iN8KW9/IC2FQf1V9z5LKx2sFCHCOUgFoVUYJlF5RxghfczMYtGpOUuhenDZ/qcpWyrymEIj/gaJjU/dRpg3o1OEVF4gQHb51wqL1kGQbOuFJnSZ0WOP1Gk0LwgMdKzxRnsbasoo/yU/LN5pH3vdxgWE79Tad+H173ZezZRVvV3aoZNl2xvnEO7vR+2gbcb5x+1DnEIxWgM1qU4hv21RUpEfzRZi4Xcgn64MRhJvWXuNlqOKzffhg6z9+rsKGLHngOzvLKwu2WLBj2oOhLHkxTMUEKJQqBp4/u2mdYd7LKH76R0Y/NlNbtAWnzt/KGKM0AvEOODoj0aeM0YxxL2unJhpv1vu4DbPCu76PTkSSx8Z1PvOkl8Y9qeOI8uApMp4O433agTTRsct7zOpw5U0PZYgKDNgM26NHng51NF6d71GOoh6FPHaDXbQdIN94HaFDH2WM+3jN+u5FO822TU2LgzYVXezDCi1bHtRrVMQjfFyI27A4Jz0IiN7n++wEIHbT5p9GU8Hvf7Q9Re/xvYcEOPTOw0qJmgRPEo+5CPQP0anZ2RzIs9+bKyFGJoECBDBMK95RQecIna3oU2f8caIDhM5W2lAOmz3uJx1IM+lAxwsTkYt02pPSy3sNnTV0aNM6tRBR0c5d3vSj4W1Z7TXMRYl3JpM6h2ATF3Po0MD26GE7sbaTjjKh7tBRxhC6uOCI1300rfh7pI3OdZJ98bB5PscXcUCZ3klIALZG22RCECeX8rbftExRDtRtEZvBODpXL6md2HyT+L1rb0bO4BedRwS78MJ3Gu0Dc8niggplwDXYE29TaFeIE29TVpDFr8MUeDHjBxabSGMEYQUbfO24u/4uWDZp6ab9hoJf2mIO0d8uePTwsvVq68/Wmc0fdR6NZ6/z7CEBCiUPK2XCJOqkCRw5P/QP1Vgk5YzI4CTgiAD+YNEJj/9RQhShA4bOsf1TtVmis4MOc1rnxoaLn5FO2oEOPTpMZXeIbCcYZUNHzh74jE5kWkfEhoufUaY8ccAzKsjQIYkLJeSBzkzUPogi1BGGcuFAvLiwROfKCiWkiWFPCI+0bKcHwhjDa2YdSMd2vPAe8W0as+LmvR8t57S4qKO0Njet3biyG3Wd1oZtu0KdoG7sgc9pNtswSWeIpCztBHHz8LNCCW0JQ+sgRNA+YCNeKF+SyEI+KBd+F2wccEUctJOkeV1pq/DFywv7YY9tu/H7eECQlH48XB2f8Z1LEzXz2GPb0zxp2Lj2NwpncMRvAOoN9Y4X+OLBRPQ/IK2d2zR59ogAhZJHlZFkiuJSd0lYslzrP1Bq5Ek6Dt0V1Zl3/vsxIL4phwBET1JHBJ3PtA6oHV6DP9z4kZSWDTOt8qvoENlODTpl0Q4mOgYQI9HOqbU5OvzIXrNndGhsmvaaizM6o1H7kCY+x69F80IcHCiLFb+2025tjNdnWucU15NYjLNwdoKgy9opg+1pHepZdZTH4GntN60Da/kiH8sc72FvUa9SFpuRV7SDOy0OwoEhBI71DuOMF65B8CelZdsIGOO+jWPLnBQHdZr0ACDNPrRrK+LiYZAP7uH7ySOZAFin8cbvAr7L4If6xwu/D6hXvFBX8Tp09XAh2VpedUqAQskpzhIS49C7AlBN/0GwEBNJBZJhFBJwQwAdEYgldICyHhBISSIpa/ykcFV2iNBBgP3RzoX1KiXZVvU1dFTy1AnC2o6r9T5FbY523qPXrdcoeq3K93GvA8oQHXIGr1i0E4f6qkLAFWUA+/GK8i7qVcpiQ3yxBLQbeAzsEffSoo2jzqP2ISw6z0kHyoLvCrjHw8TTsPEhauKCHiLMekMRzg7zs3FQjjShhDD2wUG0Ldi4PM8mAG6o++iBa0k8Ud+odx4NIUCh5HlFBfQo5aohI9I/SBNJXXEo5SLGwBURgGjAHyTEUtKfpzXDdnjK6qxW2SFCXlGhhCerPj21Rp2AN+okzeuC+/DEFRGtiFNWPdr2Mu2MMsU71HaooI2H8kW9RehQ12mztWvaGe0qKiLwfYLNru1O4xdtC/Y7be0FbwgpcE1rUzYsRJfdVBZhs8RBBxvljw/vxBCvaPnBJDoPzXo6bN7xs23n8XTj4fg5nUCW+kN7QZ0jLI+GEKBQ8r2i6FHKXEPGSP/hxcW1AyzcwIME/COATs5jY/Fgn0SjQ4P2ap9U28571Hp0jPIc+DOOxsFneyAveEeiHc3ofRsuGt9ei5/j+STdR15RYYj88cQ96tWIx4t+TrItej/+ZDYefpaN6GAiDQg6PIWPdm7tXIP47wk6pPapPuJEywfbbF1GbYvbEbczWib7Ph7HXo+f4zxtvihLvB5R3uiBz9Ey23vxNO31pLMtSzwvG9ZlWkgT5YN4jdptbbB5xs9xGywjGy6JNdKPemkQNiqS8Bn8kur/kbFIRfuIe4qQF9p/NC20J3yG0EpqU4iDMli7ET/6HYqmBbsQPs4I5YlzQDh7oCzxONH7Nlz0jPtJ9W7ttGFnpWPDlXVOsnFaXnH7Z4VF+fDbjrq2dRiNg98Q/J6Acfz3JBqO7z0kMG08u4fmds+khz/9ZfpBslS7kf65xTNrg2ki6bPf6QrLe/LSh9PG+mehiU70tHkEWdKIh8EfVfSJZ/x+3s9IC0NuXB5lzYdxaSPTIgESIAESIAESqIgAPUoVgS6cTVe69oUBhRFni6T50mdsEiABEiABEiABEiCBjhGgUPK8wgMOvZtVQ/0zZ85O9yTZFFRHVGdHimmrlWcSIAESIAESIAESKIMAhVIZVJ2myV7vFJz9M2fOZRNJSERPSYm3SIAESIAESIAESIAESCBCgEIpAsPHt4oepZRqUf3Fs++tDXY+wYmRKYR4mQRIgARIgARIgARIoDgBCqXi7CqJSaF0GjOWAF88d39tsHMpl0jq0ua99EOebje8QgIkQAIkQAIkQAJ5CFAo5aFVS1h2eaPYlUh/4dyD3CIpTIMooyj5ngRIgARIgARIgARIYAoBCqUpcHy4pQwn1hzXg5F+8PBRMZF0nAjfkAAJkAAJkAAJkAAJkMBsAhRKsxnVG4JzlMb8VT84OFobfCnfcLuJyuvKqnfC7dEm6p0fSIAESIAESIAESKAAAQqlAtCqjMLlwUPafXkwXBv05hBJIp2RDxxhWOU3lHmRAAmQAAmQAAm0lQCFkuc1y8UcpG8OzdwiKaxm3REJQS+k599qmkcCJEACJEACJNAEAhRKntdSl1Zqi1cFVrczh+JGJMUT52cSIAESIAESIAESIAESmEKAQmkKHC9uddU7YFTPDOXSvMPtJuqwK3OUOEVpotr5gQRIgARIgARIgASKEKBQKkKtwjgdXfWu9+OvfmbTOeaOjLyTrpTTeQNhgiRAAiRAAiRAAiRwQoBC6YSFl++6NkfJiOr9+GsliKQOLeYAh9LQy9ZMo0iABEiABEiABEigOQQolDyvqy4JJW2k9+PeZ917ko7rmK6WYxR8QwIkQAIkQAIkQAIkMJUAhdJUPB7c7MwcJdP7ce9yiSLJg7qkCSRAAiRAAiRAAiRAAo0hQKHkeVV1ZI5S769fuVK6SOqOd46rOXj+taZ5JEACJEACJEACDSBAoeR5JbV9eXDMSapCJHlezTSPBEiABPwncPnOsojgdXIovSJKlo4vmODnRcyKiHlDzgU92T4/OL7HNyRAAiTQMAIUSp5XWJu9IFpJ769fuVq6J+m4irszjPG4yHxDAiRAAiGBy3dWJ0jEBY6WR0WpSREkMhkncUlNJZOXTV9E3ROlKJAmgPMDCZBAEwlQKHlea4HRnltY1DzV+9F//rfViaQOrXpXtEYYjwRIwEMC23eW5L6sHFsWwKOjJwWNkfeLqBOvjoQenpM4YeT4YjYxgVNsxG5fjOmLkrfFBH25cf7esZ18QwIkQAItIECh5Hsl6vifm+8GZ7Kv95ff/HeViqSRVa1kmQk4A5EACXhIwIogK35OvDoQPSOhc2BEoiIm/BmLXiitXCeiR5k3j3OBIDIyoCg6JsI3JEACLSZAoeR55bZwMYfeD7+1XYNIktjwEM8rnuaRAAm0g0BcDJ14f1bFiiArfirRPxNY74kx+xLID0QH9ySQgTx/vj8Rgh9IgARIoMMEKJQ8r/w2zVEyRno//M71ekRSOPSuGx6lbpRSft7zry7N6xqBq3dWRMuSBHpVTjxDK3JglkKPkBVD9XG5J6JGw+RE+hRE9VUEcyYBEmgOAQolz+uqRR4qZ6ofAAAZ5UlEQVSl3l9859/XJpJG1dwRCTExTsebBv6kiGw7tCY2ydxhykyKBKYRgCAysixYDGHkHcJ8oRXBYjHwCBk1OVRuWlrl3rsnGDIHTxHnDpVLmqmTAAm0lgCFkudV2w6Pkun9j+/+x5pFUoeG3s2vB/dL+FpgvgU6lC7ShkiKTVR3YvHJnAwnyTGRRhPAUthKVhIFEQoGQeTXQWHkV33QGhIggRYQoFDyvBKb7lEySnr/47vP1y+SRCSYXMPW85qfxzwjh/NEdyNmkizYFZG1pBs5r13LGZ7BSWA6ASydDQ+RBI+O9gDCstjjJw7+CSJbltEy3CJvygvn9+xFnkmABEiABNwRoFByx7KUlBoulHo/+N4NL0RSWDnze1pKqWNPE8UeKNHlhl2YCU/Qhoj05khsS07t7TJHaidRXXi6TlLjO38JWFGEYXNKwTOJzVHHGwh4/SMxEDH3RAVviBYMp2Ob9beV0TISIIGWEKBQ8rwimzr0Thnpff/2H/ojksJ69roT5FtLxMpXZcwDglcJRxGxBJF1cxzf9Ykrfbkm6kN600SRdyPnEoGNhtNJsMfFFxL5+HnRLuwxy7r4pr8Ib5dfT4vLlQnTyPA6CZRCgEKpFKzuEm2oR6n3/dsveSaSML+aQilHy8S+KWUIJZgAsfR+EbkuIvBczTrg2cJwO3iTyjreLithplsRAXRO4R3S+olTnqJmiCKAOhlOd07uyfb5LN+PigA3PBuI5qRDydJo2GXCTRP8/HgoZsLNcM7l5Ma/NpRd2MN+Tj3HNv0Nw8X2zYrHxd/YldfjV/EZD3sm20t0/6swRrAvOjZPlAt9JLHkNRI4JkChdIzCzzfN8yiZ3p+9/rJ3IimsXeqkPI28bA8LRM+6iLwy9i4lDSNCJwRepIslDAOMs+BCDnEivn9GxxdLcRv1xHjVudFQUdUcVURhFGlkSV4YuxFvJFj49mQvqvgd/GYki5dpD8pS56E16k/j9AI3RsXEYYIIOy26YoLLDETJ26KDHod7xpsbP3eBAIWS57XcKI+Skkv//fXP7/iKtDuLOTjpKGJyeBnzlKLNAx0aeIrwglCKiqUpHZ5oEk7eo5wUSk5QlpjIpDAaLbaQ2sEt0Y75km6fx8huqGu5xMVNslcGnfrJOZBJXphQpzj5PbPW8TxJIPa7OxZF0TBYXr5RejFqPN+TwPwEKJTmZ1hqCg0SSpv/7c5OkXknpfKbSJw/9hM4MnyAWIJHp4qjSmEULw9XDIsT8eFzuF+RXhVR2IOrqcJoX8x4AYamDKWLenaic2gmvTgnQucg5qU4JW74w1vC1ykmcJADNhPWf3ucl5FBON/p+IKIPCR9DueMAuF7EphNgEJpNqNaQyy4WU55ogxaO557YqT///6XnQZ0Nrvyh+2snBgWV5VQmmijFX+4VXF+zC6NwJU762L0k6LUqhiz7MvOrWnmJlwfCaMgeNO7lemsAIp6fEbDFlGMkwcVE56dpDk0CaXmpSwE4LmeHNJszL4E8oOJyPHFHLh4wwQefiCBqglQKFVNPGd+/3Vvp4whQWWkmbNk1Qdv3nyvgoyc6aRwOBqeXKIT1dYD34XJzktbS+pjuTBs64GMxJGo9XCZ7mbNMRot2Y29jFRwr7aV6eIiSMujohS+txjeNpq7YgVQ+PvA4Ww5vg7Jc3aiCcTFDe5xkYQoIb4ngcYSoFBqbNXR8PwE3CmI/Hk3NgZWprNLeje2EFMMpzdpCpxSbkXF0YHBgh7jPYxKya2MRKtfsvvynZHHxw6FOxkGNxoCFxdB1EG23idFzikPTmwVuCTvzanV8pSIwpDQieMJUWYkSO3lK69jKwN7bSAvfOARe4tnEiCB5hCgUGpOXdHSOQko6qQiBDHvDKvO2T/8Imn4GgfepAYMGfUVXw67QnGk18XIk9I8cXSyAMML58trL6FX6GhJgmBVThZAGA+Jsz9enR0KdyJ4Jpa8jgmd4wVhjia94CpYkXAZ8EibDcWmeUKiotLI6umlty37MO5obtDxIiLjeUGYG2TkjYk5QZwPFIHNtyTQXAIUSs2tO1qem8DEH17u2M2JEP3nd2L1JRG56yQlvxKBt4xHmQSuvLYuRj0pBxqeo/EqZ95/D/fFyD0J5E3Bil83zqNz7OYIPUNHyyMxJD8volZEMBdLlsVoERWEow9FtJv82pKKGQ+PxXDCk3lVIqIviEoaGhycLvlks9sXUSf1eiK+sH/cvmh9cu/GBzs5VP00QF4hgW4SoFDqZr13s9STf5TdZFCs1OgoYNn3Mjd8LWZZ8VgoDztAxfmlx4RnZBh2YCGOliee2KfHqvsOPEWz5xmhbEavihZ4IlbCzrYyb5yan3T51VWRYCyAsLmyWZYAoggCyIohFJk/SpkqXtlFZeK8TF8kGH+PY0tbG9MXY042YKXgyYSagUiABCYJUChN8uCnFhNQHemUmHLKCe/LqOPb/DaCYTz0JrmsRwytO9Abos0F0RrDnEZHvF/rMs950kInWtQ9UfoNmdaBjgojLFGu9XhTW5u5WRYM14I36PJt6B5szjm5P1DIorND5iyo2WfUiQpGwiZ8L3ap632RsYcnWBzUtmDG7BIwBAmQQAsJUCi1sFJZpBQCmPDMoygBdGDOj4fgTXYEi6ZYTzyUY3O8mW49FrQpVwyt0+qC3A+H1on4vWId5tu9KQ8Fe6l7ycwURjMqLy6SZgTv3O1QAGFej7wtRvdFFvedDm0EUDu8MQku5iqZmJCNhsO8JaVy/L6Z+KIO0dSqfj85nDBL7pOCNCWGTve8P7TIfZlSqPFyewhQKLWnLlmSGQSCcjwtM3Jt1W14YiAy7jS4VBB7KAePogTQETUaC3xshJ1O6z0qml7Z8dAZXFjYTPREzCuMyra9Dekb2RMlb6QKVHgj7x/FFosJ4gLkUZFwufMTIkYvicJwxvgxHt4Yv4zPs56VhW15VqCkhL24tjye75bdGJVlT8XgWmqC98ee1HiA0LOqEn5nDeZ+Te4bpbAxLkRz9ChBQEeT53sSyEHA97+4HEVhUBKYTmDp47ca+w84vWSxu0bdG3zld9diV11+xCa0TVwyHCIPXgUeeQmEnVmsWmcujubm5E2gpvDG7MgffhCLkYyO0NuApZ3NE2Jk/dQwORuOZxcEsPkuRNLfiqgnjhOERyec33V8hW9IYDYBLOgBUXVy7IuYE9GFYZtRwRWYgTz/oZgAO4nMdySQlQCFUlZSDNd4Ao90SCi9W65QQltokljCnys6yxRJeb/FV7+3Ijq42FBRsS+ysCYyFkaYY9TuzZPz1i7Dk4D/BE4LpKI2x4SVOlnsg0MIizLtRDwOvetENbOQIYHOzFGqxHEG0YFhFBiGl2NMf+VtESIJ3jU+WcyKfuvOkpzVGxKYi6LHSy8385HassjwnazFZjgS6DSBREFisFx60pE+bykMzaFzSdB4rZkEKJSaWW+0uhCBSgREIcsaGgl/lo+PxVLCXIHaSwVxhDlJJ3ui1G6SxwZgSWujLogM4S2cPZ/D46LQNBLoMAE8HLIPhvZFjYen6WAgQWQu0P3Fvuycjw5l6zAyFp0E0glQKKWz4Z2WEVAd8ShVLAchQiCWtkUkfdJv9W0Jy3/DJh7TCFz+9rLoxXVR6qIYbHxaceuZZhvvkQAJJBGACLo3mvuFxRHGG+dOW+Y+KRVeIwESyESAQikTJgZqB4GudAJrGScFUYJNO2/KaC5IXU0GXi4s2kAv0rQaePa1dVH6ghiFBQ3oPprGivdIwD8C8OC/Ga4EqGVJAulLuMkxHnZgdcCjntx4mr+B/tUbLWogAQqlBlYaTS5GQHVEJ9Uik0ZVgiedmA+EjWkhmJaL1VShWBBI8CLNGDtfKO12RAq9R8FFEbUuorFRKgVSO2qWpWgHgX64YTHKokxfgvGGu1r6Eow34qXXqB01zVI0igCFUqOqi8bOR6AjSqn+4VPwLOGFVcaw3w6EU1kH8rlFgZSCFwsznDkE/wuis+yZkpIOL5MACeQlMBAskIAjXNbavB2+N2pfFsbD5eRon56fvFgZngSqJUChVC1v5lYjgcDoTSOqifv/5KE2UNqc7BuTJ6b7sPDu4AXP0qizLuJi0Qd0Pl4ZizEOL0mqt2e/uy7KPCnmAbj7vCphkvW8RgK+EuiLUaMFEFRkRbhAjzzZw4WBvMS9e3ytPNpFAkUI1DhKp4i5jEMC8xH4x7/x4oYxjdwsNUvBB8rI2t/0nh09xcwSo/owEE3wNGEDSoimLMIJ5cELS9WiQ0JxlFRvn/3eymjeUShKqxz2mGQNr5FAEwnsi1KvCLw+Zjj6nTl6iKvDNbEmaTMJOCJAoeQIJJNpDgGIJTGmbZ6lgfz/7d1daxzXGcDx5zmzTkQLRaQYDMawkKa31Teo9AkiQk1dF+NxSN2kaUE2dnFsjEWK4+A2SBdtYqiLFJK4Fy509Qm8+gQdX+eia1qXgHsxhgaUePc85ex4V29raSXty8zovzf7NjPnnN+Zi332nPMc07wHSS+6SUKw1GvUI/xQISh6kVr4fG5pUl56ORZzZ/sMOne6Gt8hcNgFGqJSE+vrD5xxW62n/t61JpaK053/QPvwZ9mo2K7X4gAEDpcAgdLh6m9a+1zgaHw7VvGlCJZMJBVxRQ2SuCf3I3Dpr9NiclZUsj2P9nMNzkEAAQT6E3hRELV9Q1qVhtiWP7gqwlqs/pw5KocCBEo57BSqNBqBo/GtWIu/Zik1gqTR3DB5KOXiF7G6sCksiRny0B3UAQEE9i2wKfjSMN1R/aPO1byXhji3PqOgKQ1ZJOV5x4fn0QkQKI3OmpJyKBCCJVfQNUsmmpq2Zp4sX9t5SkUO3anSHgUufxGrlxuiI025vsdKcjgCCCAwMoFEpJtYI6zPzbIKiog3TURbWdKNSoXRrJF1STkLIlAqZ7/Sqj0IHDtzMzYtXDa81DsjSNpDPxfx0Mqlz6a96UJB1kwUkZg6I4DA4RFIrZOyPWRt35C50LlsD75m06Wy+HP+fDw898SuLSVQ2pWIAw6DQAiWRIuRDS+sSfIuZLdjJKm09+bc0mTkjiyIGmuQStvJNAwBBHItYLJhLyxtqFh7aqCpJNreG0uk+Yczm6YQ5ro9VG5fAgRK+2LjpDIKtIMlyXc2vBAkVSKdeUyQVMZbsN2maO6zWXHt+7BXJsDStpuGIYBA6QW2J3rYS5Ozqcd53fqg2zbVsJ2FPfVeUydZtsGmNBNZPJdNB9xLmzl27AIESmPvAiqQJ4HjZ96PzXI7DS/ViiNIytMNM+C6VOaWF0R1bsCX5XIIIIDADgK6eVREfSqi3TU/3RP98411ux9kLyoijbXFc+uJF7Z8n6e3R+aWpqz3dhRDr2Yz7AdIsDR050EXQKA0aFGuV3iBLFjK3TS8VL2feXxvnrnThb/DtjdgYm6p2hL5O3shbbfhEwQQ2FFgc5AjkqjI084Zrex9dySjSEFNpw08IzBOAQKlcepTdm4Fjp9+PxbNzTS8VMwIknJ7txysYuEfTjV78IJNdw92cc5GAIHcCphkCQTWK6iJqu8GOWGqtYnr/jmmIumzxXPd9+vn8QoBBIYlQKA0LFmuW3iB46fnw0L6cW9KG/4JJEgq/N3UuwETv/lLYZKI9G4BnyJweAW8SMPC/j+dh7NEbX00x7nNU9XWFn+xdfSncybPCCCQUwECpZx2DNXKh8CJ0/OxjS/BQ2qiBEn5uBUGXovv/PrurKmF6XY8EEBgjAKbR3bCxqdZdrN2lfz6qE9UsfTrxfOM6IyxrygagVELECiNWpzyCidw4vT1cSR4SE0dQVLh7pb+Kjzx9ifVKHL/EBUy2/VHNrKjvISF7RYWs086semRFUxBBxbwJg3RzgiPpSobNiEVtz6aU2k21hbfWR8JOnDJXAABBMoqUClrw2gXAoMS+Ne93y2fOHU9XG400/BMUh9FBEmD6sAcXidyckPNT4rlsHIjr5KG6aV1MZsUlZEGJiYSfizXRe2hmNWdaVVUXxeRaRXJaxrikffQOAoMfaMh8AkPDfeIrWdhe745aPiqUllL0sUL3WQF46grZSKAQHkFGFEqb9/SsgELnDh1PdZhT8MzSV3kZxr3PmB6x4D7Ly+Xm3z7k2pL/T/zUp8x1KMdGKnoakut/vXH7ybf/dWfpqKWLJmTqSHWJ4wSJaq26r2rVybWkuZaZcqJmzbRH4syejQMexVJTNrBcPvywb9TTgiGzLvuyM7/7ryzPurTOYhnBBBAYIwCBEpjxKfo4gmcOHU11uHts5Q6bzON+wRJxbsz+q/x987/cU7UFvo/o/hHqkjNnK461Xr68bvdPwEm44VJ/3J0Q2Qoe0clITAy1dXISRLKDeXJRDRrJq+baBi9Yurj9tsrCdnWtn6ssmXtTjhANXVm3f5snzPRZIRnKx7vEUCgsAIESoXtOio+LoHqyaux6cCn4aVqQpA0rk4dYbmv/HJxyUxCRsXSPto/tFVqYrYi30o9Xd4+NWryrYVpde3NnQ88xS2bQhfSKNtDcb6e3rmwaWRi8vzCrIqeFZHZIqCbbVhPs7XCGoKYDdPQtn7feR+ysUWt7mhN5+P285okvfpk0zG8QQABBBAQ1ihxEyCwR4HG/Q+WqyevigxuGl6YEkSQtMd+KOzhrbDIvISLk7KF9DUnsvLfu5sDla199cpbHy2I2Jz4/TmELGUqtqrmktYRSdI7F3oGBN9/86Pwp8YN8VaV8Zh3R2dUNBHJ9sgJ9dZ2wCPSrEjjRfXf6sZ7BBBAAIHRChAojdab0koikAVLV0JrDpjgIWTXigiSSnJf9NMMtdaqms31c2zuj1FJvMmnUWT1J3d/u3kK1g6Vd97v8O2WrywkWwjrXNxDF7WSJ3/evZyj8e0pi3RJzE9piMX2F49tqUj3bSomWVtVEnHy1HtJncs+azYrjXS5d+DWvQIvEEAAAQQKIcDUu0J0E5XMq0D15JVYzfYbLKWmfqZx//d9/8DMqwP12pvA0Tdvx+r9fu+bvRU24KNNXN2crVS8r321/F7PkZx+izwW36o2RarqoqpKGPXJHhbWw3hJnizvHhR1zuk8H41vxSrtKX2dj/p6fj5973l7LFEnT0M9zGfT15oywXS1viQ5CAEEECiPAIFSefqSloxJoPrG5djp3n6YhTUc5kLiBoKkMXXb2Is9Gt+cci1d6DMldkPC1DYniao+9WKJE00j8WnT64OhJyVQqXnVlWfyTS1dnt+20H/smBsqcOzMzdjCeqRsj6opCSNSzx8aaTvjWkukEWWpweWr5fe633eO4xkBBBBAAIEgQKDEfYDAAARefeNybP2vWUp9FNYkESQNgL7wlzge35ySVuusN22nxtb2Inx75L3Uo4pLHy9f6zniWI3nJ79tupBmfBiZ21IxVxO1lf98fr1WeGQagAACCCCAwD4ECJT2gcYpCPQSCMGSyK7TqVLn3cyXNYKkXoZ81p9ACJKa39gD0cHtOxSmnjmTmkW68u/P5xll6a8rOAoBBBBAoMQCBEol7lyaNnqBV2cvxvLi1OGps4ggafTdUroST/z02gPN9gE6aNsScfppS6P643vzPUeuDloA5yOAAAIIIFBUAQKlovYc9c6twGuzF3tNwwspoWe+rC3yYzS3PVeMilVPXglJIPa5D1PIshjW7EQr8uylWqOW7/VGxegRaokAAgggUFYBAqWy9iztGqvAa7NzsVg3dXgqKgRJY+2RchT+g59cmjYvIXlDXw8Ta4i4MGr00IurN/72IVPq+pLjIAQQQAABBEjmwD2AwNAEsmDJFkSVIGloyofvwj+cvTjvzf9IsyQOIQFESOYQRirb+/uYc49EfNIUSRq1xVxnqDt8vUeLEUAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQGJvB/nmm4r6KURx8AAAAASUVORK5CYII='
               var doc = new jsPDF({
              orientation: 'landscape',
            });
            var width = doc.internal.pageSize.getWidth()/2-12;
            var height = doc.internal.pageSize.getHeight()/2-6;
            doc.setFont("helvetica");
            doc.setFontType("bold");
            doc.setFontSize(13);
            doc.text(width-50, 20, 'PROGRAMME DES BRANCARDIERS DES URGENCES');
            doc.addImage(imgData, 'PNG', width, 1, 24, 12);
            doc.autoTable({html: '#basic-table', startY: 25, styles: {
                theme: 'grid',
                halign: 'center',
                valign: 'middle',
            },
            });
            var string = doc.output('datauristring');
            this.srcpdf=string;
    var embed = "<embed width='100%' height='100%' src='" + string + "'/>"
},

     urgence(){
       this.isurgence= true;
    },
    autresservices(){
      this.isurgence= false;
        this.isautomatique=false;
    },
    automatique(){
      this.isautomatique=true;

    },
    manuelle(){
      
        this.isautomatique=false;
    },


   searchit: _.debounce(() => {
            Fire.$emit('searching');
            console.log("shearchit !");
        },10),

    printme() {
            window.print();
        },

    getResults(page = 1) {
                        axios.get('api/brancardier?page=' + page)
                            .then(response => {
                                this.brancardiers = response.data;
                            });
                },
       loadAffectation(){
        axios.get('api/pdfUrgence/'+this.selectedItemService).then(({data})=>(
           this.lLundi=data.lLundi,
           this.lMardi=data.lMardi,
           this.lMercredi=data.lMercredi,
           this.lJeudi=data.lJeudi,
           this.lVendredi=data.lVendredi,
           this.lSamedi=data.lSamedi,
           this.lDimanche=data.lDimanche,
           this.lundi=data.lundi,
           this.mardi=data.mardi,
           this.mercredi=data.mercredi,
           this.jeudi=data.jeudi,
           this.vendredi=data.vendredi,
           this.samedi=data.samedi,
           this.dimanche=data.dimanche,

           this.lundi1=data.lundi1,
           this.mardi1=data.mardi1,
           this.mercredi1=data.mercredi1,
           this.jeudi1=data.jeudi1,
           this.vendredi1=data.vendredi1,
           this.samedi1=data.samedi1,
           this.dimanche1=data.dimanche1,

           this.llundi1=data.llundi1,
           this.lmardi1=data.lmardi1,
           this.lmercredi1=data.lmercredi1,
           this.ljeudi1=data.ljeudi1,
           this.lvendredi1=data.lvendredi1,
           this.lsamedi1=data.lsamedi1,
           this.ldimanche1=data.ldimanche1,
          
          this.lundiTemp=data.lundiTemp,
          this.mardiTemp=data.mardiTemp,
          this.mercrediTemp=data.mercrediTemp,
          this.jeudiTemp=data.jeudiTemp,
          this.vendrediTemp=data.vendrediTemp,
        
          
          this.llundiTemp=data.llundiTemp,
          this.lmardiTemp=data.lmardiTemp,
          this.lmercrediTemp=data.lmercrediTemp,
          this.ljeudiTemp=data.ljeudiTemp,
          this.lvendrediTemp=data.lvendrediTemp,

           this.lLundiSize=Object.keys(data.lLundi).length,
           this.lMardiSize=Object.keys(data.lMardi).length,
           this.lMercrediSize=Object.keys(data.lMercredi).length,
           this.lJeudiSize=Object.keys(data.lJeudi).length,
           this.lVendrediSize=Object.keys(data.lVendredi).length,
           this.lSamediSize=Object.keys(data.lSamedi).length,
           this.lDimacheSize=Object.keys(data.lDimanche).length,
           this.lundiSize=Object.keys(data.lundi).length,
           this.mardiSize=Object.keys(data.mardi).length,
           this.mercrediSize=Object.keys(data.mercredi).length,
           this.jeudiSize=Object.keys(data.jeudi).length,
           this.vendrediSize=Object.keys(data.vendredi).length,
           this.samediSize=Object.keys(data.samedi).length,
           this.dimacheSize=Object.keys(data.dimanche).length,

           this.lLundi1Size=Object.keys(data.llundi1).length,
           this.lMardi1Size=Object.keys(data.lmardi1).length,
           this.lMercredi1Size=Object.keys(data.lmercredi1).length,
           this.lJeudi1Size=Object.keys(data.ljeudi1).length,
           this.lVendredi1Size=Object.keys(data.lvendredi1).length,
           this.lSamedi1Size=Object.keys(data.lsamedi1).length,
           this.lDimache1ize=Object.keys(data.ldimanche1).length,
           this.lundi1Size=Object.keys(data.lundi1).length,
           this.mardi1Size=Object.keys(data.mardi1).length,
           this.mercredi1Size=Object.keys(data.mercredi1).length,
           this.jeudi1Size=Object.keys(data.jeudi1).length,
           this.vendredi1Size=Object.keys(data.vendredi1).length,
           this.samedi1Size=Object.keys(data.samedi1).length,
           this.dimache1Size=Object.keys(data.dimanche1).length,

           this.lLundiTempSize=Object.keys(data.llundiTemp).length,
           this.lMardiTempSize=Object.keys(data.lmardiTemp).length,
           this.lMercrediTempSize=Object.keys(data.lmercrediTemp).length,
           this.lJeudiTempSize=Object.keys(data.ljeudiTemp).length,
           this.lVendrediTempSize=Object.keys(data.lvendrediTemp).length,
           this.lundiTempSize=Object.keys(data.lundiTemp).length,
           this.mardiTempSize=Object.keys(data.mardiTemp).length,
           this.mercrediTempSize=Object.keys(data.mercrediTemp).length,
           this.jeudiTempSize=Object.keys(data.jeudiTemp).length,
           this.vendrediTempSize=Object.keys(data.vendrediTemp).length
            ));
      },
                
    nextClicked(currentPage) {

        
      console.log('next clicked', currentPage);
      if(currentPage===0 ){
          var date1 = new Date(this.$options.filters.formatDate(this.form.DateDebut));
        var date2 = new Date(this.$options.filters.formatDate(this.form.DateFin));
       //this.diff = date2.getDate() - date1.getDate(); 
       const diffTime = Math.abs(date2.getTime() - date1.getTime());
      this.diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
      console.log('diffDays',this.diffDays);
            
       
    if(this.diffDays%3!=0){
       swal.fire({
                type: "error",
                title: "Oops...",
                text: "Something went wrong!",
                footer: "<a href>Why do I have this issue?</a>"
              });
              return false;
    }
         // this.automatique();
         if (this.form.DateDebut != "" && this.form.DateFin != "" && this.$options.filters.formatDate(this.form.DateFin) >= this.$options.filters.formatDate(this.form.DateDebut)) {
            this.automatique();
            return true;
              }
      else {
              swal.fire({
                type: "error",
                title: "Oops...",
                text: "Something went wrong!",
                footer: "<a href>Why do I have this issue?</a>"
              });
              return false;
            
            }

      }
       




else if (currentPage === 1) {
        
    if(this.selectedItem.length>0){
      this.sendBranAffect();
      this.loadAffectation();
        return true;
    }
else{
     swal.fire({
                type: "error",
                title: "Oops...",
                text: "Veuillez sélectionner des brancariers",
                footer: "<a href>Why do I have this issue?</a>"
              });
              return false;
}

      }


      if(currentPage===3 )
      
       console.log(this.form.DateDebut);
       console.log( this.$options.filters.formatDate(this.form.DateDebut));
        console.log( this.$options.filters.formatDate(this.form.DateFin));
       
      return true; //return false if you want to prevent moving to next page
    },

    backClicked(currentPage) {
      console.log('back clicked', currentPage);
      console.log('clcked',this.selectedItem);
      console.log('clcked',this.branurgence);
      return true; //return false if you want to prevent moving to previous page
    },

    loadService(){
        axios.get('api/service').then(({data})=>(this.services = data));  
      },
    
    loadBrancardier(){
        axios.get('api/brancardier').then(({data})=>(this.brancardiers = data));  
    },

    sendBranAffect(){
      
        var date1 = new Date(this.$options.filters.formatDate(this.form.DateDebut));
        var date2 = new Date(this.$options.filters.formatDate(this.form.DateFin));
        const diffTime = Math.abs(date2.getTime() - date1.getTime());
        this.diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
            console.log('succéeeeeees');
            axios.post('api/sendbran',{
                selectedItem: this.selectedItem,
                DateDebut: this.$options.filters.formatDate(this.form.DateDebut),
                DateFin: this.$options.filters.formatDate(this.form.DateFin),
                diffDays:this.diffDays,
            }).then(resp =>{
              console.log('succées');
            }).catch(error => {
              console.log('failed')
            },
            )
    },

   /* sendHoraires(){
       
      var date1 = new Date(this.$options.filters.formatDate(this.form.DateDebut));
      var date2 = new Date(this.$options.filters.formatDate(this.form.DateFin));
      this.diffDays = date2.getDate() - date1.getDate(); 

            axios.post('api/senddate',{
              DateDebut: this.$options.filters.formatDate(this.form.DateDebut),
              DateFin: this.$options.filters.formatDate(this.form.DateFin),
              diffDays:this.diffDays,
            }).then(resp =>{
              console.log('succées');
            }).catch(error => {
              console.log('failed')
            },
            )
    },*/

    checked(id){var t=0;

        for(var i=0; i < this.selectedItem.length; i++){
          if( this.selectedItem[i]===id) {this.selectedItem.splice(i, 1); t++;}        
        }
        if(t===0) this.selectedItem.push(id);
      },

    isChecked(id){
        var t=0;
        for(var i=0; i < this.selectedItem.length; i++){
          if( this.selectedItem[i]===id) t++;    
        }
        if(t===0) return false;
        return true;
      }

  },
      
      
    created() {

          Fire.$on('searching',() => {
           let query = this.search;
            axios.get('api/findBran?q=' + query)
              .then((data) => {
                  this.brancardiers = data.data
              })
             .catch(() => {
           })
          })
           
            this.loadBrancardier();
            this.loadService();
         //   setInterval(()=>this.loadBrancardier(),3000);
        // Fire.$on('AfterCreateBran',()=>this.loadBrancardier());
           
        },
        
              
        displayGRP(){
          var t=0;
          if(this.selectedItem.length%3===0){
            for(var i=0; i<3;i++){
              for(var j=0; j<this.selectedItem.length;j++)
                while(t<4){
                    this.branurgence[i]=this.selectedItem[j];
                    t++;
               }
            }
          }
          return true;
        },


        displayAffectation(){
          
        } 
          
         
        
};
</script>
<style type="text/css">
.v-divider {
  margin-left: 5px;
  margin-right: 5px;
  width: 1px;
  height: 100%;
  border-left: 1px solid gray;
}

</style>