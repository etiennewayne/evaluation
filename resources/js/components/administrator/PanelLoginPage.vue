<template>
    <div>
        <div class="hero is-fullheight">
            <div class="hero-body">
                <div class="container">
                    <div class="columns">
                        <div class="column is-6 is-offset-3">
                            <div class="panel">
                                <div class="panel-heading">
                                    SECURITY CHECK
                                </div>

                                <div class="p-4">
                                    <form @submit.prevent="submit">
                                        <b-field label="Username">
                                            <b-input placeholder="Username"
                                                     required type="text"
                                                     v-model="fields.username">
                                            </b-input>
                                        </b-field>

                                        <b-field label="Password">
                                            <b-input placeholder="Username" required type="password"
                                                     password-reveal
                                                     v-model="fields.password">
                                            </b-input>
                                        </b-field>

                                        <div class="alert-danger" v-if="loginError" :disabled="isActive" type="is-danger">
                                            {{ this.loginError }}
                                        </div>

                                        <div class="buttons">
                                            <button class="button is-primary">LOGIN</button>
                                        </div>
                                    </form>
                                </div>

                            </div><!--panel-->
                        </div><!--coloumn-->
                    </div> <!--columns-->
                </div>

            </div>

        </div>

    </div>
</template>

<script>
export default {
    data(){
        return{
            fields: {},
            loginError: '',
            isActive : false,
        }
    },

    methods: {
        submit(){
            axios.post('/cpanel', this.fields).then(res=>{
                //console.log(res.data[0].status);
                if(res.data[0].status === 'login_success'){
                    this.loginError = '';
                    this.isActive = false;
                    window.location = '/cpanel-home';

                }

                if(res.data[0].status === 'login_error'){
                    this.isActive = true;
                    this.loginError = 'Username and Password Error!.';
                }
            }).catch(err=>{
                console.log(err);
            })
        }
    },


}
</script>

<style scoped>
    .alert-danger{
        color: red;
        margin: 10px;
    }
</style>
