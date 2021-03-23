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
        }
    },

    methods: {

    },


}
</script>
