<template>
  

<div class="modal fade login " id="loginModal">
		      <div class="modal-dialog modal-dialog-centered modal-lg animated" >
    		      <div class="modal-content">
    		         <div class="modal-header">
                       <h5 class="modal-title">login</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box">
                             <div class="content">
                                <div class="error"></div>
                                <div class="form loginBox">
                                    <form method="" action="" accept-charset="UTF-8">
                                    <input id="email" v-model="email" class="form-control mb-3 mt-3" type="text" placeholder="Email" name="email">
                                    <input id="password" v-model="password" class="form-control mb-4" type="password" placeholder="Password" name="password">
                                    <input class="btn btn-teal btn-lg btn-block mb-2" @click="attemptLogin()" :disabled="!isValidLoginForm" type="button" value="Login" >
                                    </form>
                                </div>
                             </div>
                        </div>
                        <div class="box">
                            <div class="content registerBox" style="display:none;">
                             <div class="form ">
                                <form method="" html="{:multipart=>true}" data-remote="true" action="" accept-charset="UTF-8">
                               <input id="name" v-model="form.name" class="form-control " type="text" placeholder="Name" name="name" :class="{ 'is-invalid': form.errors.has('name') }">
                                 <has-error :form="form" field="name"></has-error>
                                <input id="email" v-model="form.email" class="form-control mb-1" type="email" placeholder="Email" name="email" :class="{ 'is-invalid': form.errors.has('email') }">
                                  <has-error :form="form" field="email"></has-error>
                                <input id="password"  v-model="form.password" class="form-control" type="password" placeholder="Password" name="password" :class="{ 'is-invalid': form.errors.has('password') }">
                                  <has-error :form="form" field="password"></has-error>
                                <input id="password_confirmation" v-model="form.password_confirmation" class="form-control" type="password" placeholder="Repeat Password" name="password_confirmation">
                                <input class="btn btn-teal btn-lg btn-block"  type="button" @click="attemptRegister()" :disabled="!isValidRegisterForm" value="Create account" name="commit">
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="forgot login-footer">
                            <span>Looking to
                                 <a href="javascript: showRegisterForm();">create an account</a>
                            ?</span>
                        </div>
                        <div class="forgot register-footer" style="display:none">
                             <span>Already have an account?</span>
                             <a href="javascript: showLoginForm();">Login</a>
                        </div>
                    </div>
    		      </div>
		      </div>
		  </div>
</template>
<script type="text/javascript">

   /* $(document).ready(function(){
        openLoginModal();// for open modal automaticly
    });*/
    import axios from 'axios'
    import { Form, HasError, AlertError } from 'vform';

     export default {
       data(){
         return{
           email: '',
           password: '',

          form: new Form({
           name: '',
           email: '',
           password: '',
           password_confirmation: '',
        }),
         }
       },
       computed: {
        isValidLoginForm(){
         return this.emailIsValid() && this.password 
        },
        isValidRegisterForm(){
         return this.form.name && this.emailIsValidRegister() && this.form.password
        }
       },
       props: [
       ],
       methods: {
         emailIsValid(mail) 
            {
              if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email))
                {
                  return (true)
                }
                  return (false)
            },
          emailIsValidRegister(mail) 
                  {
                    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.form.email))
                      {
                        return (true)
                      }
                        return (false)
                  },
         
        attemptLogin(){
           this.$Progress.start();
            
            axios.post('/login',{
              email: this.email, password: this.password
            }).then(resp =>{
              console.log('nja7t'),
              location.href = '/admin';
              
              this.$Progress.finish();
             //redirectTo()
            }).catch(error => {
              this.$Progress.fail(),
              loginAjax(0),
              console.log('khsart')
            },
            )
        },
        attemptRegister(){
            this.$Progress.start();
            this.form.post('/register').then(() =>{
              console.log('register')
              location.reload()
            }).catch(() => {
              this.$Progress.fail(),
              loginAjax(1),
              console.log('not register')
            },
            )
        }
        

       },
        mounted() {
            console.log('hi im tawfiq')
        }
    }
    window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    // Handle page restore.
    window.location.reload();
  }
});
</script>