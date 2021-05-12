<template>

    <div>

        <div class="wrapper">
            <div class="columns">
                <div class="column is-6-desktop is-offset-3-desktop is-8-tablet is-offset-2-tablet">
                    <div class="box">

                        <div class="columns">
                            <div class="column">
                                <div class="right-header">
                                    FACULTY PERFORMANCE EVALUATION SYSTEM
                                </div>
                                <br>
                                <p class="right-header-subtitle">An Assessment of teacher's performance that aims to measure teacher's competence.
                                    Produce fast, secure and reliable result where disclosure of ratings is strictly prohibited.</p>
                            </div>
                            <div class="column vertical-line">
                                <div class="login-header">SECURITY LOGIN</div>
                                <p style="height: 5px; background: #22773a;"></p>

                                <form action="/login" method="post">
                                    <csrf></csrf>
                                    <div class="controls-panel">
                                        <b-field label="Student ID">
                                            <b-input type="text" v-model="fields.username"
                                                     name="StudID"
                                                     placeholder="Student ID" required></b-input>
                                        </b-field>
                                        <b-field label="Password">
                                            <b-input type="password" password-reveal v-model="fields.password"
                                                     name="password"
                                                     placeholder="Password" required></b-input>
                                        </b-field>

                                        <b-notification v-if="error !== ''" class="is-danger" aria-close-label="Close notification">
                                            {{ error }}
                                        </b-notification>
                                        <div class="buttons is-right">
                                            <button class="button is-primary expand-mobile"><b-icon pack="fa" icon="sign-in"></b-icon>&nbsp;
                                                &nbsp;LOGIN</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div><!--box-->
                </div><!--column with width -->
            </div>

        </div>

    </div><!--root div-->
</template>

<script>
export default {
    props: ['error'],
    data(){
        return{
            fields: {},

        }
    },

    methods: {
        // submit(){
        //     axios.post('/login', this.fields).then(res=>{
        //         this.fields ={};
        //
        //     });
        // }
    }
}
</script>

<style scoped>

.wrapper{
    margin-top: -5rem;
    display: flex;
    justify-content: center;

    height: 100vh;
    align-items: center;
}

/*.login-panel{*/
/*    height: 500px;*/
/*    width: 900px;*/

/*    border-radius: 10px;*/

/*    -webkit-box-shadow: 0 10px 6px -6px #777;*/
/*    -moz-box-shadow: 0 10px 6px -6px #777;*/
/*    box-shadow: 5px 10px 6px -6px #b0b0b0;*/

/*}*/

.controls-panel{
    padding: 10px;
    margin-top: 10px;
}

.login-header{
    font-size: large;
    font-weight: bold;
}

.right-header{
    font-size: large;
    font-weight: bold;
    text-align: center;
}

.vertical-line{
    border-left: 1px solid green;
}

@media only screen and (max-width: 768px) {
    .vertical-line{
        border-left: white;
        border-top: 1px solid green;
    }

    .right-header-subtitle{

        text-align: center;
    }
    .expand-mobile{
        width: 100%;
    }
}


</style>
